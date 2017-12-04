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
</style>

<h1>Public library</h1>
<script src="<?php  echo get_theme_file_uri( '/js/dataFutures.js' )?>"></script>

<div id="library">

</div>

<script>
jQuery('#library').append("<div id='lib1'><canvas id='dataFuturesWheelCanvas1' class='inline' width='350px' height='350px'></canvas><div id='dataFuturesGuidelinesAnswers1' class='inline' ><div id='dataFuturesGuidelinesAnswersQuestion1'></div><div id='dataFuturesGuidelinesAnswersAnswer1'></div></div></div>");
var lib1 = new DataFuturesWheel();
lib1.init(document.getElementById('dataFuturesWheelCanvas1'), document.getElementById('dataFuturesGuidelinesAnswersQuestion1'), document.getElementById('dataFuturesGuidelinesAnswersAnswer1'));
jQuery('#library').append("<div id='lib2'><canvas id='dataFuturesWheelCanvas2' class='inline' width='350px' height='350px'></canvas><div id='dataFuturesGuidelinesAnswers2' class='inline' ><div id='dataFuturesGuidelinesAnswersQuestion2'></div><div id='dataFuturesGuidelinesAnswersAnswer2'></div></div></div>");
var lib2 = new DataFuturesWheel();
lib2.init(document.getElementById('dataFuturesWheelCanvas2'), document.getElementById('dataFuturesGuidelinesAnswersQuestion2'), document.getElementById('dataFuturesGuidelinesAnswersAnswer2'));

lib1.draw();
lib2.draw();

var data = {'action':'public_wheel', 'id':4849664};
$.get('https://trusteddata.co.nz/wp-json/dataFutures/v1/wheel/'+data.id, data, function(response) {
	lib1.answers = response.answers;
});
var data = {'action':'public_wheel', 'id':2228224};
$.get('https://trusteddata.co.nz/wp-json/dataFutures/v1/wheel/'+data.id, data, function(response) {
	lib1.answers = response.answers;
});


</script>
<?php get_footer(); ?>