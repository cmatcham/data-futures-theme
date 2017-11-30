<?php /* Template Name: Create your wheel template */ ?>
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


<title>Create your dial</title>

<style>
   .modal-content { padding: 15px;}
	h1.dataFuturesQuestion {display:none;}
    #create-your-dial h1.dataFuturesQuestion {display:block;}
   .modal-content .tab-content{ padding-top:20px;padding-bottom:50px;}
   .question .label-info {float:right;}
   
	#loginCreateTabContent input {
	  color: #337ab7;
	  font-weight: bold;
	}
	#loginCreateTabContent ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
		color:    #5085a0;
	}
	#loginCreateTabContent :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
	   color:    #5085a0;
	   opacity:  1;
	}
	#loginCreateTabContent ::-moz-placeholder { /* Mozilla Firefox 19+ */
	   color:    #5085a0;
	   opacity:  1;
	}
	#loginCreateTabContent :-ms-input-placeholder { /* Internet Explorer 10-11 */
	   color:    #5085a0;
	}
	#loginCreateTabContent ::-ms-input-placeholder { /* Microsoft Edge */
	   color:    #5085a0;
	}
	#create-your-dial {
		color: #5085a0;
	}
	:placeholder-shown { /* Standard one last! */
		color: #337ab7;
	}
	
	
	.social {
		margin: 0;
		padding: 0;
	}
	
	.social ul {
		margin: 0;
		padding: 5px;
	}
	
	.social ul li {
		margin: 5px;
		list-style: none outside none;
		display: inline-block;
	}
	
	.social i {
		width: 40px;
		height: 40px;
		color: #FFF;
		background-color: #909AA0;
		font-size: 22px;
		text-align:center;
		padding-top: 12px;
		border-radius: 50%;
		-moz-border-radius: 50%;
		-webkit-border-radius: 50%;
		-o-border-radius: 50%;
		transition: all ease 0.3s;
		-moz-transition: all ease 0.3s;
		-webkit-transition: all ease 0.3s;
		-o-transition: all ease 0.3s;
		-ms-transition: all ease 0.3s;
	}
	
	.social i:hover {
		color: #FFF;
		text-decoration: none;
		transition: all ease 0.3s;
		-moz-transition: all ease 0.3s;
		-webkit-transition: all ease 0.3s;
		-o-transition: all ease 0.3s;
		-ms-transition: all ease 0.3s;
	}
	
	.social .fa-facebook:hover { /* round facebook icon*/
		background: #4060A5;
	}
	
	.social .fa-twitter:hover { /* round twitter icon*/
		background: #00ABE3;
	}
	
	.social .fa-linkedin:hover {
		background: #0094BC;
	}
	
	
	input.text_input {
		background: #f5f5f5;
		border-color: #f5f5f5;
		color: #5085a0;
	}
	
	#rootwizard {
		background: #f5f5f5;
		border-radius: 10px;
		padding-bottom: 50px;
		margin-bottom: 50px;
		position: relative;
	}
	#rootwizard .jumbotron {
		background-color: #f5f5f5;
		padding-left: 0px;
		padding-top: 0px;
		padding-bottom: 0px;
	}
	#rootwizard .jumbotron p {
		font-size: 31px;
	}
	span.badge {
		margin: 10px;
	}
	li span.badge {
		background-color: inherit;
		border: 1px grey solid;
		color: grey;
	}
	li.active span.badge {
		background-color: #5085a0;
		border: none;
		color: white;
	}

	#rootwizard textarea {
		border: none;
		border-radius: 10px;
		width: 100%;
		height: 150px;
		margin-left: 10px;
	}
	@media(max-width:767px) {
		#rootwizard textarea {
			width: 90%;
		}
		p#current-question {
			padding-left: 10px;
			padding-top: 20px;
		}
		#rootwizard .jumbotron {
			margin-bottom: 0px;
		}
	}
	ul#navigation {
		list-style: none;
		padding-left: 0px;
	}
	ul#navigation>li {
		float: left;
		position: relative;
		display: block;
   }
   .help-link {
	position: absolute;
	top: 15px;
	right: 15px;
	color: grey;
   }
   .help-link a {
	color: grey;
   }
   .modal-content .modal-close {
	position: absolute;
	top: 10px;
	right: 10px;
	color: grey;
	cursor: pointer;
   }
   p.step-heading {
   	font-size:1.7em; 
   	margin-bottom:0px;
   }
   p.step-heading a {
   	color: #5085a0;
   	text-decoration: none;
   }
   
   .button-image:before {
    content: "";
    width: 24px;
    height: 24px;
    display: inline-block;
    margin-right: 5px;
    vertical-align: text-top;
    background-color: transparent;
    background-position : center center;
    background-repeat:no-repeat;
    }

    .button-image.html:before{
        background-image : url(<?php echo get_theme_file_uri('images/html-24.png');?>);
    }
    .button-image.wordpress:before{
        background-image : url(<?php echo get_theme_file_uri('images/wordpress-logo-24.png');?>);
    }
    .button-image.wordpress:hover:before{
        background-image : url(<?php echo get_theme_file_uri('images/wordpress-logo-24-blue.png');?>);
    }
    .button-image.silverstripe:before{
        background-image : url(<?php echo get_theme_file_uri('images/silverstripe-logo-24.png');?>);
    }
    .button-image.silverstripe:hover:before{
        background-image : url(<?php echo get_theme_file_uri('images/silverstripe-logo-24-blue.png');?>);
    }
    .button-image.pdf:before{
        background-image : url(<?php echo get_theme_file_uri('images/pdf-24.png');?>);
    }
    .button-image.pdf:hover:before{
        background-image : url(<?php echo get_theme_file_uri('images/pdf-24-red.png');?>);
    }
    .button-image.link:before{
        background-image : url(<?php echo get_theme_file_uri('images/link-24.png');?>);
    }
   
