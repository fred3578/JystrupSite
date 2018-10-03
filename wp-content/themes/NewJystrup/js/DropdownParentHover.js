jQuery(function($) {
    // Bootstrap menu magic
    $(window).resize(function() {
      if ($(window).width() < 768) {
        $(".navbar-toggler").attr('collapse', 'navbarCollapse');
      } else {
        $(".navbar-toggler").removeAttr('collapse navbarCollapse');
      }
    });
  });