$(window).scroll(function(){
    if ($(this).scrollTop()<300) {
        $('.header-effect').fadeOut();
    }else {
        $('.header-effect').fadeIn();
    }
});