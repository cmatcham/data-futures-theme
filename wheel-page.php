<?php /* Template Name: Create your wheel template */ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Create your wheel</title>


    <?php wp_head(); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

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
            <?php if (is_user_logged_in()) { ?>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                	<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Your wheels <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php
							foreach ( get_wheels() as $data_future_wheel) {
								echo '<li><a class="loadWheel" href="#" data-target="'.$data_future_wheel->id.'">'.$data_future_wheel->name.'</li>';
							}
							?>	
				            <li role="separator" class="divider"></li>
				            <li><a href="#">Create new</a></li>
						</ul>
                	</li>
                	<li><a href="<?php echo wp_logout_url( get_permalink() ); ?>">Logout</a></li>
                </ul>
            </div>
            
            <?php } ?>
            
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
<!-- Custom Login/Register/Password Code @ https://digwp.com/2010/12/login-register-password-code/ -->
<!-- Theme Template Code -->

<div id="login-register-password">

	<?php global $user_ID, $user_identity; if (!$user_ID) { ?>

	<ul class="tabs_login">
		<li class="active_login"><a href="#tab1_login">Login</a></li>
		<li><a href="#tab2_login">Register</a></li>
		<li><a href="#tab3_login">Forgot?</a></li>
	</ul>
	<div class="tab_container_login">
		<div id="tab1_login" class="tab_content_login">

			<?php $register = $_GET['register']; $reset = $_GET['reset']; if ($register == true) { ?>

			<h3>Success!</h3>
			<p>Check your email for the password and then return to log in.</p>

			<?php } elseif ($reset == true) { ?>

			<h3>Success!</h3>
			<p>Check your email to reset your password.</p>

			<?php } else { ?>

			<h3>Have an account?</h3>
			<p>Log in or sign up! It&rsquo;s fast &amp; <em>free!</em></p>

			<?php } ?>

			<form method="post" action="<?php bloginfo('url') ?>/wp-login.php" class="wp-user-form">
				<div class="username">
					<label for="user_login"><?php _e('Username'); ?>: </label>
					<input type="text" name="log" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="11" />
				</div>
				<div class="password">
					<label for="user_pass"><?php _e('Password'); ?>: </label>
					<input type="password" name="pwd" value="" size="20" id="user_pass" tabindex="12" />
				</div>
				<div class="login_fields">
					<div class="rememberme">
						<label for="rememberme">
							<input type="checkbox" name="rememberme" value="forever" checked="checked" id="rememberme" tabindex="13" /> Remember me
						</label>
					</div>
					<?php do_action('login_form'); ?>
					<input type="submit" name="user-submit" value="<?php _e('Login'); ?>" tabindex="14" class="user-submit" />
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
		<div id="tab2_login" class="tab_content_login" style="display:none;">
			<h3>Register for this site!</h3>
			<p>Sign up now for the good stuff.</p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" class="wp-user-form">
				<div class="username">
					<label for="user_login"><?php _e('Username'); ?>: </label>
					<input type="text" name="user_login" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="101" />
				</div>
				<div class="password">
					<label for="user_email"><?php _e('Your Email'); ?>: </label>
					<input type="text" name="user_email" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" id="user_email" tabindex="102" />
				</div>
				<div class="login_fields">
					<?php do_action('register_form'); ?>
					<input type="submit" name="user-submit" value="<?php _e('Sign up!'); ?>" class="user-submit" tabindex="103" />
					<?php $register = $_GET['register']; if($register == true) { echo '<p>Check your email for the password!</p>'; } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
		<div id="tab3_login" class="tab_content_login" style="display:none;">
			<h3>Lose something?</h3>
			<p>Enter your username or email to reset your password.</p>
			<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" class="wp-user-form">
				<div class="username">
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
				</div>
				<div class="login_fields">
					<?php do_action('login_form', 'resetpass'); ?>
					<input type="submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="user-submit" tabindex="1002" />
					<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>A message will be sent to your email address.</p>'; } ?>
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?reset=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</div>
			</form>
		</div>
	</div>

	<?php } else { // is logged in ?>

	<div class="sidebox">
		<h3>Welcome, <?php echo $user_identity; ?></h3>
		<div class="usericon">
			<?php global $userdata; echo get_avatar($userdata->ID, 60); ?>

		</div>
		<div class="userinfo">
			<p>You&rsquo;re logged in as <strong><?php echo $user_identity; ?></strong></p>
			<p>
				<a href="<?php echo wp_logout_url('index.php'); ?>">Log out</a> | 
				<?php if (current_user_can('manage_options')) { 
					echo '<a href="' . admin_url() . '">' . __('Admin') . '</a>'; } else { 
					echo '<a href="' . admin_url() . 'profile.php">' . __('Profile') . '</a>'; } ?>

			</p>
		</div>
	</div>

	<?php } ?>

