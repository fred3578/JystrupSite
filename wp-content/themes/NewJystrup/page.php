<?php get_header(); ?>

<!-- Other Content here -->
<div id="posts" class="col-12">
    <?php if ( have_posts() ) : while ( have_posts() ) :   the_post(); ?>

        <h2>
            <a href="<?php the_permalink() ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        <?php the_content(); ?>
        
    <?php endwhile; else: ?>
        <p>There no'nt posts to show</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>