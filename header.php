<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<div class="container">

	<!-- site-header -->
	<header class="site-header">
		<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		
		<?php
			$args = array(
				'theme_location' => 'primary'
			);
		?>
		
		<nav class="site-nav">
			<?php wp_nav_menu( $args ); ?>
		</nav>
		
	</header><!-- /site-header -->