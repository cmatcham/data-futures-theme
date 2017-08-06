<html>
<body>
<?php
$mypages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'post_date', 'sort_order' => 'desc' ) );
print_r($mypages);
?>
This is home.php
<?php get_the_content(); ?>
</body>
</html>