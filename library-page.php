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
</style>

<h1>Public library</h1>
<?php
if (get_query_var('approve') != null) {
	$approved = approve_library(get_query_var('approve'));
	if ($approved) {
		?>
		<div class="alert alert-success" role="alert">Thank you for approving your dial to the public library.  You'll be able to see it below.</div>
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