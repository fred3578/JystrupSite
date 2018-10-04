<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Intet fundet', 'Jystrup.dk' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Klar til at skrive et indlæg? <a href="%1$s">Begynd her</a>.', 'Jystrup.dk' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Beklager, din søgning gav ingen resultater. Forsøg venligst igen med andre nøgleord.', 'Jystrup.dk' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'Vi kan ikke finde, hvad du leder efter. Måske kan en søgning hjælpe.', 'Jystrup.dk' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
