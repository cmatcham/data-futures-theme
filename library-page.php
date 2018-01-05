<?php /* Template Name: Public dials display */ ?>
<?php get_header(); ?>

<?php 

/*

// Deal with images uploaded from the front-end while allowing ACF to do itâ€™s thing
function my_acf_pre_save_post($post_id) {

if ( !function_exists(â€˜wp_handle_uploadâ€™) ) {
require_once(ABSPATH . â€˜wp-admin/includes/file.phpâ€™);
}

// Move file to media library
$movefile = wp_handle_upload( $_FILES[â€˜my_image_uploadâ€™], array(â€˜test_formâ€™ => false) );

// If move was successful, insert WordPress attachment
if ( $movefile && !isset($movefile[â€˜errorâ€™]) ) {
$wp_upload_dir = wp_upload_dir();
$attachment = array(
â€˜guidâ€™ => $wp_upload_dir[â€˜urlâ€™] . â€˜/â€™ . basename($movefile[â€˜fileâ€™]),
â€˜post_mime_typeâ€™ => $movefile[â€˜typeâ€™],
â€˜post_titleâ€™ => preg_replace( â€˜/\.[^.]+$/â€™, â€�, basename($movefile[â€˜fileâ€™]) ),
â€˜post_contentâ€™ => â€�,
â€˜post_statusâ€™ => â€˜inheritâ€™
);
$attach_id = wp_insert_attachment($attachment, $movefile[â€˜fileâ€™]);

// Assign the file as the featured image
set_post_thumbnail($post_id, $attach_id);
update_field(â€˜my_image_uploadâ€™, $attach_id, $post_id);

}

return $post_id;

}

add_filter(â€˜acf/pre_save_postâ€™ , â€˜my_acf_pre_save_postâ€™);

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
.col-library {
    height: 300px;
    cursor: pointer;
}
.col-library h2 {
    height: 44px;
}
#dialLoadingOverlay img {
   width: 102px;
   height: 102px;
   position: absolute;
   left: 50%;
   top: 50%; 
   margin-left: -51px;
   margin-top: -51px;
}
#dialInsertion {
    display: none;
}
.modal-body {
    min-height: 200px;
}
</style>
<div class="public">
<h1 class="heading">Public library</h1>

</div>
<?php
if (get_query_var('approve') != null) {
	$approved = approve_library(get_query_var('approve'));
	if ($approved) {
		?>
		<div class="alert alert-success" role="alert">Thank you for approving your dial to the public library.  You'll be able to see it below. You can also upload an image (for example, your company logo) to display in the library.</div>
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

<div class="container">
<?php 
foreach ($dials as $dial) {
?>
<div class="col-lg-3 col-md-4 col-sm-6 col-library" data-dial-id="<?php echo $dial->id;?>" data-public-id="<?php echo hash_id($dial->id)?>" data-url="<?php echo htmlspecialchars($dial->url)?>" data-title="<?php echo htmlspecialchars($dial->name);?>">
	<h2><?php echo $dial->name ?></h2>
	<img class="greyed" src="<?php echo get_library_dial_image($dial->id);?>" id="libraryImage<?php echo $dial->id?>"/>
	<?php 
	
	
	if (is_user_logged_in() && is_valid_wheel($dial->id)) {
	    echo image_upload_form_html($dial->id);
	}
	?>
</div>
<?php } ?>


</div>

<div class="modal fade" tabindex="-1" role="dialog" id="displayModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="dialTitle"></h4>
      </div>
      <div class="modal-body">
		<div id="dialLoadingOverlay">
			<img src="<?php echo get_theme_file_uri( '/images/ajax.gif' )?>">
		</div>
		<div id="dialInsertion">
			<canvas id="dataFuturesWheelCanvas" class="inline" width='350px' height='350px'></canvas>
			<div id="dataFuturesGuidelinesAnswers" class="inline answers">
				<div id="dataFuturesGuidelinesAnswersQuestion" class="question"></div>
				<div id="dataFuturesGuidelinesAnswersAnswer"></div>
			</div>
			<p id="dialLink"><a href="#">Go to site</a></p>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php } ?>
<?php get_footer(); ?>