<?php /* Template Name: Embargo template */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$page_object = get_page(get_the_ID()); // page stuff
$page_content = $page_object->post_content;

?>

<?php wp_head(); ?>
</head>
<title>Coming Soon!</title>
<style>
@font-face {
	font-family: 'PT Sans';
	font-style: normal;
	font-weight: 400;
	src: local('PT Sans'), local('PTSans-Regular'), url(https://fonts.gstatic.com/s/ptsans/v8/ATKpv8nLYAKUYexo8iqqrg.woff2) format('woff2');
	unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
}
html { 
	background: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>') no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
  	min-height: 100%;
	font-family: 'PT Sans';
	color:white;
}
body {
	color: white;
	background-color: inherit;
	height: 100%;
}

.public .glyphicon-record{
  color: #5085a0; 
}
.entity .glyphicon-record {
  color: #f78f33; 
} 
#entryNav {
	font-size: 1.4em;
	position: absolute;
	top: 70%;
	left: 0;
	right: 0;
}
.public-entity-nav {
	text-align: center;
	max-width: 1170px;
	margin:auto;
	
}
.public-entity-nav h2 {
	font-size: 0.9em;
}
.nav>li>a:focus, .nav>li>a:hover {
	background-color: inherit;
	color: white;
}

div.welcome {
	padding-top: 5%;
	width: 400px;
	margin: auto;
}
div.entry {
	position:absolute;
	bottom: 0px;
	padding-bottom: 5%;
	margin:auto;
	left:0px;
	right:0px;
	width: 400px;
}
h1 {
	
	text-align: center;
}
a:link, a:visited {
    color: #FFFFFF;
    text-decoration: none;
}

span.link {
  position:absolute; 
  width:100%;
  height:100%;
  top:0;
  left: 0;

  z-index: 1;
}   

@media(max-width:767px) {
    .navbar-fixed-bottom {
		background-color: black;
    }

	.public-entity-nav.row {
		padding-bottom: 200px;
	}
	#entryNav {
		top: 60%;
	}
}

</style>
</head>
<body>



<div class="welcome">
<h1>Coming Soon</h1>
</div>
</body>
</html>