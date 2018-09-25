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
<body <?php body_class(); ?>>
<!-- bg-primary, bg-success, bg-warning, bg-info, bg-danger, bg-dark, bg-light -->
<nav id="site-navigation" class="navbar navbar-expand-md navbar-light sticky-top bg-success">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse">
        <a class="navbar-brand" href="#">
            <?php bloginfo('name'); ?>
        </a>
        </div>
    <div id="navbarCollapse"
    <?php
    wp_nav_menu(array(
        'menu'            => 'primary',
        'container'       => 'div',
        'container_id'    => 'navbarCollapse',
        'container_class' => 'collapse navbar-collapse',
        'menu_id'         => false,
        'menu_class'      => 'navbar-nav mr-auto',
        'depth'           => 0,
        'fallback_cb'     => 'bs4navwalker::fallback',
        'walker'          => new bs4navwalker(),
            'theme_location' => 'my-custom-menu'
    ));
    ?>
    </div>
</nav>