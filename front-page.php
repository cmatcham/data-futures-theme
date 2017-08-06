<!DOCTYPE html>
<html>
<head>
<?php
$page_object = get_page(get_the_ID()); // page stuff
$page_content = $page_object->post_content;

?>

<?php wp_head(); ?>
</head>
<title>Transparent Data Use</title>
<style>
@font-face {
	font-family: 'PT Sans';
	font-style: normal;
	font-weight: 400;
	src: local('PT Sans'), local('PTSans-Regular'), url(https://fonts.gstatic.com/s/ptsans/v8/ATKpv8nLYAKUYexo8iqqrg.woff2) format('woff2');
	unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
}
html, body { 
	background: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>') no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
  	min-height: 100%;
	font-family: 'PT Sans';
	color:white;
}

.public .glyphicon-record{
  color: #5085a0; 
}
.entity .glyphicon-record {
  color: #f78f33; 
} 
.public-entity-nav {
	text-align: center;
	position:absolute;
	bottom: 0px;
	padding-bottom: 5%;
	margin:auto;
	left:0px;
	right:0px;
	font-size: 1.4em;
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
}

</style>
</head>
<body>



<div class="welcome">
<h1><?php the_title() ?></h1>
<?php echo $page_content ?>
</div>
<div class="container">
    <div class="row public-entity-nav" style="padding-top:30px">
    <div class="col-md-4"></div>
    <div class="col-md-4">
    	<div class="col-xs-6 public-entity-nav public">
    		<div class="col-xs-4 col-xs-offset-8 col-md-6 col-md-offset-6" >
    		<?php
    		$public_link = get_post_meta(get_the_ID(), 'public-link', true);
    		$public_url = get_permalink($public_link);
    		$entity_link = get_post_meta(get_the_ID(), 'entity-link', true);
    		$entity_url = get_permalink($entity_link);
    		?>
    		<a href="<?php echo $public_url;?>"><span class="link"></span></a>
    		<h2>PUBLIC</h2>
    		<span class="glyphicon glyphicon-record"></span>
    		</div>
    	</div>
    	<div class="col-xs-6 public-entity-nav entity" >
    		<div class="col-xs-4 col-md-6 ">
    		<a href="<?php echo $entity_url;?>"><span class="link"></span></a>
    		<h2>ENTITY</h2>
    		<span class="glyphicon glyphicon-record"></span>
    		</div>
    	</div>
    </div>
    <div class="col-md-4"></div>
    </div>

</div>

    <footer>
    <div class="navbar navbar-fixed-bottom">
    <div class="container">
    <ul class="nav navbar-nav navbar-left">
      <li><a href="#about">TERMS</a></li>
      <li><a href="#contact">PRIVACY</a></li>
      <li><a href="#contact">TRUSTED DATA</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a>Brought to you by <strong>DATA FUTURES</strong> partnership</a></li>
    </ul>
    </div>
    </div>
    </footer>
</body>
</html>