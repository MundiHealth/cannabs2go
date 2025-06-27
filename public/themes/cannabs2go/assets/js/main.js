(function ($) {
"use strict";

    // loading
    $(window).load(function() {
        $(".se-pre-con").fadeOut("slow");
    });

    // main menu
    var toggle = $('.toggle-nav');
    var toggleClose = $('.open-nav .main-menu::before');
    var dropDown = $('.main-menu nav .fa-chevron-down');

    toggle.on('click', function(event) {
        $('body').stop(true,true).addClass('open-nav');
        $('.overlay').stop(true,true).addClass('active');
        event.stopPropagation();
    });

    toggleClose.on('click', function(event) {
        $('body').stop(true,true).removeClass('open-nav');
        $('.overlay').stop(true,true).removeClass('active');
        event.stopPropagation();
    });

    dropDown.on('click', function(event) {
        $(this).next().stop(true,true).slideToggle('slow');
        event.stopPropagation();
    });

    $('html').on('click', function(){
        $('body').removeClass('open-nav');
        $('.overlay').stop(true,true).removeClass('active');
        dropDown.next().slideUp();
    });

    // sticky
    var wind = $(window);
    var sticky = $('#sticky-header');
    wind.on('scroll', function () {
        var scroll = wind.scrollTop();
        if (scroll < 100) {
            sticky.removeClass('sticky');
        } else {
            sticky.addClass('sticky');
        }
    });

    // main slider
    function mainSlider() {
        var BasicSlider = $('.slider-active');
        BasicSlider.on('init', function(e, slick) {
            var $firstAnimatingElements = $('.single-slider:first-child').find('[data-animation]');
            doAnimations($firstAnimatingElements);
        });
        BasicSlider.on('beforeChange', function(e, slick, currentSlide, nextSlide) {
            var $animatingElements = $('.single-slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
            doAnimations($animatingElements);
        });
        BasicSlider.slick({
            autoplay: false,
            autoplaySpeed: 10000,
            dots: false,
            fade: true,
            arrows:true,
            prevArrow: '<button type="button" class="slick-prev"> <i class="fas fa-angle-left"></i> </button>',
            nextArrow: '<button type="button" class="slick-next"> <i class="fas fa-angle-right"></i></button>',
            responsive: [
                { breakpoint: 767, settings: { dots: false, arrows: false } }
            ]
        });

        function doAnimations(elements) {
            var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            elements.each(function() {
                var $this = $(this);
                var $animationDelay = $this.data('delay');
                var $animationType = 'animated ' + $this.data('animation');
                $this.css({
                    'animation-delay': $animationDelay,
                    '-webkit-animation-delay': $animationDelay
                });
                $this.addClass($animationType).one(animationEndEvents, function() {
                    $this.removeClass($animationType);
                });
            });
        }
    } mainSlider();

    // scroll to top
    $(document).ready(function($){
        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
            //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
            offset_opacity = 1200,
            //duration of the top scrolling animation (in ms)
            scroll_top_duration = 700,
            //grab the "back to top" link
            $back_to_top = $('.back-top');

        //hide or show the "back to top" link
        $(window).scroll(function(){
            ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('is-visible') : $back_to_top.removeClass('is-visible fade-out');
            if( $(this).scrollTop() > offset_opacity ) {
                $back_to_top.addClass('fade-out');
            }
        });

        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                    scrollTop: 0 ,
                }, scroll_top_duration
            );
        });
    });

    // WOW active
    new WOW().init();

})(jQuery);