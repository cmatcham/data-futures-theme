<?php /* Template Name: Public dials display */ ?>
<?php acf_form_head(); ?>
<?php get_header(); ?>

<?php 

/*

// Deal with images uploaded from the front-end while allowing ACF to do it’s thing
function my_acf_pre_save_post($post_id) {

if ( !function_exists(‘wp_handle_upload’) ) {
require_once(ABSPATH . ‘wp-admin/includes/file.php’);
}

// Move file to media library
$movefile = wp_handle_upload( $_FILES[‘my_image_upload’], array(‘test_form’ => false) );

// If move was successful, insert WordPress attachment
if ( $movefile && !isset($movefile[‘error’]) ) {
$wp_upload_dir = wp_upload_dir();
$attachment = array(
‘guid’ => $wp_upload_dir[‘url’] . ‘/’ . basename($movefile[‘file’]),
‘post_mime_type’ => $movefile[‘type’],
‘post_title’ => preg_replace( ‘/\.[^.]+$/’, ”, basename($movefile[‘file’]) ),
‘post_content’ => ”,
‘post_status’ => ‘inherit’
);
$attach_id = wp_insert_attachment($attachment, $movefile[‘file’]);

// Assign the file as the featured image
set_post_thumbnail($post_id, $attach_id);
update_field(‘my_image_upload’, $attach_id, $post_id);

}

return $post_id;

}

add_filter(‘acf/pre_save_post’ , ‘my_acf_pre_save_post’);

*/
?>

<style>
#dataFuturesGuidelinesAnswers {
	width: 40%;
}
@media(max-width:767px) {
    #dataFuturesWheelCanvas {
		display: block;
		margin:auto;
    }
    #dataFuturesGuidelinesAnswers {
		display:block;
		margin: auto;
    	width: 80%;
    }
}
.inline {
    display: inline-block;
    vertical-align: top;
}
.answers {
	max-width: 550px;
	padding-left: 20px;
}
.question h1 {
	font-size: 14pt;
}
h2 {
	color: #5085a0;
	font-size: 20px;
}
</style>
<div class="public">
<h1 class="heading">Public library</h1>

<div class="container">
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>TAG The Agency</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>Social Media NZ</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>XERO</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>Mastercard</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>Hubspot</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>Toshiba</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>This is a dial</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>This is a dial</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>This is a dial</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>This is a dial</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>This is a dial</h2>
</div>
<div class="col-lg-3 col-md-4 col-sm-6">
	<h2>This is a dial</h2>
</div>
</div>

</div>
<?php
if (get_query_var('approve') != null) {
	$approved = approve_library(get_query_var('approve'));
	if ($approved) {
		?>
		<div class="alert alert-success" role="alert">Thank you for approving your dial to the public library.  You'll be able to see it below.</div>
		<?php acf_form(); ?>
		<?php
	} else {
		?>
		<div class="alert alert-warning" role="alert">That approval code wasn't recognised!  Please go to the dial creation page to generate a new approval code.</div>
		<?php
	}
}

$dials = get_public_library_dials();


if (count($dials) == 0) {
	?><p>Currently there are no dials published to the library</p><?php	
} else {
?>


<script src="<?php  echo get_theme_file_uri( '/js/dataFutures.js' )?>"></script>

<div id="library">
<?php 
foreach ($dials as $dial) {
	?>
	<div style="padding-bottom: 10px; border-bottom: 1px grey solid; margin-bottom: 20px" id="dial<?php echo $dial->id;?>">
		<h2><?php echo $dial->name ?></h2>
		<div id="lib<?php echo $dial->id;?>">
			<canvas id="dataFuturesWheelCanvas<?php echo $dial->id;?>" class="inline" width='350px' height='350px'></canvas>
			<div id="dataFuturesGuidelinesAnswers<?php echo $dial->id;?>" class="inline answers">
				<div id="dataFuturesGuidelinesAnswersQuestion<?php echo $dial->id;?>" class="question"></div>
				<div id="dataFuturesGuidelinesAnswersAnswer<?php echo $dial->id;?>"></div>
			</div>
		</div>
		<script>
		var lib<?php echo $dial->id;?> = new DataFuturesWheel();
		lib<?php echo $dial->id;?>.init(
			document.getElementById('dataFuturesWheelCanvas<?php echo $dial->id;?>'),
			document.getElementById('dataFuturesGuidelinesAnswersQuestion<?php echo $dial->id;?>'), 
			document.getElementById('dataFuturesGuidelinesAnswersAnswer<?php echo $dial->id;?>'));
		lib<?php echo $dial->id;?>.draw();
		lib<?php echo $dial->id;?>.answers = <?php echo json_encode($dial->answers)?>;
		
		</script>
	</div>
<?php 
}
?>

</div>

<?php } ?>
<?php get_footer(); ?>