</div>
<script>
	jquery(document).ready(function() {
		jquery(".tab_content_login").hide();
		jquery("ul.tabs_login li:first").addClass("active_login").show();
		jquery(".tab_content_login:first").show();
		jquery("ul.tabs_login li").click(function() {
			jquery("ul.tabs_login li").removeClass("active_login");
			jquery(this).addClass("active_login");
			jquery(".tab_content_login").hide();
			var activeTab = jquery(this).find("a").attr("href");
			if (jquery.browser.msie) {jquery(activeTab).show();}
			else {jquery(activeTab).show();}
			return false;
		});
	});
</script>
<?php

}
?>



<?php
if (is_user_logged_in()) {
?>
<div class="container">
	<div class="row" style="padding-top:60px;">
<?php 
$wheels = get_wheels();
?>    
<div class="form-group">
	<label for="wheelName">Name</label>
	<input type="text" class="form-control" id="wheelName" placeholder="Enter a name for this wheel (eg. your organisation name)" name="wheelName">
</div>
<div class="form-group">
	<label for="wheelURL">URL</label>
	<input type="text" class="form-control" id="wheelURL" placeholder="Enter the url of your organisation or business unit" name="wheelName">
</div>

<div id="rootwizard">
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<ul class="nav nav-pills">
						<li><a href="#tab1" data-toggle="tab">Question 1</a></li>
						<li><a href="#tab2" data-toggle="tab">Question 2</a></li>
						<li><a href="#tab3" data-toggle="tab">Question 3</a></li>
						<li><a href="#tab4" data-toggle="tab">Question 4</a></li>
						<li><a href="#tab5" data-toggle="tab">Question 5</a></li>
						<li><a href="#tab6" data-toggle="tab">Question 6</a></li>
						<li><a href="#tab7" data-toggle="tab">Question 7</a></li>
						<li><a href="#tab8" data-toggle="tab">Question 8</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="bar" class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="0"
				aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
		</div>
		<div class="tab-content">
			<div class="tab-pane" id="tab1">
				<div class="question" id="question1">
					<h1>What will my data be used for?</h1>
					<a href="#" class="btn btn-lg btn-success" data-toggle="modal"
						data-target="#q1help">Click to open help</a>
				</div>
				<div class="form-group">
					<textarea id="q1answer" data-question="1" class="form-control" rows="3"></textarea>
				</div>
				<div class="modal fade" id="q1help" tabindex="-1" role="dialog"
					aria-labelledby="q1help" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
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
								why it isn�t possible to achieve the purpose in any other way eg
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
							<p>If it isn�t possible to be precise about possible future
								uses, provide an assurance that the person will be asked to give
								consent to that use before it occurs.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="tab2">
				<div class="question" id="question2">
					<h1>What are the benefits and who will benefit?</h1>
					<a href="#" class="btn btn-lg btn-success" data-toggle="modal"
						data-target="#q2help">Click to open help</a>
				</div>
				<div class="form-group">
					<textarea data-question="2" id="q2answer" class="form-control" rows="3"></textarea>
				</div>
				<div class="modal fade" id="q2help" tabindex="-1" role="dialog"
					aria-labelledby="q2help" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
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

			</div>
			<div class="tab-pane" id="tab3">
				<div class="question" id="question3">
					<h1>Who will be using my data?</h1>
					<a href="#" class="btn btn-lg btn-success" data-toggle="modal"
						data-target="#q3help">Click to open help</a>
				</div>
				<div class="form-group">
					<textarea data-question="3" id="q3answer" class="form-control" rows="3"></textarea>
				</div>
				<div class="modal fade" id="q3help" tabindex="-1" role="dialog"
					aria-labelledby="q3help" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
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
			</div>
			<div class="tab-pane" id="tab4">
				<div class="question" id="question4">
					<h1>Is my data secure?</h1>
					<a href="#" class="btn btn-lg btn-success" data-toggle="modal"
						data-target="#q4help">Click to open help</a>
				</div>
				<div class="form-group">
					<textarea data-question="4" id="q4answer" class="form-control" rows="3"></textarea>
				</div>
				<div class="modal fade" id="q4help" tabindex="-1" role="dialog"
					aria-labelledby="q4help" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
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
			</div>
			<div class="tab-pane" id="tab5">
				<div class="question" id="question5">
					<h1>Will my data be anonymous?</h1>
					<a href="#" class="btn btn-lg btn-success" data-toggle="modal"
						data-target="#q5help">Click to open help</a>
				</div>
				<div class="form-group">
					<textarea data-question="5" id="q5answer" class="form-control" rows="3"></textarea>
				</div>
				<div class="modal fade" id="q5help" tabindex="-1" role="dialog"
					aria-labelledby="q5help" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
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
								<li>assurances regarding sharing the data � with whom and for what purpose</li>
								<li>assurances regarding linking the data with other datasets and steps to minimise the risk of re-identification</li>
								<li>that those accessing the data are prohibited from attempting to identify individuals</li>
								<li>a date for the destruction of data after use.</li>
							</ul>
							<p>Providing these details through a link that allows people to drill down if they want to will avoid your statement appearing too long and complex.   People who already have a high level of trust in your organisation and the proposed data use are unlikely to need this further detail.</p>
						</div>
					</div>
				</div>				
			</div>
			<div class="tab-pane" id="tab6">
				<div class="question" id="question6">
					<h1>Can I see and correct data about me?</h1>
					<a href="#" class="btn btn-lg btn-success" data-toggle="modal"
						data-target="#q6help">Click to open help</a>
				</div>
				<div class="form-group">
					<textarea data-question="6" id="q6answer" class="form-control" rows="3"></textarea>
				</div>
				<div class="modal fade" id="q6help" tabindex="-1" role="dialog"
					aria-labelledby="q6help" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<h2>Guidelines</h2>
							<h3>Client's ability to see their data</h3>
							<p>Be clear about how people can find out what information is currently held about them, by whom and for what purpose, and how it is currently used and shared.</p>
							<p>People will have higher comfort if the organisation makes a commitment to providing an individual with the information held about them, whether �readily retrievable� or not.</p>
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
			</div>
			<div class="tab-pane" id="tab7">
				<div class="question" id="question7">
					<h1>Could my data be sold?</h1>
					<a href="#" class="btn btn-lg btn-success" data-toggle="modal"
						data-target="#q7help">Click to open help</a>
				</div>
				<div class="form-group">
					<textarea data-question="7" id="q7answer" class="form-control" rows="3"></textarea>
				</div>
				<div class="modal fade" id="q7help" tabindex="-1" role="dialog"
					aria-labelledby="q7help" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
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
			</div>
			<div class="tab-pane" id="tab8">
				<div class="question" id="question8">
					<h1>Will I be asked for consent?</h1>
					<a href="#" class="btn btn-lg btn-success" data-toggle="modal"
						data-target="#q8help">Click to open help</a>
				</div>
				<div class="form-group">
					<textarea data-question="8" id="q8answer" class="form-control" rows="3"></textarea>
				</div>
				<div class="modal fade" id="q8help" tabindex="-1" role="dialog"
					aria-labelledby="q8help" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
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
							<p>Make the request for consent short and easy to understand � present it separately rather than as part of a lengthy terms and conditions statement.</p>
							<p>Give clients or customers as much flexibility as you can to make choices about the use and sharing of data about them.  Make it easy for them adjust those choices over time.</p>
							<p>Make it as easy to withdraw consent as it is to give it.</p>
							<p>Where people are in vulnerable situations (eg a person using a rape counselling service or a women�s refuge for the first time, or a homeless person) it is especially important to limit the initial data collection to the minimum needed for service delivery.  Issues of data use and consent should be addressed at a later stage.  </p>
							<p>Where the information being collected relates to a child under 16, seek consent from the child�s parent or guardian.</p>
						</div>
					</div>
				</div>
			</div>
			<ul class="pager wizard">
				<li class="previous first" style="display: none;"><a href="#">First</a></li>
				<li class="previous"><a href="#">Previous</a></li>
				<li class="next last" style="display: none;"><a href="#">Last</a></li>
				<li class="next"><a href="#">Next</a></li>
			</ul>
		</div>
	</div>


	<p>
		In your html
		<code>&lt;head&gt;</code>
		block, include the widget code:
		<code>
			<pre>
&lt;script src="http://parhelion.co.nz/dataFutures/media/dataFutures.js">&lt;/script>
</pre>
		</code>
		Then in the location you want the widget, create a
		<code>&lt;div&gt;</code>
		block with the id
		<code>dataFutures</code>
		and a
		<code>data-embed</code>
		attribute as generated from your answers
		<code>
			<pre>&lt;div id="dataFutures" data-embed="<span id="embedCode"></span>"&gt;</pre>
		</code>
	</p>
<script>
var ajaxurl = '<?php echo admin_url( "admin-ajax.php" )?>';
var wheel_id = -1;

jQuery(document).ready(function() {
	console.log('ready');
  	jQuery('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
		var $total = navigation.find('li').length;
		var $current = index+1;
		var $percent = ($current/$total) * 100;
		jQuery('#rootwizard .progress-bar').css({width:$percent+'%'});
	}});
  	
  	$('a.loadWheel').click(function(e) {
  	     e.preventDefault(); 
  	     console.log(this);
  	     loadWheel(jQuery(this).data('target'));
  	 });
  	
  	monitorAnswers();
  	
  	jQuery("#createAccountTab").tab('show');
  	
});

