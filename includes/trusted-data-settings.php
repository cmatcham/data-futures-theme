<?php
add_action( 'admin_menu', 'trusted_data_admin_menu' );

function trusted_data_admin_menu() {
    add_options_page('Trusted Data settings', 'Trusted Data settings', 'manage_options', 'trusted_data', 'trusted_data_options_page' );
}
add_action( 'admin_init', 'trusted_data_settings_init' );
function trusted_data_settings_init() {
  
    register_setting('trusted-data-settings-group', 'library_email_subject');
    register_setting('trusted-data-settings-group', 'library_email_body');
    
    // register a new section in the "reading" page
    add_settings_section(
        'trusted_data_settings_section',
        'Trusted Data Settings Section',
        'trusted_data_settings_section_cb',
        'trusted_data'
        );
    
    // register a new field in the "rwnz_settings_section" section, inside the "reading" page
    add_settings_field(
        'library_email_subject',
        'Library Email Subject',
        'library_email_subject_cb',
        'trusted_data',
        'trusted_data_settings_section'
        );
    
    add_settings_field(
        'library_email_body',
        'Library Email Body',
        'library_email_body_cb',
        'trusted_data',
        'trusted_data_settings_section'
        );
    
    /* 
	 * http://codex.wordpress.org/Function_Reference/register_setting
	 * register_setting( $option_group, $option_name, $sanitize_callback );
	 * The second argument ($option_name) is the option name. It’s the one we use with functions like get_option() and update_option()
	 * */
  	register_setting( 'trusted-data-settings-group', 'trusted-data-settings' );
	
}


/* 
 * THE ACTUAL PAGE 
 * 
 */
function trusted_data_options_page() {
?>
  <div class="wrap">
      <h2>Trusted Data Settings</h2>
      <form action="options.php" method="POST">
        <?php settings_fields('trusted-data-settings-group'); ?>
        <?php do_settings_sections('trusted_data'); ?>
        <?php submit_button(); ?>
      </form>
  </div>
<?php 
}



/**
 * callback functions
 */

// section content cb
function trusted_data_settings_section_cb() {
    echo '<p>To fully activate the RWNZ theme, you need to complete this section with your API keys etc.</p>';
}

// field content cb
function library_email_body_cb() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('library_email_subject');
    // output the field
    wp_editor( $setting, 'library_email_subject_editor', $settings = array() );
}

function library_email_subject_cb() {
	// get the value of the setting we've registered with register_setting()
	$setting = get_option('library_email_subject');
	// output the field
	?>
	<input type="text" class="regular-text" name="library_email_subject" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
	<?php
}


?>