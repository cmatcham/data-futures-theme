<?php /* Template Name: Public dials display */ ?>
<?php get_header(); ?>

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
		<div class="container-fluid">
		<div id="opengraph" class="row" style="border-bottom: 1px grey solid; border-left: 1px grey solid; border-right: 1px grey solid; padding: 10px;">
			<div class="col-xs-3">
			<img id="opengraph-image" class="center-block" style="max-width: 100%"/>
			</div>
			<div class="col-xs-9">
			<h3 id="opengraph-title"></h3>
			<p id="opengraph-description"></p>
			</div>
		</div>
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

<script>

</script>

<?php get_footer(); ?>