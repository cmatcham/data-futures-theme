<?php /* Template Name: Assets page */ ?>
<?php get_header(); ?>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

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
	padding-bottom: 25px;
}
@media (min-width: 768px) {
	.col-library {
	    height: 300px;
	    padding-bottom: 0px;
	}
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
.col-library {
	padding-left: 0px;
	padding-right: 30px;
}
.boxed {
	border: 1px solid #CCCCCC;
}
.video .boxed {
	width: 321px;
}
.title {
	padding: 10px;
	color: #5085a0;
}
.fbshare {
	float: right;
	padding-left: 10px;
}

</style>
<div class="container">
<div class="public">
<h1 class="heading">Assets</h1>
</div>
<p style="margin-bottom: 60px">
<a class="type_switch df_button" data-type="videos">Videos</a>
<a class="type_switch df_button selected" data-type="images">Images</a>
</p>
</div>
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
	{ file: '01_Data.png', title: 'Data' },
	{ file: '02_Personally-identifiable-information.png', title: 'Personally-Identifiable Information' },
	{ file: '03_Non-identified-information.png', title: 'Non-Identified Information' },
	{ file: '04_De-identified-information.png', title: 'De-Identified Information' },
	{ file: '05_Re-identification.png', title: 'Re-identification' },
	{ file: '06_AnonymisedInformation.png', title: 'Anonymised Information' },
	{ file: '07_SocialLicence.png', title: 'Social Licence' },
	{ file: '08_Consent.png', title: 'Consent' },
	{ file: '09_Algorithm.png', title: 'Algorithm' },
	{ file: '10_Pseudonymisation.png', title: 'Pseudonymisation' },
	{ file: '11_Information-Privacy.png', title: 'Information Privacy' },
	{ file: '12_BigData.png', title: 'Big Data' },
	{ file: '13_DataDrivenDecisions.png', title: 'Data Driven Decisions' },
	{ file: '14_Artificial-Intelligence.png', title: 'Artificial Intelligence' },
	{ file: '15_MachineLearning.png', title: 'Machine Learning' },
	{ file: '16_Blockchain.png', title: 'Blockchain' },
	{ file: '17_InternetOfThings.png', title: 'Internet of Things' },
	{ file: '18_Encryption.png', title: 'Encryption' },
	{ file: '19_OpenData.png', title: 'Open Data' },
	{ file: '20_DataBreach.png', title: 'Data Breach' },
	{ file: '21_OptInOptOut.png', title: 'Opt in, opt out' },
	{ file: '22_RightToAccessRightToCorrect.png', title: 'Right to access, right to correct' }
	
	
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
				$('#videoInsertion').append('<div class="col-md-4 col-sm-6 col-library video" data-video="'+id+'"><div class="boxed"><div class="player"></div><div class="title">'+title+'</div></div></div>');
			});

			var tag = document.createElement('script');

			tag.src = "https://www.youtube.com/iframe_api";
			var firstScriptTag = document.getElementsByTagName('script')[0];
			firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
						
		}
	});

	images.forEach(function(el) {
		var uri = '<?php echo get_theme_file_uri('/assets/')?>'+el.file;
		var id = 'fbshare'+(el.file.replace(/ /g, '_'));
		id = id.replace(/\./g, '_');
		var shares = '<a href="#" class="fbshare" data-image="'+uri+'" id="'+id+'"><i class="fa fa-lg fa-facebook"></i></a>'

		$('#imageInsertion').append('<div class="col-md-4 col-sm-6 col-library image"><div class="boxed"><div class="img"><a href="'+uri+'" data-fancybox="images" data-caption="'+el.title+'" ><img id="'+el.title.replace(/ /g,'_')+'" src="'+uri+'"/></a></div><div class="title">'+el.title+shares+'</div></div></div>');
		console.log('clickable: ',$('#fbshare'+id));
		$('#'+id).click(function(e) {
			e.preventDefault();
			console.log('Sharing with uri '+uri);
			shareOverrideOGMeta('https://trusteddata.co.nz/', el.title, 'Data is not just numbers – it is information and stories.', uri);

		});
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
			host: 'https://www.youtube.com'});
	});
}

window.fbAsyncInit = function() {
	FB.init({
		appId            : '157015495020413',
		autoLogAppEvents : true,
		xfbml            : true,
		version          : 'v2.10'
	});
	FB.AppEvents.logPageView();
  };

  (function(d, s, id){
	 var js, fjs = d.getElementsByTagName(s)[0];
	 if (d.getElementById(id)) {return;}
	 js = d.createElement(s); js.id = id;
	 js.src = "//connect.facebook.net/en_US/sdk.js";
	 fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  function shareOverrideOGMeta(overrideLink, overrideTitle, overrideDescription, overrideImage) {
	FB.ui({
		method: 'share_open_graph',
		action_type: 'og.shares',
		action_properties: JSON.stringify({
			object: {
				'og:url': overrideLink,
				'og:title': overrideTitle,
				'og:description': overrideDescription,
				'og:image': overrideImage
			}
		})
	},
	function (response) {
	// Action after response
	});
}

</script>
<!-- script async defer src="https://apis.google.com/js/api.js" 
        onload="this.onload=function(){};handleClientLoad()" 
        onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script -->