</style>
<?php wp_head(); ?>
<!--load font awesome-->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="public">
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
			<ul class="nav navbar-nav">
				<li><a href="<?= $entity_url ?>">For Organisations</a></li>
				<li><a href="<?= $public_url ?>">For Public</a></li>
			</ul>
			<?php if (is_user_logged_in()) { ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Your dials <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<?php
						$wheels = get_wheels();
						foreach ( $wheels as $data_future_wheel) {
							echo '<li><a class="loadWheel" href="#" data-target="'.$data_future_wheel->id.'" id="wheelLink'.$data_future_wheel->id.'">'.$data_future_wheel->name.'</li>';
						}
						?>	
						<li role="separator" class="divider"></li>
						<li><a id="createNewWheel" href="#">Create new</a></li>
					</ul>
				</li>
				<li><a href="<?php echo wp_logout_url( get_permalink() ); ?>">Logout</a></li>
			</ul>
			<?php } ?>
		</div>
		
		
		
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				

			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>


<?php
if (!is_user_logged_in()) {  
data_futures_show_login();             

?>

<script>
jQuery(document).ready(function() {
	jQuery(".tab_content_login").hide();
	jQuery("ul.tabs_login li:first").addClass("active_login").show();
	jQuery(".tab_content_login:first").show();
	jQuery("ul.tabs_login li").click(function() {
		jQuery("ul.tabs_login li").removeClass("active_login");
		jQuery(this).addClass("active_login");
		jQuery(".tab_content_login").hide();
		var activeTab = jQuery(this).find("a").attr("href");
		if (jQuery.browser.msie) {jQuery(activeTab).show();}
		else {jQuery(activeTab).show();}
		return false;
	});
});
</script>
<?php

}
?>



