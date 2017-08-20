<?php /* Template Name: Public dials display */ ?>
<?php get_header(); ?>
<?php
$dial = get_query_var('dial');
$wheel = get_public_wheel_details($dial);
?>

<div class="alert alert-info" role="alert">
<p>This Transparent Data Dial is built with answers provided by a third party.  This data belongs to the organisation shown, and does not in any way reflect the views of the Data Futures Partnership.  To report inappropriate content please contact <a href="mailto:info@datafutures.co.nz?subject=inappropriate content dial <?php echo $dial;?>">info@datafutures.co.nz</a>.</p>
</div>
<h1><?php echo $wheel->name; ?></h1>
<script src="https://trusteddata.co.nz/media/dataFutures.js"></script>
<div id="dataFutures" data-wheel-id="<?php echo $dial?>"></div>

<?php get_footer(); ?>