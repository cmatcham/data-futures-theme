<?php

add_action( 'after_switch_theme', 'create_db' );

add_filter( 'allowed_http_origins', 'add_allowed_origins' );
function add_allowed_origins( $origins ) {
    $origins[] = 'http://192.168.1.4:81';
    return $origins;
}


function create_db() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
	global $wpdb;
	$users_table = $wpdb->prefix . "users";
	$wheel_table = $wpdb->prefix . "data_futures_wheel";
	$answers_table = $wpdb->prefix . "data_futures_answers";

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $wheel_table (
		id INT NOT NULL AUTO_INCREMENT,
		user_id BIGINT(20) UNSIGNED NOT NULL,
		name TEXT,
		url VARCHAR(255),
        creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
        modification_time DATETIME ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
	) $charset_collate;";

	dbDelta( $sql );

	$sql = "CREATE TABLE $answers_table (
		id INT NOT NULL AUTO_INCREMENT,
		wheel_id INT NOT NULL,
		question_id INT NOT NULL,
		answer TEXT,
		link VARCHAR(255),
		PRIMARY KEY (id)
	) $charset_collate;";

	dbDelta( $sql );
	
	/* Gah, looks like dbdelta dies on foreign keys.  so removed. Ugh.
		FOREIGN KEY (user_id) references $users_table(id)
		,
		FOREIGN KEY (wheel_id) references $wheel_table(id)
		 */
	
	add_role( 'client', __('Client' ), array( ) );
}



show_admin_bar(false);
add_theme_support( 'post-thumbnails', array( 'page' ) );
add_action('admin_head', 'remove_content_editor');

add_action( 'admin_enqueue_scripts', 'add_bar_graphs' );

function add_bar_graphs() {
    wp_enqueue_script( 'bar_graphs', get_template_directory_uri() . '/js/bargraph.js' );
    
}

function register_data_future_menus() {
    register_nav_menu('about-menu',__( 'About Menu' ));
    register_nav_menu('privacy-menu',__( 'Privacy Menu' ));
}
add_action( 'init', 'register_data_future_menus' );

/**
 * Remove the content editor from scrolling pages
 */
function remove_content_editor() {
    //Check against your meta data here
    if(get_page_template_slug() === 'scrolling-page.php'){      
        remove_post_type_support('page', 'editor');         
    }

}


function styles() {
	wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', false, '2.1.3');
    wp_enqueue_script('jquery');

    wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/css/bootstrap.min.css'), array(), null );
    wp_enqueue_script('bootstrap', get_theme_file_uri( '/js/bootstrap.min.js'), array('jquery'), null);
    
	if (get_page_template_slug() === 'scrolling-page.php') {
		wp_enqueue_style( 'scrolling', get_theme_file_uri( '/css/scrolling-nav.css'), array(), null );
		wp_enqueue_script('jquery-easing', get_theme_file_uri( '/js/jquery.easing.min.js'), array(), null);
		wp_enqueue_script('scrolling', get_theme_file_uri( '/js/scrolling-nav.js'), array(), null);
	} else if (get_page_template_slug() === 'wheel-page.php') {		
		wp_enqueue_script( 'lz-string', get_theme_file_uri( '/js/lz-string.js' ), array(), null);
		wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), null);
		wp_enqueue_script( 'bootstrapWizard', get_theme_file_uri( '/js/bootstrapWizard.js' ), array( 'jquery' ), '1.0');
		wp_enqueue_script( 'debounce', get_theme_file_uri( '/js/jquery.debounce-1.0.5.js' ), array(), null);
		wp_enqueue_script( 'dataFutures', get_theme_file_uri( '/js/dataFutures.js' ), array(), null);
	} else if (is_front_page()) {
		wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), null);
	}

}

