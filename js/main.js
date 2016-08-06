;(function () {
	
	'use strict';



	// iPad and iPod detection	
	var isiPad = function(){
		return (navigator.platform.indexOf("iPad") != -1);
	};

	var isiPhone = function(){
	    return (
			(navigator.platform.indexOf("iPhone") != -1) || 
			(navigator.platform.indexOf("iPod") != -1)
	    );
	};

	// Main Menu Superfish
	var mainMenu = function() {

		$('#fh5co-primary-menu').superfish({
			delay: 0,
			animation: {
				opacity: 'show'
			},
			speed: 'fast',
			cssArrows: true,
			disableHI: true
		});

	};

	// Parallax
	var parallax = function() {
		$(window).stellar();
	};


	// Offcanvas and cloning of the main menu
	var offcanvas = function() {

		var $clone = $('#fh5co-menu-wrap').clone();
		$clone.attr({
			'id' : 'offcanvas-menu'
		});
		$clone.find('> ul').attr({
			'class' : '',
			'id' : ''
		});

		$('#fh5co-page').prepend($clone);

		// click the burger
		$('.js-fh5co-nav-toggle').on('click', function(){

			if ( $('body').hasClass('fh5co-offcanvas') ) {
				$('body').removeClass('fh5co-offcanvas');
			} else {
				$('body').addClass('fh5co-offcanvas');
			}
			// $('body').toggleClass('fh5co-offcanvas');

		});

		$('#offcanvas-menu').css('height', $(window).height());

		$(window).resize(function(){
			var w = $(window);


			$('#offcanvas-menu').css('height', w.height());

			if ( w.width() > 769 ) {
				if ( $('body').hasClass('fh5co-offcanvas') ) {
					$('body').removeClass('fh5co-offcanvas');
				}
			}

		});	

	}

	

	// Click outside of the Mobile Menu
	var mobileMenuOutsideClick = function() {
		$(document).click(function (e) {
	    var container = $("#offcanvas-menu, .js-fh5co-nav-toggle");
	    if (!container.is(e.target) && container.has(e.target).length === 0) {
	      if ( $('body').hasClass('fh5co-offcanvas') ) {
				$('body').removeClass('fh5co-offcanvas');
			}
	    }
		});
	};


	// Animations

	var contentWayPoint = function() {
		var i = 0;
		$('.animate-box').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .animate-box.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							el.addClass('fadeInUp animated');
							el.removeClass('item-animate');
						},  k * 200, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '85%' } );
	};
	

	// Document on load.
	$(function(){
		mainMenu();
		parallax();
		offcanvas();
		mobileMenuOutsideClick();
		contentWayPoint();
		

	});


}());

// Newsletter forma

jQuery(document).ready(function($){
	var messages = $('div[data-type="message"]');
	//check if user updates the email field
	$('.cd-form .cd-email').keyup(function(event){	
		//check if user has pressed the enter button (event.which == 13)
		if(event.which!= 13) {
			//if not..
			//hide messages and loading bar 
			messages.removeClass('slide-in is-visible');
			$('.cd-form').removeClass('is-submitted').find('.cd-loading').off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
		}

		var emailInput = $(this),
			insertedEmail = emailInput.val(),
			atPosition = insertedEmail.indexOf("@");
	    	dotPosition = insertedEmail.lastIndexOf(".");
	    //check if user has inserted a "@" and a dot
	    if (atPosition< 1 || dotPosition<atPosition+2 ) {
	    	//if he hasn't..
	    	//hide the submit button
	    	$('.cd-form').removeClass('is-active').find('.cd-loading').off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
	    } else {
	    	//if he has..
	    	//show the submit button
	    	$('.cd-form').addClass('is-active');
	    }
	});

	//backspace doesn't fire the keyup event in android mobile
	//so we check if the email input is focused to hide messages and loading bar 
	$('.cd-form .cd-email').on('focus', function(){
		messages.removeClass('slide-in is-visible');
		$('.cd-form').removeClass('is-submitted').find('.cd-loading').off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
	});	

	//you should replace this part with your ajax function
	$('.cd-submit').on('click', function(event){
		if($('.cd-form').hasClass('is-active')) {
			event.preventDefault();
			//show the loading bar and the corrisponding message
			$('.cd-form').addClass('is-submitted').find('.cd-loading').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
				showMessage();
			});

			//if transitions are not supported - show messages
			if($('html').hasClass('no-csstransitions')) {
				showMessage();
			}
		}
	});

	function showMessage() {
		if( $('#cd-success').is(':checked') ) {
			$('.cd-response-success').addClass('slide-in');
		} else if ( $('#cd-error').is(':checked') ) {
			$('.cd-response-error').addClass('is-visible');
		} else {
			$('.cd-response-notification').addClass('is-visible');
		}
	}

	//placeholder fallback (i.e. IE9)
	//credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
	if(!Modernizr.input.placeholder){
		$('[placeholder]').focus(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
		  	}
		}).blur(function() {
		 	var input = $(this);
		  	if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.val(input.attr('placeholder'));
		  	}
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
		  	$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
			 		input.val('');
				}
		  	})
		});
	}
});


(function ($) {
   $('.btn-default').on('click', function (e) {
      e.preventDefault();
      var obj = $(this);

      obj.addClass('active');

      setTimeout(function () {
         obj.removeClass('active');
      }, 1500);

      // Više partnera
      if (obj.hasClass('btn-load-partneri')) {
         if (!$('.load-partneri-box').hasClass('open')) {
            $('.load-partneri-box').slideToggle(1000);
            setTimeout (function () {
               $('.load-partneri-box').addClass('open');
            }, 700);
         }
      }

      // Load nagradnih igara
      if (obj.hasClass('btn-load-nagradna-igra')) {
         if (!$('.load-nagrade-box').hasClass('open')) {
            $('.load-nagrade-box').slideToggle(1000);
            setTimeout (function () {
               $('.load-nagrade-box').addClass('open');
            }, 700);
         }
      }
   });

   // Fade In Page
   $(document).ready(function () {
      setTimeout(function () {
         $('body').addClass('dom-ready');
      }, 300);
   });
})(jQuery);


//opsirnije za emisije
$(document).ready(function(){
    $('.program a').on('click',function(){
        var aID = $(this).attr('href');
        var elem = $(''+aID).html();
        
        $('.target').html(elem);
    });
});