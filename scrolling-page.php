<?php /* Template Name: Scrolling template for Consumer and Business pages */ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Scrolling Nav - Start Bootstrap Template</title>


    <?php wp_head(); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<?php

$child_pages = new WP_Query( array(
    'orderby'	=> 'menu_order',
    'post_type'      => 'page', // set the post type to page
    'post_parent'    => get_the_ID(),
//    'no_found_rows'  => true, // no pagination necessary so improve efficiency of loop
    'order'	=> 'asc'
) );


?>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top" class="<?php echo get_post_meta(get_the_ID(), 'scrolling-page-class', true) ?>">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Transparent Data Use</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    <?php if ( $child_pages->have_posts() ) : while ( $child_pages->have_posts() ) : $child_pages->the_post(); ?>
                    <li>
                        <a class="page-scroll" href="#<?php echo sanitize_title_with_dashes(get_the_title(get_the_ID())); ?>"><?php the_title() ?></a>
                    </li>

					<?php endwhile; endif;  ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<?php


if ( $child_pages->have_posts() ) : while ( $child_pages->have_posts() ) : $child_pages->the_post();
?>	
	<section id="<?php echo sanitize_title_with_dashes(get_the_title(get_the_ID())); ?>" class="scrolling-section">
        <div class="container">
            <div class="row">
            	<div class="col-md-5 col-md-push-7">
                    <div class="scrolling-page-image" style="background-image:url('<?php the_post_thumbnail_url('full'); ?>');">
                    	<div class="public"></div>
                    </div>
            	
            	</div>
                <div class="col-md-7 col-md-pull-5">
	                <h1><?php the_title() ?></h1>
	                <?php the_content() ?>
                </div>
                
            </div>
            <div class="row" style="padding-top:30px">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            	<div class="col-xs-6 public-entity-nav public">
            		<div class="col-xs-4 col-xs-offset-8 col-md-6 col-md-offset-6" >
            		<h2>PUBLIC</h2>
            		<span class="glyphicon glyphicon-record"></span>
            		</div>
            	</div>
            	<div class="col-xs-6 public-entity-nav entity" >
            		<div class="col-xs-4 col-md-6 ">
            		<h2>ENTITY</h2>
            		<span class="glyphicon glyphicon-record"></span>
            		</div>
            	</div>
            </div>
            <div class="col-md-4"></div>
            </div>
		</div>

    </section>

<?php
endwhile; endif;  

wp_reset_postdata();

wp_footer();
?>
	<div class="footer-padding"></div>
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