function data_futures_footer($fixed) {
?>
<footer>
    <div class="navbar <?php echo $fixed ? 'navbar-fixed-bottom' : ''?>">
	    <div class="container">
    		<div class="navbar-header">
    
		    </div>
            <div class="collapse navbar-collapse">
            <?php wp_nav_menu( array(
                'theme_location' 	=> 'privacy-menu',
                'container'         => false,
                'container_class' 	=> 'collapse navbar-collapse',
                'container_id'    	=> 'main-navbar-collapse',
                'menu_class'      	=> 'nav navbar-nav',
                'menu_id'         	=> '',
                'echo'            	=> true,
                'fallback_cb'     	=> 'wp_page_menu',
                'before'          	=> '',
                'after'           	=> '',
                'link_before'     	=> '',
                'link_after'      	=> '',
                'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth'           	=> 0,
                'walker'          	=> ''
            )); ?>

				<ul class="nav navbar-nav navbar-right">
      				<li><a>Brought to you by <strong>DATA FUTURES</strong> partnership</a></li>
    			</ul>
    		</div>
    	</div>
    </div>
</footer>
<?php 
}

function data_futures_show_login() {
    $screen = 'login';
    
    //are we creating a user?
    if (isset( $_POST[ 'data_futures_create_account' ] )) {
        $is_valid_nonce = wp_verify_nonce( $_POST[ 'data_futures_create_account' ], 'create_account_nonce' );
        $screen = 'create';    
    }
    
    
    if ($is_valid_nonce) {
        $email_address = $_POST['email'];
        $email_error = '';
        if (empty($email_address)) {
            $error = 'You must supply an email address';
        }
        if( null != email_exists( $email_address ) ) {
            $error = 'That account is already in use.  Please log in';
            $screen = 'login';
        }
        
        if (empty($error)) {
            $password = $_POST['pwd'];
            $user_id = wp_create_user ( $email_address, $password, $email_address );
            $user = new WP_User( $user_id );
            $user->set_role( 'client' );
            $screen = 'login';
            $message = 'Account created, please log in.';
        }
    }
    
    
?>
<div class="container">
	<div class="row" style="padding-top:60px;">
		<div class="col-md-6">
			<h1>Create your own data-use wheel!</h1>
			<p>By answering the eight questions, you can create an embeddable widget for your website to give your customers surety about how you use their data.</p>
			<p>Create an account or log in now to continue.</p>
			<div class="modal-body">
				<div class="well">
					<ul class="nav nav-tabs" >
						<li class="active"><a href="#login" data-toggle="tab">Login</a></li>
						<li><a href="#create" data-toggle="tab" id="createAccountTab">Create Account</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active in" id="login">
							<?php if (!empty($message)) { ?>
							<div class="alert alert-success" role="alert"><?php echo $message ?></div>
							<?php } ?>
							<form action="<?php echo wp_login_url(); ?>" method="post">
								<div class="form-group">
				    				<label for="loginEmail">Email address</label>
				    				<input type="email" class="form-control" id="loginEmail" placeholder="Email" name="log">
				    			</div>
				    			<div class="form-group">
									<label for="loginPassword">Password</label>
									<input type="password" name="pwd" class="form-control" id="loginPassword" placeholder="Password">
								</div>
								<div class="form-group">
									<labe>
									<input name="rememberme" type="checkbox" id="rememberme" value="forever" checked="checked">
									Remember Me
									</label>
								</div>
								
								<input type="hidden" name="redirect_to" value="<?php echo get_permalink();?>">
								<button type="submit" name="wp-submit" value="Log in" class="btn btn-default">Log in</button>
							</form>
						</div>
						<div class="tab-pane fade" id="create">
							<form action="<?php echo esc_url(get_permalink()) ?>" method="post">
								<input type="hidden" name="action" value="data_futures_create_account"/>
								<?php wp_nonce_field( 'create_account_nonce', 'data_futures_create_account' );  ?>
								<?php if (!empty($error)) { ?>
								<div class="alert alert-danger" role="alert"><?php echo $error ?></div>
								<?php } ?>
								<div class="form-group">
				    				<label for="loginEmail">Email address</label>
				    				<input type="email" class="form-control" id="createEmail" placeholder="Email" name="email">
				    			</div>
				    			<div class="form-group">
									<label for="loginPassword">Password</label>
									<input type="password" name="pwd" class="form-control" id="createPassword" placeholder="Password">
								</div>
				    			<div class="form-group">
									<label for="loginPassword">Confirm Password</label>
									<input type="password" name="pwd2" class="form-control" id="createPassword2" placeholder="Password">
								</div>
								<button type="submit" name="wp-submit" value="Log in" class="btn btn-default">Create Account</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div id="dataFutures" data-disclaimer="none" data-style="none"></div>
		</div>
	</div>
</div>

<?php if ($screen == 'create') { ?>
<script>
jQuery(document).ready(function() {
	jQuery("#createAccountTab").tab('show');
});
</script>
<?php
}

}



