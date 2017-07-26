$(".hero-slider").lightSlider({
        item: 1,
        slideMove:1,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed: 600,
        pager: false,
        enableDrag: false,
        auto: true,
        pause: 5000,
        loop: true,
        slideMargin: 0,
        controls: false,
    });

$('.menu-tab').on('click', function() {
    $('.mobile-menu').toggleClass('show');
});

$('.filter-tab').on('click', function() {
    $(this).toggleClass('active');
    $('.filter-menu').toggleClass('active');
});
