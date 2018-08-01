<?php
/**
 * The Header template
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama 1.0
 */ 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php
	$user = wp_get_current_user();
    if ( in_array( 'administrator', (array) $user->roles ) )
	{
       echo "<style>
	   			@media screen and (min-width: 600px) {
	   				.default {display:inline-block; }
					.default_block {display:block; }
	   				.defaultt { display:none; }
	   				.admin_show { display:inline-block; }
					.admin_block { display:block; }
				}
			</style>";
    }
	else if ( in_array( 'user_high', (array) $user->roles ) )
	{
		echo "<style>
				@media screen and (min-width: 600px) {
					.default {display:inline-block; }
					.default_block {display:block; }
					.defaultt { display:none; }
					.user_high_show { display:inline-block; }
					.user_high_block {display:block; }
				}
			</style>";
	}
	else if ( in_array( 'medium_user', (array) $user->roles ) )
	{
		echo "<style>
				@media screen and (min-width: 600px) {
					.default {display:inline-block; }
					.default_block {display:block; }
					.defaultt { display:none; }
					.medium_user_show { display:inline-block; }
					.medium_user_block { display:block; }
				}
			</style>";
	}
	else if ( in_array( 'primary_user', (array) $user->roles ) )
	{
		echo "<style>
				@media screen and (min-width: 600px) {
					.default {display:inline-block; }
					.default_block {display:block; }
					.defaultt { display:none; }
					.primary_user_show { display:inline-block; }
					.primary_user_block { display:block; }
				}
			</style>";
	}
	else
	{
		echo "<style>
				@media screen and (min-width: 600px) {
					.default {display:inline-block; }
					.default_block {display:block; }
	   				.defaultt { display:none; }
				}
			</style>";
	}
?>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head(); ?>

</head>
<body <?php body_class('stretched'); ?>>
<!-- Main Wrapper Start -->
<div id="main-wrapper">
	
	<!-- Header Start -->
	<header id="masthead" class="site-header clearfix <?php Agama::header_class(); ?>" role="banner">
		
		<?php Agama_Helper::get_header(); ?>
		
		<?php Agama_Helper::get_header_image(); ?>
		
	</header><!-- Header End -->
	
	<?php Agama_Helper::get_slider(); ?>
	
	<?php Agama_Helper::get_breadcrumb(); ?>

	<div id="page" class="hfeed site">
		<div id="main" class="wrapper">
			<div class="vision-row clearfix">
				
				<?php Agama_Helper::get_front_page_boxes(); ?>
				
				<?php //Agama_Helper::get_agama_blue_contents(); ?>
				
