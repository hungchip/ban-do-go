$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    var top = 300;
    $(window).scroll(function() {
        var y = $(this).scrollTop();
        if (y > top) {
            $("a.btn-top").css({
                'opacity': '1',
                'visibility': 'visible'
            });
        } else {
            $("a.btn-top").css({
                'opacity': '0',
                'visibility': 'hidden'
            });
        }
    });
    $('a.btn-top').click(function() {
        $('body, html').animate({
            scrollTop: '0'
        }, 700);
        return false
    });
});