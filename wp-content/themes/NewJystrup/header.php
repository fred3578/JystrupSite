<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php wp_head(); ?>
</head>

<!-- image size of 1151x250-->
<img src="img/DSC_0018hej.jpg" class="img-fluid" alt="Responsive image">

<body class <?php body_class(); ?>>
<!-- bg-primary, bg-success, bg-warning, bg-info, bg-danger, bg-dark, bg-light -->
<nav id="site-navigation" class="navbar navbar-expand-md sticky-top">

    <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>



    <div class="collapse navbar-collapse">
        <a class="navbar-brand" href="http://localhost/JystrupSite/">
           <!-- <?php bloginfo('name'); ?> -->
        </a>
    </div>

    <?php
    $WP_Array = wp_nav_menu( array(
    'menu'            => 'primary',
    'container'       => 'div',
    'container_id'    => 'navbarCollapse',
    'container_class' => 'collapse navbar-collapse',
    'menu_id'         => false,
    'menu_class'      => 'navbar-nav mr-auto',
    'depth'           => 0,
    'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
    'walker'          => new wp_bootstrap_navwalker(),
        'theme_location' => 'my-custom-menu'
    ));
    ?>

    <div id="navbarCollapse" class="table-responsive{-sm|-md|-lg|-xl}" <?php $WP_Array ?>></div>

</nav>