<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <meta property="og:title" content="Trusted Data Dial" />
	<meta property="og:description" content="Create your own trusted data dial" />
	<meta property="og:image" content="https://www.trusteddata.co.nz/media/dial.png" />
	<meta property="og:image:width" content="512px" />
	<meta property="og:image:height" content="512px" />

    <title><?php data_futures_title(); ?></title>
    <?php wp_head(); ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php
$front_page = get_option('page_on_front');
$public_link = get_post_meta($front_page, 'public-link', true);
$public_url = get_permalink($public_link);
$entity_link = get_post_meta($front_page, 'entity-link', true);
$entity_url = get_permalink($entity_link);
?>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="../"><span class="logo_heading transparent">TRUSTED</span> <span class="logo_heading data_use">DATA</span></a>
                
                
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
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	<div class="container" style="padding-top:100px;">