<?php
if (is_user_logged_in()) {
$selected_wheel = get_selected_wheel($wheels);

?>
<div class="container" id="create-your-dial">
<div style="padding-top:60px;">
<div id="accordion" class="panel-group">

<div class="panel">
	<p class="step-heading"><a data-toggle="collapse" data-parent="#accordion" href="#step1">STEP 1</a></p>
	<div id="step1" class="panel-collapse collapse in">
	<div class="panel-body">
	<h1 class="heading" style="margin-top:0px">Create your data use dial</h1>
	<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<label for="wheelName">Name</label>
			<input type="text" class="form-control text_input" id="wheelName" placeholder="Enter a name for this wheel (eg. your organisation name)" name="wheelName">
		</div>
	</div>
	<div class="col-sm-6">
		<div class="form-group">
			<label for="wheelURL">URL</label>
			<input type="text" class="form-control text_input" id="wheelURL" placeholder="Enter the url of your organisation or business unit" name="wheelName">
		</div>
	</div>
	</div>


	<label>Questions</label>
	<div id="rootwizard">
	<ul id="navigation" class="clearfix">
	<li><a href="#tab1" data-toggle="tab"><span class="badge ">1</span></a></li>
	<li><a href="#tab2" data-toggle="tab"><span class="badge ">2</span></a></li>
	<li><a href="#tab3" data-toggle="tab"><span class="badge ">3</span></a></li>
	<li><a href="#tab4" data-toggle="tab"><span class="badge ">4</span></a></li>
	<li><a href="#tab5" data-toggle="tab"><span class="badge ">5</span></a></li>
	<li><a href="#tab6" data-toggle="tab"><span class="badge ">6</span></a></li>
	<li><a href="#tab7" data-toggle="tab"><span class="badge ">7</span></a></li>
	<li><a href="#tab8" data-toggle="tab"><span class="badge ">8</span></a></li>
	</ul>
	<div class="tab-content">
	<div class="row tab-pane" id="tab1">
	<div class="col-sm-6 col-sm-push-6">
		<div class="jumbotron">
			<p id="current-question">What will my data be used for?</p>
		</div>
	</div>
	<div class="col-sm-6 col-sm-pull-6">
		<textarea id="q1answer" data-question="1" class="form-control" rows="3"></textarea>
	</div>
	<div class="help-link"><a href="#" data-toggle="modal" data-target="#q1help"><span class="glyphicon glyphicon-question-sign"></span></a></div>
	</div>
	<div class="row tab-pane" id="tab2">
	<div class="col-sm-6 col-sm-push-6">
		<div class="jumbotron">
			<p id="current-question">What are the benefits and who will benefit?</p>
		</div>
	</div>
	<div class="col-sm-6 col-sm-pull-6">
		<textarea id="q2answer" data-question="2" class="form-control" rows="3"></textarea>
	</div>
	<div class="help-link"><a href="#" data-toggle="modal" data-target="#q2help"><span class="glyphicon glyphicon-question-sign"></span></a></div>

	</div>
	<div class="row tab-pane" id="tab3">
	<div class="col-sm-6 col-sm-push-6">
		<div class="jumbotron">
			<p id="current-question">Who will be using my data?</p>
		</div>
	</div>
	<div class="col-sm-6 col-sm-pull-6">
		<textarea id="q3answer" data-question="3" class="form-control" rows="3"></textarea>
	</div>
	<div class="help-link"><a href="#" data-toggle="modal" data-target="#q3help"><span class="glyphicon glyphicon-question-sign"></span></a></div>

	</div>
	<div class="row tab-pane" id="tab4">
	<div class="col-sm-6 col-sm-push-6">
		<div class="jumbotron">
			<p id="current-question">Is my data secure?</p>
		</div>
	</div>
	<div class="col-sm-6 col-sm-pull-6">
		<textarea id="q4answer" data-question="4" class="form-control" rows="3"></textarea>
	</div>
	<div class="help-link"><a href="#" data-toggle="modal" data-target="#q4help"><span class="glyphicon glyphicon-question-sign"></span></a></div>

	</div>
	<div class="row tab-pane" id="tab5">
	<div class="col-sm-6 col-sm-push-6">
		<div class="jumbotron">
			<p id="current-question">Will my data be anonymous?</p>
		</div>
	</div>
	<div class="col-sm-6 col-sm-pull-6">
		<textarea id="q5answer" data-question="5" class="form-control" rows="3"></textarea>
	</div>
	<div class="help-link"><a href="#" data-toggle="modal" data-target="#q5help"><span class="glyphicon glyphicon-question-sign"></span></a></div>

	</div>
	<div class="row tab-pane" id="tab6">
	<div class="col-sm-6 col-sm-push-6">
		<div class="jumbotron">
			<p id="current-question">Can I see and correct data about me?</p>
		</div>
	</div>
	<div class="col-sm-6 col-sm-pull-6">
		<textarea id="q6answer" data-question="6" class="form-control" rows="3"></textarea>
	</div>
	<div class="help-link"><a href="#" data-toggle="modal" data-target="#q6help"><span class="glyphicon glyphicon-question-sign"></span></a></div>

	</div>
	<div class="row tab-pane" id="tab7">
	<div class="col-sm-6 col-sm-push-6">
		<div class="jumbotron">
			<p id="current-question">Could my data be sold?</p>
		</div>
	</div>
	<div class="col-sm-6 col-sm-pull-6">
		<textarea id="q7answer" data-question="7" class="form-control" rows="3"></textarea>
	</div>
	<div class="help-link"><a href="#" data-toggle="modal" data-target="#q7help"><span class="glyphicon glyphicon-question-sign"></span></a></div>

	</div>
	<div class="row tab-pane" id="tab8">
	<div class="col-sm-6 col-sm-push-6">
		<div class="jumbotron">
			<p id="current-question">Will I be asked for consent?</p>
		</div>
	</div>
	<div class="col-sm-6 col-sm-pull-6">
		<textarea id="q8answer" data-question="8" class="form-control" rows="3"></textarea>
	</div>
	<div class="help-link"><a href="#" data-toggle="modal" data-target="#q8help"><span class="glyphicon glyphicon-question-sign"></span></a></div>

	</div>


	</div>


	<div class="col-sm-12">
	<p>Answers should be kept short, to a maximum of 500 characters. You've written <span id="characterCount">0 characters</span></p>
	</div>
	</div>
	<label>Public library</label>
	<div>Kittens</div>
	<!-- ul class="pager wizard">
	<li class="previous first" style="display: none;"><a href="#">First</a></li>
	<li class="previous"><a href="#">Previous</a></li>
	<li class="next last" style="display: none;"><a href="#">Last</a></li>
	<li class="next"><a href="#">Next</a></li>
	</ul -->
</div>





<div class="modal fade" id="q1help" tabindex="-1" role="dialog" aria-labelledby="q1help" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
	<span class="button glyphicon glyphicon-remove-circle modal-close" data-dismiss="modal" aria-label="Close"></span>
	<h2>Guidelines</h2>
	<p>The information on purpose needs to include:</p>
	<ul>
		<li>a clearly identified, specific purpose for the data</li>
		<li>a list of the data being collected</li>
		<li>a description of any algorithms used</li>
		<li>disclosure of possible future purposes.</li>
	</ul>
	<h3>Purpose</h3>
	<p>
		Clearly <em>explain</em> the use and purpose of the collection
		of data, for example &ndash;
	</p>
	<blockquote>
		<p>We only collect data that are necessary to deliver the
			service we offer, and no more.</p>
		<p>We will make your medical records accessible online to
			specialists and hospitals. This will provide access to your
			medical history if you need treatment, including in an
			emergency.</p>
		<p>We use your information to target marketing to you. We
			also share it with the companies in our loyalty programme and
			they use it to target marketing material to you by email.</p>
		<p>We provide your information to charities so that they can
			approach you for support.</p>
	</blockquote>

	<p>
		<strong>Provide</strong> further detail, together with concrete
		examples, for those interested. Examples might include ways you
		have used research to improve services in the past.
	</p>
	<p>If you can, provide the more detailed information as a
		click or drill-down option so that it can be skipped by people
		who are only interested in more general statements about
		purpose.</p>
	<h3>Data being collected</h3>
	<p>
		<em>List</em> what data you are collecting in these 3
		categories:
	</p>

	<table class="table">
		<tr>
			<td>1.</td>
			<td>Data you are requiring as a condition of supplying the
				service or product.</td>
			<td>In most cases this should only be the data that is
				strictly necessary for the service.</td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Information beyond what is strictly needed for service
				delivery, but authorised under legislation.</td>
			<td><p>Describe the purpose for collecting this
					additional data and state the authorisation clearly.</p>
				<p>Be explicit about any consequences of not providing
					this additional information.</p></td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Information beyond that needed for service delivery or
				authorised under legislation (eg for marketing or research).</td>
			<td><p>Describe the purpose.</p>
				<p>Be explicit about any incentives you are offering in
					exchange for gaining the right to use customer/client
					information.</p></td>
		</tr>
	</table>
	<p>
		Where the data is sensitive, or some client groups are likely to
		have a low level of trust in your organisation, <em>explain</em>
		why it isn't possible to achieve the purpose in any other way eg
		by using anonymous instead of personally-identified data.
	</p>
	<h3>Algorithms</h3>
	<p>If you use algorithms (formula-based decision tools) eg to
		determine whether to grant loans, what interest rate to charge,
		or as part of a recruitment process:</p>
	<ul>
		<li><em>inform</em> your customers/applicants of how this
			works and which pieces of data are used</li>
		<li><em>advise</em> clients of other inputs to your
			decision processes (eg does a staff member review
			applications?)</li>
		<li><em>offer</em> the applicant the right to contest the
			decision, including the data that was used in the algorithm.</li>
	</ul>
	<h3>Future Uses</h3>
	<p>Explicitly address whether the data may be used for other
		purposes in the future and if so what.</p>
	<p>If it isn't possible to be precise about possible future
		uses, provide an assurance that the person will be asked to give
		consent to that use before it occurs.</p>
	</div>
</div>
</div>
			

<div class="modal fade" id="q2help" tabindex="-1" role="dialog"	aria-labelledby="q2help" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">		
		<span class="button glyphicon glyphicon-remove-circle modal-close" data-dismiss="modal" aria-label="Close"></span>
	
		<h2>Guidelines</h2>
		<p>The information on benefits needs to include:</p>
		<ul>
			<li>factual evidence and examples of benefits</li>
			<li>clarity about both personal and wider benefits.</li>
			<li>evidence that the proposed data use and sharing will
				bring about the benefits claimed.</li>
		</ul>
		<h3>Benefits</h3>
		<p>
			<em>Explain</em> what personal benefits the individual or their
			family can expect. Also explain any wider benefits (for example
			to the organisation itself, an iwi, or to society as a whole.)
		</p>
		<p>Be specific and provide evidence about how the proposed
			data use will lead to the benefits claimed.</p>
		<p>
			Proven outcomes are the best way to demonstrate benefits. <em>Provide</em>
			concrete examples of similar data use and the resulting benefits
			or a concrete example of an anticipated benefit from the current
			use.
		</p>
		<h3>Marketing</h3>
		<p>Where personally-identifiable data is collected to target
			people for advertising, the benefit accrues mainly to the
			company as profit and the level of comfort is likely to be less.
			Therefore, people might expect to receive a considerable amount
			of personal benefit.</p>
		<p>
			<em>Be explicit</em> about any benefits offered in exchange for
			the use of personal data eg free services, such as access to a
			social networking platform, or access to services at a lower
			charge.
		</p>
		<p>
			<em>Explain</em> whether any other organisations are benefiting
			from the information. Which organisations? How are they
			benefiting?
		</p>
		<p>If you intend providing information to charities or
			political organisations, this should also be made clear.</p>
		<p>
			<em>Give</em> people the ability to opt out of direct marketing
			that uses their data. Make this option readily accessible.
		</p>
	</div>
</div>
</div>

<div class="modal fade" id="q3help" tabindex="-1" role="dialog"
aria-labelledby="q3help" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<span class="button glyphicon glyphicon-remove-circle modal-close" data-dismiss="modal" aria-label="Close"></span>
		<h2>Guidelines</h2>
		<p>
			If you will not be linking the data with any other datasets or
			sharing the data with any other organisations, <em>state</em>
			this clearly.
		</p>
		<p>
			Otherwise &mdash;<br /> <em>Identify</em> which data will be
			linked, what data it will be linked with, and for what purposes.
		</p>
		<p>
			<em>Identify</em> which data will be shared 10 with other
			organisations &mdash; which organisations and for what purposes.
		</p>
	</div>
</div>
</div>
<div class="modal fade" id="q4help" tabindex="-1" role="dialog"
aria-labelledby="q4help" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<span class="button glyphicon glyphicon-remove-circle modal-close" data-dismiss="modal" aria-label="Close"></span>
		<h2>Guidelines</h2>
		<p>
			<em>Build</em> data protection safeguards into your products and
			services from the earliest stages of development.
		</p>
		<p>
			<em>Outline</em> the measures you have in place to keep data
			secure and measures taken by other agencies that you are sharing
			data with. This might include:
		</p>
		<ul>
			<li>describing who will have access to data and their
				training, credentials and referee checks, declarations of
				confidentiality</li>
			<li>the rules and protocols in place and any consequences
				for staff who break them</li>
			<li>security arrangements that prevent unauthorised access
				to the data.</li>
		</ul>
		<p>
			If there is a data breach, <em>inform</em> the people affected
			as soon as possible. This will give your clients or customers
			the best opportunity to protect themselves.
		</p>
		<p>(Note that the guidelines in the next section also assist
			with data security.)</p>
	</div>
</div>
</div>
<div class="modal fade" id="q5help" tabindex="-1" role="dialog"
aria-labelledby="q5help" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<span class="button glyphicon glyphicon-remove-circle modal-close" data-dismiss="modal" aria-label="Close"></span>
		<h2>Guidelines</h2>
		<p>Unless data needs to be personally-identified to achieve its purpose, always use de-identified data.</p>
		<p>In situations where you intend that data be anonymous, rather than providing a guarantee, many people may be satisfied with a high level assurance like:  </p>
		<blockquote>
			We use data in a form that does not identify you personally and we do not use it to target you or other individuals.  While it may be theoretically possible to re-identify you from the data we hold, we use a number of measures to make that highly unlikely.
		</blockquote>
		<p>For those clients with a greater level of concern, or where the data is of a more sensitive nature, you will increase comfort by describing the measures you have in place, and providing assurances, such as:</p>
		<ul>
			<li>techniques you are using that make re-identification more difficult, such as encryption, pseudonymisation, data being analysed at an aggregated rather than at the individual level, adding 'noise'</li>
			<li>controls on who will be able to access the data and for what purposes</li>
			<li>assurances regarding sharing the data &mdash; with whom and for what purpose</li>
			<li>assurances regarding linking the data with other datasets and steps to minimise the risk of re-identification</li>
			<li>that those accessing the data are prohibited from attempting to identify individuals</li>
			<li>a date for the destruction of data after use.</li>
		</ul>
		<p>Providing these details through a link that allows people to drill down if they want to will avoid your statement appearing too long and complex.   People who already have a high level of trust in your organisation and the proposed data use are unlikely to need this further detail.</p>
	</div>
</div>
</div>				
		
<div class="modal fade" id="q6help" tabindex="-1" role="dialog"
aria-labelledby="q6help" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<span class="button glyphicon glyphicon-remove-circle modal-close" data-dismiss="modal" aria-label="Close"></span>
		<h2>Guidelines</h2>
		<h3>Client's ability to see their data</h3>
		<p>Be clear about how people can find out what information is currently held about them, by whom and for what purpose, and how it is currently used and shared.</p>
		<p>People will have higher comfort if the organisation makes a commitment to providing an individual with the information held about them, whether 'readily retrievable' or not.</p>
		<p><em>Set out</em> any circumstances in which this information will not be provided (ie circumstances particular to that organisation rather than the list in the Privacy Act).
		<h3>Client's ability to ask that their data be transferred</h3>
		<p>Organisations should be clear about whether they are willing and able to transfer data to another organisation at the customer's request.  </p>
		<h3>Correcting Data</h3> 
		<p>Organisations should <em>supply</em> a phone number that will directly connect an individual with someone qualified to deal with sensitive requests.</p>
		<p><em>Ensure</em> you have suitable safeguards to prove that the person requesting the information is the person to whom the data relates.</p>
		<p><em>Act</em> promptly on requests to correct data.</p>
		<p><em>Establish</em> a process, complete with a timeline for responding, and include this in the information provided to your customers.   This process needs to include how data that has been shared with another agency will also be corrected.</p>
		<p><em>Explain</em> how you will be accountable for any failures to correct wrong information about clients or customers, eg what are the consequences if your staff disregard requests to correct information? </p>
		<p><em>Offer</em> to meet with any individual who has made a request that you have not acted on.  This provides an opportunity to discuss your reasons, and for the person seeking a correction to explain their situation.</p>
	</div>
</div>
</div>
		
<div class="modal fade" id="q7help" tabindex="-1" role="dialog"
aria-labelledby="q7help" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<span class="button glyphicon glyphicon-remove-circle modal-close" data-dismiss="modal" aria-label="Close"></span>
		<h2>Guidelines</h2>
		<p>If there is no possibility that your organisation will sell personal data &mdash; information about individuals, whether personally-identified or not &mdash; <em>state</em> this clearly and simply.</p>
		<h3>Identified information</h3>
		<p>If the data you collect from customers could be sold in an identified form, you need to seek consent unless the sale is part of the sale of a business as a going concern. (The guidelines in the eighth question cover consent processes.)</p>
		<p>If the business is being sold as a going concern, <em>advise</em> customers and <em>provide</em> an opportunity to opt-off the customer database.</p>
		<h3>Non-identified information</h3>
		<p>Information sold in a non-identified form could potentially be linked or matched with data that could make it identifiable. If you intend selling such information, it would therefore be preferable to &ndash;</p>
		<ul>
			<li><em>tell</em> customers who the data is being sold to and for what purposes (eg marketing)</li>
			<li><em>ask</em> customers for their consent first.
		</ul>
	</div>
</div>
</div>

<div class="modal fade" id="q8help" tabindex="-1" role="dialog"
aria-labelledby="q8help" aria-hidden="true">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<span class="button glyphicon glyphicon-remove-circle modal-close" data-dismiss="modal" aria-label="Close"></span>
		<h2>Guidelines</h2>
		<h3>Ensuring consent is informed</h3>
		<p>Provide information by answering the Eight Key Questions to inform customers or clients about the data use.   </p>
		<p>Be clear about where people have choice and where data provision is a condition of receiving the service or product, using these 3 categories:</p>
		<table class="table">
			<tr>
				<td>1.</td>
				<td>Data you are requiring as a condition of supplying the
					service or product.</td>
				<td>In most cases this should only be the data that is
					strictly necessary for the service.</td>
			</tr>
			<tr>
				<td>2.</td>
				<td>Information beyond what is strictly needed for service
					delivery, but authorised under legislation.</td>
				<td><p>Be explicit about any consequences of not providing
						this additional information.</p></td>
			</tr>
			<tr>
				<td>3.</td>
				<td>Information beyond that needed for service delivery or
					authorised under legislation (eg for marketing or research).</td>
				<td><p>Consider seeking this information, and consent for its use, separately.  In some cases this might best be done after the service or product has been delivered.</p>
					<p>Be explicit about any incentives you are offering in exchange for gaining the right to use customer/client information.</p>
				</td>
			</tr>
		</table>
		<h3>Obtaining consent</h3>
		<p>Clients and customers should be asked to give consent through a positive action, eg by ticking a box or clicking an 'I agree' statement.  </p>
		<p>Make the request for consent short and easy to understand &mdash; present it separately rather than as part of a lengthy terms and conditions statement.</p>
		<p>Give clients or customers as much flexibility as you can to make choices about the use and sharing of data about them.  Make it easy for them adjust those choices over time.</p>
		<p>Make it as easy to withdraw consent as it is to give it.</p>
		<p>Where people are in vulnerable situations (eg a person using a rape counselling service or a women's refuge for the first time, or a homeless person) it is especially important to limit the initial data collection to the minimum needed for service delivery.  Issues of data use and consent should be addressed at a later stage.  </p>
		<p>Where the information being collected relates to a child under 16, seek consent from the child's parent or guardian.</p>
	</div>
</div>
</div>

</div>
</div>


<div class="panel">
<p class="step-heading"><a data-toggle="collapse" data-parent="#accordion" href="#step2">STEP 2</a></p>
<div id="step2" class="panel-collapse collapse">
	<div class="panel-body">
		<h1 class="heading">Test your dial</h1>
		<p>This is how your dial will appear when published on your site, or <a href="../public-dials/" id="testDialLink">linked to on our site</a>.  Check everything is working, then on to step 3!</p>
		<div id="dataFutures"></div>
	</div>
</div>
</div>

<div class="panel">
<p class="step-heading"><a data-toggle="collapse" data-parent="#accordion" href="#step3">STEP 3</a></p>
<div id="step3" class="panel-collapse collapse">
	<div class="panel-body">

<h1 class="heading">Display your dial</h1>
<p>Add the data dial to your website</p>

<div id="embedParent">

<a href="#" class="btn btn-default btn-lg button-image html" data-toggle="collapse" data-parent="#embedParent" data-target="#htmlEmbed">Direct HTML</a>
<a href="#" class="btn btn-default btn-lg button-image wordpress" data-toggle="collapse"  data-parent="#embedParent" data-target="#wordPressEmbed">Wordpress</a>
<a href="#" class="btn btn-default btn-lg button-image silverstripe" data-toggle="collapse"  data-parent="#embedParent" data-target="#silverstripeEmbed">Silverstripe</a>
<a href="#" class="btn btn-default btn-lg" data-toggle="collapse" data-target="#otherEmbed">Other</a>
|
<a href="#" class="btn btn-default btn-lg button-image link" data-toggle="collapse" data-target="#linkToYourDial">Link to the dial on our website</a>
<a href="#" class="btn btn-default btn-lg button-image pdf" data-toggle="collapse" data-target="#pdfLink">Generate a PDF</a>



<div class="accordion-group">
<div class="collapse" id="htmlEmbed">
	<div class="well">
		<p>To enable your data dial on your own website, please cut and paste the following code. You may wish to send the code and instructions to your web developer.</p>
		<p>	In your html
			<code>&lt;head&gt;</code>
			block, include the widget code:
			<code>
				<pre>&lt;script src="https://trusteddata.co.nz/media/dataFutures.js">&lt;/script></pre>
			</code>
			Then in the location you want the widget, create a
			<code>&lt;div&gt;</code>
			block with the id
			<code>dataFutures</code>
			and a
			<code>data-wheel-id</code>
			attribute as generated from your answers
			<code>
				<pre>&lt;div id="dataFutures" data-wheel-id="<span id="embedCode"></span>"&gt;</pre>
			</code>
		</p>
	</div>
</div>
<div class="collapse" id="wordPressEmbed">
	<div class="well">
	<p>If your site is built with Wordpress, simply download and install the attached plugin</p>
	<p>Once installed, use the shortcode <code>[data-dial id="<span id="wordpressEmbedCode"></span>"]</code></p>
	<p><a href="https://trusteddata.co.nz/media/wordpress/transparent-data-dial.zip" class="btn btn-default">Download wordpress plugin</a>
	<p></p>
	</div>
</div>

<div id="silverstripeEmbed" class="collapse">
	<div class="well">
		<p>If your site is built with Silverstripe, you can use a shortcode to embed your dial.  The simplest way to use this is with composer.  </p>
		<p>Run <code>composer require parhelion-nz/transparentdatadial:*</code> to install the module.  If you do not use composer, simply download and install the attached addon.</p>
		<p>Once installed in your silverstripe directory, use the shortcode <code>[transparent_data_dial,id=<span id="silverstripeEmbedCode"></span>]</code></p>
		<p><a href="https://trusteddata.co.nz/media/silverstripe/transparentdata.zip" class="btn btn-default">Download silverstripe module</a>
		<p></p>
	</div>
</div>

<div id="otherEmbed" class="collapse">
	<div class="well">
		<p>If you use an alternative CMS, or need assistance, the team at <a href="http://tagtheagency.com">TAG The Agency</a> can help.  Please contact <a href="mailto:info@tagtheagency.com">info@tagtheagency.com</a> to discuss a professional services contract.</p>
	</div>
</div>

<div class="collapse" id="linkToYourDial" aria-labelledby="linkLink" aria-hidden="true">
	<div class="well">
		<p>If you would prefer to link to the Dial on our site, create a link from your site to <a href="../public-dials/" id="linkEmbedCode"></a>.</p>
	</div>
</div>

<div class="collapse" id="pdfLink" aria-labelledby="linkLink" aria-hidden="true">
	<div class="well">
		<p><a href="../public-pdf/" id="pdfEmbedCode">Download a PDF</a> of your answers which you can load onto your website or use in other media.</p>
	</div>
</div>


</div>
</div>
<div class="modal fade" id="embedYourDial" tabindex="-1" role="dialog" aria-labelledby="embedLink" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a data-toggle="tab" href="#htmlEmbed">Direct HTML</a></li>
			<li role="presentation"><a data-toggle="tab" href="#wordPressEmbed">Wordpress</a></li>
			<li role="presentation"><a data-toggle="tab" href="#silverstripeEmbed">Silverstripe</a></li>
			<li role="presentation"><a data-toggle="tab" href="#otherEmbed">Other</a></li>
		</ul>
		<div class="tab-content">
		<div id="htmlEmbed" class="tab-pane fade in active">
		<p>To enable your data dial on your own website, please cut and paste the following code. You may wish to send the code and instructions to your web developer.</p>
		<p>	In your html
			<code>&lt;head&gt;</code>
			block, include the widget code:
			<code>
				<pre>&lt;script src="https://trusteddata.co.nz/media/dataFutures.js">&lt;/script></pre>
			</code>
			Then in the location you want the widget, create a
			<code>&lt;div&gt;</code>
			block with the id
			<code>dataFutures</code>
			and a
			<code>data-wheel-id</code>
			attribute as generated from your answers
			<code>
				<pre>&lt;div id="dataFutures" data-wheel-id="<span id="embedCode"></span>"&gt;</pre>
			</code>
		</p>
		</div>
		<div id="wordPressEmbed" class="tab-pane fade">
		<p>If your site is built with Wordpress, simply download and install the attached plugin</p>
		<p>Once installed, use the shortcode <code>[data-dial id="<span id="wordpressEmbedCode"></span>"]</code></p>
		<p><a href="https://trusteddata.co.nz/media/wordpress/transparent-data-dial.zip" class="btn btn-default">Download wordpress plugin</a>
		<p></p>
		</div>
		<div id="silverstripeEmbed" class="tab-pane fade">
		<p>If your site is built with Silverstripe, simply download and install the attached addon</p>
		<p>Once installed in your silverstripe directory, use the shortcode <code>[transparent_data_dial,id=<span id="silverstripeEmbedCode"></span>]</code></p>
		<p><a href="https://trusteddata.co.nz/media/silverstripe/transparentdata.zip" class="btn btn-default">Download silverstripe module</a>
		<p></p>
		</div>
		<div id="otherEmbed" class="tab-pane fade">
		<p>If you use an alternative CMS, or need assistance, <a href="http://tagtheagency.com">TAG The Agency</a> can help.  Please contact <a href="mailto:info@tagtheagency.com">info@tagtheagency.com</a> to discuss a professional services contract.</p>
		<p></p>
		<p></p>
		</div>
		</div>
	</div>
</div>
</div>

	</div>
</div>
</div>

<div class="panel">
<p class="step-heading"><a data-toggle="collapse" data-parent="#accordion" href="#step4">STEP 4</a></p>
<div id="step4" class="panel-collapse collapse">
	<div class="panel-body">


<h2>Share your dial</h2>
<div class="social">
<ul>
	<li><a href="#" id="fbshare"><i class="fa fa-lg fa-facebook"></i></a></li>
	<li><a href="#" id="twittershare"><i class="fa fa-lg fa-twitter"></i></a></li>
	<li><a href="#" id="lnshare"><i class="fa fa-lg fa-linkedin"></i></a></li>
	
</ul>
</div>
</div></div></div>

<script>
var ajaxurl = '<?php echo admin_url( "admin-ajax.php" )?>';
var wheelId = <?php echo $selected_wheel->id;?>;

var activeTextArea = null;

var wheelRef = null;
function dataFuturesDialCallback(wheel) {
	wheelRef = wheel;
}

jQuery(document).ready(function() {
	jQuery('#rootwizard').bootstrapWizard({
		tabClass: '', 
		onTabShow: function(tab, nav, index) {
			activeTextArea = $('#q'+(index+1)+'answer')[0];
			countChars({target:activeTextArea});
		}
	});
	
	jQuery('a.loadWheel').click(function(e) {
		 e.preventDefault(); 
		 loadWheel(jQuery(this).data('target'));
	 });
	
	jQuery('#wheelName').on('change keyup paste', jQuery.debounce(function(evt) {
		jQuery('#wheelLink'+wheelId).text(jQuery('#wheelName').val());
		saveWheel();
	}, 1000));
	
	jQuery('#wheelURL').on('change keyup paste', jQuery.debounce(function(evt) {
		saveWheel();
	}, 1000));
	
	jQuery('#createNewWheel').click(function(e) {
		e.preventDefault();
		createWheel();
	});
	
	loadWheel(wheelId);
	monitorAnswers();
	
	jQuery("#createAccountTab").tab('show');
	
	$('#step2').on('show.bs.collapse', function () {
		wheelRef.answers = [];
		for (var i = 1; i < 9; i++) {
			wheelRef.answers.push({question_id:i, answer: $('#q'+(i)+'answer')[0].value});
		}
		wheelRef.rotate(0);
		$('#dataFuturesGuidelinesAnswersQuestion').text('');
		$('#dataFuturesGuidelinesAnswersAnswer').text('');
//		wheelRef.load(wheelId);
	});


	var $myGroup = $('#embedParent');
	$myGroup.on('show.bs.collapse','.collapse', function() {
	    $myGroup.find('.collapse.in').collapse('hide');
	});

});

function monitorAnswers() {
	jQuery("textarea").each(function(idx, element) {
		jQuery(element).on('change keyup paste', countChars);
	
		jQuery(element).on('change keyup paste', jQuery.debounce(function(evt) {
			localStorage.setItem(evt.target.id, evt.target.value);
			
			ajaxSave(jQuery(evt.target).data('question'), evt.target.value);
			
			//generateEmbed();
		}, 2000));
	});
}

function countChars(evt) {
	var length = evt.target.value.length;
	
	jQuery("#characterCount").text(length + ' characters.');
	if (length > 500) {
		jQuery("#characterCount").css('color', 'red');
	} else {
		jQuery("#characterCount").css('color', 'inherit');
	}
}

function createWheel() {
	var ajaxurl = '<?php echo admin_url( "admin-ajax.php" )?>';
	var data = {'action':'create_wheel'};
	jQuery.post(ajaxurl, data, function(response) {
	});
}

function saveWheel() {
	var ajaxurl = '<?php echo admin_url( "admin-ajax.php" )?>';
	var data = {
			'action':'save_wheel',
			'id':wheelId,
			'name':jQuery('#wheelName').val(),
			'url':jQuery('#wheelURL').val()
	};
	jQuery.post(ajaxurl, data, function(response) {
	});

}

function ajaxSave(id, value) {
	var ajaxurl = '<?php echo admin_url( "admin-ajax.php" )?>';
	var data = {
		'action':'save_answer',
		'id':wheelId,
		'question':id,
		'answer':value
	};
	jQuery.post(ajaxurl, data, function(response) {
	
	});
}

function loadWheel(id) {
	wheelId = id;
	var ajaxurl = '<?php echo admin_url( "admin-ajax.php" )?>';
	var data = {
		'action':'get_wheel',
		'id':id
	};
	jQuery.post(ajaxurl, data, function(response) {
		var json = JSON.parse(response);
		jQuery('#embedCode').text(json.embedCode);
		jQuery('#wordpressEmbedCode').text(json.embedCode);
		jQuery('#silverstripeEmbedCode').text(json.embedCode);
		jQuery('#linkEmbedCode').html('<a href="../public-dials/'+json.embedCode+'">https://www.trusteddata.co.nz/public-dials/'+json.embedCode+'</a>');
		jQuery('#pdfEmbedCode').html('<a href="../pdf-dials/'+json.embedCode+'">Download a PDF</a>');
		jQuery('#testDialLink').attr('href', '../public-dials/'+json.embedCode);
		jQuery('#fbshare').attr('href', 'http://www.facebook.com/sharer/sharer.php?u=https://trusteddata.co.nz/public-dials/'+json.embedCode+'/');
		jQuery('#twittershare').attr('href', "http://twitter.com/share?text=I've just made my data dial, visit www.TrustedData.co.nz to create yours!&url=https://trusteddata.co.nz/public-dials/"+json.embedCode+"/");
		jQuery('#lnshare').attr('href', "http://www.linkedin.com/shareArticle?mini=true&url=https://trusteddata.co.nz/public-dials/"+json.embedCode+"/&title=Trusted Data Dial&summary=I've just made my data dial, visit www.TrustedData.co.nz to create yours!");
		jQuery('#wheelName').val(json.name);		
		jQuery('#wheelURL').val(json.url);
		jQuery('#q1answer').val(getAnswer(1, json.answers));
		jQuery('#q2answer').val(getAnswer(2, json.answers));
		jQuery('#q3answer').val(getAnswer(3, json.answers));
		jQuery('#q4answer').val(getAnswer(4, json.answers));
		jQuery('#q5answer').val(getAnswer(5, json.answers));
		jQuery('#q6answer').val(getAnswer(6, json.answers));
		jQuery('#q7answer').val(getAnswer(7, json.answers));
		jQuery('#q8answer').val(getAnswer(8, json.answers));
		countChars({target:activeTextArea});
	});
}

function getAnswer(id, array) {
var object = array.find(function(el){return el.question_id == id});
if (typeof(object) !== 'undefined') {
	return object.answer;
}
return '';
}

function generateEmbed() {
var json = [];
json.push({'answer':localStorage.q1answer});
json.push({'answer':localStorage.q2answer});
json.push({'answer':localStorage.q3answer});
json.push({'answer':localStorage.q4answer});
console.log(json);
var code = LZString.compressToBase64(JSON.stringify(json));
//$('#embedCode').text(code);
}
</script>

</div>

</div>

<?php 
} 

data_futures_footer(false);
?>



</body>
</html>