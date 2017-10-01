<?php /* Template Name: Scrolling template for Consumer and Business pages */ ?>
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
	
    <title><?php echo get_bloginfo('name');?> :: <?php echo get_the_title(get_the_ID());?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

    <?php wp_head(); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
	document.addEventListener("DOMContentLoaded", function() {
    	var emailForm = document.querySelector('input[type=email]');
    	var showEmailCheckbox = document.querySelector('.trusted-data-show-email input');
    	if (emailForm && showEmailCheckbox)  {
    		emailForm.parentElement.classList.add('hidden');
    
    		showEmailCheckbox.addEventListener('change', function() {
    			if (showEmailCheckbox.checked) {
    				emailForm.parentElement.classList.remove('hidden');
    			} else {
    				emailForm.parentElement.classList.add('hidden');
    			}
    		});
    	}
	});
</script>
<style>
#dataFutures {
	width: inherit;
	min-width:380px;
}
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
</style>
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
                <a class="navbar-brand page-scroll" href="../"><span class="logo_heading transparent">TRUSTED</span> <span class="logo_heading data_use">DATA</span></a>
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

<?php
$front_page = get_option('page_on_front');
$public_link = get_post_meta($front_page, 'public-link', true);
$public_url = get_permalink($public_link);
$entity_link = get_post_meta($front_page, 'entity-link', true);
$entity_url = get_permalink($entity_link);

if ( $child_pages->have_posts() ) : while ( $child_pages->have_posts() ) : $child_pages->the_post();
?>	
	<section id="<?php echo sanitize_title_with_dashes(get_the_title(get_the_ID())); ?>" class="scrolling-section">
        <div class="container">
            <div class="row">
            	<?php 
            	$url = get_the_post_thumbnail_url( null, 'full');
            	if ( $url ) {
                ?>
            	<div class="col-md-5 col-md-push-7">
                    <div class="scrolling-page-image" style="background-image:url('<?php the_post_thumbnail_url('full'); ?>');">
                    	<div class="public <?php if (get_the_id() == 41) {echo 'noborder';}?>"></div>
                    </div>
            	
            	</div>
                <div class="col-md-7 col-md-pull-5">
	                <h1 class="heading"><?php the_title() ?></h1>
	                <?php the_content() ?>
                </div>
                <?php } else { ?>
                <div class="col-md-12">
	                <h1 class="heading"><?php the_title() ?></h1>
	                <?php the_content() ?>
                </div>
                <?php } ?>
            </div>

		</div>

    </section>

<?php
endwhile; endif;  

wp_reset_postdata();



data_futures_footer(false);
?>




</body>

</html>
