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
            // arrowsNav: false,
            keyboardNavEnabled: true,
            imageScaleMode: 'fit',
            imageScalePadding: 0,
            minSlideOffset: 0,
            slidesSpacing: 0,
            navigateByClick: false
        }).data('royalSlider');



      if ( $('.product-slider').find('video').length ) {
        productDesktopSlider.ev.on('rsBeforeMove', function(event, type, userAction ) {
            $('.product-slider').find('video')[0].pause();
        });
      }
      
        
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

    if ( $('.product-slider').find('video').length ) {
        productDesktopSlider.ev.on('rsBeforeMove', function(event, type, userAction ) {
            $('.product-slider').find('video')[0].pause();
        });
      }
}

    
    $('.product-right-matchHeight').matchHeight();

    // $('.pcs').numeric();
    // $('.pcs').on('keyup', function() {
    //     if ( $(this).val() == '0' ) {
    //         $(this).val('1');
    //     }
    // });
    // $('.pcs').on('blur', function() {
    //     if ( $(this).val() == '' ) {
    //         $(this).val('1');
    //     }
    // });

    $('.qty-input input').numeric();
    $('.qty-input input').on('keyup', function() {
        if ( $(this).val() <= '0' ) {
            $(this).val('1');
            $(this).parent().find('.qty-less').addClass('disabled');
        }
    });
    $('.qty-input input').on('blur', function() {
        if ( $(this).val() == '' ) {
            $(this).val('1');
            $(this).parent().find('.qty-less').addClass('disabled');
        }
    });

    $('.qty-input').each(function() {
        var inputValue = $(this).find('input').val();
        if ( inputValue == 1 ) {
            $(this).find('.qty-less').addClass('disabled');
        }
    });

    $('.qty-input').on('click', '.qty-less', function() {
        var qtyInput = $(this).siblings('input'),
            qtyLess = $(this).parent().find('.qty-less');
            console.log(qtyLess);
        if ( qtyInput.val() > 1 ) {
            if ( qtyInput.val() == 2 ) {
                qtyLess.addClass('disabled');
            }
            qtyInput.val( parseInt(qtyInput.val()) - 1);
        }

    });

    $('.qty-input').on('click', '.qty-more', function() {
        var qtyInput = $(this).siblings('input'),
            qtyLess = $(this).parent().find('.qty-less');
        qtyInput.val( parseInt(qtyInput.val()) + 1);
        qtyLess.removeClass('disabled');
    });

    // $('.qty-input').on('click', 'a', function() {
    //     var qtyInput = $(this).siblings('input');
    //     if ( $(this).hasClass('qty-less') ) {
    //         if ( qtyInput.val() > 1 ) {
    //             qtyInput.val( parseInt(qtyInput.val()) - 1);
    //         }
    //     }
    //     if ( $(this).hasClass('qty-more') ) {
    //         qtyInput.val( parseInt(qtyInput.val()) + 1);
    //     }
    // });

    
    

    $('.enter-code').on('click', function() {
        $('.promo-form').toggleClass('active');
        $('.enter-code span').toggleClass('active');        
    });

    $('.cart-checkout').colorbox({
      inline: true,
      href: '.cart-checkout-wrap',
      transition: 'none',
      maxWidth: '95%',
      maxHeight: '95%',
      onComplete: function() {
        $.colorbox.resize();
        }

    });

    $('.dropdown-cart-checkout').colorbox({
      inline: true,
      href: '.cart-checkout-wrap',
      transition: 'none',
      maxWidth: '95%',
      maxHeight: '95%',
      onComplete: function() {
        $.colorbox.resize();
        }

    });

    $('.toinform').colorbox({
      inline: true,
      href: '.toinform-wrap',
      transition: 'none',
      maxWidth: '95%',
      maxHeight: '95%',
      onComplete: function() {
        $.colorbox.resize();
        }

    });

    $('.filter-scrollable').mCustomScrollbar({
        theme: 'inset-2-dark'
    });

    $('.selectmenu select').selectmenu();

    formatSidebarPrice();
    $('.price-range-slider').slider({
        create: function(event, ui) {
            var self = $(this),
                dataValues = self.data('values').split(',');
            self.slider('option', {
              range: true,
              min: 0,
              max: self.data('max'),
              values: dataValues
            });
        },
        slide: function( event, ui ) {
            $('#sidebar-price-from').val(ui.values[ 0 ]);
            $('#sidebar-price-to').val(ui.values[ 1 ]);
            formatSidebarPrice();
        }
    });

    $('body').on('keyup', '#sidebar-price-from', function() {
           var self = $(this),
               value = self.val(),
               price = numeral(value);
           self.val(price.format('0,0'));
           $('.price-range-slider').slider('values', 0, numeral().unformat( price.value() ) );
       });
       $('body').on('keyup', '#sidebar-price-to', function() {
           var self = $(this),
               value = self.val(),
               price = numeral(value);
           self.val(price.format('0,0'));
           $('.price-range-slider').slider('values', 1, numeral().unformat( price.value() ) );
       });

       $('.filter-mobile-dropdown').on('click', function() {
        $('.filter').toggleClass('active');
        
    });



    //   $('.send').colorbox({
    //   inline: true,
    //   href: '.popup-message-sent-form',
    //   transition: 'none',
    //   maxWidth: '95%',
    //   maxHeight: '95%'
      

    // });
   

  //   $('.price-range-slider').slider({
  //     create: function( event, ui ) {
  //       var self = $(this),
  //           dataValues = self.data('values').split(',');
  //       self.slider('option', {
  //         range: self.data('range'),
  //         min: self.data('min'),
  //         max: self.data('max'),
  //         values: dataValues
  //       });
  //       self.find('.ui-slider-handle').first().html('<i class="first-handle-value">' + dataValues[0] + '</i>');
  //       self.find('.ui-slider-handle').last().html('<i class="last-handle-value">' + dataValues[1] + '</i>');
  //     },
  //     slide: function( event, ui ) {
  //       $(this).find('.first-handle-value').text(ui.values[0]);
  //       $(this).find('.last-handle-value').text(ui.values[1]);
  //     }
  // });

	
});

function notify(message) {
    $('.popup-notify').find('.message-wrap').text(message);
    $.colorbox({
      inline: true,
      href: '.popup-notify',      
      transition: 'none',
      onComplete: setTimeout(function() {$.colorbox.resize(); $.colorbox.resize();}, 100)
    });
}

function formatSidebarPrice() {
    var priceFrom = $('#sidebar-price-from'),
        priceTo = $('#sidebar-price-to');
    priceFrom.val( numeral(priceFrom.val()).format('0,0') );
    priceTo.val( numeral(priceTo.val()).format('0,0') );
}

$(window).resize(function() {});
$(window).load(function() {});
// $().on('', function() {});