function data_futures_create_account() {
	
	if (isset( $_POST[ 'data_futures_create_account' ] )) {
		$is_valid_nonce = wp_verify_nonce( $_POST[ 'data_futures_create_account' ], 'create_account_nonce' );
	}

	$is_valid_nonce = ( isset( $_POST[ 'data_futures_create_account' ] ) && wp_verify_nonce( $_POST[ 'data_futures_create_account' ], 'create_account_nonce' ) ) ? 'true' : 'false';
	if (!$is_valid_nonce) {
		wp_redirect(esc_url(home_url()));
		exit;
	}
	
	$email_address = $_POST['email'];
	$error = '';
	if (empty($email_address)) {
		$error = 'You must supply an email address';		
	}
	if( null != username_exists( $email_address ) ) {
		$error = 'That account is already in use.  Please log in';
	}

	if (!empty($error)) {
		wp_safe_redirect( esc_url( add_query_arg( 'error', $error, $_POST['_wp_http_referer'] ) ) );
		exit;
	}
	wp_safe_redirect(esc_url($_POST['_wp_http_referer'] ));
	

}

add_action( 'admin_post_nopriv_data_futures_create_account', 'data_futures_create_account' );
add_action( 'admin_post_data_futures_create_account', 'data_futures_create_account' );


add_action( 'wp_login_failed', 'csjm_login_fail' );  // hook failed login
function csjm_login_fail( $username ) {
     $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
     // if there's a valid referrer, and it's not the default log-in screen
     if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
          wp_redirect(get_permalink() . '/?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
          exit;
     }
}

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-login-logo.png);
		height:65px;
		width:320px;
		background-size: 320px 65px;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

add_action( 'wp_enqueue_scripts', 'styles' );	
	
	


function data_futures_add_meta_boxes( $post ) {

    // Get the page template post meta
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    // If the current page uses our specific
    // template, then output our custom metabox
    if ( 'scrolling-page.php' == $page_template ) {
        add_meta_box(
            'scrolling-page-custom-metabox', // Metabox HTML ID attribute
            'Choose type of page', // Metabox title
            'scrolling_page_template_metabox', // callback name
            'page', // post type
            'normal', // context (advanced, normal, or side)
            'default' // priority (high, core, default or low)
        );
    }

    if (get_option('page_on_front') == get_the_ID()) {
    	add_meta_box(
    		'home_page_page_select',
    		'Select the main content pages to link to',
    		'home_page_page_select_metabox',
    		'page',
    		'normal',
    		'high'
    	);
    } 
    
}
add_action( 'add_meta_boxes_page', 'data_futures_add_meta_boxes' );

function home_page_page_select_metabox($post) {
	$selected_public = get_post_meta( $post->ID, 'public-link', true );
	$selected_entity = get_post_meta( $post->ID, 'entity-link', true );
	
  	wp_nonce_field( basename( __FILE__ ), 'home_page_links_nonce' );
	?>
	<p>These are the blue and orange links on the front page</p>
	<label for="entity_select">Entity page</label><?php
	$args = array(
		'name' => 'entity-link',
		'id' => 'entity_select',
		'selected' => $selected_entity
	);
	wp_dropdown_pages($args);
	?><br/><label for="public_select">Public page</label><?php
	$args = array(
		'name' => 'public-link',
		'id' => 'public_select',
		'selected' => $selected_public
	);
	wp_dropdown_pages($args);
}

