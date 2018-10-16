<?php get_header(); ?>



<!-- Other Content here -->
<div id="posts" class="card">

    <?php if ( have_posts() ) : while ( have_posts() ) :   the_post(); ?>
        
        <h2>
            <a href="<?php the_permalink() ?>">
                <?php the_title(); ?>
            </a>
        </h2>

        <?php the_content(); ?>

    <?php endwhile; else: ?>
        <p>Der ingen indlæg at vise.</p>
    <?php endif; ?>

</div>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div>
<?php endif; ?>

<?php get_footer(); ?>