function monitorAnswers() {
	console.log('monitoring answers');
	jQuery("textarea").each(function(idx, element) {
		console.log(element);
		jQuery(element).on('change keyup paste', jQuery.debounce(function(evt) {
		    localStorage.setItem(evt.target.id, evt.target.value);
		    
		    ajaxSave(jQuery(evt.target).data('question'), evt.target.value);
		    
		    generateEmbed();
		}, 2000));
	});
}

function ajaxSave(id, value) {
	console.log("CSJM", id, value);
	var ajaxurl = '<?php echo admin_url( "admin-ajax.php" )?>';
	var data = {
		'action':'save_answer',
		'id':wheel_id,
		'question':id,
		'answer':value
	};
	jQuery.post(ajaxurl, data, function(response) {
		console.log(response);
	});
}

function loadWheel(id) {
	var ajaxurl = '<?php echo admin_url( "admin-ajax.php" )?>';
	var data = {
		'action':'get_wheel',
		'id':id
	};
	jQuery.post(ajaxurl, data, function(response) {
		var json = JSON.parse(response);
		jQuery('#wheelName').val(json.name);		
		jQuery('#wheelUrl').val(json.url);
		console.log(json);
		console.log(json.answers);
		jQuery('#q1answer').val(getAnswer(1, json.answers));
		jQuery('#q2answer').val(getAnswer(2, json.answers));
		jQuery('#q3answer').val(getAnswer(3, json.answers));
		jQuery('#q4answer').val(getAnswer(4, json.answers));
		jQuery('#q5answer').val(getAnswer(5, json.answers));
		jQuery('#q6answer').val(getAnswer(6, json.answers));
		jQuery('#q7answer').val(getAnswer(7, json.answers));
		jQuery('#q8answer').val(getAnswer(8, json.answers));
	});
}

function getAnswer(id, array) {
	var object = array.find(function(el){return el.question_id == id});
	console.log(id, object, array);
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
	$('#embedCode').text(code);
}
</script>

</div>

</div></div>

<?php 
} 


?>



</body>
</html>