function home_page_save_select_metabox($post_id) {
	// Checks save status
	error_log('saving home page');
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'home_page_links_nonce' ] ) && wp_verify_nonce( $_POST[ 'home_page_links_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		error_log('not a manual save or not valid');

        return;
    }
 
	error_log('Updating past meta data to '.$_POST[ 'public-link' ]);
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'public-link' ] ) ) {
        update_post_meta( $post_id, 'public-link', sanitize_text_field( $_POST[ 'public-link' ] ) );
    }
    if( isset( $_POST[ 'entity-link' ] ) ) {
        update_post_meta( $post_id, 'entity-link', sanitize_text_field( $_POST[ 'entity-link' ] ) );
    }


}
add_action( 'publish_page', 'home_page_save_select_metabox' );
add_action( 'draft_page', 'home_page_save_select_metabox' );
add_action( 'future_page', 'home_page_save_select_metabox' );
	

function scrolling_page_template_metabox($post) {
	$selected = get_post_meta( $post->ID, 'scrolling-page-class', true );
    /* Display the post meta box. */
  	wp_nonce_field( basename( __FILE__ ), 'scrolling_page_class_nonce' ); ?>

  <p>
    <label for="scrolling-page-class"><?php _e( "Changes colour of page based on target audience.", 'example' ); ?></label>
    <br />
    <select name="scrolling-page-class" id="scrolling-page-class">
    	<option value="entity" <?php selected( $selected, 'entity'); ?>>Entity</option>
    	<option value="public" <?php selected( $selected, 'public'); ?>>Public</option>
    </select>
  </p>
<?php 
}


function scrolling_page_save_custom_post_meta($post_id) {
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'scrolling_page_class_nonce' ] ) && wp_verify_nonce( $_POST[ 'scrolling_page_class_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'scrolling-page-class' ] ) ) {
        update_post_meta( $post_id, 'scrolling-page-class', sanitize_text_field( $_POST[ 'scrolling-page-class' ] ) );
    }

}
add_action( 'publish_page', 'scrolling_page_save_custom_post_meta' );
add_action( 'draft_page', 'scrolling_page_save_custom_post_meta' );
add_action( 'future_page', 'scrolling_page_save_custom_post_meta' );
	

add_action('edit_page_form', add_instructions);

function add_instructions($post_id) {
	if(get_page_template_slug() === 'scrolling-page.php'){      
        ?>
        <h1>Scrolling page template</h1>
        <p>This is a 'holder' template for the organisation/public pages.  </p>
        <ol>
        <li>Fist, set the page type on the right to either 'public' or 'entity'.  This affects the colour scheme of the page</li>
        <li>Secondly, to add content, create child pages of this page.  Be sure to set the 'order' field, and to give each page a 'feature image' in the options on the right</li>
		</ol>
		<p>The content will then be shown in this page.</p> 
        <?php
    }
}
	
function get_wheels() {
	global $wpdb;
	$wheel_table = $wpdb->prefix . "data_futures_wheel";
	$answers_table = $wpdb->prefix . "data_futures_answers";
	
	$wheels = $wpdb->get_results("SELECT * FROM $wheel_table WHERE user_id = ".get_current_user_id());

	if (empty($wheels)) {
	    create_wheel('New wheel', '');
	    return get_wheels();
	}
	return $wheels;

}



function get_wheel() {
    global $wpdb;
    $wheel_id = $_REQUEST['id'];
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $answers_table = $wpdb->prefix . "data_futures_answers";
    
    $wheels = $wpdb->get_row("SELECT * FROM $wheel_table WHERE user_id = ".get_current_user_id()." AND id = ".sanitize_key($wheel_id));

    if (empty($wheels)) {
        echo '{"error":"invalid"}';
        wp_die();
    }
    
    $answers = $wpdb->get_results("SELECT * FROM $answers_table WHERE wheel_id = ".sanitize_key($wheel_id));
        
    $wheel = array("embedCode" => hash_id($wheels->id), "id" => $wheels->id, "name" => $wheels->name, "url" => $wheels->url, "answers" => $answers);
    
    echo json_encode($wheel);
    wp_die();
}

add_action( 'wp_ajax_get_wheel', get_wheel );
add_action( 'wp_ajax_nopriv_get_wheel', get_wheel );

function get_public_wheel() {
    global $wpdb;
    $wheel_id = $_REQUEST['id'];
    $wheel_id = un_hash($wheel_id);

    error_log('public wheel '.id);
    $answers_table = $wpdb->prefix . "data_futures_answers";
    
    $answers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $answers_table WHERE wheel_id = %d", $wheel_id));
    
    $wheel = array("answers" => $answers);
    echo json_encode($wheel);
    wp_die();
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'dataFutures/v1', '/wheel/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_public_wheel_rest',
    ));
});

