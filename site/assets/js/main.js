//
// Main App
// scripts gerais
// --------------------------------------------------

$(window).load(function() {
	// loading
	$(".se-pre-con").fadeOut("slow");

	// menu mobile
    $('.toggle-nav').on('click', function(event) {
		$('body').stop(true,true).addClass('open-nav');
		$('.overlay').stop(true,true).addClass('active');
		event.stopPropagation();
	});

	$('html').on('click', function(){
        $('body').removeClass('open-nav');
        $('.overlay').stop(true,true).removeClass('active');
    });

	// fixed header
	var header = $(".header").height();

	$(window).scroll(function() {
		if ($(this).scrollTop() > header){  
			$('.header').addClass("fixed");
		} else{
			$('.header').removeClass("fixed");
		}
	});
})