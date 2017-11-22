<?php

add_action( 'after_switch_theme', 'create_db' );

/* add_action( 'template_redirect', 'wpse_76802_maintance_mode' );
function wpse_76802_maintance_mode() {
    if ( is_page( 48 ) ) {
        wp_redirect( esc_url_raw( home_url( 'index.php?page_id=2' ) ) );
        exit;
    }
}
 */

function create_db() {
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
    global $wpdb;
    $users_table = $wpdb->prefix . "users";
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $answers_table = $wpdb->prefix . "data_futures_answers";
    $views_table = $wpdb->prefix . "data_futures_views";
    
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

     $sql = "CREATE TABLE $views_table (
        id INT NOT NULL AUTO_INCREMENT,
        wheel_id INT NOT NULL,
        ip VARCHAR(50),
        view_time DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    dbDelta($sql);

    
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
    wp_footer();
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
      				<li><a href="http://datafutures.co.nz">Brought to you by the <img src="<?php echo get_theme_file_uri('images/dfp_logo.png')?>"/></li>
    			</ul>
    		</div>
    	</div>
    </div>
</footer>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68230113-13', 'auto');
  ga('send', 'pageview');

</script>
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
    
    //failed login?
    if ($_REQUEST['login'] == 'failed') {
        $error = 'Invalid login, please try again.';
    }
    
    
?>
<div class="container">
	<div class="row" style="padding-top:60px;">
		<div class="col-md-12">
		<h1 class="heading">Create your own data-use dial!</h1>
		</div>
		<div class="col-md-6">
			<p>By answering the eight questions, you can create an embeddable widget for your website to give your customers surety about how you use their data.</p>
			<p>Create an account or log in now to continue.</p>



					<div id="loginCreateTabContent" class="tab-content">
						<div class="tab-pane active in" id="login">
							<?php if (!empty($message)) { ?>
							<div class="alert alert-success" role="alert"><?php echo $message ?></div>
							<?php } ?>
							<?php if (!empty($error) && $screen == 'login') { ?>
							<div class="alert alert-danger" role="alert"><?php echo $error ?></div>
							<?php } ?>
							<form action="<?php echo wp_login_url(); ?>" method="post">
								<div class="form-group">
				    				<input type="email" class="form-control" id="loginEmail" placeholder="Email" name="log">
				    			</div>
				    			<div class="form-group">
									<input type="password" name="pwd" class="form-control" id="loginPassword" placeholder="Password">
								</div>
								<div class="form-group">
									<input name="rememberme" type="checkbox" id="rememberme" value="forever" checked="checked">
									Remember Me
									</label>
								</div>
								
								<input type="hidden" name="redirect_to" value="<?php echo get_permalink();?>">
								<ul class="nav nav-pills" >
									<li><button type="submit" name="wp-submit" value="Log in" class="btn btn-default" style="background-color: #5085a0;color:white">Log in</button></li>
									<li style="margin-left:20px; padding-left: 20px; border-left:1px #ccc solid;border-radius:inherit;line-height:10px"><a href="#create" id="createAccountTab">Create Account</a></li>
								</ul>
							</form>
						</div>
						<div class="tab-pane fade" id="create">
							<form action="<?php echo esc_url(get_permalink()) ?>" method="post">
								<input type="hidden" name="action" value="data_futures_create_account"/>
								<?php wp_nonce_field( 'create_account_nonce', 'data_futures_create_account' );  ?>
								<?php if (!empty($error) && $screen == 'create') { ?>
								<div class="alert alert-danger" role="alert"><?php echo $error ?></div>
								<?php } ?>
								<div class="form-group">
				    				<input type="email" class="form-control" id="createEmail" placeholder="Email" name="email">
				    			</div>
				    			<div class="form-group">
									<input type="password" name="pwd" class="form-control" id="createPassword" placeholder="Password">
								</div>
				    			<div class="form-group">
									<input type="password" name="pwd2" class="form-control" id="createPassword2" placeholder="Confirm password">
								</div>
								<ul class="nav nav-pills" >
									<li style="margin-right:20px; padding-right: 20px; border-right:1px #ccc solid;border-radius:inherit;line-height:10px"><a href="#login" id="loginTab">Login</a></li>
									<li><button type="submit" name="wp-submit" value="Log in" class="btn btn-default" style="background-color: #5085a0;color:white">Create Account</button></li>
								</ul>
							
								
							</form>
						</div>
					</div>
					<!-- ul class="nav nav-pills" >
						<li class="active"><a href="#login" data-toggle="tab">Login</a></li>
						<li><a href="#create" data-toggle="tab" id="createAccountTab">Create Account</a></li>
					</ul -->
		</div>
		<div class="col-md-6">
			<div id="dataFutures" data-disclaimer="none" data-style="none"></div>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function() {
	$('#createAccountTab').click(function(evt) {
		evt.preventDefault();
		$('#create').removeClass('fade').addClass('active in');
		$('#login').removeClass('active in').addClass('fade');
	});
	$('#loginTab').click(function(evt) {
		evt.preventDefault();
		$('#login').removeClass('fade').addClass('active in');
		$('#create').removeClass('active in').addClass('fade');
	});
});
</script>

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

         wp_redirect($referrer . '/?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
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
	    create_wheel('New dial', '');
	    return get_wheels();
	}
	return $wheels;

}

