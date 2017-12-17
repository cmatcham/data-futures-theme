<?php /* Template Name: Public dials display */ ?>
<?php get_header(); ?>
<?php
$dials = get_public_library_dials();
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
</style>

<h1>Public library</h1>
<?php
if (count($dials) == 0) {
	?><p>Currently there are no dials published to the library</p><?php	
} else {
?>


<script src="<?php  echo get_theme_file_uri( '/js/dataFutures.js' )?>"></script>

<div id="library">
<?php 
foreach ($dials as $dial) {
	?>
	<div style="padding-bottom: 30px;">
		<h2><?php echo $dial->name ?></h2>
		<div id="lib<?php echo $dial->id;?>">
			<canvas id="dataFuturesWheelCanvas<?php echo $dial->id;?>" class="inline" width='350px' height='350px'></canvas>
			<div id="dataFuturesGuidelinesAnswers<?php echo $dial->id;?>" class="inline">
				<div id="dataFuturesGuidelinesAnswersQuestion<?php echo $dial->id;?>"></div>
				<div id="dataFuturesGuidelinesAnswersAnswer<?php echo $dial->id;?>"></div>
			</div>
		</div>
		<script>
		var lib<?php echo $dial->id;?> = new DataFuturesWheel();
		lib<?php echo $dial->id;?>.init(document.getElementById('dataFuturesWheelCanvas<?php echo $dial->id;?>'),document.getElementById('dataFuturesGuidelinesAnswersQuestion<?php echo $dial->id;?>', document.getElementById('dataFuturesGuidelinesAnswersAnswer<?php echo $dial->id;?>')));
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