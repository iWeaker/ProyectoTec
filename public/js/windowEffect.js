$( window ).scroll(function() {
    if ($(this).scrollTop()<100) {
        $('.header-effect').fadeOut();
    }else {
        $('.header-effect').fadeIn();
    }
});