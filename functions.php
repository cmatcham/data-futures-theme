<?php

add_action( 'after_switch_theme', 'create_db' );

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



add_theme_support( 'post-thumbnails', array( 'page' ) );

add_action('admin_head', 'remove_content_editor');

/**
 * Remove the content editor from scrolling pages
 */
function remove_content_editor()
{
    //Check against your meta data here
    if(get_page_template_slug() === 'scrolling-page.php'){      
        remove_post_type_support('page', 'editor');         
    }

}


function styles() {
	error_log(get_page_template_slug());
	error_log(is_front_page());
	wp_deregister_script('jquery');
    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', false, '2.1.3');
    wp_enqueue_script('jquery');

	if (get_page_template_slug() === 'scrolling-page.php') {
		wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/css/bootstrap.min.css'), array(), null );
		wp_enqueue_style( 'scrolling', get_theme_file_uri( '/css/scrolling-nav.css'), array(), null );
		
		// Bootstrap Core JavaScript 
		wp_enqueue_script('bootstrap', get_theme_file_uri( '/js/bootstrap.min.js'), array('jquery'), null);
		wp_enqueue_script('jquery-easing', get_theme_file_uri( '/js/jquery.easing.min.js'), array(), null);
		wp_enqueue_script('scrolling', get_theme_file_uri( '/js/scrolling-nav.js'), array(), null);

	} else if (get_page_template_slug() === 'wheel-page.php') {
		
		wp_enqueue_script( 'lz-string', get_theme_file_uri( '/js/lz-string.js' ), array(), null);
		wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), null);
		wp_enqueue_script( 'bootstrapWizard', get_theme_file_uri( '/js/bootstrapWizard.js' ), array( 'jquery' ), '1.0');
		wp_enqueue_script( 'debounce', get_theme_file_uri( '/js/jquery.debounce-1.0.5.js' ), array(), null);
		wp_enqueue_script( 'dataFutures', get_theme_file_uri( '/js/dataFutures.js' ), array(), null);

		wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/css/bootstrap.min.css'), array(), null );
	} else if (is_front_page()) {
		wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), null);
		wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/css/bootstrap.min.css'), array(), null );
	}

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
			<div id="dataFutures"></div>
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
	
	
add_action('wp_ajax_add_transfer', 'process_add_transfer');

function process_add_transfer() {
	if ( empty($_POST) || !wp_verify_nonce($_POST['nonce'],'add_transfer') ) {
	    echo 'You targeted the right function, but sorry, your nonce did not verify.';
	    die();
	} else {
	    // do your function here 
	    wp_redirect($redirect_url_for_non_ajax_request);
	}
}


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

	return $wheels;
/* 	if (empty($wheels)) {
		echo 'and my wheels are empty';
	}
	echo empty($wheels);
	if (is_array($wheels) || is_object($wheels)) {
		foreach ( $wheels as $data_future_wheel) {
			echo 'You have a wheel called '.$data_future_wheel->name;
		}
		echo 'Shown all your wheels';
	} else {
		echo 'You have no wheels, create one here';
	}
 */
}

function get_wheel() {
    global $wpdb;
    $wheel_id = $_REQUEST['id'];
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $answers_table = $wpdb->prefix . "data_futures_answers";
    
    $wheels = $wpdb->get_row("SELECT * FROM $wheel_table WHERE user_id = ".get_current_user_id()." AND id = ".sanitize_key($wheel_id));

    if (empty($wheels)) {
        echo "{'error':'invalid'}";
        wp_die();
    }
    
    $answers = $wpdb->get_results("SELECT * FROM $answers_table WHERE wheel_id = ".sanitize_key($wheel_id));
        
    $wheel = array("id" => $wheels->id, "name" => $wheels->name, "url" => $wheels->url, "answers" => $answers);
    
    echo json_encode($wheel);
    wp_die();
}

add_action( 'wp_ajax_get_wheel', get_wheel );
add_action( 'wp_ajax_nopriv_get_wheel', get_wheel );

function save_answer() {
    global $wpdb;
    $answers_table = $wpdb->prefix . "data_futures_answers";
    $wheel_id = $_REQUEST['id'];
    $question = $_REQUEST['question'];
    $answer = sanitize_text_field($_REQUEST['answer']);
    $link = sanitize_text_field($_REQUEST['link']);
    
    if (!is_valid_wheel($wheel_id)) {
        echo "{'error':'invalid'}";
        wp_die();
    }
    
    if (!is_numeric($question)) {
        echo "{'error':'invalid'}";
        wp_die();
    }
    
    if ($question < 1 || $question > 8) {
        echo "{'error':'invalid'}";
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

function create_wheel($name, $url) {
	global $wpdb;
	$wheel_table = $wpdb->prefix . "data_futures_wheel";
	
	$wpdb->insert($wheel_table, array('user_id' => get_current_user_id(), 'name' => $name, 'url' => $url));
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

?>