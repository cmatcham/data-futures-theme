<?php /* Template Name: Assets page */ ?>
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
.df_button {
    padding: 10px;
    border: 1px #CCCCCC solid;
    margin-right: 20px;
    border-radius: 5px;
    font-size: 1.2em;
    font-weight: bold;
}
a.df_button, a.df_button:hover {
    color: #CCCCCC;
    cursor: pointer;
    text-decoration: none;
}

a.df_button.selected, a.df_button.selected:hover {
    color: #5085a0;
}
.col-library.image img {
    width: 100%;
}

</style>
<div class="public">
<h1 class="heading">Assets</h1>
</div>
<p>
<a class="type_switch df_button" data-type="videos">Videos</a>
<a class="type_switch df_button selected" data-type="images">Images</a>
</p>

<div class="mainDisplay videos">
	<div class="container" id="videoInsertion">
		
	</div>
</div>

<div class="mainDisplay images">
	<div class="container" id="imageInsertion">
	</div>
</div>


<?php get_footer(); ?>
<script>
var images = [
	{ file: '01_Data.jpg', title: 'Data' },
	{ file: '02_Personally-identifiable-information.jpg', title: 'Personally-Identifiable Information' },
	{ file: '03_Non-identified-information.jpg', title: 'Non-Identified Information' },
	{ file: '04_De-identified-information.jpg', title: 'De-Identified Information' },
	{ file: '05_Re-identification.jpg', title: 'Re-identification' },
	{ file: '06_AnonymisedInformation.jpg', title: 'Anonymised Information' },
	{ file: '07_SocialLicence.jpg', title: 'Social Licence' }
	
];

$(function() {
	$('.mainDisplay.videos').hide();
	$.ajax({
		url: "https://www.googleapis.com/youtube/v3/playlistItems?playlistId=UUFcQdhJy9oZ0azvONIjmJcQ&key=AIzaSyAQp2ygwP3sLockoyN8V9zN-llB7mQpYG4&part=snippet&maxResults=50",
		success: function(data, status, xhr) {
			console.log(data);
			data.items.forEach(function(el) {
				var title = el.snippet.title;
				var id = el.snippet.resourceId.videoId;
				$('#videoInsertion').append('<div class="col-md-4 col-sm-6 col-library video" data-video="'+id+'"><div class="player"></div><div class="title">'+title+'</div></div>');
			});

			var tag = document.createElement('script');

			tag.src = "http://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
						
		}
	});

	images.forEach(function(el) {
		$('#imageInsertion').append('<div class="col-md-4 col-sm-6 col-library image"><div class="img"><img src="<?php echo get_theme_file_uri('/assets/')?>'+el.file+'"/></div><div class="title">'+el.title+'</div></div>');
		
	});
	
});


jQuery('.type_switch').click(function(evt) {
	jQuery('.type_switch').removeClass('selected');
	$(this).addClass('selected');
	$('.mainDisplay').hide();
	$('.mainDisplay.'+$(this).data("type")).show();
});


function onYouTubeIframeAPIReady() {
	$('.col-library.video').each(function(idx, el) {
		new YT.Player($(this).find('.player')[0], {
			height: '195', 
			width: '320', 
			videoId: $(this).data("video"), 
			playerVars: {showinfo: 0}, 
			host: 'http://www.youtube.com'});
	});
}

</script>
<!-- script async defer src="https://apis.google.com/js/api.js" 
        onload="this.onload=function(){};handleClientLoad()" 
        onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script -->
