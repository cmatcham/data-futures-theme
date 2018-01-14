<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    
<meta property="og:title" content="Trusted Data Dial" />
<meta property="og:description" content="Create your own trusted data dial" />
<meta property="og:image" content="https://www.trusteddata.co.nz/media/dial.png" />
<meta property="og:image:width" content="512px" />
<meta property="og:image:height" content="512px" />

<?php
$page_object = get_page(get_the_ID()); // page stuff
$page_content = $page_object->post_content;

?>

<?php wp_head(); ?>
</head>
<title><?php echo get_bloginfo('name');?></title>
<style>
@font-face {
    font-family: MyriadPro;
    src: url("wp-content/themes/datafutures/fonts/MyriadPro-Light.otf") format("opentype");
}
@font-face {
    font-family: MyriadPro;
    font-style: normal;
    font-weight: 100;
    src: url("wp-content/themes/datafutures/fonts/MyriadPro-Light.otf") format("opentype");
}
@font-face {
    font-family: MyriadPro;
    font-style: normal;
    font-weight: bold;
    src: url("wp-content/themes/datafutures/fonts/MyriadPro-BoldSemiCn.otf") format("opentype");
}
@font-face {

	font-family: 'PT Sans';
	font-style: normal;
	font-weight: 400;
	src: local('PT Sans'), local('PTSans-Regular'), url(https://fonts.gstatic.com/s/ptsans/v8/ATKpv8nLYAKUYexo8iqqrg.woff2) format('woff2');
	unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
}
html { 
<?php $image = rand(1,5);?>
	background: url('<?php echo esc_url( get_theme_mod( 'datafutures_background_'.$image )); ?>') no-repeat center center fixed; 
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
  	min-height: 100%;
	font-family: 'MyriadPro' !important;
	color:white;
}
body {
	color: white;
	background-color: inherit;
	height: 100%;
	font-family: 'MyriadPro' !important;
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
	width: 400px;
	margin-left: 100px;
	margin-top: 200px;
	padding: 20px;
	background-color: rgba(255,255,255,0.5);
	color: rgb(0,0,0);
}
div.welcome a.public:hover {
    color: #5085a0;
}
div.welcome a.organisation:hover {
    color: #f78f33;
}
.logo_heading.transparent {
	color:#006b8a;
	font-weight:bold;
}
.logo_heading.data_use{
	color:black;
}
p.logo {
    position: absolute;
    top: 0;
    left: 100px;
}
@media(max-width:600px) {
	div.welcome {
		margin: auto;
		margin-top: 100px;
		width: 66.66666667%;
	}
	p.logo {
        position: absolute;
        top: 0;
        left: 10px;
    }
}
@media(max-height:600px) {
	div.welcome {
		margin-top: 100px;
	}
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
	font-weight: bold;
}
a:link, a:visited {
    color: #000000;
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
		background-color: white;
    }

	.public-entity-nav.row {
		padding-bottom: 200px;
	}
	#entryNav {
		top: 60%;
	}
}
button.navbar-toggle {
    background-color: grey;
    border: 1px solid white;
}
span.icon-bar {
    background-color: white;
}
.navbar-collapse.navbar-ex1-collapse.collapsing,.navbar-collapse.navbar-ex1-collapse.in  {
    background-color: white;
}


</style>
</head>
<body>
<nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            
            <div class="collapse navbar-collapse navbar-ex1-collapse">
            <?php wp_nav_menu( array(
                'theme_location' 	=> 'about-menu',
                'container' 		=> false,
                'menu_class'      	=> 'nav navbar-nav navbar-right',
                'menu_id'         	=> '',
                'echo'            	=> true,
                'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth'           	=> 0
            )); ?>
            <?php wp_nav_menu( array(
                'theme_location' 	=> 'privacy-menu',
                'container' 		=> false,
                'menu_class'      	=> 'nav navbar-nav hidden-lg hidden-md hidden-sm',
                'menu_id'         	=> '',
                'echo'            	=> true,
                'items_wrap'      	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth'           	=> 0
            )); ?>
            </div>
        </div>
        <!-- /.container -->
    </nav>
<p class="logo">
	<a class="navbar-brand page-scroll" href="./"><span class="logo_heading transparent">TRUSTED</span> <span class="logo_heading data_use">DATA</span></a>
</p>

<div class="welcome">
<h1><?php the_title() ?></h1>
<?php echo $page_content ?>
<?php
	$public_link = get_post_meta(get_the_ID(), 'public-link', true);
	$public_url = get_permalink($public_link);
	$entity_link = get_post_meta(get_the_ID(), 'entity-link', true);
	$entity_url = get_permalink($entity_link);
?>
<p></p>
<p><strong>
<a class="public" href="<?php echo $public_url;?>">Public</a> | 
<a class="organisation" href="<?php echo $entity_url;?>">Organisation</a>
<span style="float:right"><a href="create-your-wheel">Create your dial &gt;</a></span>
</strong></p>
</div>


<div class="hidden-xs">
<?php data_futures_footer(true); ?>
</div>
</body>
</html>