function get_public_wheel_rest($data) {
    global $wpdb;
    $wheel_id = $data['id'];
    $wheel_id = un_hash($wheel_id);
    
    error_log('public wheel '.id);
    $answers_table = $wpdb->prefix . "data_futures_answers";
    
    $answers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $answers_table WHERE wheel_id = %d", $wheel_id));
    
    $wheel = array("answers" => $answers);
    return $wheel;
//    wp_die();
}

add_action( 'wp_ajax_public_wheel', get_public_wheel );
add_action( 'wp_ajax_nopriv_public_wheel', get_public_wheel );

add_action( 'wp_ajax_create_wheel', ajax_create_wheel );
add_action( 'wp_ajax_nopriv_create_wheel', ajax_create_wheel );

function get_selected_wheel($wheels) {
    if (isset($_REQUEST['id'])) {
        foreach ($wheels as $candidate) {
            if ($candidate->id == $_REQUEST['id']) {
                return $candidate;
            }
        }
    }
    return $wheels[0];
}

function save_wheel() {
    global $wpdb;
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $wheel_id = $_REQUEST['id'];
    $name = sanitize_text_field($_REQUEST['name']);
    $url = sanitize_text_field($_REQUEST['url']);
    
    if (!is_valid_wheel($wheel_id)) {
        echo '{"error":"invalid"}';
        wp_die();
    }
    $wpdb->update(
        $wheel_table,
        array(
            'name' => stripslashes($name),
            'url'  => stripslashes($url)
        ),
        array(
            'id' => $wheel_id
        ),
        array( '%s', '%s'),
        array( '%d')
    );
}

add_action( 'wp_ajax_save_wheel', save_wheel );
add_action( 'wp_ajax_nopriv_save_wheel', save_wheel );


function save_answer() {
    global $wpdb;
    $answers_table = $wpdb->prefix . "data_futures_answers";
    $wheel_id = $_REQUEST['id'];
    $question = $_REQUEST['question'];
    $answer = sanitize_text_field($_REQUEST['answer']);
    $link = sanitize_text_field($_REQUEST['link']);
    
    if (!is_valid_wheel($wheel_id)) {
        echo '{"error":"invalid"}';
        wp_die();
    }
    
    if (!is_numeric($question)) {
        echo '{"error":"invalid"}';
        wp_die();
    }
    
    if ($question < 1 || $question > 8) {
        echo '{"error":"invalid"}';
        wp_die();
    }
    
    $existing = $wpdb->get_var( "SELECT COUNT(*) FROM $answers_table WHERE question_id = $question AND wheel_id = $wheel_id" );
    if ($existing) {
        $wpdb->update(
            $answers_table,
            array(
                'answer' => stripslashes($answer),
                'link'  => $link
            ),
            array(
                'wheel_id' => $wheel_id,
                'question_id' => $question
            ),
            array( '%s', '%s'),
            array( '%d', '%d')
        );
    } else {
        $wpdb->insert(
            $answers_table,
            array(
                'wheel_id' => $wheel_id,
                'question_id' => $question,
                'answer' => stripslashes($answer),
                'link'  => $link
            ),
            array(
                '%d',
                '%d',
                '%s',
                '%s'
            )
         );
    }  
    
}

add_action( 'wp_ajax_save_answer', save_answer );
add_action( 'wp_ajax_nopriv_save_answer', save_answer );

function is_valid_wheel($id) {
    global $wpdb;
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $wheels = $wpdb->get_row("SELECT * FROM $wheel_table WHERE user_id = ".get_current_user_id()." AND id = ".sanitize_key($id));
    return (!empty($wheels));
}

function ajax_create_wheel() {
    $id = create_wheel('New wheel', '');
    echo "{\"id\":$id}";
}

function create_wheel($name, $url) {
	global $wpdb;
	$wheel_table = $wpdb->prefix . "data_futures_wheel";
	
	$wpdb->insert($wheel_table, array('user_id' => get_current_user_id(), 'name' => $name, 'url' => $url));
	return $wpdb->insert_id;
}