function get_public_wheel_details($id) {
    $wheel_id = un_hash($id);
    global $wpdb;
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $wheel = $wpdb->get_row("SELECT * FROM $wheel_table WHERE id = ".sanitize_key($wheel_id));
    return $wheel;
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
    
    $answers_table = $wpdb->prefix . "data_futures_answers";
    
    $answers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $answers_table WHERE wheel_id = %d", $wheel_id));
    
    $wheel = array("answers" => $answers);

    log_dial_request($wheel_id);
    return $wheel;
//    wp_die();
}

function log_dial_request($wheel_id) {
    global $wpdb;
    $ip = $_SERVER['REMOTE_ADDR'];
    $views_table = $wpdb->prefix . "data_futures_views";

    $wpdb->insert(
    $views_table,
    array(
        'wheel_id' => $wheel_id,
        'ip'  => $ip
    ),
    array(
        '%d',
        '%s'
    ));

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'dataFuturesAdmin/v1', '/all', array(
        'methods' => 'GET',
        'callback' => 'admin_get_all_wheels',
    ));
});

function admin_get_all_wheels($data) {
    global $wpdb;

    $answers_table = $wpdb->prefix . "data_futures_answers";
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    
    $answers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wheel_table JOIN $answers_table ON $answers_table.wheel_id = $wheel_table.id", $wheel_id));
    
    $wheel = array("wheels" => $answers);
    return $wheel;
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
    return '<script src="https://trusteddata.co.nz/media/dataFutures.js"></script>
        <div id="dataFutures" data-wheel-id="'.$atts["id"].'"></div>';
}

add_shortcode( 'wheel', 'wheel_embed' );

function flowchart($atts) {
    $code = file_get_contents(get_theme_file_uri('includes/flowchart.html'));
    return $code;
}

add_shortcode('flowchart', 'flowchart');

function add_dial_query_vars_filter( $vars ){
    $vars[] = "dial";
    return $vars;
}
add_filter( 'query_vars', 'add_dial_query_vars_filter' );

function public_dials_rewrite_rule() {
    add_rewrite_rule('^public-dials/([0-9]+)?','index.php?pagename=public-dial&dial=$matches[1]','top');
    add_rewrite_endpoint( 'public-dials', EP_PERMALINK | EP_PAGES );
    add_rewrite_rule('^download-dials/([0-9]+)?','index.php?pagename=download_dials', 'top');
    add_rewrite_endpoint( 'download-dials', EP_PERMALINK | EP_PAGES );
    add_rewrite_rule('^pdf-dials/([0-9]+)?','index.php?pagename=pdf-dial&dial=$matches[1]', 'top');
    add_rewrite_endpoint( 'download-dials', EP_PERMALINK | EP_PAGES );
}
add_action('init', 'public_dials_rewrite_rule', 10, 0);

function download_dials_display() {
    $dials_page = get_query_var('pagename');
    if ('download_dials' == $dials_page) {
        header("HTTP/1.1 200 OK");
        download_image_link();
        exit;
    } else if ('public-dial' == $dials_page) {
        header("HTTP/1.1 200 OK");
        include( get_template_directory().'/public-dial-page.php');
        exit;
    } else if ('pdf-dial' == $dials_page) {
        header("HTTP/1.1 200 OK");
        include( get_template_directory().'/pdfgen.php');
        exit;
    }
}

//register plugin custom pages display
add_filter('template_redirect', 'download_dials_display');

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
    $summary = $wpdb->get_results("SELECT YEAR(creation_time) AS year, MONTH(creation_time) AS month, count(*) AS num FROM $wheel_table WHERE creation_time >= CURDATE() - INTERVAL 365 DAY GROUP BY YEAR(creation_time), MONTH(creation_time)", 'ARRAY_N');
    
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

