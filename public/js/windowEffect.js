$( window ).scroll(function() {
    if ($(this).scrollTop()<70) {
        $("header > div" ).css({
            background: "none",

        });

        $(".color_white > a").css({
            color:"#ff0081",
        })
        $(".color_white").css({
            background: "white",
        })
    } else {
        $("header > div" ).css({
            background: "rgba(255,255,255,0.5)",
        });
        $(".color_white > a").css({
            color:"white",
        })
        $(".color_white").css({
            background: "#ff0081",
        })
    }
});