//[button]
function button_func( $atts ){
	if ($atts['type'] == 'attachment') {
		return '<a href="'.wp_get_attachment_url($atts['link']).'" class="btn btn-default">'.$atts['text'].'</a>';
	} else {
		return '<a href="'.get_permalink($atts['link']).'" class="btn btn-default">'.$atts['text'].'</a>';
	}
}
add_shortcode( 'button', 'button_func' );


function wheel_embed($atts) {
    return '<script src="http://localhost:81/dataFutures/wp-content/themes/datafutures/js/dataFutures.js"></script>
        <div id="dataFutures" data-wheel-id="'.$atts["id"].'"></div>';
}

add_shortcode( 'wheel', 'wheel_embed' );

function hash_id($n) {
    $upperlimit = 8388608;
    $buckets = 64;
    return (($n * $upperlimit / $buckets) % $upperlimit) + floor($n / $buckets);
 
}
    
function un_hash($n) {
    
    $upperlimit = 8388608;
    $buckets = 64;
    return (($n % ($upperlimit / $buckets)) * $buckets) + floor($n / ($upperlimit / $buckets));
}


// Function that outputs the contents of the dashboard widget
function dashboard_widget_function( $post, $callback_args ) {
    global $wpdb;
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $number_wheels = $wpdb->get_var("SELECT count(*) FROM $wheel_table");
    
    $number_wheels_week = $wpdb->get_var("SELECT count(*) FROM $wheel_table WHERE creation_time > CURDATE() - INTERVAL 7 DAY");
    $number_wheels_month = $wpdb->get_var("SELECT count(*) FROM $wheel_table WHERE creation_time > CURDATE() - INTERVAL 30 DAY");
    $number_wheels_year = $wpdb->get_var("SELECT count(*) FROM $wheel_table WHERE creation_time > CURDATE() - INTERVAL 365 DAY");
    
    $number_accounts = $wpdb->get_var("SELECT count(distinct user_id) FROM $wheel_table");
    ?>
    <p>Over it's lifetime, <strong><?php echo $number_accounts; ?></strong> people have signed up to create <strong><?php echo $number_wheels ?></strong> unique wheels</p>
    <p>Wheels created in the last week: <?php echo $number_wheels_week; ?></p>
    <p>Wheels created in the last 30 days: <?php echo $number_wheels_month ?></p>
    <p>Wheels created in the last year: <?php echo $number_wheels_year?></p>

    
    <?php 
    $summary = $wpdb->get_results("SELECT YEAR(creation_time) AS year, MONTH(creation_time) AS month, count(*) AS num FROM $wheel_table WHERE creation_time > CURDATE() - INTERVAL 365 DAY GROUP BY YEAR(creation_time), MONTH(creation_time)", 'ARRAY_N');
    
    for ($i = 0; $i < 12; $i++) {
        $months[] = strtotime( date( 'Y-m-01' )." -$i months");
    }
    $months_desc = array_reverse($months);
    
    $graphable = array();
    foreach ($months_desc as $month) {
        $month_num = date('n', $month);
        $year_num = date('Y', $month);
        $found = 0;
        foreach ($summary as $result) {
            if ($result[0] == $year_num && $result[1] == $month_num) {
                $found = $result[2];
            }
        }
        $graphable[date('M', $month)] = $found;   
        
        
    }
    ?>
    <canvas id="wheelSummaryPlot"></canvas> 
    <script>
   	var ctx = document.getElementById("wheelSummaryPlot").getContext("2d");
                        
    var graph = new BarGraph(ctx);
    graph.margin = 2;
    graph.width = 350;
    graph.height = 150;
    graph.xAxisLabelArr = [<?php foreach ($graphable as $key => $value) { echo '"'.$key.'",';}?>];
    graph.update([<?php foreach ($graphable as $key => $value) { echo $value.',';}?>]);
	</script>
    <?php 
}

// Function used in the action hook
function add_dashboard_widgets() {
    wp_add_dashboard_widget('dashboard_widget', 'Wheels Dashboard', 'dashboard_widget_function');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );
?>