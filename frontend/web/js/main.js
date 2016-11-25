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

    function showMainMobileMenu() {
        $('.mobile-menu-wrap').addClass('active');
    }
    function hideMainMobileMenu() {
        $('.mobile-menu-wrap').removeClass('active');
    }

    $('.mobile-menu-btn').on('click', function() {
      showMainMobileMenu();
    });

    $('.mobile-menu-btn-backward').on('click', function() {
      $('.mobile-menu-block').removeClass('active');
      showMainMobileMenu();
    });

    // $('.mobile-nav-parent-btn').on('click', function() {
    //     var parent = $(this).parent();
    //     if ( parent.hasClass('active') ) {
    //         parent.removeClass('active');
    //     } else {
    //         $('.mobile-nav-parent').removeClass('active');
    //         $(this).parent().addClass('active');
    //     }
    // });

    $('.mobile-nav-category').on('click', function() {
        var thisTarget = $(this).data('target');
        $('.' + thisTarget).addClass('active');
         hideMainMobileMenu();
    });
    $('.close-menu-btn').on('click', function() {
      $('.mobile-menu-block').removeClass('active'); 
    });



    $('.add-review-btn').on('click', function() {
        $('.add-review-form').toggleClass('active');
        
    });
    $('.add-review-form .send').on('click', function() {
        // $('.add-review-form').removeClass('active');
        
    });

    $('.open-btn-review').on('click', function() {
        if ( $(this).hasClass('plus') ) {
            $(this).removeClass('plus');
            $('.review-item, .load-more-review').fadeIn();
        } else {
            $(this).addClass('plus');
            $('.review-item, .load-more-review').fadeOut();
        }
    });

    $('.open-btn-description').on('click', function() {
        if ( $(this).hasClass('plus') ) {
            $(this).removeClass('plus');
            $('.product-description-content').fadeIn();
        } else {
            $(this).addClass('plus');
            $('.product-description-content').fadeOut();
        }
    });
    
        


    if (!mobile && $('.product-slider').length) {
        var productDesktopSlider = $('#gallery-2').royalSlider({
            controlNavigation: 'thumbnails',
            thumbs: {
              orientation: 'vertical',
              spacing: 10,
              appendSpan: false,
              firstMargin: false,
              arrows: true,
              arrowsAutoHide: false,
              arrowLeft: $(".product-slider-prev"),
              arrowRight: $(".product-slider-next")
            },
            transitionType:'fade',
            autoScaleSlider: false,
            autoScaleSliderWidth: 355,     
            autoScaleSliderHeight: 515,
            arrowsNavAutoHide: false,
            numImagesToPreload: 5,
            arrowsNavHideOnTouch: false,
            controlsInside: false,
            loop: true,
            arrowsNav: false,
            keyboardNavEnabled: true,
            imageScaleMode: 'fit',
            imageScalePadding: 0,
            minSlideOffset: 0,
            slidesSpacing: 0,
            navigateByClick: false
        }).data('royalSlider');

        productDesktopSlider.ev.on('rsBeforeMove', function(event, type, userAction ) {
            $('.product-slider').find('video')[0].pause();
        });
        
} else if (mobile && $('.product-slider').length) {
    var productDesktopSlider = $('#gallery-2').royalSlider({
        arrowsNav: true,
        arrowsNavAutoHide: false,
        fadeinLoadedSlide: false,
        controlNavigationSpacing: 0,
        controlNavigation: 'bullets',
        loop: true,
        numImagesToPreload: 6,
        transitionType: 'slide',
        keyboardNavEnabled: true,
        autoHeight: true,
        autoScaleSlider:false,
        imageScaleMode:'none',
        imageAlignCenter: false,
        navigateByClick: false
    }).data('royalSlider');

    productDesktopSlider.ev.on('rsBeforeMove', function(event, type, userAction ) {
        $('.product-slider').find('video')[0].pause();
    });
}

    

    $('.product-right-matchHeight').matchHeight();

    $('.pcs').numeric();
    $('.pcs').on('keyup', function() {
        if ( $(this).val() == '0' ) {
            $(this).val('1');
        }
    });
    $('.pcs').on('blur', function() {
        if ( $(this).val() == '' ) {
            $(this).val('1');
        }
    });

    $('.qty-input input').numeric();
    $('.qty-input input').on('keyup', function() {
        if ( $(this).val() == '0' ) {
            $(this).val('1');
        }
    });
    $('.qty-input input').on('blur', function() {
        if ( $(this).val() == '' ) {
            $(this).val('1');
        }
    });

    $('.qty-input').on('click', 'a', function() {
        var qtyInput = $(this).siblings('input');
        if ( $(this).hasClass('qty-less') ) {
            if ( qtyInput.val() > 1 ) {
                qtyInput.val( parseInt(qtyInput.val()) - 1);
            }
        }
        if ( $(this).hasClass('qty-more') ) {
            qtyInput.val( parseInt(qtyInput.val()) + 1);
        }
    });


	
});

$(window).resize(function() {});
$(window).load(function() {});
// $().on('', function() {});