// Function that outputs the contents of the dashboard widget
function dashboard_views_widget_function( $post, $callback_args ) {
    global $wpdb;
    $views_table = $wpdb->prefix . "data_futures_views";
    $number_views = $wpdb->get_var("SELECT count(*) FROM $views_table");

	$top_views = $wpdb->get_results("SELECT count(wheel_id) AS count, wheel_id FROM $views_table GROUP BY wheel_id ORDER BY count(wheel_id) DESC");
    
    $number_wheels_week = $wpdb->get_var("SELECT count(*) FROM $views_table WHERE view_time > CURDATE() - INTERVAL 7 DAY");
    $number_wheels_month = $wpdb->get_var("SELECT count(*) FROM $views_table WHERE view_time > CURDATE() - INTERVAL 30 DAY");
    $number_wheels_year = $wpdb->get_var("SELECT count(*) FROM $views_table WHERE view_time > CURDATE() - INTERVAL 365 DAY");
    
    ?>
    <p>Since October 2017, a total of <strong><?php echo $number_views; ?></strong> views have been made across all dials. The top three dials are:</p>
    <ul>
    	<?php foreach ($top_views AS $result) {
    		echo "<li><a href='/public-dials/" . hash_id($result->wheel_id) . "'>Wheel " . $result->wheel_id . "</a> with " . $result->count . " views</li>";
    	} ?>
    </ul>
    	
    <p>Views in the last week: <?php echo $number_wheels_week; ?></p>
    <p>Views in the last 30 days: <?php echo $number_wheels_month ?></p>
    <p>Views in the last year: <?php echo $number_wheels_year?></p>

    
    <?php 
    $summary = $wpdb->get_results("SELECT YEAR(view_time) AS year, MONTH(view_time) AS month, count(*) AS num FROM $views_table WHERE view_time > CURDATE() - INTERVAL 365 DAY GROUP BY YEAR(view_time), MONTH(view_time)", 'ARRAY_N');
    
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
    <canvas id="viewsSummaryPlot"></canvas> 
    <script>
    var ctx = document.getElementById("viewsSummaryPlot").getContext("2d");
                        
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
    wp_add_dashboard_widget('dashboard_views_widget', 'Views Dashboard', 'dashboard_views_widget_function');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );


function download_image_link() {
    $imgPng = imageCreateFromPng(get_template_directory() . '/data-dial.png');
    imageAlphaBlending($imgPng, true);
    imageSaveAlpha($imgPng, true);
    
    $background_color = imagecolorallocate($imgPng, 0, 0, 0);
    $text_color = imagecolorallocate($imgPng, 233, 14, 91);
   
    $white = imagecolorallocate($imgPng, 255, 255, 255);
    $grey = imagecolorallocate($imgPng, 128, 128, 128);
    $black = imagecolorallocate($imgPng, 0, 0, 0);
    imagefilledrectangle($imgPng, 0, 0, 399, 29, $white);
    
    // The text to draw
    $text = 'Testing...';
    // Replace path by your own font path
    $font = get_template_directory() . '/arial.ttf';
    
    // Add some shadow to the text
    imagettftext($imgPng, 10, 0, 11, 21, $grey, $font, $text);
    
    // Add the text
    imagettftext($imgPng, 10, 0, 10, 20, $black, $font, $text);
    
    
//    imagestring($imgPng, 5, 50, 50, "A Simple Text String", $text_color);
    /* Output image to browser */
    header("Content-type: image/png");
    imagePng($imgPng);
    
}

function data_futures_title() {
    $dials_page = get_query_var('pagename');
    if('public-dial' == $dials_page){
        echo 'Dial';
    } else {
        wp_title('');
    }
}

//customizer
function datafutures_customize_register( $wp_customize ) {
    // Do stuff with $wp_customize, the WP_Customize_Manager object.
    
    $wp_customize->add_section( 'datafutures_background_section' , array(
        'title'       => __( 'Background', 'datafutures' ),
        'priority'    => 30,
        'description' => 'Upload multiple backgrounds that the homepage will cycle through.',
    ) );
    
    $wp_customize->add_setting( 'datafutures_background_1' );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'datafutures_background_1', array(
        'label'    => __( 'Background 1', 'datafutures' ),
        'section'  => 'datafutures_background_section',
        'settings' => 'datafutures_background_1',
    ) ) );
    
    $wp_customize->add_setting( 'datafutures_background_2' );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'datafutures_background_2', array(
        'label'    => __( 'Background 2', 'datafutures' ),
        'section'  => 'datafutures_background_section',
        'settings' => 'datafutures_background_2',
    ) ) );

    $wp_customize->add_setting( 'datafutures_background_3' );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'datafutures_background_3', array(
        'label'    => __( 'Background 3', 'datafutures' ),
        'section'  => 'datafutures_background_section',
        'settings' => 'datafutures_background_3',
    ) ) );
    
    $wp_customize->add_setting( 'datafutures_background_4' );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'datafutures_background_4', array(
        'label'    => __( 'Background 4', 'datafutures' ),
        'section'  => 'datafutures_background_section',
        'settings' => 'datafutures_background_4',
    ) ) );
    
    $wp_customize->add_setting( 'datafutures_background_5' );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'datafutures_background_5', array(
        'label'    => __( 'Background 5', 'datafutures' ),
        'section'  => 'datafutures_background_section',
        'settings' => 'datafutures_background_5',
    ) ) );

}
add_action( 'customize_register', 'datafutures_customize_register' );


?>
