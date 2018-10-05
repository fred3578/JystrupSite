<?php get_header(); ?>
<?php get_sidebar(); ?>
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

<?php get_footer(); ?>