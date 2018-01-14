<?php

add_action( 'after_switch_theme', 'create_db' );

include_once 'includes/trusted-data-settings.php';
include_once 'includes/class.uploads.php';
include_once 'advanced-custom-fields/acf.php';


//Our class extends the WP_List_Table class, so we need to make sure that it's there
if(!class_exists('WP_List_Table')){
   require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

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
    $library_image_table = $wpdb->prefix . "data_futures_library_image";
    
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $wheel_table (
		id INT NOT NULL AUTO_INCREMENT,
		user_id BIGINT(20) UNSIGNED NOT NULL,
		name TEXT,
		url VARCHAR(255),
		industry VARCHAR(2),
        creation_time DATETIME DEFAULT CURRENT_TIMESTAMP,
        modification_time DATETIME ON UPDATE CURRENT_TIMESTAMP,
        public_library BIT(1),
        public_library_hash VARCHAR(255),
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
    
    $sql = "CREATE TABLE $library_image_table (
	    wheel_id INT NOT NULL,
		answer TEXT
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
    } else if (get_page_template_slug() === 'assets-page.php') {
        wp_enqueue_style( 'fancybox', get_theme_file_uri( '/css/jquery.fancybox.css'), array(), null );
        wp_enqueue_script('fancybox', get_theme_file_uri( '/js/jquery.fancybox.min.js'), array('jquery'), null);
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
        
    $wheel = array(
        "embedCode" => hash_id($wheels->id), 
        "id" => $wheels->id, 
        "name" => $wheels->name, 
        "url" => $wheels->url, 
        "industry" => $wheels->industry,
        "library" => $wheels-> public_library,
        "public_library_hash" => $wheels -> public_library_hash,
        "answers" => $answers
    );
    
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

function get_public_library_dials() {
    global $wpdb;
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $answers_table = $wpdb->prefix . "data_futures_answers";
    
    $wheels = $wpdb->get_results("SELECT * FROM $wheel_table WHERE public_library = true");

    if (count($wheels) == 0) {
        return array();
    }

    foreach ($wheels as $wheel) {
        $answers = $wpdb->get_results($wpdb->prepare("SELECT * FROM $answers_table WHERE wheel_id = %d", $wheel->id));
        $wheel -> answers = $answers;
    }
        
    return $wheels;

}

function get_public_library_dial_by_approval($hash) {
	global $wpdb;
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $wheels = $wpdb->get_row("SELECT * FROM $wheel_table WHERE public_library_hash = '$hash'");

    if (empty($wheels)) {
		return false;
    }
    
    $wpdb->update(
        $wheel_table,
        array(
            'public_library'   => 1
        ),
        array(
            'id' => $wheels->id
        ),
        array( '%d'),
        array( '%d')
        );
        
	return true;
    
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
    $industry = sanitize_text_field($_REQUEST['industry']);
    
    
    
    if (!is_valid_wheel($wheel_id)) {
        echo '{"error":"invalid"}';
        wp_die();
    }
    $wpdb->update(
        $wheel_table,
        array(
            'name' => stripslashes($name),
            'url'  => stripslashes($url),
            'industry' => stripslashes($industry),
            'public_library'    => 0,
            'public_library_hash'   => null
        ),
        array(
            'id' => $wheel_id
        ),
        array( '%s', '%s', '%s', '%d', '%s'),
        array( '%d')
    );
}

add_action( 'wp_ajax_save_wheel', save_wheel );
add_action( 'wp_ajax_nopriv_save_wheel', save_wheel );


function save_answer() {
    global $wpdb;
    $answers_table = $wpdb->prefix . "data_futures_answers";
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
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
    
    $wpdb->update(
        $wheel_table,
        array(
            'public_library'    => 0,
            'public_library_hash'   => null
        ),
        array(
            'id' => $wheel_id
        ),
        array( '%d', '%s'),
        array( '%d')
        );
    
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
    $vars[] = "approve";
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
    
    add_rewrite_rule('^dial-library','index.php?pagename=library', 'top');
    add_rewrite_endpoint( 'dial-library', EP_PERMALINK | EP_PAGES );
    
    add_rewrite_rule('^dial-font', 'index.php?pagename=dial-font', 'top');
    add_rewrite_endpoint( 'dial-font', EP_PERMALINK | EP_PAGES );
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
    } else if ('dial-font' == $dials_page) {
		$name = get_template_directory().'/fonts/MyriadPro-Light.otf';
    	$rsc = fopen($name, 'rb');
    	header("HTTP/1.1 200 OK");
    	header("Access-Control-Allow-Origin: *");
    	header("Content-Type: application/x-font-opentype");
    	header("Content-Length: " . filesize($name));
    	fpassthru($rsc);
    	exit;
    } else if ('library' == $dials_page) {
    	error_log("approval: " . get_query_var('approve'));

		
        header("HTTP/1.1 200 OK");
        include( get_template_directory().'/library-page.php');
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
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    $number_views = $wpdb->get_var("SELECT count(*) FROM $views_table");

	$top_views = $wpdb->get_results("SELECT count($views_table.wheel_id) AS count, $views_table.wheel_id, $wheel_table.name FROM $views_table JOIN $wheel_table ON $views_table.wheel_id = $wheel_table.id GROUP BY wheel_id, name ORDER BY count(wheel_id) DESC");
    
    $number_wheels_week = $wpdb->get_var("SELECT count(*) FROM $views_table WHERE view_time > CURDATE() - INTERVAL 7 DAY");
    $number_wheels_month = $wpdb->get_var("SELECT count(*) FROM $views_table WHERE view_time > CURDATE() - INTERVAL 30 DAY");
    $number_wheels_year = $wpdb->get_var("SELECT count(*) FROM $views_table WHERE view_time > CURDATE() - INTERVAL 365 DAY");
    
    ?>
    <p>Since October 2017, a total of <strong><?php echo $number_views; ?></strong> views have been made across all dials. The top three dials are:</p>
    <ul>
    	<?php foreach (array_slice($top_views,0,3) AS $result) {
    		echo "<li><a href='/public-dials/" . hash_id($result->wheel_id) . "'>Wheel " . $result->wheel_id . ": " . $result->name . "</a> with " . $result->count . " views</li>";
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
    } else if ('library' == $dials_page) {
    	echo 'Public library';
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

class Dial_List_Table extends WP_List_Table {

   /**
    * Constructor, we override the parent to pass our own arguments
    * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
    */
    function __construct() {
       parent::__construct( array(
      'singular'=> 'wp_list_text_link', //Singular label
      'plural' => 'wp_list_test_links', //plural label, also this well be one of the table css class
      'ajax'   => false //We won't support Ajax for this table
      ) );
    }
    
    /**
	 * Add extra markup in the toolbars before or after the list
	 * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
	 */
	function extra_tablenav( $which ) {
	   if ( $which == "top" ){
	      //The code that goes before the table is here
	      //echo"Hello, I'm before the table";
	   }
	   if ( $which == "bottom" ){
	      //The code that goes after the table is there
	      //echo"Hi, I'm after the table";
	   }
	}
	
	/**
	 * Define the columns that are going to be used in the table
	 * @return array $columns, the array of columns to use with the table
	 */
	function get_columns() {
	   return $columns = array(
	      'id'=>__('ID'),
	      'name'=>__('Name'),
	      'url'=>__('Url'),
	      'public_library' => 'Public library'
	   );
	}
	
	/**
	 * Decide which columns to activate the sorting functionality on
	 * @return array $sortable, the array of columns that can be sorted by the user
	 */
	function get_sortable_columns() {
	   return $sortable = array(
	      'id'=> array('id', false),
	      'name'=> array('name', false),
	      'url'=> array('url', false),
	      'public_library' => array('public_library', false)
	   );
	}
	
	/**
	 * Prepare the table with different parameters, pagination, columns and table elements
	 */
	function prepare_items() {
	   global $wpdb, $_wp_column_headers;
	   $screen = get_current_screen();
	   $wheel_table = $wpdb->prefix . "data_futures_wheel";
	
	   /* -- Preparing your query -- */
	        $query = "SELECT * FROM $wheel_table";
	
	   /* -- Ordering parameters -- */
	       //Parameters that are going to be used to order the result
	       $orderby = !empty($_GET["orderby"]) ? $_GET["orderby"] : 'ASC';
	       $order = !empty($_GET["order"]) ? $_GET["order"] : '';
	       if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }
	
	   /* -- Pagination parameters -- */
	        //Number of elements in your table?
	        $totalitems = $wpdb->query($query); //return the total number of affected rows
	        //How many to display per page?
	        $perpage = 5;
	        //Which page is this?
	        $paged = !empty($_GET["paged"]) ? $_GET["paged"] : '';
	        //Page Number
	        if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; } //How many pages do we have in total? 
	        $totalpages = ceil($totalitems/$perpage); //adjust the query to take pagination into account 
	        if(!empty($paged) && !empty($perpage)){ 
	        	$offset=($paged-1)*$perpage; $query.=' LIMIT '.(int)$offset.','.(int)$perpage; 
	        } /* -- Register the pagination -- */ 
	        $this->set_pagination_args( array(
	         "total_items" => $totalitems,
	         "total_pages" => $totalpages,
	         "per_page" => $perpage,
	      ) );
	      //The pagination links are automatically built according to those parameters
	
	   /* -- Register the Columns -- */
	      $columns = $this->get_columns();
	      $_wp_column_headers[$screen->id]=$columns;
	      
	      $this->_column_headers = array( 
			 $this->get_columns(),		// columns
			 array(),			// hidden
			 $this->get_sortable_columns(),	// sortable
		);
	
	   /* -- Fetch the items -- */
	      $this->items = $wpdb->get_results($query);
	}
	
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display_rows() {
	
	   //Get the records registered in the prepare_items method
	   $records = $this->items;
	
	   //Get the columns registered in the get_columns and get_sortable_columns methods
	   list( $columns, $hidden ) = $this->get_column_info();
		$columns = $this->get_columns();
	
	   //Loop for each record
	   if(!empty($records)){
	   	foreach($records as $rec) {
	
	      //Open the line
	        echo '<tr id="record_'.$rec->id.'">';
	        foreach ( $columns as $column_name => $column_display_name ) {
			
	         //Style attributes for each col
	         $class = "class='$column_name column-$column_name'";
	         $style = "";
	         if ( in_array( $column_name, $hidden ) ) $style = ' style="display:none;"';
	         $attributes = $class . $style;
	
	         //edit link
	         $editlink  = '/wp-admin/link.php?action=edit&link_id='.(int)$rec->link_id;
	
	         //Display the cell
	         switch ( $column_name ) {
	            case "id":  echo '<td '.$attributes.'><a href="/public_dials/'.hash_id($rec->id).'">'.$rec->id.'</a></td>';   break;
	            case "name": echo '<td '.$attributes.'>'.stripslashes($rec->name).'</td>'; break;
	            case "url": echo '<td '.$attributes.'>'.stripslashes($rec->url).'</td>'; break;
	            case "public_library": echo '<td '.$attributes.'>'.($rec->public_library === 1 ? 'Yes' : 'No') .'</td>'; break;
	         }
	      }
	
	      //Close the line
	      echo'</tr>';
	   }}
	}

}

/** Step 2 (from text above). */
add_action( 'admin_menu', 'list_dials_menu' );

/** Step 1. */
function list_dials_menu() {
	add_options_page( 'Dials', 'Dials', 'manage_options', 'list-dials', 'list_dials_cb' );
}

/** Step 3. */
function list_dials_cb() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	$wp_list_table = new Dial_List_Table();
	$wp_list_table->prepare_items();
	$wp_list_table->display();
	echo '</div>';
}

function generate_public_library_hash($wheel_id) {
    global $wpdb;
    $wheel_table = $wpdb->prefix . "data_futures_wheel";
    
    if (!is_valid_wheel($wheel_id)) {
        return;
    }
    
    $hash = substr(base64_encode(mt_rand()), 0, 15);
    
    print_r('updating wheel '.$wheel_id.' with hash '.$hash);
    echo('updating wheel '.$wheel_id.' with hash '.$hash);
    
    
    $wpdb->update(
        $wheel_table,
        array(
            'public_library_hash'   => $hash
        ),
        array(
            'id' => $wheel_id
        ),
        array( '%s'),
        array( '%d')
        );
    return $hash;
}

function send_library_approval_mail() {
    $dial_id = $_REQUEST['id'];

    if (!is_user_logged_in()) {
		return;
	}
	
	global $current_user;
    get_currentuserinfo();
	
	$dial = get_public_wheel_details(hash_id($dial_id));
	
	if ($dial -> user_id != $current_user -> ID) {
	    echo $dial->user_id;
	    echo ",";
	    echo $current_user -> ID;
	    echo json_encode(array("error" => "Invalid"));
	    wp_die();
	}
	
	$hash = generate_public_library_hash($dial->id);
	
	$to = $current_user->user_email;

    $subject = 'Publish your Trusted Data Dial to the public library?';
	$body = <<<EOD
Thank you for agreeing to publish your trusted data dial to the public library.  To complete the process, please click the link below:

https://trusteddata.co.nz/dial-library?approve=${hash}

If you make any changes to your dial, it will be removed from the library and you will need to approve it again.

The Data Futures team.
EOD;
	$headers = array('From: Trusted Data <info@datafutures.co.nz');
 
	wp_mail( $to, $subject, $body, $headers );
	
	echo json_encode(array("email" => $current_user->user_email));
	wp_die();
}

function approve_library($hash) {
	$approved = get_public_library_dial_by_approval($hash);	
	return $approved;
	
}

add_action( 'wp_ajax_library_approval', send_library_approval_mail );
add_action( 'wp_ajax_nopriv_library_approval', send_library_approval_mail );

function get_industry_codes() {
	return array(
		'A'	=> 'Agriculture, Forestry and Fishing',
		'B'	=> 'Mining',
		'C' => 'Manufacturing',
		'D' => 'Electricity, Gas, Water and Waste Services',
		'E' => 'Construction',
		'F' => 'Wholesale Trade',
		'G' => 'Retail Trade',
		'H' => 'Accommodation and Food Services',
		'I' => 'Transport, Postal and Warehousing',
		'J' => 'Information Media and Telecommunications',
		'K' => 'Financial and Insurance Services',
		'L' => 'Rental, Hiring and Real Estate Services',
		'M' => 'Professional, Scientific and Technical Services',
		'N' => 'Administrative and Support Services',
		'O' => 'Public Administration and Safety',
		'P' => 'Education and Training',
		'Q' => 'Health Care and Social Assistance',
		'R' => 'Arts and Recreation Services',
		'S' => 'Other Services'
	);
}

function library_image_upload_load_scripts() {
    wp_enqueue_script('image-form-js', get_template_directory_uri() . '/js/library-image-upload.js', array('jquery'), '0.1.0', true);
    
    $uploads = wp_upload_dir();
    $basedir = $uploads["baseurl"] . "/publicLibrary";
    
    $data = array(
        'upload_url' => admin_url('async-upload.php'),
        'ajax_url'   => admin_url('admin-ajax.php'),
        'nonce'      => wp_create_nonce('media-form'),
        'upload_basedir' => $basedir
    );
    
    wp_localize_script( 'image-form-js', 'su_config', $data );
}
add_action('wp_enqueue_scripts', 'library_image_upload_load_scripts');

function image_upload_form_html($dial_id){
    ob_start();
    ?>
        <?php if ( is_user_logged_in() ): ?>
            <p class="form-notice"></p>
            <form action="" method="post" class="image-form">
                <?php wp_nonce_field('image-submission'); ?>
                <p class="image-notice"></p>
                <p><label>Replace logo: </label><input type="file" name="async-upload" class="image-file" accept="image/*" value="Change image" required></p>
                <input type="hidden" name="image_id">
                <input type="hidden" name="dialId" value="<?php echo $dial_id; ?>"/>
                <input type="hidden" name="action" value="image_submission">
            </form>
        <?php else: ?>
            <p>Please <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>">login</a> first to submit your image.</p>
        <?php endif; ?>
    <?php
    $output = ob_get_clean();
    return $output;
}

function allow_client_to_uploads() {
    $client = get_role('client');
    
    if ( ! $client->has_cap('upload_files') ) {
        $client->add_cap('upload_files');
    }
}
add_action('admin_init', 'allow_client_to_uploads');

add_filter('wp_handle_upload_prefilter', 'my_upload_prefilter');
add_filter('wp_handle_upload', 'my_handle_upload');

function my_upload_prefilter( $file ) {
    add_filter('upload_dir', 'my_custom_upload_dir');
    return $file;
}

function get_library_dial_image($dialid) {
    $uploads = wp_upload_dir();
    $basedir = $uploads["basedir"] . "/publicLibrary/" . $dialid;
    error_log("Looking for ". $basedir . "/" . $dialid . ".png");
    if (file_exists($basedir . "/" . $dialid . ".png")) {
        error_log(print_r($uploads,true));
        return $uploads["baseurl"] . "/publicLibrary/$dialid/$dialid.png";
    } else {
        return get_theme_file_uri('images/library-dial.png');
    }
}

function my_handle_upload( $fileinfo ) {
    remove_filter('upload_dir', 'my_custom_upload_dir');

    if(null !==  $_REQUEST["publicLibrary"]) {
        $dial = $_REQUEST["dialId"];
        if (is_valid_wheel($dial)) {
            
            $handle = new upload($fileinfo["file"]);
            $handle->allowed = 'image/*';
            $handle->image_convert = 'png';
            $handle->image_x = 220;
            $handle->image_y  = 200;
            $handle->image_resize = true;
            $handle->image_ratio = true;
            $handle->process(wp_upload_dir()["basedir"] . "/publicLibrary/" . $dial);
            
            if (!$handle->processed) {
                $fileinfo["error"] = $handle->error;
                return $fileinfo;
            }
            if (!copy($handle->file_dst_pathname , $handle->file_dst_path . $dial . ".png")) {
                error_log ("failed to copy to $handle->file_dst_path / $dial .png...\n");
            }
            unlink($handle->file_dst_pathname);
            
            $handle->allowed = 'image/*';
            $handle->image_convert = 'png';
            $handle->image_x = 220;
            $handle->image_y  = 200;
            $handle->image_resize = true;
            $handle->image_ratio = true;
            $handle->image_greyscale = true;
            $handle->process(wp_upload_dir()["basedir"] . "/publicLibrary/" . $dial);
            copy($handle->file_dst_pathname , $handle->file_dst_path . $dial . "-grey.png");
            unlink($handle->file_dst_pathname);
        }
    }
    
    return $fileinfo;
}   

function my_custom_upload_dir($path) {
    if(null !==  $_REQUEST["publicLibrary"]) {
        $mydir = '/publicLibrary';
        
        $path['subdir']  = $mydir;
        $path['path']   = $path['basedir'].$mydir;
        $path['url']    = $path['baseurl'].$mydir;
    }
    
    error_log(print_r($path, true));
    return $path; //altered or not
}


?>
