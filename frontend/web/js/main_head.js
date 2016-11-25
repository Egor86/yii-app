jQuery(document).ready(function($) {

    var mobile = window.matchMedia('(max-width: 767px)').matches;

	
	$('.phone-select-icon').on('click', function() {
        var thisParent = $(this).parents('.phone-select-parent');
        if (thisParent.hasClass('active')) {
            $('.header-dropdown-parent').removeClass('active');
        } else {
            $('.header-dropdown-parent').removeClass('active');
            thisParent.addClass('active');
        }
    });

    $('.callback-btn').on('click', function() {
        var thisParent = $(this).parents('.callback-parent');
        if (thisParent.hasClass('active')) {
            $('.header-dropdown-parent').removeClass('active');
        } else {
            $('.header-dropdown-parent').removeClass('active');
            thisParent.addClass('active');
        }
    });

    $('.add-to-cart-btn').on('click', function() {
        var thisParent = $(this).parents('.add-to-cart-parent');
        if (thisParent.hasClass('active')) {
            $('.header-dropdown-parent').removeClass('active');
        } else {
            $('.header-dropdown-parent').removeClass('active');
            thisParent.addClass('active');
        }
    });

    $('.catalog-icon').on('click', function() {
        $('.dropdown-catalog').toggleClass('active');
        $('.catalog-parent').toggleClass('active');
        
    });

    $('.delivery-icon').on('click', function() {
        $('.dropdown-delivery').toggleClass('active');
        $('.delivery-parent').toggleClass('active');
        
    });

    $('.about-brend').on('click', function() {
        var scrollTarget = $(this).data('id'),
            scrollCoord = $('#' + scrollTarget).offset().top;
        $('html, body').animate({
          scrollTop: scrollCoord 
        }, 500);
      });

    $('#products-slider').owlCarousel({
        itemsCustom: [[0, 1], [768, 4]],
        navigation: true,
        scrollPerPage: true
    });

    if (mobile) {
        $('.section-top-slider-wrap').owlCarousel({
            itemsCustom: [[0, 1], [480, 2]],
            navigation: true,
            scrollPerPage: true 
        });
    }

    $('.mobile-menu-btn').on('click', function() {
      $('.mobile-menu-wrap').addClass('active'); 
    });

    $('.close-menu-btn').on('click', function() {
      $('.mobile-menu-wrap').removeClass('active'); 
    });

    $('.mobile-menu-btn-backward').on('click', function() {
      $('.mobile-menu-wrap').removeClass('active'); 
    });

    $('.mobile-nav-parent-btn').on('click', function() {
        var parent = $(this).parent();
        if ( parent.hasClass('active') ) {
            parent.removeClass('active');
        } else {
            $('.mobile-nav-parent').removeClass('active');
            $(this).parent().addClass('active');
        }
    });



	
});

$(window).resize(function() {});
$(window).load(function() {});
// $().on('', function() {});