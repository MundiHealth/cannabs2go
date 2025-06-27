// loading
$(window).load(function() {
    $(".se-pre-con").fadeOut("slow");

    // main menu
    $('.toggle-nav').on('click', function(event) {
        $('body').stop(true,true).addClass('open-nav');
        $('.overlay').stop(true,true).addClass('active');
        event.stopPropagation();
    });

    $('.open-nav .main-menu::before').on('click', function(event) {
        $('body').stop(true,true).removeClass('open-nav');
        $('.overlay').stop(true,true).removeClass('active');
        event.stopPropagation();
    });

    $('.main-menu nav .fa-chevron-down').on('click', function(event) {
        $(this).next().stop(true,true).slideToggle('slow');
        event.stopPropagation();
    });

    $('.search-icon').on('click', function(event) {
        $('.search-open').stop(true,true).slideToggle('slow');
        event.stopPropagation();
    });

    $('.search-open .fa-times').on('click', function(event) {
        $('.search-open').stop(true,true).slideUp('slow');
        event.stopPropagation();
    });

    $('html').on('click', function(){
        $('body').removeClass('open-nav');
        $('.overlay').stop(true,true).removeClass('active');
        $('.main-menu nav .fa-chevron-down').next().slideUp();
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

    // scroll to top
    $(document).ready(function(){
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

        $('#show_password').click(function(e) {
            e.preventDefault();
            if ( $('#password').attr('type') == 'password' ) {
                $('#password').attr('type', 'text');
                $('#show_password').attr('class', 'fa fa-eye');
            } else {
                $('#password').attr('type', 'password');
                $('#show_password').attr('class', 'fa fa-eye-slash');
            }
        });
    });

    // WOW active
    window.wow.init();
});