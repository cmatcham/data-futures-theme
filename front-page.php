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
<title><?php echo get_bloginfo('name');?></title>
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
button.navbar-toggle {
    background-color: grey;
    border: 1px solid white;
}
span.icon-bar {
    background-color: white;
}
.navbar-collapse.navbar-ex1-collapse.collapsing,.navbar-collapse.navbar-ex1-collapse.in  {
    background-color: black;
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


<div class="welcome">
<h1><?php the_title() ?></h1>
<?php echo $page_content ?>
</div>
<div class="container">
	<div id="entryNav">
    <div class="row public-entity-nav">
    <div class="col-md-3"></div>
    <div class="col-md-6">
    	<div class="col-xs-6 public">
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
    	<div class="col-xs-6 entity" >
    		<a href="<?php echo $entity_url;?>"><span class="link"></span></a>
    		<h2>ORGANISATION</h2>
    		<span class="glyphicon glyphicon-record"></span>
    	</div>
    </div>
    <div class="col-md-3"></div>
    </div>
	</div>
</div>

<div class="hidden-xs">
<?php data_futures_footer(true); ?>
</div>
</body>
</html>