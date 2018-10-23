<?php get_header(); ?>
<!-- Page Heading -->
<section class="page-heading">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1><?php printf(__("Search Results For: %s", 'fortune'), '<span>"' . esc_attr(get_search_query()) . '"</span>'); ?></h1>
			</div>
			<div class="col-md-6">
				<?php fortune_breadcrumbs(); ?>
			</div>
		</div>
	</div>
</section>
<!-- Page Heading / End -->
<!-- Page Content -->
<section class="page-content">
	<div class="container">

		<div class="row">
			<div class="content col-md-8"><?php
					if (have_posts()) { 
					  while (have_posts()): the_post();
						get_template_part('blog', 'content');
					  endwhile;
					}else{ ?>
						<div class="search_error">
                            <div class="search_err_heading"><h2><?php _e("Nothing Found", 'fortune'); ?></h2></div>
                            <div class="fortune_searching">
                                <p><?php _e("Sorry, but nothing matched your search criteria. Please try again with some different keywords.", 'fortune'); ?></p>
                            </div>

                        </div>
                        <?php get_search_form(); ?>
					<?php }
				fortune_pagination(); ?>
			</div>
			<?php get_sidebar();?>
		</div>
	</div>
</section>
<?php get_footer(); ?>