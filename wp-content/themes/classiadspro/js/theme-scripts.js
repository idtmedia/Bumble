/**
*
*   Classiadspro since v1
*
*/

(function () {
	'use strict';

	// Root namespace: classiadspro
	// Init in header.php

	// Object to hold our modules
	classiadspro.modules = {};

	// We need function wrappers to trigger our modules on demand.
	// This is best way until we refactor whole codebase into modules so we could remove wrappers and move to AMD loading.
	// Some of modules are mendatory, some will be triggered with if(true) based on JSON collection and dependency map.
	// We don't need DOM ready as we include scripts in footer where DOM is ready already. Bind to onload with reason.

	// IMPORTANT TODO - try to handle modules with ES6 module import / export polyfilled with google traceur
	Utils();
	Polyfills();
	ModuleHeader();


	// Polyfill older browsers
	classiadspro.utils.polyfills.initAll(); 

})();

;function ModuleHeader() {
	// Dependency CLASSIADSPRO modules:
	// classiadspro.utils

	// Dependency JSON->DOM modules
	// 'theme_header',
	// 'pacz_header'

	// Dependency libraries
	// jQuery

	(function ($) {
		'use strict';

		classiadspro.modules.header = (function() {

			var Public = {
	            calcHeight: calcHeight
	        };


	        var $window = $(window);

			//
	        // calcHeight() method
	        //

	        var header = classiadspro.utils.JSONLookup('theme_header'),
	            vcHeader = classiadspro.utils.JSONLookup('pacz_header'),
	            adminbar = 0,
	            totalHeight = 0;

	        function calcHeight() {
	            if(php.hasAdminbar) {
	                if($window.width() > 782) {
	                    adminbar = 32;   
	                } else {
	                    adminbar = 46;
	                }
	            }

	            totalHeight = 
	                adminbar + 
	                (header[0] != undefined ? header[0].params.stickyHeight : 0) +
	                (vcHeader[0] != undefined ? vcHeader[0].params.stickyHeight : 0);

	            return Math.round(totalHeight);
	        }        

	        return Public;

		})();
	})(jQuery); 
}
;function Utils() {
    // Dependency CLASSIADSPRO modules:

    // Dependency PHP modules:
    // php.json

    // Dependency JSON->DOM modules
    // Try not to keep them here.

    (function () {
        classiadspro.utils = (function () {
            'use strict';

            var Public = {
                JSONLookup: JSONLookup
            };

            //
            // JSONLookup() method
            // Searches through our global JSON collection by element name
            // returns array of objects matched by name
            //

            function JSONLookup(name) {
                var params = [];
                for(var i = 0, jsonLength = php.json.length; i < jsonLength; i++) {
                  if(php.json[i].name == name) {
                    params.push(php.json[i]);
                  } 
                }
                return params;
            }

            return Public;

        })();
    })();
};function Polyfills() {

	(function () {
		'use strict';

		classiadspro.utils.polyfills = (function () {

			var Public = {
				bindPolyfill: bindPolyfill,
				rAFPolyfill: rAFPolyfill,
				initAll: function() {
					bindPolyfill();
					rAFPolyfill();
				}
			}

			function bindPolyfill() {
				if (!Function.prototype.bind) {
				  Function.prototype.bind = function(oThis) {
				    if (typeof this !== 'function') {
				      // closest thing possible to the ECMAScript 5
				      // internal IsCallable function
				      throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
				    }

				    var aArgs   = Array.prototype.slice.call(arguments, 1),
				        fToBind = this,
				        fNOP    = function() {},
				        fBound  = function() {
				          return fToBind.apply(this instanceof fNOP && oThis
				                 ? this
				                 : oThis,
				                 aArgs.concat(Array.prototype.slice.call(arguments)));
				        };

				    fNOP.prototype = this.prototype;
				    fBound.prototype = new fNOP();

				    return fBound;
				  };
				}
			}

			function rAFPolyfill() {
			    var lastTime, vendors, x;
			    lastTime = 0;
			    vendors = ["webkit", "moz"];
			    x = 0;
			    while (x < vendors.length && !window.requestAnimationFrame) {
			      window.requestAnimationFrame = window[vendors[x] + "RequestAnimationFrame"];
			      window.cancelAnimationFrame = window[vendors[x] + "CancelAnimationFrame"] || window[vendors[x] + "CancelRequestAnimationFrame"];
			      ++x;
			    }
			    if (!window.requestAnimationFrame) {
			      window.requestAnimationFrame = function(callback, element) {
			        var currTime, id, timeToCall;
			        currTime = new Date().getTime();
			        timeToCall = Math.max(0, 16 - (currTime - lastTime));
			        id = window.setTimeout(function() {
			          callback(currTime + timeToCall);
			        }, timeToCall);
			        lastTime = currTime + timeToCall;
			        return id;
			      };
			    }
			    if (!window.cancelAnimationFrame) {
			      window.cancelAnimationFrame = function(id) {
			        clearTimeout(id);
			      };
			    }
			};

			return Public;

		})();
	})();

};var abb = {};

function is_touch_device() {
    return !!('ontouchstart' in window) || !!('onmsgesturechange' in window);
}
jQuery.exists = function(selector) {
    return (jQuery(selector).length > 0);
};

jQuery.fn.hasAttr = function(name) {
    return this.attr(name) !== undefined;
};


var BrowserDetect = {
        init: function () {
            this.browser = this.searchString(this.dataBrowser) || "Other";
            this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
        },
        searchString: function (data) {
            for (var i = 0; i < data.length; i++) {
                var dataString = data[i].string;
                this.versionSearchString = data[i].subString;

                if (dataString.indexOf(data[i].subString) !== -1) {
                    return data[i].identity;
                }
            }
        },
        searchVersion: function (dataString) {
            var index = dataString.indexOf(this.versionSearchString);
            if (index === -1) {
                return;
            }

            var rv = dataString.indexOf("rv:");
            if (this.versionSearchString === "Trident" && rv !== -1) {
                return parseFloat(dataString.substring(rv + 3));
            } else {
                return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
            }
        },

        dataBrowser: [
            {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
            {string: navigator.userAgent, subString: "MSIE", identity: "IE"},
            {string: navigator.userAgent, subString: "Trident", identity: "IE"},
            {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
            {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
            {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
        ]
};

BrowserDetect.init();
jQuery('html').addClass(BrowserDetect.browser).addClass(BrowserDetect.browser + BrowserDetect.version);


(function($) {

    "use strict";

/* Gets IE version */
/* -------------------------------------------------------------------- */

function pacz_detect_ie() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf('MSIE ');
    var trident = ua.indexOf('Trident/');
    if (msie > 0) {
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }
    if (trident > 0) {
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }
    return false;
}

// abb.header = function() {
//     var Public = {
//         height: height
//     };

//     var $window = $(window);

//     //
//     // height() method
//     //

//     var headerHeight = $('#pacz-header').height(),
//         adminbar = 0,
//         totalHeight = 0;

//     function height() {
//         if(php.hasAdminbar) {
//             if($window.width() > 782) {
//                 adminbar = 32;   
//             } else {
//                 adminbar = 46;
//             }
//         }

//         totalHeight = 
//             adminbar + 
//             headerHeight;

//         return Math.round(totalHeight);

//         conso
//     }        

//     return Public;
// };

//////////////////////////////////////////////////////////////////////////
//
//   Defining global utils and variables for cross app use
//   todo: move vars to utils
//
//////////////////////////////////////////////////////////////////////////

 


var scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop, // Updated in global event handler
    global_window_width = $(window).width(),
    global_window_height = $(window).height(),
    global_admin_bar,
    global_admin_bar_height = 0;


$(window).load(function() {
    if ($.exists("#wpadminbar")) {
        global_admin_bar = $("#wpadminbar");
    } 
});

if(php.hasAdminbar) {
    if($(window).width() > 782) {
        global_admin_bar_height = 32;   
    } else {
        global_admin_bar_height = 46;
    }
}
        
function pacz_update_globals() {
    global_window_width = $(window).width();
    global_window_height = $(window).height();
}

window.scroll = function() {
        scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
}

abb.fullHeight = function() {
    var $header = $('#pacz-header'),
        windowHeight = $(window).height(),
        adminbar = global_admin_bar_height,
        totalHeight;

        var headerHeight = 0;
        if($header) headerHeight = $header.data('height');
        if($header.hasClass('transparent-header')) headerHeight = 0;
        if($header.hasClass('sticky-trigger-header')) headerHeight = $header.data('sticky-height');
        if($header.hasClass('header-structure-vertical')) headerHeight = 0;

        totalHeight = windowHeight - (adminbar + headerHeight);

        return totalHeight;
}

abb.smoothScrollTo = function(offsetTop, duration) {
    $('html, body').stop().animate({
      scrollTop: offsetTop
    }, {
      duration: duration,
      easing: "easeInOutExpo"
    });
};

//////////////////////////////////////////////////////////////////////////
//
//   Global scroll handler
//
//////////////////////////////////////////////////////////////////////////


var animationThrottle = function(toThrottle, wait) {
    var lastTick = Date.now(),
        endTimeout = null;
    
    return function run() {
        if(Date.now() - lastTick > wait) {
            lastTick = Date.now();
            clearTimeout(endTimeout);
            window.requestAnimationFrame(toThrottle);
        }
        else {
            clearTimeout(endTimeout);
            endTimeout = setTimeout(run, wait);
        }
    };
};


var scrollAnimations = {
    sets: [],

    init: function() {
        this.update();
        this.attachEvents();
        // console.table(this.sets);
    },

    attachEvents: function() {
        window.addEventListener('scroll', animationThrottle(
            this.play.bind(this), 0
        ));
    },

    add: function(handler) {
        this.sets.push(handler);
    },

    play: function() {
        this.update();
        this.sets.forEach( function(animationSet) {
            animationSet(scrollY);
        }.bind(this));
    },

    update: function() {
        scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
    },

};
scrollAnimations.init();


var debouncedScrollAnimations = {
    sets: [],

    init: function() {
        this.attachEvents();
    },

    attachEvents: function() {
        window.addEventListener('scroll', animationThrottle(
            this.play.bind(this), 200
        ));
    },

    add: function(handler) {
        this.sets.push(handler);
    },

    play: function() {
        this.sets.forEach( function(animationSet) {
            animationSet(scrollY);
        }.bind(this));
    },
};
debouncedScrollAnimations.init();



/* Logo placement */
/* -------------------------------------------------------------------- */

function pacz_logo_middle() {
    if($.exists('#pacz-header.theme-main-header.header-align-center')) {
    var $menu = $('.theme-main-header .main-navigation-ul'),
        menuItems = $menu.find('> .menu-item'),
        $logo = $menu.find('.pacz-header-logo'),
        menuWidthLeftFloor = 0,
        menuWidthLeftCeil = 0,
        menuWidthRightFloor = 0,
        menuWidthRightCeil = 0,
        halfFloor = Math.floor(menuItems.length/2),
        halfCeil = Math.ceil(menuItems.length/2);

    // Left widths 
    for (var i = 0; i < halfFloor; i++) {
        menuWidthLeftFloor += $(menuItems[i]).width();
    }
    for (var i = 0; i < halfCeil; i++) {
        menuWidthLeftCeil += $(menuItems[i]).width();
    }

    // Right wdths 
    for (var i = halfFloor-1; i < menuItems.length; i++) {
        menuWidthRightFloor += $(menuItems[i]).width();
    }
    for (var i = halfCeil-1; i < menuItems.length; i++) {
        menuWidthRightCeil += $(menuItems[i]).width();
    }

    if( menuWidthLeftCeil >= menuWidthRightCeil) {
        $logo.clone().addClass('pacz-header-logo-center').insertAfter(menuItems[halfCeil-1]);
        $logo.remove();
    } else {
        $logo.clone().addClass('pacz-header-logo-center').insertAfter(menuItems[halfFloor-1]);
        $logo.remove();
    }
}
}
pacz_logo_middle();

/* Marge double menu */
/* -------------------------------------------------------------------- */

function pacz_double_menu() {
  "use strict";

  var $header_1 = $('.theme-main-header'),
      $header_2 = $('#theme-page .vc_row').first().find('.pacz-secondary-header'),
      $stickyPadding = $('.sticky-header-padding');

  if($header_1.length && $header_2.length) {
    // Merge headers if placed one under the other
    $header_1.append($header_2);
    $header_2.removeClass('sticky-header');

    // Get heights values
    var header_1_height = $header_1.data('height'),
        header_1_sticky_height = $header_1.data('sticky-height'),
        header_2_height = $header_2.height(),
        header_2_sticky_height = $header_2.data('sticky-height'),
        stickyPaddingVal = parseInt($stickyPadding.css('padding-top').replace('px', ''));

        // Lets check what we have
        // console.log('header_1_height: ' + header_1_height);
        // console.log('header_1_sticky_height: ' + header_1_sticky_height);
        // console.log('header_2_height: ' + header_2_height);
        // console.log('header_2_sticky_height: ' + header_2_sticky_height);
        // console.log('stickyPaddingVal: ' + stickyPaddingVal);

    // Update height values of marged header
    $header_1.attr('data-height', (header_1_height + header_2_height));
    $header_1.attr('data-sticky-height', (header_1_sticky_height + header_2_sticky_height));

    // Update top padding 
    $stickyPadding.css({
        'padding-top': (stickyPaddingVal + header_2_height) + 'px'
    });
  }
}
pacz_double_menu();


/* Page Title Intro */
/* -------------------------------------------------------------------- */

function pacz_page_title_intro() {

    "use strict";

    if (!is_touch_device()) {
        $('#pacz-page-title').each(function() {
            var progressVal,
                currentPoint,
                $this = $(this),
                parentHeight = $this.outerHeight(),
                $fullHeight = $this.attr('data-fullHeight'),
                startPoint = 0,
                endPoint = $this.offset().top + parentHeight,
                effectLayer = $this.find('.pacz-page-title-bg'),
                gradientLayer = $this.find('.pacz-effect-gradient-layer'),
                animation = $this.attr('data-intro');

            var layout = function() {
                var $heading = $this.find('.pacz-page-heading'),
                    $fullHeight = $this.attr('data-fullHeight'),
                    $header_height = 0,
                    $height = $this.attr('data-height'),
                    page_title_full_height = 0;

                if ($.exists('#pacz-header.sticky-header') && !$('#pacz-header').hasClass('transparent-header')) {
                    var $header_height = parseInt($('#pacz-header.sticky-header').attr('data-sticky-height'));
                }

                if ($fullHeight === 'true') {
                    page_title_full_height = global_window_height - $header_height - global_admin_bar_height;
                } 
                else {
                    page_title_full_height = $height;
                }

                $this.css('height', page_title_full_height);

                if ($('#pacz-header').hasClass('transparent-header') && $fullHeight == 'true') {
                    var header_height = parseInt($('#pacz-header').attr('data-height'));
                    var padding = parseInt($this.css('padding-top'));
                    $this.css({ 
                        'padding' : 0
                    });
                    $heading.css({
                        'padding-top' : (page_title_full_height/2 - $heading.height()/2)+'px'
                    });
                }
            } 
            layout();

            if ($fullHeight == 'true') {
                $(window).on("debouncedresize", function() {
                    layout();
                })
            }

            if ($('#pacz-header').hasClass('transparent-header') && $fullHeight != 'true' ) {
                var header_height = parseInt($('#pacz-header').attr('data-height'));
                var padding = parseInt($this.css('padding-top'));
                $this.css({ 
                    'padding-top' : (padding + header_height)+'px'
                })
            }
        

            var parallaxSpeed = .7,
                zoomFactor = 1.4;

                if (animation == "parallax") {
                    var set = function() {
                        currentPoint = (startPoint + scrollY) * parallaxSpeed;
                        effectLayer.css({
                            'transform': 'translateY(' + currentPoint + 'px)'
                        });
                    }
                    set();
                    scrollAnimations.add(set);
                }

                if (animation == "parallaxZoomOut") {
                    var set = function() {
                        currentPoint = (startPoint + scrollY) * parallaxSpeed;
                        progressVal = (1 / (endPoint - startPoint) * (scrollY - startPoint));
                        var zoomCalc = zoomFactor - ((zoomFactor - 1.2) * progressVal);

                        effectLayer.css({
                            'transform': 'translateY(' + currentPoint + 'px), scale(' + zoomCalc + ')'
                        });
                    }
                    set();
                    scrollAnimations.add(set);
                }

                if (animation == "gradient") {
                    var set = function() {
                        progressVal = (1 / (endPoint - startPoint) * (scrollY - startPoint));
                        gradientLayer.css({
                            opacity: progressVal * 2
                        });
                    }
                    set();
                    scrollAnimations.add(set);
                }
        });
    }
}

/* Progress Button */
/* -------------------------------------------------------------------- */

var progressButton = {
    loader: function(form) {
        var $form = form,
            progressBar = $form.find(".pacz-progress-button .pacz-progress-inner"),
            buttonText = $form.find(".pacz-progress-button .pacz-progress-button-content"),
            progressButton = new TimelineLite();

        progressButton
            .to(progressBar, 0, {
                width: "100%",
                scaleX: 0,
                scaleY: 1
            })
            .to(buttonText, .3, {
                y: -5
            })
            .to(progressBar, 1.5, {
                scaleX: 1,
                ease: Power2.easeInOut
            }, "-=.1")
            .to(buttonText, .3, {
                y: 0
            })
            .to(progressBar, .3, {
                scaleY: 0
            });
    },

    success: function(form) {
        var $form = form,
            buttonText = $form.find(".pacz-button .pacz-progress-button-content, .pacz-contact-button .pacz-progress-button-content"),
            successIcon = $form.find(".pacz-progress-button .state-success"),
            progressButtonSuccess = new TimelineLite({
                onComplete: hideSuccessMessage
            });

        progressButtonSuccess
            .to(buttonText, .3, {
                paddingRight: 20,
                ease: Power2.easeInOut
            }, "+=1")
            .to(successIcon, .3, {
                opacity: 1
            })
            .to(successIcon, 2, {
                opacity: 1
            });

        function hideSuccessMessage() {
            progressButtonSuccess.reverse()
        }
    },

    error: function(form) {
        var $form = form,
            buttonText = $form.find(".pacz-button .pacz-progress-button-content, .pacz-contact-button .pacz-progress-button-content"),
            errorIcon = $form.find(".pacz-progress-button .state-error"),
            progressButtonError = new TimelineLite({
                onComplete: hideErrorMessage
            });

        progressButtonError
            .to(buttonText, .3, {
                paddingRight: 20
            }, "+=1")
            .to(errorIcon, .3, {
                opacity: 1
            })
            .to(errorIcon, 2, {
                opacity: 1
            });

        function hideErrorMessage() {
            progressButtonError.reverse()
        }
    }
}





;/* Window Scroller */
/* -------------------------------------------------------------------- */

function pacz_window_scroller() {
    if (!$.exists('.pacz-window-scroller')) {
        return false;
    }

    $('.pacz-window-scroller').each(function() {
        var $this = $(this),
            $container_h = $this.attr('data-height'),
            $image = $this.find('img'),
            $speed = parseInt($this.attr('data-speed'));

        $this.stop(true, true).hoverIntent(function() {
            $image.animate({
                'top': -($image.height() - $container_h)
            }, $speed);

        }, function() {
            $image.animate({
                'top': 0
            }, $speed / 3);
        });
    });

};/* Header Section Sticky function */
/* -------------------------------------------------------------------- */


function sticky_header() {
    var $pacz_header = $('#pacz-header').first();
	var $pacz_body = $('body').first();
    if ($pacz_header.hasClass('sticky-header') && global_window_width > pacz_nav_res_width) {

            var header_structure = $pacz_header.attr('data-header-structure');

            if(header_structure == 'vertical') {
                var pacz_header_height = 100;
            }else if(pacz_header_toolbar = true){
				//var pacz_header_height = parseInt(pacz_logo_height) + 0;
				
                //var pacz_header_height = 0;
				var pacz_header_height = 110;
            }else if(pacz_header_toolbar = false){
				var pacz_header_height = 1;
			}


        var chopScrollAnimation = function() {
            if (global_window_width > pacz_nav_res_width) {
                if (scrollY > pacz_header_height) {
                    $pacz_header.addClass('sticky-trigger-header');
					//$pacz_body.addClass('sticky--header-padding');
                } else {
					//$pacz_body.removeClass('sticky--header-padding');
                    $pacz_header.removeClass('sticky-trigger-header');
					
                }
            }
            // setTimeout(function() {
            //     pacz_main_navigation();
            // }, 200);
        }
        debouncedScrollAnimations.add(chopScrollAnimation);
    }

}



function transparent_header_sticky() {
    var $pacz_header = $('#pacz-header');
    if ($pacz_header.hasClass('transparent-header') && global_window_width > pacz_nav_res_width) {

        var trigger = false;

       var chopScrollAnimation = function() {
            var sharp_active = $('.pacz-sharp-slider.first-el-true').find('.swiper-slide-active').attr('data-header-skin'),
                header_structure = $pacz_header.attr('data-header-structure');
                if(header_structure == 'vertical') {
                    var pacz_header_height = 100;
                } else {
                    var pacz_header_height = parseInt((pacz_header_padding * 2) + pacz_logo_height) + 0;
                }

            pacz_header_trans_offset = 1;

                if (global_window_width > pacz_nav_res_width) {
                    if (scrollY > pacz_header_height || trigger) {
                        $pacz_header.addClass('header-offset-passed');
                    } else {
                        $pacz_header.removeClass('header-offset-passed');
                    }

                    if (scrollY > pacz_header_trans_offset  || trigger) {
                        $pacz_header.addClass('transparent-header-sticky sticky-trigger-header').removeClass('light-header-skin dark-header-skin');

                    } else {
                        if (sharp_active != '' && typeof sharp_active !== 'undefined') {
                            $pacz_header.removeClass('transparent-header-sticky sticky-trigger-header').addClass(sharp_active + '-header-skin');
                        } else {
                            $pacz_header.removeClass('transparent-header-sticky sticky-trigger-header').addClass($pacz_header.attr('data-transparent-skin') + '-header-skin');
                        }
                    }
                }

                // setTimeout(function() {
                //     pacz_main_navigation();
                // }, 200);
        }
        debouncedScrollAnimations.add(chopScrollAnimation);

        $('body').on('page_intro', function() { 
            setTimeout(function() {
                trigger = true;
                chopScrollAnimation();
            }, 1000);
        });
        $('body').on('page_outro', function() { 
            setTimeout(function() {
                trigger = false;
                chopScrollAnimation();
            }, 500);
        });

    }

};/* Main Navigation Init */
/* -------------------------------------------------------------------- */


function pacz_main_navigation_init() {

    // $(".main-navigation-ul").dcMegaMenu({
    //     rowItems: '6',
    //     speed: 200,
    //     effect: 'fade',
    //     fullWidth: true
    // });

  "use strict";

  var $body = $('body');

  if (!$body.hasClass('navigation-initialised')) {

    $(".main-navigation-ul").MegaMenu({
      type: "vertical",
      delay: 200
    });

    $('#pacz-vm-menu').dlmenu();

    $body.addClass('navigation-initialised');

  }

  

}




/* Main Navigation mobile mode */
/* -------------------------------------------------------------------- */

$('body').data('res-nav-appended', false);
function pacz_main_navigation_functions() {

    if (global_window_width > pacz_nav_res_width) {

        $('.pacz-responsive-nav').hide();
        setTimeout(function() {
            pacz_main_navigation_init();
            // pacz_main_navigation();
        }, 200);

        if ($('#pacz-header').attr('data-header-style') == 'transparent') {
            $('#pacz-header').addClass('transparent-header ' + $('#pacz-header').attr('data-transparent-skin') + '-header-skin');
        }

    } else {

            $('.main-navigation-ul, .pacz-vertical-menu').each(function() {
                var $this = $(this),
                res_nav = $('.responsive-nav-container');
                if(!res_nav.hasClass('res-nav-appended')) {
                    $this.clone().attr({
                        "class": "pacz-responsive-nav"
                    }).appendTo(res_nav);
                    res_nav.addClass('res-nav-appended')
                }
            });
            

            $('.pacz-responsive-nav > li > ul').each(function() {
                if(!$(this).siblings('a').find('span').length) {
                    $(this).siblings('a').append('<span class="pacz-theme-icon-bottom-big pacz-nav-arrow pacz-nav-sub-closed"></span>');
                }
            });

            $('.pacz-responsive-nav').show();

            if(!$('body').data('res-nav-appended')) {
                $('.pacz-responsive-nav > li').stop(true).on('click', function(e) { 

                    var $this = $(this),
                        $arrow = $this.find('.pacz-nav-arrow');

                    if($(e.target).hasClass('pacz-nav-arrow') || $(e.target).hasClass('pacz-nav-open')) {
                      if ($arrow.hasClass('pacz-nav-sub-closed')) {
                        $arrow.parent().siblings('ul').slideDown(450).end().end().removeClass('pacz-nav-sub-closed').addClass('pacz-nav-sub-opened');
                      } else {
                        $arrow.parent().siblings('ul').slideUp(450).end().end().removeClass('pacz-nav-sub-opened').addClass('pacz-nav-sub-closed');
                      }
                      e.preventDefault();
                  }
                });

                $('body').data('res-nav-appended', true);
            };

        if ($('#pacz-header').attr('data-header-style') == 'transparent') {
            $('#pacz-header').removeClass('transparent-header ' + $('#pacz-header').attr('data-transparent-skin') + '-header-skin');
        }

        if(!$.exists('#pacz-responsive-wrap')) {
          var $header_height = 0;
          var $window_height = $(window).outerHeight();

          if ($.exists('#wpadminbar')) {
            $header_height += $('#wpadminbar').outerHeight();
          }

          if($.exists('.responsive-nav-container')) {
            $header_height += $('#pacz-header').height();
            // console.log($header_height);

            var nav_height = $window_height - $header_height;

            $('.responsive-nav-container').wrap('<div id="pacz-responsive-wrap" style="max-height:'+nav_height+'px; top:0"></div>');
			 $('body').append('<div class="mobile-overlay"></div>');
			 $('body').append('<div class="mobile-search-overlay"></div>');
          }

          $(window).on('resize', function() {
            $('#pacz-responsive-wrap').css({
              'max-height' : ($(window).height() - $header_height) + 'px'
            });
          });

        }
		if(!$.exists('#pacz-responsive-search-wrap')) {
          var $header_height = 0;
          var $window_height = $(window).outerHeight();

          if ($.exists('#wpadminbar')) {
            $header_height += $('#wpadminbar').outerHeight();
          }

          if($.exists('.responsive-search-form-container')) {
            $header_height += $('#pacz-header').height();
            // console.log($header_height);

            var nav_search_height = $window_height - $header_height;

            $('.responsive-search-form-container').wrap('<div id="pacz-responsive-search-wrap" style="max-height:'+nav_search_height+'px; top: '+$header_height+'px;"></div>');
          }

          $(window).on('resize', function() {
            $('#pacz-responsive-search-wrap').css({
              'max-height' : ($(window).height() - $header_height) + 'px'
            });
          });

        }

    }


    if (global_window_width < pacz_grid_width) {
        $('.main-navigation-ul .sub-container.mega, .main-navigation-ul .sub-container.mega .row').each(function() {
            $(this).css('width', global_window_width - 40);
        });
    }

};/* Secondary Header Scripts */
/* -------------------------------------------------------------------- */

var secondary_header_offset;

function pacz_secondary_header_res() {
    if ($.exists('.pacz-secondary-header')) {
        secondary_header_offset = $('.pacz-secondary-header').offset().top; // switched from position(). We need val relative to document.
        // console.log(secondary_header_offset);
    }
}

function secondary_header() {
    var $this = $('.pacz-secondary-header');
    if ($this.length) {

        var pacz_header = 0; 

        if ($.exists("#pacz-header.sticky-header")) {
            pacz_header = parseInt($("#pacz-header.sticky-header").attr('data-sticky-height'));
        }
        if ($.exists(".pacz-header-toolbar") && $.exists('#pacz-header.sticky-header')) {
            pacz_header += 35;
        }

        if(!$('.pacz-secondary-header').parent().hasClass('theme-main-header')) {
            var dsitance_from_top = secondary_header_offset - pacz_header - global_admin_bar_height;

            var animationSet = function() {
                if (scrollY > dsitance_from_top) {
                    $this.addClass('secondary-header-sticky').css('top', (pacz_header + global_admin_bar_height));
                    $('.secondary-header-space').addClass('secondary-space-sticky');
                } else {
                    $this.removeClass('secondary-header-sticky').css('top', 'auto');
                    $('.secondary-header-space').removeClass('secondary-space-sticky');
                }
            }
            debouncedScrollAnimations.add(animationSet);
        }
    }
}
;
/* Retina compatible images */
/* -------------------------------------------------------------------- */
var pacz_retina = function() {
    return {
        init: function() {
            var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
            if (pixelRatio > 1) {
                $("img").each(function(idx, el) {
                    el = $(el);
                    if (el.attr("data-retina-src")) {
                        el.attr("data-src-orig", el.attr("src"));
                        el.attr("src", el.attr("data-retina-src"));
                    }
                });
            }
        }
    };
}();
pacz_retina.init();

;
$(window).load(function() {

    /* Milestone Number Shortcode */
    /* -------------------------------------------------------------------- */
    $('.pacz-milestone').one('inview', function(event, visible) {
        if (visible == true) {

            var el_this = $(this),
                stop_number = el_this.find('.milestone-number').attr('data-stop'),
                animation_speed = parseInt(el_this.find('.milestone-number').attr('data-speed'));

            $({
                countNum: el_this.find('.milestone-number').text()
            }).animate({
                countNum: stop_number
            }, {
                duration: animation_speed,
                step: function() {
                    el_this.find('.milestone-number').text(Math.floor(this.countNum));
                },
                complete: function() {
                    el_this.find('.milestone-number').text(this.countNum);
                }
            });
        }
    });



    /* Skill Meter and Charts */
    /* -------------------------------------------------------------------- */
    $('.pacz-skill-meter .progress-outer').one('inview', function(event, visible) {
        if (visible == true) {
            var $this = $(this);
            $this.animate({
                width: $(this).attr("data-width") + '%'
            }, 2000);
        }
    });



    $('.pacz-chart').one('inview', function(event, visible) {
        if (visible == true) {
            var $this = $(this),
                $parent_width = $(this).parent().width(),
                $chart_size = $this.attr('data-barSize');

            if ($parent_width < $chart_size) {
                $chart_size = $parent_width;
                $this.css('line-height', $chart_size);
                $this.find('i').css({
                    'line-height': $chart_size + 'px',
                    'font-size': ($chart_size / 3)
                });
            }
            $this.easyPieChart({
                animate: 1300,
                lineCap: 'square',
                lineWidth: $this.attr('data-lineWidth'),
                size: $chart_size,
                barColor: $this.attr('data-barColor'),
                trackColor: $this.attr('data-trackColor'),
                scaleColor: 'transparent',
                onStep: function(value) {
                    this.$el.find('.chart-percent span').text(Math.ceil(value));
                }
            });
        }
    });



    /* Animated Contents */
    /* -------------------------------------------------------------------- */
    if (is_touch_device() || global_window_width < 800) {
        $('body').addClass('no-transform').find('.pacz-animate-element').removeClass('pacz-animate-element');
    }

    $('.pacz-animate-element').one('inview', function(event, visible) {
        if (visible == true) {
            $(this).addClass('pacz-in-viewport');
        }
    });


});
;/* Google Maps */
/* -------------------------------------------------------------------- */

function pacz_google_maps() {


    "use strict";

    $('.pacz-gmaps').each(function() {

        var $this = $(this),
            $id = $this.attr('id'),
            $zoom = parseInt($this.attr('data-zoom')),
            $latitude = $this.attr('data-latitude'),
            $longitude = $this.attr('data-longitude'),
            $address = $this.attr('data-address'),
            $latitude_2 = $this.attr('data-latitude2'),
            $longitude_2 = $this.attr('data-longitude2'),
            $address_2 = $this.attr('data-address2'),
            $latitude_3 = $this.attr('data-latitude3'),
            $longitude_3 = $this.attr('data-longitude3'),
            $address_3 = $this.attr('data-address3'),
            $pin_icon = $this.attr('data-pin-icon'),
            $pan_control = $this.attr('data-pan-control') === "true" ? true : false,
            $map_type_control = $this.attr('data-map-type-control') === "true" ? true : false,
            $scale_control = $this.attr('data-scale-control') === "true" ? true : false,
            $draggable = $this.attr('data-draggable') === "true" ? true : false,
            $zoom_control = $this.attr('data-zoom-control') === "true" ? true : false,
            $modify_coloring = $this.attr('data-modify-coloring') === "true" ? true : false,
            $saturation = $this.attr('data-saturation'),
            $hue = $this.attr('data-hue'),
			$gamma = $this.attr('data-gamma'),
            $lightness = $this.attr('data-lightness'),
            $fullHeight = $this.attr('data-fullHeight') === "true" ? true : false,
            map_height,
            $header_height = 0,
            $parent = $this.parent(),
            $height = $parent.height(),
            $styles;

        var mapDimensions = function() {
            if ($.exists('#pacz-header') && !$('#pacz-header').hasClass('transparent-header')) {
                if($('#pacz-header').hasClass('sticky-header')) {
                    $header_height = parseInt($('#pacz-header').attr('data-sticky-height'));
                } else {
                    $header_height = parseInt($('#pacz-header').attr('data-height'));
                }
            }
            if ($fullHeight === true) {
                map_height = global_window_height - $header_height - global_admin_bar_height;

            } else {
                map_height = $height;
            }

            $parent.height(map_height);

            if($parent.hasClass('pacz-gmaps-parallax')){
                $this.height(map_height+200);
            } else {
                $this.height(map_height);
            }
            // Reinit maps
        }


        if ($modify_coloring == true) {
            var $styles = [{
                stylers: [{
                    hue: $hue
                }, {
                    saturation: $saturation
                }, {
                    lightness: $lightness
                },{
                    gamma: $gamma
                },{
                    featureType: "landscape.man_made",
                    stylers: [{
                        visibility: "on"
                    }]
                }]
            }];
        }


        var map;

        function initialize() {

            var bounds = new google.maps.LatLngBounds();

            var mapOptions = {
                zoom: $zoom,
                panControl: $pan_control,
                zoomControl: $zoom_control,
                mapTypeControl: $map_type_control,
                scaleControl: $scale_control,
                draggable: $draggable,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: $styles
            };

            map = new google.maps.Map(document.getElementById($id), mapOptions);
            map.setTilt(45);

            // Multiple Markers

            var markers = [];
            var infoWindowContent = [];

            if ($latitude != '' && $longitude != '') {
                markers[0] = [$address, $latitude, $longitude];
                infoWindowContent[0] = ['<div class="info_content"><p>' + $address + '</p></div>'];
            }

            if ($latitude_2 != '' && $longitude_2 != '') {
                markers[1] = [$address_2, $latitude_2, $longitude_2];
                infoWindowContent[1] = ['<div class="info_content"><p>' + $address_2 + '</p></div>'];
            }

            if ($latitude_3 != '' && $longitude_3 != '') {
                markers[2] = [$address_3, $latitude_3, $longitude_3];
                infoWindowContent[2] = ['<div class="info_content"><p>' + $address_3 + '</p></div>'];
            }



            var infoWindow = new google.maps.InfoWindow(),
                marker, i;


            for (i = 0; i < markers.length; i++) {
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[i][0],
                    icon: $pin_icon
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(map, marker);
                    }
                })(marker, i));

                map.fitBounds(bounds);

            }


            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                this.setZoom($zoom);
                google.maps.event.removeListener(boundsListener);
            });
        }



        $(window).load(function() {
            mapDimensions();
            setTimeout(function() {
                initialize();
            }, 500);
        });

        $(window).on('resize', function() {
            setTimeout(function() {
                mapDimensions();
                google.maps.event.trigger(map, 'resize');
            }, 500);
        });


    });

    $(window).load(function() {
        if ($.exists('.pacz-gmaps-parallax')) {
            var pacz_skrollr = skrollr.init({
                forceHeight: false
            });
            pacz_skrollr.refresh($('.pacz-page-section'));
        }
    });

};/* Header Search, Header Dashboard scripts */
/* -------------------------------------------------------------------- */

$(".pacz-header-search, .pacz-side-dashboard, .dashboard-trigger, .search-ajax-input, .pacz-quick-contact-inset").click(function(event) {
    if (event.stopPropagation) {
        event.stopPropagation();
    } else if (window.event) {
        window.event.cancelBubble = true;
    }
});


$("html").click(function() {
    $('.header-search-icon').removeClass('search-clicked');
    $('form.header-searchform-input').fadeOut(250);
    $('#pacz-header').removeClass('header-search-triggered');
    $('.pacz-secondary-header').removeClass('header-search-triggered');
    $('.dashboard-trigger').removeClass('dashboard-active');
    $('.theme-main-wrapper, .pacz-side-dashboard').removeClass('dashboard-opened');

});


$('.header-search-icon').on('click', function(e) {
    var $this = $(this);
    //console.log(pacz_boxed_header); 
    $this.parent().parent().parent().next().fadeIn(250);
    $this.parent().parent().parent().next().find('input[type=text]').focus(); 
    if(pacz_boxed_header == '0'){
        $this.parent().parent().parent().parent().addClass('header-search-triggered');
    }else{
        $this.parent().parent().parent().parent().parent().addClass('header-search-triggered');
    }
    e.preventDefault(); 
});

$('.header-search-close').on('click', function(e) {
    var $this = $(this);
    $this.parent().fadeOut(250);
    $this.parent().parent().parent().removeClass('header-search-triggered');
    e.preventDefault();
});



$('.dashboard-trigger').on('click', function(e) {

    var $this = $(this);

    if (!$this.hasClass('dashboard-active')) {

        $this.addClass('dashboard-active');
        $('.theme-main-wrapper, .pacz-side-dashboard').addClass('dashboard-opened');

    } else {

        $this.removeClass('dashboard-active');
        $('.theme-main-wrapper, .pacz-side-dashboard').removeClass('dashboard-opened');
    }
    e.preventDefault();
});


$('.responsive-nav-link').on('click', function(e) {
    var $this = $(this),
        $header = $('#pacz-header'),
        res_nav = $('.responsive-nav-container');

    if (!$this.hasClass('active-burger')) {
        if($header.hasClass('theme-main-header')) {
            $this.addClass('active-burger');
			 $(".mobile-overlay").fadeIn(500);
             res_nav.toggle('slide');
            $('body').removeClass('pacz-closed-nav').addClass('pacz-opened-nav').trigger('pacz-opened-nav');
        } else {
            //var offset = $this.offset().top - global_admin_bar_height;
           // abb.smoothScrollTo(offset, 500);
            $this.addClass('active-burger');
            setTimeout(function() {
				 $(".mobile-overlay").fadeIn(500);
                res_nav.toggle('slide');
                $('#pacz-responsive-wrap').css({
                    'position': 'absolute',
                    'top': '0',
                    'max-height': ($(document).height() + 'px'),
                    'width': '250px',
					'z-index': '10000'
                });
            }, 200);
        }
    } 
    else {
        if($header.hasClass('theme-main-header')) {
            $this.removeClass('active-burger');
             res_nav.toggle('slide');
			  $(".mobile-overlay").fadeOut(500);
            $('body').removeClass('pacz-opened-nav').addClass('pacz-closed-nav').trigger('pacz-closed-nav');
        } else {
            $this.removeClass('active-burger');
             res_nav.toggle('slide');
			 $(".mobile-overlay").fadeOut(500);
        }
    }
    $('#pacz-responsive-wrap').show();
    e.preventDefault();
});
$('.res-menu-close').on('click', function(e) {

	var res_nav = $('.responsive-nav-container');
	$('.responsive-nav-link').removeClass('active-burger');
     res_nav.toggle('slide');
	 $(".mobile-overlay").fadeOut(500);
     $('body').removeClass('pacz-opened-nav').addClass('pacz-closed-nav').trigger('pacz-closed-nav');
	 $('#pacz-responsive-wrap').hide();
	 e.preventDefault();
});
$('.responsive-nav-search-link').on('click', function(e) {
    var $this = $(this),
        $header = $('#pacz-header'),
        res_nav_search = $('.responsive-search-form-container');

    if (!$this.hasClass('active-search-burger')) {
        if($header.hasClass('theme-main-header')) {
            $this.addClass('active-search-burger');
			$(".mobile-search-overlay").fadeIn(500);
            res_nav_search.slideDown();
            $('body').removeClass('pacz-closed-search').addClass('pacz-opened-search').trigger('pacz-opened-search');
        } else {
            //var offset = $this.offset().top - global_admin_bar_height;
            //abb.smoothScrollTo(offset, 500);
            $this.addClass('active-search-burger');
            setTimeout(function() {
				$(".mobile-search-overlay").fadeIn(500);
                res_nav_search.slideDown();
                $('#pacz-responsive-search-wrap').css({
                    'position': 'absolute',
                    'top': 'auto',
                    'max-height': ($(document).height() + 'px'),
                    'width': ($(window).width()) + 'px',
					'z-index': 10000
                });
            }, 300);
        }
    } 
    else {
        if($header.hasClass('theme-main-header')) {
            $this.removeClass('active-search-burger');
            res_nav_search.slideUp();
			$(".mobile-search-overlay").fadeOut(500);
            $('body').removeClass('pacz-opened-search').addClass('pacz-closed-search').trigger('pacz-closed-search');
        } else {
            $this.removeClass('active-search-burger');
            res_nav_search.slideUp();
			$(".mobile-search-overlay").fadeOut(500);
        }
    }
    e.preventDefault();
});
;/* jQuery Colorbox lightbox */
/* -------------------------------------------------------------------- */

function pacz_lightbox_init() {

   //jQuery(".pacz-lightbox").each(function() {

        jQuery(".pacz-lightbox").fancybox({
            padding: 15,
            margin: 15,

            width: 800,
            height: 600,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 9999,
            maxHeight: 9999,
            pixelRatio: 1, // Set to 2 for retina display support

            autoSize: true,
            autoHeight: false,
            autoWidth: false,

            autoResize: true,
            fitToView: true,
            aspectRatio: false,
            topRatio: 0.5,
            leftRatio: 0.5,

            scrolling: 'auto', // 'auto', 'yes' or 'no'
            wrapCSS: '',

            arrows: true,
            closeBtn: true,
            closeClick: false,
            nextClick: false,
            mouseWheel: true,
            autoPlay: false,
            playSpeed: 3000,
            preload: 3,
            modal: false,
            loop: true,
            // Properties for each animation type
            // Opening fancyBox
            openEffect: 'elastic', // 'elastic', 'fade' or 'none'
            openSpeed: 250,
            openEasing: 'swing',
            openOpacity: true,
            openMethod: 'zoomIn',

            // Closing fancyBox
            closeEffect: 'elastic', // 'elastic', 'fade' or 'none'
            closeSpeed: 250,
            closeEasing: 'swing',
            closeOpacity: true,
            closeMethod: 'zoomOut',

            // Changing next gallery item
            nextEffect: 'fade', // 'elastic', 'fade' or 'none'
            nextSpeed: 350,
            nextEasing: 'swing',
            nextMethod: 'changeIn',

            // Changing previous gallery item
            prevEffect: 'fade', // 'elastic', 'fade' or 'none'
            prevSpeed: 350,
            prevEasing: 'swing',
            prevMethod: 'changeOut',

            tpl: {
                wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                image: '<img class="fancybox-image" src="{href}" alt="" />',
                error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"><i class="pacz-icon-times"></i></a>',
                next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span><i class="pacz-theme-icon-next-big"></i></span></a>',
                prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span><i class="pacz-theme-icon-prev-big"></i></span></a>',
                loading: '<div id="fancybox-loading"><div></div></div>'
            },

        });
   // });

};/* Sharp Slideshow */
/* -------------------------------------------------------------------- */

function pacz_sharp_slider_init() {

    $('.pacz-sharp-slider').each(function(i, val) {
        var $slider_wrapper = $(this),
            $slider_holder = $slider_wrapper.find('.sharp-slider-holder'),
            $nav = $('.pacz-sharp-nav'),
            $next_arrow = $slider_wrapper.find('.pacz-sharp-next'),
            $prev_arrow = $slider_wrapper.find('.pacz-sharp-prev'),
            $pause = $slider_wrapper.attr('data-pause'),
            $first_el = $slider_wrapper.attr('data-first'),
            $speed = $slider_wrapper.attr('data-speed'),
            $animation = $slider_wrapper.attr('data-animation'),
            $loop = $slider_wrapper.attr('data-loop'),
            $hash = $slider_wrapper.attr('data-hash') == "true" ? true : false,
            $height = $slider_wrapper.attr('data-height'),
            $fullHeight = $slider_wrapper.attr('data-fullHeight'),
            $header_height = 0,
            sharp_height = 0,
            $pagination = $slider_wrapper.attr('data-pagination') == "true" ? true : false;


        if ($pagination === true) {
            var $pagination_class = '#' + $slider_wrapper.attr('id') + ' .swiper-pagination';

            $($pagination_class).on('click', 'span', function(e){
                e.preventDefault();
              pacz_swiper.swipeTo($(this).index(), 500);
            });

            $slider_wrapper.find('.sharp-skip-slider').css('bottom', '14%');
            } else {
            var $pagination_class = false;
        }

        var animationDimensions = function() {
            if ($.exists('#pacz-header') && !$('#pacz-header').hasClass('transparent-header') && !$('#pacz-header').hasClass('header-structure-vertical')) {
                $header_height = parseInt($('#pacz-header').attr('data-sticky-height'));
            }
            if ($fullHeight === 'true') {
                sharp_height = abb.fullHeight();
            } else {
                sharp_height = $height;
            }
            
        }
        animationDimensions();

        $(window).on("debouncedresize", function(event) {
            setTimeout(function() {
                pacz_sharp_slider_resposnive();
                animationDimensions();
            }, 100);
        });

        if(BrowserDetect.browser == 'IE' && $animation == 'horizontal_curtain') {
            $animation = 'slide';
        }

        // remove viewport animations from slider
        $slider_wrapper.find('.pacz-animate-element').removeClass('pacz-animate-element fade-in scale-up right-to-left left-to-right bottom-to-top top-to-bottom forthy-five-rotate');

        var pacz_swiper = $slider_wrapper.swiper({
            mode: 'horizontal', 
            // loop: $loop === 'true' ? true : false,
            loop: true,
            roundLengths: true,
            calculateHeight: true,
            grabCursor: true,
            useCSS3Transforms: true,
            mousewheelControl: false,
            pagination : $pagination_class,
            paginationClickable: true,
            freeModeFluid: true,
            speed: $speed,
            autoplay: $pause,
            progress: true,
            autoplayDisableOnInteraction: false,
            hashNav: $hash, 
            onSwiperCreated: function(swiper) {
                // if (pacz_detect_ie() == false) {
                    var prev_active_slide = $slider_wrapper.find('.swiper-slide').eq(0).find('.sharp-slide-content .pacz-sharp-title').text(),
                        next_active_slide = $slider_wrapper.find('.swiper-slide').eq(2).find('.sharp-slide-content .pacz-sharp-title').text();
                    //console.log(prev_active_slide + "---" + next_active_slide);
                    var prev_active_slide_bg = $slider_wrapper.find('.swiper-slide').eq(0).css('background-image'),
                        next_active_slide_bg = $slider_wrapper.find('.swiper-slide').eq(2).css('background-image');
                    // console.log(prev_active_slide_bg + "---" + next_active_slide_bg);
                    var prev_active_slide_bg_video = $slider_wrapper.find('.swiper-slide').eq(0).find('.pacz-video-section-touch').css('background-image'),
                        next_active_slide_bg_video = $slider_wrapper.find('.swiper-slide').eq(2).find('.pacz-video-section-touch').css('background-image');

                        // console.log(prev_active_slide_bg_video);
                        // console.log(next_active_slide_bg_video);

                    var prev_active_slide_bg_color = $slider_wrapper.find('.swiper-slide').eq(0).css('background-color'),
                        next_active_slide_bg_color = $slider_wrapper.find('.swiper-slide').eq(2).css('background-color');

                    if (prev_active_slide.length > 1) {
                        $prev_arrow.find('.prev-item-caption').show().text(prev_active_slide);
                        // console.log(prev_active_slide);
                    }

                    if (typeof prev_active_slide_bg !== 'undefined' && prev_active_slide_bg != "none") {
                      $prev_arrow.find('.sharp-nav-bg').show().css({ 'background-image': prev_active_slide_bg });
                      // console.log(prev_active_slide_bg);
                    } 
                    else if (typeof prev_active_slide_bg_video !== 'undefined' && prev_active_slide_bg_video != "none") {
                      $prev_arrow.find('.sharp-nav-bg').show().css({ 'background-image': prev_active_slide_bg_video });
                      // console.log(prev_active_slide_bg_video);
                    } 
                    else if (prev_active_slide_bg_color !== 'undefined') {
                      $prev_arrow.find('.sharp-nav-bg').show().css({ 'background-color': prev_active_slide_bg_color });
                      // console.log(prev_active_slide_bg_color);
                    }

                    if (typeof next_active_slide !== 'undefined') {
                        $next_arrow.find('.next-item-caption').show().text(next_active_slide);
                    } 

                    if (typeof next_active_slide_bg !== 'undefined' && next_active_slide_bg != "none") {
                      $next_arrow.find('.sharp-nav-bg').show().css({ 'background-image': next_active_slide_bg });
                    } 
                    else if (typeof next_active_slide_bg_video !== 'undefined' && next_active_slide_bg_video != "none") {
                      $next_arrow.find('.sharp-nav-bg').show().css({ 'background-image': next_active_slide_bg_video });
                    } 
                    else if (typeof next_active_slide_bg_color !== 'undefined') {
                      $next_arrow.find('.sharp-nav-bg').show().css({ 'background-color': next_active_slide_bg_color });
                    }

                    if (!$('#pacz-header').hasClass('transparent-header-sticky')) {
                        if ($first_el == 'true') {
                            $('#pacz-header.transparent-header').removeClass('light-header-skin dark-header-skin').addClass($slider_wrapper.find('.swiper-slide').eq(1).attr('data-header-skin') + '-header-skin');
                        }
                    }

                    var currentSkin = $slider_wrapper.find('.swiper-slide').eq(1).attr("data-header-skin");
                    $('#' + $slider_wrapper.attr('id') + ' .pacz-sharp-nav a').attr('data-skin', currentSkin);
                    $($pagination_class).attr('data-skin', currentSkin);
                    $('#' + $slider_wrapper.attr('id') + ' .sharp-skip-slider').attr('data-skin', currentSkin);

                    $($pagination_class).find('span').append('<a href="#"></a>');
                    

                    if($nav.hasClass('nav-flip')) {
                        var slideNextNr = $('.slide-next-nr'),
                            slidePrevNr = $('.slide-prev-nr'),
                            slidesAll = $('.slides-all'),
                            slidesAllNr = swiper.slides.length - 2,
                            slideNext, 
                            slidePrev;

                        slidesAll.text(slidesAllNr);
                        slidePrevNr.text(slidesAllNr);
                        slideNextNr.text('2');
                    }

                // } else {
                //     $next_arrow.find('.next-item-caption').css('display', 'none');
                //     $prev_arrow.find('.prev-item-caption').css('display', 'none');
                // }

            },
            onSlideChangeEnd: function(swiper) {

                // if (pacz_detect_ie() == false) {

                    var currentSlide = $(pacz_swiper.activeSlide()),
                        currentSkin = currentSlide.attr("data-header-skin");
                        $('#' + $slider_wrapper.attr('id') + ' .pacz-sharp-nav a').attr('data-skin', currentSkin);
                        $('#' + $slider_wrapper.attr('id') + ' .sharp-skip-slider').attr('data-skin', currentSkin);
                        $($pagination_class).attr('data-skin', currentSkin);


                        var prev_active_slide = $(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex)).find('.sharp-slide-content .pacz-sharp-title').text(),
                            next_active_slide = $(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex + 2)).find('.sharp-slide-content .pacz-sharp-title').text();

                        var prev_active_slide_bg = $(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex)).css('background-image'),
                            next_active_slide_bg = $(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex + 2)).css('background-image');

                        var prev_active_slide_bg_video = $(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex)).find('.pacz-video-section-touch').css('background-image'),
                            next_active_slide_bg_video = $(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex + 2)).find('.pacz-video-section-touch').css('background-image');

                        var prev_active_slide_bg_color = $(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex)).css('background-color'),
                            next_active_slide_bg_color = $(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex + 2)).css('background-color');

                        if (typeof prev_active_slide !== 'undefined') {
                            $prev_arrow.find('.prev-item-caption').show().text(prev_active_slide);
                            // console.log(prev_active_slide);
                        }

                        if (typeof prev_active_slide_bg !== 'undefined' && prev_active_slide_bg != "none") {
                          $prev_arrow.find('.sharp-nav-bg').show().css({ 'background-image': prev_active_slide_bg });
                          // console.log(prev_active_slide_bg);
                        } 
                        else if (typeof prev_active_slide_bg_video !== 'undefined' && prev_active_slide_bg_video != "none") {
                          $prev_arrow.find('.sharp-nav-bg').show().css({ 'background-image': prev_active_slide_bg_video });
                          // console.log(prev_active_slide_bg_video);
                        } 
                        else if (typeof prev_active_slide_bg_color !== 'undefined') {
                          $prev_arrow.find('.sharp-nav-bg').show().css({ 'background-color': prev_active_slide_bg_color });
                          // console.log(prev_active_slide_bg_color);
                        }

                        if (typeof next_active_slide !== 'undefined') {
                            $next_arrow.find('.next-item-caption').show().text(next_active_slide);
                        } 

                        if (typeof next_active_slide_bg !== 'undefined' && next_active_slide_bg != "none") {
                          $next_arrow.find('.sharp-nav-bg').show().css({ 'background-image': next_active_slide_bg });
                        } 
                        else if (typeof next_active_slide_bg_video !== 'undefined' && next_active_slide_bg_video != "none") {
                          $next_arrow.find('.sharp-nav-bg').show().css({ 'background-image': next_active_slide_bg_video });
                        } 
                        else if (typeof next_active_slide_bg_color !== 'undefined') {
                          $next_arrow.find('.sharp-nav-bg').show().css({ 'background-color': next_active_slide_bg_color });
                        }

                        if (!$('#pacz-header').hasClass('transparent-header-sticky')) {
                            if ($first_el == 'true') {
                                $('#pacz-header.transparent-header').removeClass('light-header-skin dark-header-skin').addClass($(pacz_swiper.getSlide(pacz_swiper.activeLoopIndex + 1)).attr('data-header-skin') + '-header-skin');
                            }
                        }

                    var slideNextNr = $('.slide-next-nr'),
                        slidePrevNr = $('.slide-prev-nr'),
                        slidesAll = $('.slides-all'),
                        slidesAllNr = swiper.slides.length -2,
                        slideNext, 
                        slidePrev;

                    if( pacz_swiper.activeLoopIndex == 0) {
                        slidePrev = slidesAllNr;
                    } else {
                        slidePrev = pacz_swiper.activeLoopIndex;
                    }

                    if( pacz_swiper.activeLoopIndex == slidesAllNr - 1) {
                        slideNext = 1;
                    } else {
                        slideNext = pacz_swiper.activeLoopIndex + 2;
                    }

                    // console.log(swiper.slides.activeLoopIndex)


                    slidesAll.text(slidesAllNr);
                    slidePrevNr.text(slidePrev);
                    slideNextNr.text(slideNext);


                // } else {
                //     $next_arrow.find('.next-item-caption').css('display', 'none');
                //     $prev_arrow.find('.prev-item-caption').css('display', 'none');
                // }
            },
            onProgressChange: function(swiper){
                for (var i = 0; i < swiper.slides.length; i++){

                    var slide = swiper.slides[i];
                    var progress = slide.progress;

                    // SLIDER ANIMATION EFFECTS

                    if($animation == "vertical_slide") {
                        var translateX, translateY;

                            translateX = progress*swiper.width;
                            translateY = progress*sharp_height;

                        swiper.setTransform(slide,'translate3d('+translateX+'px,'+ (-translateY) +'px,0)');
                    }

                    if($animation == "zoom") {
                        var scale, scaleContent, translate, opacity, zIndex;

                        if (progress<=0) {
                            opacity = 1 - Math.min(Math.abs(progress),1);
                            scale = 1 - Math.min(Math.abs(progress/12),1);
                            scaleContent = 1;
                            translate = progress*swiper.width;
                        }
                        else {
                            opacity = 1 - Math.min(Math.abs(progress/2),1);
                            scale = 1 + Math.min(Math.abs(progress/6),1);
                            translate = progress*swiper.width;
                        }
                            zIndex = (1 - Math.min(Math.abs(progress),1))*10;

                        slide.style.opacity = opacity;
                        swiper.setTransform(slide,'translate3d('+translate+'px,0,0) scale('+scale+')');
                        slide.style.zIndex = zIndex;
                    }

                    if($animation == "zoom_out") {
                        var scale, translateX, translateY, opacity, zIndex;

                            translateX = progress*swiper.width;

                        if (progress<=0) {
                            opacity = 1;
                            scale = 1;
                            zIndex = 1;
                            translateY = progress*sharp_height;
                        }
                        else if (progress>0){
                            opacity = (1 - Math.min(Math.abs(progress),1))/2;
                            scale = 1 - Math.min(Math.abs(progress/2),1);
                            zIndex = 0;
                            translateY = 0;
                        }

                        swiper.setTransform(slide,'translate3d('+translateX+'px,'+ -translateY +'px,0)  scale('+scale+')');
                        slide.style.opacity = opacity;
                        slide.style.zIndex = zIndex;
                    }

                    if($animation == "fade") {
                        var translateX, opacity, zIndex;

                            translateX = progress*swiper.width;
                            opacity = 1 - Math.min(Math.abs(progress),1);
                            zIndex = (1 - Math.min(Math.abs(progress),1))*10;

                        swiper.setTransform(slide,'translate3d('+translateX+'px,0,0)');
                        slide.style.opacity = opacity;
                        slide.style.zIndex = zIndex;

                    }

                    if($animation == "horizontal_curtain") {
                        var translateX, zIndex, transitionTiming;
                            translateX = progress*swiper.width;

                        if (progress<=0) {
                            zIndex = 1;
                            translateX = 0;
                            transitionTiming = 'ease';
                        }
                        else if (progress>0){
                            zIndex = 0;
                            translateX = (progress*swiper.width)/2;
                            transitionTiming = 'ease';
                        }

                        swiper.setTransform(slide,'translate3d('+(translateX/2)+'px,0,0)');
                        slide.style.webkitTransitionTimingFunction = transitionTiming;
                        slide.style.zIndex = zIndex;
                    }

                    if($animation == "perspective_flip") {
                        var translateX, translateY, rotateX;

                            translateX = progress*swiper.width;
                            translateY = progress*sharp_height;

                        if (progress>=0) {
                            rotateX = 0;
                        }
                        else if (progress<0){
                            rotateX = 70;
                        }

                        swiper.setTransform(slide,'translate3d('+translateX+'px,'+ (-translateY) +'px,0) rotateX('+rotateX+'deg)');
                    }

                }
              },
              onTouchStart:function(swiper){
                for (var i = 0; i < swiper.slides.length; i++){
                  swiper.setTransition(swiper.slides[i], 0);
                }
              },
              onSetWrapperTransition: function(swiper, speed) {
                for (var i = 0; i < swiper.slides.length; i++){
                  swiper.setTransition(swiper.slides[i], speed);
                }
              }



        });

        $prev_arrow.click(function(e) {
            pacz_swiper.swipePrev();
            e.preventDefault();
        });

        $next_arrow.click(function(e) {
            pacz_swiper.swipeNext();
            e.preventDefault();
        });


        //
        // PARALLAX
        //
        //////////////////////////////////////////////


        if ($slider_wrapper.parent().hasClass('pacz-parallax') && !is_touch_device()) {
            var offset, translateValue,
                $parent = $slider_wrapper.parent(),
                height = $parent.outerHeight(),
                $header = $('#pacz-header'),
                headerHeight = 0;


            if(!$header.hasClass('transparent-header')) {
                headerHeight = $header.height();
            }

            if($header.hasClass('header-structure-vertical')) {
                headerHeight = 0;
            }

            scrollAnimations.add(function(scrollY) {
                offset = $parent.offset().top;
                translateValue = ((scrollY - offset + global_admin_bar_height + headerHeight) * .7);
                $slider_wrapper.css({'transform' : 'translateY(' + translateValue + 'px)'});
            });
        }

    });


}



function pacz_sharp_slider_resposnive() {


    $('.pacz-sharp-slider').each(function() {


        var $this = $(this),
            $containers = $this.find('.sharp-slider-holder, .swiper-slide'),
            $height = $this.attr('data-height'),
            $fullHeight = $this.attr('data-fullHeight'),
            $header_height = 0,
            sharp_full_height = 0;

        if ($.exists('#pacz-header.sticky-header') && !$('#pacz-header').hasClass('transparent-header') && !$('#pacz-header').hasClass('header-structure-vertical') ) {
            var $header_height = parseInt($('#pacz-header.sticky-header').attr('data-sticky-height'));
        }

        if ($fullHeight === 'true') {
            // global_window_height = global_window_height - $header_height - global_admin_bar_height; // after globalising it brought error probably because admin bar was not generated by here and was counted as 0
            sharp_full_height = abb.fullHeight();
        } else {
            sharp_full_height = $height;
        }


        $containers.css('height', sharp_full_height);
        $this.css('height', sharp_full_height);



        $this.find('.swiper-slide').each(function() {


            var $this = $(this),
                $content = $this.find('.sharp-slide-content'),
                $holder = $this.find('.sharp-content-holder');

            if ($this.hasClass('left_center') || $this.hasClass('center_center') || $this.hasClass('right_center')) {

                var $this_height_half = $content.outerHeight() / 2,
                    $window_half = sharp_full_height / 2;

                $holder.css('marginTop', ($window_half - $this_height_half));
            }

            if ($this.hasClass('left_bottom') || $this.hasClass('center_bottom') || $this.hasClass('right_bottom')) {
                if(global_window_width > 960) {
                    var $distance_from_top = sharp_full_height - $content.outerHeight() - 160;
                    $holder.css('marginTop', ($distance_from_top));    
                } else {
                    var $this_height_half = $content.outerHeight() / 2,
                    $window_half = sharp_full_height / 2;

                    $holder.css('marginTop', ($window_half - $this_height_half));
                }
                
            }

        });

        $this.find('.sharp-slider-loading').fadeOut();
    });

}



function pacz_tab_slider() {

    $('.pacz-tab-slider').each(function(i, val) {
        var $slider_wrapper = $(this),
            $slider_holder = $slider_wrapper.find('.sharp-slider-holder'),
            $pause = $slider_wrapper.attr('data-pause'),
            $speed = $slider_wrapper.attr('data-speed'),
            $height = $slider_wrapper.attr('data-height'),
            $fullHeight = $slider_wrapper.attr('data-fullHeight'),
            content = $slider_wrapper.find('.pacz-tab-slider-content')[0],
            $header_height = 0,
            sharp_height = 0,
            content_height = $(content).height(),
            $pagination = $slider_wrapper.attr('data-pagination') == "true" ? true : false,
            $burger = $slider_wrapper.find('i'),
            $nav = $('.pacz-tab-slider-pagination'),
            $menu_titles = $nav.find('.pacz-tab-slider-menu-titles a');

        if ($pagination === true) {
            var $pagination_class = '#' + $slider_wrapper.attr('id') + ' .swiper-pagination';

            $($pagination_class).on('click', 'span', function(e){
              e.preventDefault();
              pacz_swiper.swipeTo($(this).index(), 500);
            });

            } else {
            var $pagination_class = false;
        }

        // remove viewport animations from slider
        $slider_wrapper.find('.pacz-animate-element').removeClass('pacz-animate-element fade-in scale-up right-to-left left-to-right bottom-to-top top-to-bottom forthy-five-rotate');


        var animationDimensions = function() {
            if ($.exists('#pacz-header') && !$('#pacz-header').hasClass('header-structure-vertical')) {
                $header_height = parseInt($('#pacz-header').attr('data-sticky-height'));
            }
            if ($fullHeight == 'true') {
                sharp_height = global_window_height - $header_height - global_admin_bar_height;
            } else {
                sharp_height = $height;
            }
            //console.log('sharp_height: ' + sharp_height);
        }
        animationDimensions();


        var dynamicHeight = true;
        function sliderHeight() {

            if($slider_wrapper.find('.swiper-slide-active').length) {
                content_height = $slider_wrapper.find('.swiper-slide-active').height();
            }

            var tab_content = $slider_wrapper.find('.pacz-tab-slider-content')[0];
            //$tab_content_inner_height = $(tab_content).find('.pacz-grid').height() - 300,


            if (global_window_width < 960) {
                $slider_wrapper.find('.pacz-tab-slider-content').css({
                    'paddingTop' : 0,
                    'min-height' : 0
                });
            }
            
            if ($fullHeight == 'true') {
                $slider_wrapper.find('.pacz-tab-slider-content').css({
                    'min-height' : sharp_height + 'px'
                });
            }

            // console.log(content_height);
        } 
        

        var pacz_swiper = $slider_wrapper.swiper({
            mode: 'horizontal',
            loop: true,
            grabCursor: false,
            useCSS3Transforms: true,
            mousewheelControl: false,
            pagination : $pagination_class,
            paginationClickable: true,
            freeModeFluid: true,
            calculateHeight: dynamicHeight, 
            speed: $speed,
            autoplay: $pause,
            simulateTouch: false,
            autoplayDisableOnInteraction: false,
            onSwiperCreated: function(swiper) {
                var currentSkin = $slider_wrapper.find('.swiper-slide').eq(1).attr("data-skin");
                $($pagination_class).find('span').append('<a href="#"></a>');
                $($pagination_class).attr('data-skin', currentSkin);

                $slider_wrapper.find('.sharp-slider-loading').fadeOut();
            },
            onSlideChangeEnd: function() {
                var currentSlide = $(pacz_swiper.activeSlide()),
                    currentSkin = currentSlide.attr("data-skin");

                    $($pagination_class).attr('data-skin', currentSkin);
            }
        });

        sliderHeight();

        $(window).on('resize', function() {
            setTimeout(function() {
                sliderHeight();
                pacz_swiper.reInit();
                // pacz_swiper.params.calculateHeight = dynamicHeight;
            }, 200);
        });

    });
}
;
/* Swipe Slideshow */
/* -------------------------------------------------------------------- */


function pacz_swipe_slider() {

    $('.pacz-swiper-slider').each(function() {
        var $this = $(this);

        if(!(window.matchMedia("(max-width: 650px)").matches && $this.hasClass('pacz-swipper-scroller'))) {

            if($this.data('state') != 'init') {

                $this.data('state', 'init');
            
                var $thumbs = $this.parent().siblings('.gallery-thumbs-small'),
                    $next_arrow = $this.find('.pacz-swiper-next'),
                    $prev_arrow = $this.find('.pacz-swiper-prev'),
                    $direction = $this.attr('data-direction'),
                    $pagination = $this.attr('data-pagination') === "true" ? true : false,
                    $slideshowSpeed = $this.attr('data-slideshowSpeed'),
                    $animationSpeed = $this.attr('data-animationSpeed'),
                    $animation = $this.attr('data-animation'),
                    //$controlNav = $this.attr('data-controlNav') === "true" ? true : false,
                    //$directionNav = $this.attr('data-directionNav') === "true" ? true : false,
                    $freeModeFluid = $this.attr('data-freeModeFluid') === "true" ? true : false,
                    $freeMode = $this.attr('data-freeMode') === "true" ? true : false,
                    $mousewheelControl = $this.attr('data-mousewheelControl') === "true" ? true : false,
                    $loop = $this.attr('data-loop') === "true" ? true : false,
                    $autoplayStop = $this.attr('data-autoplayStop') === "false" ? false : true,
                    $slidesPerView = $this.attr('data-slidesPerView'),
                    ieCalcFix = 0;

                    // var countSlidesHeight = function() {
                    //     var heights = [];
                    //     $this.find('.swiper-slide').each(function() {
                    //         $(this).height('auto')
                    //         heights.push($(this).height());
                    //     });

                    //     return Math.max.apply(Math, heights)
                    // }

                    // var slidesMaxHeight = countSlidesHeight();

                    var employeesPerView = function() {
                        if($this.hasClass('pacz-employees')) {
                            $slidesPerView = 3;
                            if (window.matchMedia("(max-width: 600px)").matches) {
                                $slidesPerView = 2;
                            }
                        }
                    }

                    employeesPerView();
					
					var causesPerView = function() {
                        if($this.hasClass('pacz-causes')) {
                            $slidesPerView = 3;
                            if (window.matchMedia("(max-width: 600px)").matches) {
                                $slidesPerView = 2;
                            }
                        }
                    }

                    causesPerView();


                if ($pagination === true) {
                    var $pagination_class = '#' + $this.attr('id') + ' .swiper-pagination';
                } else {
                    var $pagination_class = false;
                }

                if(BrowserDetect.browser == 'IE') {
                    $animation = 'slide';
                }

                var pacz_swiper = $(this).swiper({
                    mode: $direction,
                    loop: $loop,
                    freeMode: $freeMode,
                    pagination: $pagination_class,
                    freeModeFluid: $freeModeFluid,
                    autoplay: $slideshowSpeed,
                    speed: $animationSpeed,
                    calculateHeight: true,
                    roundLengths: true,
                    grabCursor: true,
                    progress: true,
                    useCSS3Transforms: true,
					spaceBetween:30,
                    mousewheelControl: $mousewheelControl,
                    mousewheelControlForceToAxis: true,
                    paginationClickable: true,
                    slidesPerView: $slidesPerView,
                    autoplayDisableOnInteraction: $autoplayStop,
                    onSwiperCreated: function(swiper) {
                        pacz_lightbox_init();
                    },
                    onSlideChangeStart: function() {
                        $thumbs.find('.active-item').removeClass('active-item');
                        $thumbs.find('a').eq(pacz_swiper.activeIndex).addClass('active-item');
                    },
                    // onSlideChangeEnd: function(swiper) {
                    //     // console.log(swiper.getWrapperTranslate("x"));
                    // },
                    onProgressChange: function(swiper){
                        for (var i = 0; i < swiper.slides.length; i++){

                            var slide = swiper.slides[i];
                            var progress = slide.progress;

                            if($animation == "fade") {
                                var translateX, opacity, zIndex;

                                    opacity = 1 - Math.min(Math.abs(progress),1);
                                    zIndex = (1 - Math.min(Math.abs(progress),1))*10;
                                    translateX = progress*swiper.width;

                                swiper.setTransform(slide,'translate3d('+translateX+'px,0,0)');
                                slide.style.opacity = opacity;
                                slide.style.zIndex = zIndex;

                            }

                        }

                      },
                      onTouchStart:function(swiper){
                        for (var i = 0; i < swiper.slides.length; i++){
                          swiper.setTransition(swiper.slides[i], 0);
                        }
                      },
                      onSetWrapperTransition: function(swiper, speed) {
                        for (var i = 0; i < swiper.slides.length; i++){
                          swiper.setTransition(swiper.slides[i], speed);
                        }
                      }
                });

                $(window).on("debouncedresize", function() {
                    // var slidesMaxHeight = countSlidesHeight();

                    employeesPerView();
					causesPerView();
                    pacz_swiper.reInit();
                    // $this.parent().height(slidesMaxHeight);
                    // $this.find('.slideshow-swiper-arrows').css({
                    //     'top':  (slidesMaxHeight/2) + 'px'
                    // })
                    pacz_swiper.params.slidesPerView = $slidesPerView;
                });

                // $this.parent().css({
                //         'height': slidesMaxHeight + 'px',
                //         'overflow': 'hidden'
                // });
                // $this.find('.slideshow-swiper-arrows').css({
                //     'top':  (slidesMaxHeight/2) + 'px'
                // })


                $prev_arrow.click(function(e) {
                    pacz_swiper.swipePrev();
                    e.preventDefault();
                });

                $next_arrow.click(function(e) {
                    pacz_swiper.swipeNext();
                    e.preventDefault();
                });



                $thumbs.find('a').on('touchstart mousedown', function(e) {
                    e.preventDefault();
                    $thumbs.find('.active-item').removeClass('active-item');
                    $(this).addClass('active-item');
                    pacz_swiper.swipeTo($(this).index());
                });

                $thumbs.find('a').click(function(e) {
                    e.preventDefault();
                });

            }

        } else {
            $this.addClass('scroller-disabled');
        }


    });

}


function pacz_gallery_thumbs_width() {

    $('.pacz-gallery.thumb-style .gallery-thumbs-small').each(function() {

        var $this = $(this),
            $thumbs_count = $this.children().length,
            $thumbs_width = $thumbs_count * $this.find('a').outerWidth(),
            $container_width = $this.siblings('.gallery-thumb-large').outerWidth();

        if ($thumbs_width > $container_width) {
            $this.find('a').css('width', 100 / $thumbs_count + '%');
        }
    });
};
/* Section Background Parallax Effects */
/* -------------------------------------------------------------------- */

function pacz_section_parallax() {
    if (is_touch_device() || global_window_width < 800) {
        return false;
    }
    $('.pacz-page-section.parallax-true').each(function() {

        var $this = $(this),
            $direction = $this.attr('data-direction'),
            $speedFactor = $this.attr('data-speedFactor');

        if ($direction === 'horizontal_mouse' || $direction === 'vertical_mouse' || $direction === 'both_axis_mouse') {

            var $yparallax = $this.attr('data-direction') === "vertical_mouse" ? true : false,
                $xparallax = $this.attr('data-direction') === "horizontal_mouse" ? true : false,
                $xyparallax = $this.attr('data-direction') === "both_axis_mouse" ? true : false;

            if ($xyparallax === true) {
                $xparallax = true;
                $yparallax = true;
            }


            // $(this).find('.parallax-layer').parallax({
            //     mouseport: $this,
            //     yparallax: $yparallax,
            //     xparallax: $xparallax,
            //     decay: 0.8,
            //     frameDuration: 50
            // });

            /* Page Section parallax */
            /* -------------------------------------------------------------------- */


                var $parallaxContainer = $this; //our container
                var $parallaxItem = $parallaxContainer.find(".parallax-layer"); 
                var fixer = -0.004;     //experiment with the value
                var speedX = 50;                 
                var speedY = 50;

 
                $parallaxContainer.on("mousemove", function(event){  
                    var position = $parallaxContainer.offset();                      
                    var pageX =  $xparallax ? (event.clientX - position.left) - ($parallaxContainer.width() * 0.5) : 0;  
                    var pageY =  $yparallax ? (event.pageY - position.top) - ($parallaxContainer.height() * 0.5) : 0; 
                        

                    TweenLite.to($parallaxItem, 3, { scale: 1.2 });
                    TweenLite.to($parallaxItem, 1, {
                        x: (pageX * speedX)*fixer,     
                        y: (pageY * speedY)*fixer
                      
                    });  
                });     

                $parallaxContainer.on("mouseleave", function() {
                    TweenLite.to($parallaxItem, 60, { x: 0, y: 0, scale: 1 });
                });

        } else {

            // var pacz_skrollr = skrollr.init({
            //     forceHeight: false,
            //     mobileCheck: function() {
            //         return false;
            //     }
            // });
            // pacz_skrollr.refresh($('.pacz-page-section')); 

            var $this = $(this),
                $offset = $this.offset(),
                $speed_factor = 0.16;

         
                if($offset.top > global_window_height) {
                    $speed_factor = 0.2;
                } else {
                    $speed_factor = -0.2;
                }

            if ($direction == 'vertical') $this.parallaxScroll("50%", $speed_factor, 'vertical');
            if ($direction == 'horizontal') $this.parallaxScroll("50%", 0.3, 'horizontal');
        }

    });

}


/*
function pacz_image() {

    $('.pacz-image').each(function() {
        var $this = $(this),
            width = $this.outerWidth(),
            caption_h = $this.find('.pacz-image-hover').outerHeight(),
            caption_w = width - 40;

            //console.log(caption_h);

        $this.find('.pacz-image-hover').css({
            'width': caption_w,
            'margin-top': -(caption_h / 2),
            'margin-left': -(caption_w / 2)
        });
    });
}
*/

function pacz_center_caption() {
    $('.pacz-parent-element').each(function() {
        var $this = $(this),
            width = $this.outerWidth(),
            caption_h = $this.find('.pacz-caption-item').outerHeight(),
            caption_w = width - 120;

        $this.find('.pacz-caption-item').css({
            'width': caption_w,
            'margin-top': -(caption_h / 2),
            'margin-left': -(caption_w / 2)
        });
    });
}


function pacz_employees() {
    $('.pacz-employees.grid-style .pacz-employee-item').each(function() {
        var $this = $(this),
            height = $this.outerHeight();
        $this.find('.team-info-wrapper').css({
            'height': height
        });
    });
}
function pacz_causes() {
    $('.pacz-causes.grid-style .pacz-cause-item').each(function() {
        var $this = $(this),
            height = $this.outerHeight();
        $this.find('.team-info-wrapper').css({
            'height': height
        });
    });
}

function pacz_gallery_image() {

    $('.pacz-gallery-item').each(function() {
        var $this = $(this),
            width = $this.outerWidth(),
            caption_h = $this.find('.gallery-meta').outerHeight(),
            caption_w;

        if (width < 200) {
            caption_w = width;
        } else {
            caption_w = width - 100;
        }
        /*$this.find('.gallery-meta').css({
            'width': caption_w,
            'margin-top': -(caption_h / 2),
            'margin-left': -(caption_w / 2)
        });*/


    });

}

 

/* Tabs */
/* -------------------------------------------------------------------- */

function pacz_tabs() {
    if ($.exists('.pacz-tabs')) {
        $(".pacz-tabs").tabs();

        $('.pacz-tabs').on('click', function () {
	      $('.pacz-theme-loop').isotope('reLayout');
	    });

        $('.pacz-tabs.vertical-style').each(function() {
            var $this = $(this),
                inner_pane = $this.find('.inner-box'),
                tabs_height = $(this).find('.pacz-tabs-tabs').height() + 80;
            inner_pane.css('minHeight', tabs_height);
        });
    }
}

function pacz_tabs_responsive(){
  if ($.exists('.pacz-tabs')) {
    if (window.matchMedia('(max-width: 767px)').matches){
        $(".pacz-tabs").tabs("destroy");
    }
    else {
        pacz_tabs();
    }
  }
}
;/* Blog  Audio */
/* -------------------------------------------------------------------- */

function loop_audio_init() {
    if ($.exists('.jp-jplayer')) {
        $('.jp-jplayer.pacz-blog-audio').each(function() {
            var css_selector_ancestor = "#" + $(this).siblings('.jp-audio').attr('id');
            var ogg_file, mp3_file, pacz_theme_js_path;
            ogg_file = $(this).attr('data-ogg');
            mp3_file = $(this).attr('data-mp3');
            $(this).jPlayer({
                ready: function() {
                    $(this).jPlayer("setMedia", {
                        mp3: mp3_file,
                        ogg: ogg_file
                    });
                },
                play: function() { // To avoid both jPlayers playing together.
                    $(this).jPlayer("pauseOthers");
                },
                swfPath: pacz_theme_js_path,
                supplied: "mp3, ogg",
                cssSelectorAncestor: css_selector_ancestor,
                wmode: "window"
            });
        });
    }
}


/* Initialize isiotop  */
/* -------------------------------------------------------------------- */

function loops_iosotop_init() {

    $('.loop-main-wrapper').each(function() {
        var $this = $(this),
            $pacz_container = $this.find('.pacz-theme-loop'),
            $pacz_container_item = '.' + $pacz_container.attr('data-style') + '-' + $pacz_container.attr('data-uniqid'),
            $load_button = $this.find('.pacz-loadmore-button'),
            $pagination_items = $this.find('.pacz-pagination');



        if ($pacz_container.hasClass('isotop-enabled')) {
            $pacz_container.imagesLoaded(function() {
				$pacz_container.isotope({
					itemSelector: $pacz_container_item,
					animationEngine: "best-available",
					masonry: {
						columnWidth: 1
					}
				});
			});
        }


        $('.pacz-isotop-filter').on('click', 'a', function() {
            var $this;
            $this = $(this);

            /* Removes ajax container when filter items get triggered */
            // $this.parents('.portfolio-grid').find('.ajax-container').animate({
            //     'height': 0,
            //     opacity: 0
            // }, 500);
            TweenLite.to($this.parents('.portfolio-grid').find('.ajax-container'), .5, { height: 0, opacity: 0 });

            if ($this.hasClass('.current')) {
                return false;
            } 
            var $optionSet = $this.parents('.pacz-isotop-filter ul');
            $optionSet.find('.current').removeClass('current');
            $this.addClass('current');

            var selector = $(this).attr('data-filter');

            $pacz_container.isotope({
                filter: ''
            });
            $pacz_container.isotope({
                filter: selector
            });


            return false;
        });



        $load_button.hide();

        if ($this.find('.pacz-theme-loop').hasClass('scroll-load-style') || $this.find('.pacz-theme-loop').hasClass('load-button-style')) {
            if ($pagination_items.length > 0) {
                $load_button.css('display', 'block');
            }
            $pagination_items.hide();


            $load_button.on('click', function() {
                if (!$(this).hasClass('pagination-loading')) {
                    $(this).addClass('pagination-loading');
                }

            });

            $pacz_container.infinitescroll({
                    navSelector: $pagination_items,
                    nextSelector: $this.find('.pacz-pagination a:first'),
                    itemSelector: $pacz_container_item,
                    bufferPx: 70,
                    loading: {
                        finishedMsg: "",
                        msg: null,
                        msgText: "",
                        selector: $load_button,
                        speed: 300,
                        start: undefined
                    },
                    errorCallback: function() {

                        $load_button.html(pacz_no_more_posts).addClass('disable-pagination');

                    },

                },

                function(newElements) {

                    var $newElems = $(newElements);
                    $newElems.imagesLoaded(function() {
                        $load_button.removeClass('pagination-loading');

                        $pacz_container.isotope('appended', $newElems);
                        $pacz_container.isotope({
                            filter: ''
                        });
                        var selected_item = $('.pacz-isotop-filter ul').find('.current').attr('data-filter');
                        $pacz_container.isotope({
                            filter: selected_item
                        });

                        $pacz_container.isotope('reLayout');
                        loop_audio_init();
                        pacz_lightbox_init();
                        pacz_gallery_image();
                        pacz_swipe_slider();
                        pacz_center_caption();
                        ajaxStylesInjector();
                    });
                }

            );



            /* Loading elements based on scroll window */
            if ($this.find('.pacz-theme-loop').hasClass('load-button-style')) {
                $(window).unbind('.infscr');
                $load_button.click(function() {

                    $pacz_container.infinitescroll('retrieve');

                    return false;

                });
            }

        } else {
            $load_button.hide();
        }
    });
}
;
/* Fix isotop layout */
/* -------------------------------------------------------------------- */

function isotop_load_fix() {
    if ($.exists('.pacz-blog-container')) {
        $('.pacz-blog-container>article').each(function(i) {
            $(this).delay(i * 100).animate({
                'opacity': 1
            }, 100);

        }).promise().done(function() {
        	setTimeout(function() {
        		$('.pacz-theme-loop').isotope('reLayout');
        	},500);
        });
    }

}

/* Fix isotop layout */
/* -------------------------------------------------------------------- */



;
/* Event Count Down */
/* -------------------------------------------------------------------- */

function pacz_event_countdown() {
    if ($.exists('.pacz-event-countdown')) {
        $('.pacz-event-countdown').each(function() {
            var $this = $(this),
                $date = $this.attr('data-date'),
                $offset = $this.attr('data-offset');

            $this.downCount({
                date: $date,
                offset: $offset
            });
        });
    }
};
/* Instagram Feed */
/* -------------------------------------------------------------------- */

function pacz_instagram() {
    if ($.exists('.pacz-instagram-feeds')) {

        $('.pacz-instagram-feeds').each(function() {
            var $this = $(this),
                $size = $this.attr('data-size'),
                $sort_by = $this.attr('data-sort'),
                $count = $this.attr('data-count'),
                $userid = parseInt($this.attr('data-userid')),
                $access_token = $this.attr('data-accesstoken'),
                $column = $this.attr('data-column'),
                $id = $this.attr('id');



            var feed = new Instafeed({
                get: "user",
                target: $id,
                resolution: $size,
                sortBy: $sort_by,
                limit: $count,
                userId: $userid,
                accessToken: $access_token,
                template: '<a class="featured-image ' + $column + '-columns" href="{{link}}"><div class="item-holder"><img src="{{image}}" /><div class="hover-overlay"></div></div></a>'
            });
            feed.run();
        });
    }
};/* Accordions */

function pacz_accordion() {

    if ($.exists('.pacz-accordion')) {
        $(".pacz-accordion").each(function() {
            if (window.matchMedia('(max-width: 767px)').matches){

            }else{
                var $this = $(this),
                accordion_section = $this.find('.pacz-accordion-single'),
                all_panes = $this.find('.pacz-accordion-pane').hide();

                accordion_section.first().addClass('current-item').find('.pacz-accordion-pane').slideDown(300);


                $this.find('.pacz-accordion-tab').click(function() {
                    var $this = $(this),
                        $this_item = $this.parent();
                    if (!($this_item.hasClass('current-item'))) {
                        $this_item.siblings().removeClass('current-item').end().addClass('current-item');
                        all_panes.slideUp(300);
                        $this.parent().children('.pacz-accordion-pane').slideDown(300);
                    }
                    return false;
                });
            }
        });
    }

    /* Toggles */

    if ($.exists('.pacz-toggle-title')) {
        if (window.matchMedia('(max-width: 767px)').matches){
            $('.pacz-toggle-title').next().css('display', 'block');
        }else{
            $(".pacz-toggle-title").toggle(
                function() {
                    $(this).addClass('active-toggle');
                    $(this).siblings('.pacz-toggle-pane').slideDown("fast");
                },

                function() {
                    $(this).removeClass('active-toggle');
                    $(this).siblings('.pacz-toggle-pane').slideUp("fast");
                }
            );   
        }
    }
}
;/* Social Share */
/* -------------------------------------------------------------------- */

function pacz_social_share() {


    $('.twitter-share').on('click', function() {
        var $url = $(this).attr('data-url'),
            $title = $(this).attr('data-title');

        window.open('http://twitter.com/intent/tweet?text=' + $title + ' ' + $url, "twitterWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    $('.pinterest-share').on('click', function() {
        var $url = $(this).attr('data-url'),
            $title = $(this).attr('data-title'),
            $image = $(this).attr('data-image');
        window.open('http://pinterest.com/pin/create/button/?url=' + $url + '&media=' + $image + '&description=' + $title, "twitterWindow", "height=320,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    $('.facebook-share').on('click', function() {
        var $url = $(this).attr('data-url');
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + $url, "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    $('.googleplus-share').on('click', function() {
        var $url = $(this).attr('data-url');
        window.open('https://plus.google.com/share?url=' + $url, "googlePlusWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });

    $('.linkedin-share').on('click', function() {
        var $url = $(this).attr('data-url');
        var $title = $(this).attr('data-title');
        window.open('http://www.linkedin.com/shareArticle?mini=true&url='+ $url +'&title=' + $title , "linkedinWindow", "height=520,width=570,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0");
        return false;
    });
};/* Typer */
/* -------------------------------------------------------------------- */
function pacz_text_typer() {
    $('[data-typer-targets]').each(function() {
        var $this = $(this),
            $first_string = [$this.text()],
            $rest_strings = $this.attr('data-typer-targets').split(','),
            $strings = $first_string.concat($rest_strings);

        $this.text('');

        $this.typed({
            strings: $strings,
            typeSpeed: 30, // typing speed
            backDelay: 1200, // pause before backspacing
            loop: true, // loop on or off (true or false)
            loopCount: false, // number of loops, false = infinite
        });
    });
}

;/* Process Steps */
/* -------------------------------------------------------------------- */

function pacz_process_steps() {
    if ($.exists('.pacz-process-steps.horizontal')) {

        $('.pacz-process-steps.horizontal').each(function() {

            var $this = $(this),
                $tabs = $this.find('.step-items'),
                $panes = $this.find('.step-panes'),
                $panes_responsive = $this.find('.step-panes-responsive');

            $tabs.find('li').first().addClass('active-step-item');

            $panes.css('height', $panes.find('.pacz-step').first().outerHeight() + 30);
            $panes.find('.pacz-step').first().addClass('active-step');


            $tabs.find('span').hoverIntent(function() {
                var $this_id = $(this).attr('data-id'),
                    $this_pane = $panes.find('div[id^="' + $this_id + '"]'),
                    $pane_height = $this_pane.outerHeight() + 30;

                $(this).parent().siblings('li').removeClass('active-step-item').end().addClass('active-step-item');

                $panes.css('height', $pane_height);
                $panes.find('.pacz-step').removeClass('active-step'); 
                $this_pane.addClass('active-step');
            });

            

        });

    }
}
;/* Page Section full height feature */
/* -------------------------------------------------------------------- */

function section_to_full_height() {

    $('.full-height-true.pacz-page-section').each(function() {
        var $this = $(this),
            $content_height = $this.find('.page-section-content').outerHeight();

        if ($.exists("#pacz-header") && !$('#pacz-header').hasClass('header-structure-vertical') && !$('#pacz-header').hasClass('transparent-header')) {
            if ($('#pacz-header').hasClass('sticky-trigger-header')) {
                var pacz_header = parseInt($("#pacz-header").attr('data-sticky-height'));
            } else {
                var pacz_header = parseInt($("#pacz-header").attr('data-height'));
            }

        } else {
            var pacz_header = 0;
        }
        //console.log(global_admin_bar_height + " " + pacz_header);

        var window_height = global_window_height - global_admin_bar_height - pacz_header;

        if(pacz_header_structure == 'margin'){
          var window_height = global_window_height - global_admin_bar_height - pacz_header - 40;
        }else{
          var window_height = global_window_height - global_admin_bar_height - pacz_header;
        }


        if ($content_height > global_window_height) {
            $this.css('height', 'auto');
            $this.find('.page-section-content').css({
                'padding-top': 30,
                'padding-bottom': 30
            });
        } else {
            $this.css('height', window_height);

            var $this_height_half = $this.find('.page-section-content').outerHeight() / 2,
                $window_half = window_height / 2;

            $this.find('.page-section-content').css('marginTop', ($window_half - $this_height_half));

        }

        $this.find('.pacz-page-section-loader').fadeOut();

    });
   
}



/* Page Section Intro Effects */
/* -------------------------------------------------------------------- */

function pacz_section_intro_effects() {
  if ( !is_touch_device() || BrowserDetect.browser == "IE" ) {
    if($.exists('.pacz-page-section.intro-true')) {
      var IEpadding = (BrowserDetect.browser == "IE") ? 50 : 0;

      $('.pacz-page-section.intro-true').each(function() {
          var $this = $(this),
              // pageCnt = $('.theme-page-wrapper'),
              $pageCnt = $this.nextAll('div'),
              windowHeight = abb.fullHeight(),
              effectName = $this.attr('data-intro-effect'),
              $header = $('#pacz-header'),
              header_height = 0;

          if ($header.length && !$('#pacz-header').hasClass('header-structure-vertical')) {
              header_height += parseInt($header.attr('data-sticky-height')) + 50;
          }


          var effect = {
              fade :     new TimelineLite({paused: true})
                        .set($pageCnt, { opacity: 0, y: (windowHeight * 0.3) })
                        .set($pageCnt.first(), { paddingTop: header_height })
                        .to($this, 1, { opacity: 0, ease:Power2.easeInOut })
                        .set($this, { display: "none" })
                        .to($pageCnt, 1, { opacity: 1, y: 0, ease:Power2.easeInOut}, "-=.7"),

              zoom_out : new TimelineLite({paused: true})
                        .set($pageCnt, { opacity: 0, y: (windowHeight * 0.3) })
                        .set($pageCnt.first(), { paddingTop: header_height })
                        .to($this, 1.5, { opacity: .8, scale: 0.8, y: -windowHeight - 100, ease:Strong.easeInOut })
                        .set($this, { display: "none" })
                        .to($pageCnt, 1.5, { opacity: 1, y: 0, ease:Strong.easeInOut}, "-=1.3"),

              shuffle :  new TimelineLite({paused: true})
                        .to($this, 1.5, { y: -windowHeight/2, ease:Strong.easeInOut })
                        .to($this.nextAll('div').first(), 1.5, { paddingTop: (windowHeight/2 + 50), ease:Strong.easeInOut }, "-=1.3")
          }

          $this.sectiontrans({
            effect : effectName,
          });

          $('body').on('page_intro', function() {
            effect[effectName].play();
          });

          $('body').on('page_outro', function() {
            effect[effectName].reverse();
          });

      });
    }
  } else {
    $('.pacz-page-section.intro-true').each(function() {
      $(this).attr('data-intro-effect', '');
    });
  }
};
/* Expandable Page Sections */
/* -------------------------------------------------------------------- */

function pacz_expandable_page_section() {



    $('.section-expandable-true').each(function() {

        var $container = $(this).find('.pacz-padding-wrapper').hide();

        $(this).on('click', function() {
            var $this = $(this);
            if (!$this.hasClass('active-toggle')) {
                 $this.addClass('active-toggle');
                $container.slideDown(500);
            }
            setTimeout(function() {
                //pacz_image();
                pacz_lightbox_init();
            }, 1000);
        });

    });


    $(".section-expandable-true").on('click', function(event) {
        if (event.stopPropagation) {
          event.stopPropagation();
        } else if (window.event) {
          window.event.cancelBubble = true;
        }
    });

    $('body').on('click', function() {
        $('.section-expandable-true').removeClass('active-toggle');
        $('.section-expandable-true .pacz-padding-wrapper').slideUp(400);
    });

}
;

/* Flickr Feeds */
/* -------------------------------------------------------------------- */

function pacz_flickr_feeds() {

    $('.pacz-flickr-feeds').each(function() {
        var $this = $(this),
            apiKey = $this.attr('data-key'),
            userId = $this.attr('data-userid'),
            perPage = $this.attr('data-count');

        jQuery.getJSON('https://api.flickr.com/services/rest/?format=json&method=' + 'flickr.photos.search&api_key=' + apiKey + '&user_id=' + userId + '&&per_page=' + perPage + '&jsoncallback=?', function(data) {

            jQuery.each(data.photos.photo, function(i, rPhoto) {
                var basePhotoURL = 'http://farm' + rPhoto.farm + '.static.flickr.com/' + rPhoto.server + '/' + rPhoto.id + '_' + rPhoto.secret;

                var thumbPhotoURL = basePhotoURL + '_q.jpg';
                var mediumPhotoURL = basePhotoURL + '.jpg';

                var photoStringStart = '<a ';
                var photoStringEnd = 'title="' + rPhoto.title + '" rel="flickr-feeds" class="pacz-lightbox featured-image" href="' + mediumPhotoURL + '"><img src="' + thumbPhotoURL + '" alt="' + rPhoto.title + '"/><div class="hover-overlay"></div></a>;';
                var photoString = (i < perPage) ? photoStringStart + photoStringEnd : photoStringStart + photoStringEnd;

                jQuery(photoString).appendTo($this);
            });
        });
    });

}
pacz_flickr_feeds();
;
/* Flexslider init */
/* -------------------------------------------------------------------- */

function pacz_flexslider_init() {


    $('.pacz-flexslider.pacz-script-call').each(function() {

        if ($(this).parents('.pacz-tabs').length || $(this).parents('.pacz-accordion').length) {
            $(this).removeData("flexslider");
        }


        var $this = $(this),
            $selector = $this.attr('data-selector'),
            $animation = $this.attr('data-animation'),
            $easing = $this.attr('data-easing'),
            $direction = $this.attr('data-direction'),
            $smoothHeight = $this.attr('data-smoothHeight') == "true" ? true : false,
            $slideshowSpeed = $this.attr('data-slideshowSpeed'),
            $animationSpeed = $this.attr('data-animationSpeed'),
            $controlNav = $this.attr('data-controlNav') == "true" ? true : false,
            $directionNav = $this.attr('data-directionNav') == "true" ? true : false,
            $pauseOnHover = $this.attr('data-pauseOnHover') == "true" ? true : false,
            $isCarousel = $this.attr('data-isCarousel') == "true" ? true : false;

        if ($selector != undefined) {
            var $selector_class = $selector;
        } else {
            var $selector_class = ".pacz-flex-slides > li";
        }

        if ($isCarousel == true) {
            var $itemWidth = parseInt($this.attr('data-itemWidth')),
                $itemMargin = parseInt($this.attr('data-itemMargin')),
                $minItems = parseInt($this.attr('data-minItems')),
                $maxItems = parseInt($this.attr('data-maxItems')),
                $move = parseInt($this.attr('data-move'));
        } else {
            var $itemWidth = $itemMargin = $minItems = $maxItems = $move = 0;
        }

        $this.flexslider({
            selector: $selector_class,
            animation: $animation,
            easing: $easing,
            direction: $direction,
            smoothHeight: $smoothHeight,
            slideshow: true,
            slideshowSpeed: $slideshowSpeed,
            animationSpeed: $animationSpeed,
            controlNav: $controlNav,
            directionNav: $directionNav,
            pauseOnHover: $pauseOnHover,
            prevText: "",
            nextText: "",

            itemWidth: $itemWidth,
            itemMargin: $itemMargin,
            minItems: $minItems,
            maxItems: $maxItems,
            move: $move,
        });

    });

}

function pacz_fade_onload() {

    $(".pacz-mobile-image").fadeIn();
    $(".pacz-tablet-image").fadeIn();
}
;/* Sharp One Pager */
/* -------------------------------------------------------------------- */
function pacz_one_page_scroller() {
    $('.pacz-sharp-one-pager').each(function() {

        var $this = $(this),
            $tooltip_txt = [],
            $navigation = $this.attr('data-navigation') == "true" ? true : false;

        $this.find('.section').each(function() {
            $tooltip_txt.push($(this).attr('data-title'));
        });

        var $header_height = 0;
        if ($.exists('#pacz-header.sticky-header') && !$('#pacz-header').hasClass('transparent-header')) {
            var $header_height = parseInt($('#pacz-header.sticky-header').attr('data-sticky-height'));
        }

        var global_window_height = $(window).height() - $header_height - global_admin_bar_height;

        var scrollable = true;
        $this.find('.section').each(function() {
            var $section = $(this),
                $content = $section.find('.sharp-slide-content'),
                sectionHeight = $section.height(),
                contentHeight = $content.innerHeight();

            if((contentHeight + 30) > global_window_height) {
                scrollable = false;
            }
        });

        if(!scrollable){
            $this.find('.section').each(function() {
                var $section = $(this);
                $section.addClass('active').css({
                    'padding-bottom': '50px'
                });
            });
        }

        if(scrollable) {
            $this.fullpage({
                verticalCentered: false,
                resize: true,
                slidesColor: ['#ccc', '#fff'],
                anchors: $tooltip_txt,
                scrollingSpeed: 600,
                easing: 'easeInQuart',
                menu: false,
                navigation: $navigation,
                navigationPosition: 'right',
                navigationTooltips: false,
                slidesNavigation: true,
                slidesNavPosition: 'bottom',
                loopBottom: false,
                loopTop: false,
                loopHorizontal: true,
                autoScrolling: true,
                scrollOverflow: true,
                css3: true,
                paddingTop: 0,
                paddingBottom: 0,
                normalScrollElements: '',
                normalScrollElementTouchThreshold: 5,
                keyboardScrolling: true,
                touchSensitivity: 15,
                continuousVertical: false,
                animateAnchor: true,

                //events
                onLeave: function(index, nextIndex, direction) {

                    if (!$('#pacz-header').hasClass('transparent-header-sticky')) {
                        $('#pacz-header.transparent-header').removeClass('light-header-skin dark-header-skin').addClass($this.find('.one-pager-slide').eq(nextIndex - 1).attr('data-header-skin') + '-header-skin');

                        $('#fullPage-nav').removeClass('light-skin dark-skin').addClass($this.find('.one-pager-slide').eq(nextIndex - 1).attr('data-header-skin') + '-skin');
                    }

                },
                afterLoad: function(anchorLink, index) {

                },
                afterRender: function() {
                    if (!$('#pacz-header').hasClass('transparent-header-sticky')) {
                        var $slides = $this.find('.one-pager-slide'),
                            active = $slides.index('.active'),
                            pagination = $this.attr('data-pagination');
                        setTimeout(function() {
                            $('#pacz-header.transparent-header').removeClass('light-header-skin dark-header-skin').addClass($this.find('.one-pager-slide').eq(0).attr('data-header-skin') + '-header-skin');
                            $('#fullPage-nav').removeClass('light-skin dark-skin').addClass(' pagination-' + pagination).attr('data-skin', $slides.eq(active).attr('data-header-skin'));
                        }, 300);
                    }

                },
                afterResize: function() {},
                afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex) {



                },
                onSlideLeave: function(anchorLink, index, slideIndex, direction) {

                } // You can now define the direction of the One Page Scroll animation. Options available are "vertical" and "horizontal". The default value is "vertical".  
            });
        }

        // $this.find('.section').each(function() {
        //     var $section = $(this),
        //         $content = $section.find('.pacz-grid'),
        //         sectionHeight = $section.height(),
        //         contentHeight = $content.height();

        //         var i = 0;
        //         console.log('section ' + i + ' / ' + sectionHeight + ' / ' + contentHeight);

        //     if((contentHeight + 90) > sectionHeight) {
        //         $content.wrap('<div class="scrollable"></div>');
        //         $content.prepend('<div class="pacz-one-pager-prev"></div>')
        //                  .append('<div class="pacz-one-pager-next"></div>');
        //         $content.find('.sharp-slide-content').css({
        //                     'padding-bottom': '100px'
        //                  });

        //             $section.find('.pacz-one-pager-prev').each(function() {
        //                 $(this).on('inview', function(event, visible) {
        //                     if(visible == true) {
        //                         $section.data('prev', true)
        //                     } else {
        //                         $section.data('prev', false)
        //                     }
        //                     console.log('Can I go to prev? ' + $section.data('prev'));
        //                 });
        //             });

        //             $section.find('.pacz-one-pager-next').each(function() {
        //                 $(this).on('inview', function(event, visible) {
        //                     if(visible == true) {
        //                         $section.data('next', true);
        //                     } else {
        //                         $section.data('next', false);                               
        //                     }
        //                     console.log('Can I go to next? ' + $section.data('next')); 
        //                 });
        //             });  

        //             var lastY;

        //             // $(document).on('touchmove', function (e){
        //             //      var currentY = e.originalEvent.touches[0].clientY;
        //             //      if(currentY > lastY){
        //             //          // moved down
        //             //      }else if(currentY < lastY){
        //             //          // moved up
        //             //      }
        //             //      lastY = currentY;
        //             // });

        //             $section.find('.scrollable').on('scroll touchmove', function (){
        //                  var currentY = $(this).scrollTop();
        //                  if(currentY > lastY){
        //                      if($section.data('next')) {
        //                             $section.data('next', false);
        //                             setTimeout(function() {
        //                                 $.fn.fullpage.moveSectionDown();
        //                             }, 500);
        //                      }
        //                  } else if(currentY < lastY  ){
        //                      if($section.data('prev')) {
        //                             $section.data('prev', false);
        //                             setTimeout(function() {
        //                                 $.fn.fullpage.moveSectionUp();
        //                             }, 500);
        //                      }
        //                  }
        //                  lastY = currentY;
        //                  console.log(lastY);
        //             });
        //     }
        // });
    });
}


function pacz_one_pager_resposnive() {


    $('.pacz-sharp-one-pager').each(function() {
        var $this = $(this),
            $header_height = 0;

        if ($.exists('#pacz-header.sticky-header') && !$('#pacz-header').hasClass('transparent-header')) {
            var $header_height = parseInt($('#pacz-header.sticky-header').attr('data-sticky-height'));
        }

        var global_window_height = $(window).height() - $header_height - global_admin_bar_height;


        $this.find('.one-pager-slide').each(function() {
            var $this = $(this),
                $content = $this.find('.sharp-slide-content');

            if ($this.hasClass('left_center') || $this.hasClass('center_center') || $this.hasClass('right_center')) {

                var $this_height_half = $content.outerHeight() / 2,
                    $window_half = global_window_height / 2,
                    $distance_from_top =  ($window_half - $this_height_half),
                    $distance_from_top = ($distance_from_top < 50) ? 50 : $distance_from_top;


                $content.css('marginTop', $distance_from_top);
            }

            if ($this.hasClass('left_bottom') || $this.hasClass('center_bottom') || $this.hasClass('right_bottom')) {

                var $distance_from_top = global_window_height - $content.outerHeight() - 90,
                    $distance_from_top = ($distance_from_top < 50) ? 50 : $distance_from_top;

                $content.css('marginTop', $distance_from_top);
            }

        });
    });

}
;
var equalheight = function(container){ 

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPosition = $el.position().top;

   if (currentRowStart != topPosition) {
     for (var currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPosition;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

/* Animated Columns */
    /* -------------------------------------------------------------------- */
    function pacz_animated_columns() {

        function prepareCols() {

            equalheight('.vc_row .animated-column-title');
            equalheight('.vc_row .animated-column-desc');

            $('.pacz-animated-columns').each(function() {
                var $this = $(this);

                if ($this.hasClass('full-style')) {
                    $this.find('.animated-column-item').each(function() {
                        var $this = $(this),
                            contentHeight = $this.find('.animated-column-icon').innerHeight() + $this.find('.animated-column-title').innerHeight() + $this.find('.animated-column-desc').innerHeight() + $this.find('.animated-column-btn').innerHeight();

                        $this.height(contentHeight * 1.5 + 50);

                        var $box_height = $this.outerHeight(true),
                            $icon_height = $this.find('.animated-column-icon').height();

                        $this.find('.animated-column-holder').css({
                            'paddingTop': $box_height / 2 - ($icon_height)
                        });


                        $this.animate({opacity:1}, 300);
                    });
                } else {
                    $this.find('.animated-column-item').each(function() {
                        var $this = $(this),
                            $half_box_height = $this.outerHeight(true) / 2,
                            $icon_height = $this.find('.animated-column-icon').outerHeight(true)/2,
                            $title_height = $this.find('.animated-column-simple-title').outerHeight(true)/2;

                        $this.find('.animated-column-holder').css({
                            'paddingTop': $half_box_height - $icon_height
                        });
                        $this.find('.animated-column-title').css({
                            'paddingTop': $half_box_height - $title_height
                        });

                        $this.animate({opacity:1}, 300);

                    });
                }

            });
        }
        prepareCols();

        $(window).on("resize", function() {
            prepareCols();
        });

        $(".pacz-animated-columns.full-style .animated-column-item").hover(
            function() {
                TweenLite.to($(this).find(".animated-column-holder"), 0.5, {
                    top: '-15%',
                    ease: Back.easeOut
                });
                TweenLite.to($(this).find(".animated-column-desc"), 0.5, {
                    top: '-50%',
                    ease: Expo.easeOut
                }, 0.4);
                TweenLite.to($(this).find(".animated-column-btn"), 0.3, {
                    top: '-50%',
                    ease: Expo.easeOut
                }, 0.6);
            },
            function() {

                TweenLite.to($(this).find(".animated-column-holder"), 0.5, {
                    top: '0%',
                    ease: Back.easeOut, easeParams:[3]
                });
                TweenLite.to($(this).find(".animated-column-desc"), 0.5, {
                    top: '100%',
                    ease: Back.easeOut
                }, 0.4);
                TweenLite.to($(this).find(".animated-column-btn"), 0.5, {
                    top: '100%',
                    ease: Back.easeOut
                }, 0.2);
            }
        );

        $(".pacz-animated-columns.simple-style .animated-column-item, .pacz-animated-columns.simple_text-style .animated-column-item").hover(
            function() {
                var colHolderHeight = $(this).height(); 
                TweenLite.to($(this).find(".animated-column-holder"), 0.7, {
                    y: colHolderHeight,
                    ease: Expo.easeOut
                });
                TweenLite.to($(this).find(".animated-column-title"), 0.7, {
                    y: colHolderHeight,
                    ease: Back.easeOut
                }, 0.2);
            },
            function() {
                TweenLite.to($(this).find(".animated-column-holder"), 0.7, {
                    y: 0,
                    ease: Expo.easeOut
                });
                TweenLite.to($(this).find(".animated-column-title"), 0.7, {
                    y: 0,
                    ease: Back.easeOut
                }, 0.2);
            }
        );

    }
    ;$(document).ready(function() {

    pacz_go_to_top();
    pacz_instagram();
    pacz_main_navigation_functions();
    // pacz_main_navigation();
    sticky_header();
    transparent_header_sticky();
    loop_audio_init();
    pacz_header_margin_style();
    pacz_social_share();
    pacz_google_maps();
    pacz_event_countdown();
    pacz_text_typer();
    pacz_flexslider_init();
    pacz_one_page_scroller();
    pacz_one_pager_resposnive();
    pacz_child_ul_toggle_event();
    pacz_responsive_header_toolbar();
    pacz_header_checkout();
    

    $(window).load(function() {
        pacz_update_globals();
        pacz_animated_columns();
        pacz_fade_onload();
        pacz_lightbox_init();
		//isotop_load_fix2();
        //pacz_image();
        pacz_gallery_image();
        pacz_window_scroller();
        pacz_expandable_page_section();
        pacz_accordion();
        pacz_employees();
		pacz_causes();
        pacz_process_steps();
        pacz_gallery_thumbs_width();
        pacz_sharp_slider_init();
        pacz_sharp_slider_resposnive();
        pacz_tab_slider();
        pacz_swipe_slider();
        pacz_hash_scroll();
        pacz_center_caption();
        loops_iosotop_init();
        isotop_load_fix();
        pacz_page_title_intro();
        pacz_section_intro_effects();
        pacz_secondary_header_res();
        pacz_tabs();
        secondary_header();
        //scrollAnimations(); 
        pacz_theatre_responsive_calculator();
        pacz_mobile_tablet_responsive_calculator();
        pacz_button_animation();
        pacz_tabs_responsive();
        pacz_header_wpml();
        pacz_vertical_menu_submenu();
        pacz_theatre_autoplay_freeze();
        pacz_imagebox_autoplay_freeze();
        pacz_section_parallax();
        shop_isotop_init();
        shop_categories_isotop_init();
        pacz_one_pager_resposnive();
        pacz_main_nav_scroll();
        section_to_full_height();
    });



    $(window).on("debouncedresize", function() {
        pacz_update_globals();
        //pacz_portfolio_masonry();
        //pacz_image();
        section_to_full_height();
        pacz_main_navigation_functions();
        pacz_employees();
		pacz_causes();
        pacz_window_scroller();
        pacz_section_parallax();
        pacz_section_intro_effects();
        // pacz_page_title_intro();
        pacz_secondary_header_res();
        secondary_header();
        pacz_center_caption();
        pacz_one_pager_resposnive();
        pacz_theatre_responsive_calculator();
        pacz_mobile_tablet_responsive_calculator();
        transparent_header_sticky();
        sticky_header();
        pacz_tabs_responsive();
        pacz_responsive_header_toolbar();
        pacz_main_nav_scroll();
    });


    /* Floating Go to top Link */
    /* -------------------------------------------------------------------- */
    $('.pacz-go-top, .pacz-back-top-link').on('click', function(e) {
        e.preventDefault();
        // TweenLite.to(window, .8, {
        //     scrollTo: {
        //         y: 0
        //     },
        //     ease: Expo.easeInOut
        // });
        $("html, body").animate({
          scrollTop: 0
          }, 800);
       // console.log('click');
    });

    function pacz_go_to_top() {
        var pacz_go_top = $('.pacz-go-top');
        var pacz_quick_mail = $('.quick-button-container');
        var animationSet = function() {
            if (scrollY > 700) {
                pacz_go_top.removeClass('off').addClass('on');
                pacz_quick_mail.removeClass('go-right').addClass('go-left');
            } else {
                pacz_go_top.removeClass('on').addClass('off');
                pacz_quick_mail.removeClass('go-left').addClass('go-right');
            }
        }
        debouncedScrollAnimations.add(animationSet);
    }



    /* Love This */
    /* -------------------------------------------------------------------- */

    function pacz_love_post() {

        $('body').on('click', '.pacz-love-this', function() {
            var $this = $(this),
                $id = $this.attr('id');

            if ($this.hasClass('item-loved')) {
                return false;
            }

            if ($this.hasClass('item-inactive')) {
                return false;
            }

            var $sentdata = {
                action: 'pacz_love_post',
                post_id: $id
            };

            $.post(ajaxurl, $sentdata, function(data) {
                $this.find('span').html(data);
                $this.addClass('item-loved');
            });

            $this.addClass('item-inactive');
            return false;
        });


    }

    pacz_love_post();



    /* Element Click Events */
    /* -------------------------------------------------------------------- */
    function mobilecheck() {
        var check = false;
        (function(a) {
            if (/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true
        })(navigator.userAgent || navigator.vendor || window.opera);
        return check;
    }


    /* Margin Header Style */
    /* -------------------------------------------------------------------- */


    function pacz_header_margin_style() {

        var eventtype = mobilecheck() ? 'touchstart' : 'click';


        $('.pacz-margin-header-burger').on(eventtype, function() {
            var $this = $(this),
                $mainNav = $('#pacz-main-navigation');
            if (!$this.hasClass('active-burger')) {
                $this.addClass('active-burger');
                $mainNav.addClass('show-menu');
            } else {
                $this.removeClass('active-burger');
                $mainNav.removeClass('show-menu');
            }

        });

    }


    /* Product Category Accordion */
    /* -------------------------------------------------------------------- */
    function pacz_child_ul_toggle_event() {
        $('.widget_product_categories ul > .cat-item').each(function() {

            var $this = $(this),
                $subLevel = $this.find('ul');

            if ($this.hasClass('cat-parent')) {
                $this.hoverIntent({
                    over: function() {
                        $subLevel.slideDown(500);
                    },
                    out: function() {
                        $subLevel.slideUp(500);
                    },
                    timeout: 1000
                });
            }

        });
    }

    /* Fancy Link Button Hover Animation */
    /* -------------------------------------------------------------------- */
    function pacz_button_animation() {
        $('.fancy_link-button').each(function() {

            var $this = $(this),
                $line = $this.find('.line');

            $this.hoverIntent({
                over: function() {
                    $line.css({
                        'width': '100%',
                        'right': 'auto',
                        'left': '0',
                    });
                },
                out: function() {
                    $line.css({
                        'width': '0',
                        'right': '0',
                        'left': 'auto',
                    });
                },
                timeout: 100
            });

        });
    }



    /* Theatre Slider Autoplay freeze */
    /* -------------------------------------------------------------------- */

    function pacz_theatre_autoplay_freeze() {
        $(".theatre-slider-container.autoplay-true").each(function() {
            var $container = $(this),
                $source = $container.data('source'),
                player;


            if ($source == 'self_hosted') {
                player = $container.find('video')[0];
            }
            if ($source == 'youtube') {
                var youtube = $container.find('iframe')[0];
                player = new YT.Player(youtube);
            }
            if ($source == 'vimeo') {
                var vimeo = $container.find('iframe')[0];
                player = $f(vimeo);
            }


            $container.on('inview', function(event, visible) {
                if (visible == true) {
                    if ($source == 'self_hosted') {
                        player.play();
                    }
                    if ($source == 'youtube') {
                        player.playVideo();
                    }
                    if ($source == 'vimeo') {
                        player.api('play');
                    }
                } else {
                    if ($source == 'self_hosted') {
                        player.pause();
                    }
                    if ($source == 'youtube') {
                        player.pauseVideo();
                    }
                    if ($source == 'vimeo') {
                        player.api('pause');
                    }
                }
            });
        });
    }

    /* Theatre Slider Responsive Calculator */
    /* -------------------------------------------------------------------- */

    function pacz_theatre_responsive_calculator() {
        var $laptopContainer = $(".laptop-theatre-slider");
        var $computerContainer = $(".computer-theatre-slider");

        if ($.exists('.laptop-theatre-slider')) {
            $laptopContainer.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 32,
                    $paddingRight = 110,
                    $paddingBottom = 47,
                    $paddingLeft = 110;

                var $player = $this.find('.player-container');

                if ($windowWidth > $width) {
                    $player.css({
                        'padding-left': ($width * $paddingLeft) / 920,
                        'padding-right': ($width * $paddingRight) / 920,
                        'padding-top': ($height * $paddingTop) / 536,
                        'padding-bottom': ($height * $paddingBottom) / 536,
                    });
                }

            });
        }

        if ($.exists('.computer-theatre-slider')) {
            $computerContainer.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 37,
                    $paddingRight = 35,
                    $paddingBottom = 190,
                    $paddingLeft = 38;

                var $player = $this.find('.player-container');

                if ($windowWidth > $width) {
                    $player.css({
                        'padding-left': ($width * $paddingLeft) / 920,
                        'padding-right': ($width * $paddingRight) / 920,
                        'padding-top': ($height * $paddingTop) / 705,
                        'padding-bottom': ($height * $paddingBottom) / 705,
                    });
                }

            });
        }

    }

    /* Mobile and Tablet Slideshow Responsive Calculator */
    /* -------------------------------------------------------------------- */
    function pacz_mobile_tablet_responsive_calculator() {
        var $mobilePortrait = $(".pacz-mobile-slideshow.portrait-style");
        var $mobileLandscape = $(".pacz-mobile-slideshow.landscape-style");
        var $tabletPortrait = $(".pacz-tablet-slideshow");

        if ($.exists(".pacz-mobile-slideshow.portrait-style")) {
            $mobilePortrait.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 106,
                    $paddingRight = 25,
                    $paddingBottom = 100,
                    $paddingLeft = 30;

                var $player = $this.find(".slideshow-container");

                $player.css({
                    "padding-left": ($width * $paddingLeft) / 357,
                    "padding-right": ($width * $paddingRight) / 357,
                    "padding-top": ($height * $paddingTop) / 741,
                    "padding-bottom": ($height * $paddingBottom) / 735,
                });

            });
        }

        if ($.exists(".pacz-mobile-slideshow.landscape-style")) {
            $mobileLandscape.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 40,
                    $paddingRight = 125,
                    $paddingBottom = 40,
                    $paddingLeft = 135;

                var $player = $this.find(".slideshow-container");
                $player.css({
                    "padding-left": ($width * $paddingLeft) / 902,
                    "padding-right": ($width * $paddingRight) / 902,
                    "padding-top": ($height * $paddingTop) / 436,
                    "padding-bottom": ($height * $paddingBottom) / 436,
                });
            });
        }

        if ($.exists(".pacz-tablet-slideshow")) {
            $tabletPortrait.each(function() {
                var $this = $(this),
                    $window = $(window),
                    $windowWidth = $window.outerWidth(),
                    $windowHeight = $window.outerHeight(),
                    $width = $this.outerWidth(),
                    $height = $this.outerHeight(),
                    $paddingTop = 78,
                    $paddingRight = 36,
                    $paddingBottom = 83,
                    $paddingLeft = 30;

                var $player = $this.find(".slideshow-container");
                $player.css({
                    "padding-left": ($width * $paddingLeft) / 501,
                    "padding-right": ($width * $paddingRight) / 501,
                    "padding-top": ($height * $paddingTop) / 739,
                    "padding-bottom": ($height * $paddingBottom) / 739,
                });
            });
        }
    }

    /* Imagebox Video Player Autoplay Freeze
    /* -------------------------------------------------------------------- */

    function pacz_imagebox_autoplay_freeze() {
        $(".pacz-image-box.autoplay-true").each(function() {
            var $container = $(this),
                $source = $container.data('source'),
                player;


            if ($source == 'self_hosted') {
                player = $container.find('video')[0];
            }
            if ($source == 'youtube') {
                var youtube = $container.find('iframe')[0];
                player = new YT.Player(youtube);
            }
            if ($source == 'vimeo') {
                var vimeo = $container.find('iframe')[0];
                player = $f(vimeo);
            }


            $container.on('inview', function(event, visible) {
                if (visible == true) {
                    if ($source == 'self_hosted') {
                        player.play();
                    }
                    if ($source == 'youtube') {
                        player.playVideo();
                        player.mute();
                    }
                    if ($source == 'vimeo') {
                        player.api('play');
                        player.api('setVolume', 0);
                    }
                } else {
                    if ($source == 'self_hosted') {
                        player.pause();
                    }
                    if ($source == 'youtube') {
                        player.pauseVideo();
                    }
                    if ($source == 'vimeo') {
                        player.api('pause');
                    }
                }
            });
        });
    }

    function shop_isotop_init() {
        if ($.exists('.products') && !$('.products').hasClass('related')) {
            $('.products.isotope-enabled').each(function() {
                //console.log('shop_isotop_init_inside');
                if (!$(this).parents('.pacz-woocommerce-carousel').length) {
                    var $woo_container = $(this),
                        $container_item = '.products .product';

                    $woo_container.isotope({
                        itemSelector: $container_item,
                        masonry: {
                            columnWidth: 1
                        }
                    });
                }
            });
        }
    }

    function shop_categories_isotop_init() {
        if ($.exists('.pacz-product-categories')) {
            $('.pacz-product-categories-list').each(function() {
                //console.log('shop_isotop_init_inside');
                var $woo_container = $(this),
                    $container_item = '.pacz-product-categories-list .product-item';

                $woo_container.isotope({
                    itemSelector: $container_item,
                    masonry: {
                        columnWidth: 1
                    }
                });
            });
        }
    }



    /* Vertical Menu Accordion */
    /* -------------------------------------------------------------------- */
    function pacz_vertical_menu_submenu() {
        if ($.exists(".vertical-header")) {
            $('.pacz-vertical-menu .menu-item').hoverIntent({
                over: function() {
                    if ($(this).is('.menu-item-has-children')) {
                        $(this).find('> .sub-menu').slideToggle();
                    }
                },
                out: function() {
                    if ($(this).is('.menu-item-has-children')) {
                        $(this).find('> .sub-menu').slideToggle();
                    }
                },
                timeout: 300
            });
        }
    }


    /* WPML Language Selector */
    /* -------------------------------------------------------------------- */
    function pacz_header_wpml() {
        $('.pacz-header-wpml-ls').hoverIntent({
            over: function() {
                $('.language-selector-box').fadeIn(200);
            },
            out: function() {
                $('.language-selector-box').fadeOut(200);
            },
            timeout: 500
        });
    }




    /* Woocmmerce Header Checkout */
    /* -------------------------------------------------------------------- */

    function pacz_header_checkout() {
        $('header').on('mouseenter', '.pacz-shopping-cart', function() {
            $('.pacz-shopping-box').fadeIn(200).css({'z-index' : 100});
        });
        $('header').on('mouseleave', '.pacz-shopping-cart', function() {
            $('.pacz-shopping-box').delay(500).fadeOut(200);
        });

        // we need to delegate events to bind them 'live'. Element is processed off the page and reinserted
    }



    /* Woocommerce Scripts */
    /* -------------------------------------------------------------------- */

    function product_loop_add_cart() {
        var $body = $('body');

        $body.on('click', '.add_to_cart_button', function() {
            var product = $(this).parents('.product:eq(0)').addClass('adding-to-cart').removeClass('added-to-cart');
        });

        $body.bind('added_to_cart', function() {
            $('.adding-to-cart').removeClass('adding-to-cart').addClass('added-to-cart');
            pacz_header_checkout();
        });
    }
    product_loop_add_cart();


    /* Table Responsive */
    /* -------------------------------------------------------------------- */
   /* var switched = false;
    var updateTables = function() {
        if ((global_window_width < 767) && !switched) {
            switched = true;
            $("table.shop_table").each(function(i, element) {
                splitTable($(element));
            });
            return true;
        } else if (switched && (global_window_width > 767)) {
            switched = false;
            $("table.shop_table").each(function(i, element) {
                unsplitTable($(element));
            });
        }
    };

    $(window).load(updateTables);
    $(window).on("redraw", function() {
        switched = false;
        updateTables();
    }); // An event to listen for
    $(window).on("resize", updateTables);


    function splitTable(original) {
        original.wrap("<div class='table-wrapper' />");

        var copy = original.clone();
        copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
        copy.removeClass("shop_table");

        original.closest(".table-wrapper").append(copy);
        copy.wrap("<div class='pinned' />");
        original.wrap("<div class='scrollable' />");

        setCellHeights(original, copy);
    }

    function unsplitTable(original) {
        original.closest(".table-wrapper").find(".pinned").remove();
        original.unwrap();
        original.unwrap();
    }

    function setCellHeights(original, copy) {
        var tr = original.find('tr'),
            tr_copy = copy.find('tr'),
            heights = [];

        tr.each(function(index) {
            var self = $(this),
                tx = self.find('th, td');

            tx.each(function() {
                var height = $(this).outerHeight(true);
                heights[index] = heights[index] || 0;
                if (height > heights[index]) heights[index] = height;
            });

        });

        tr_copy.each(function(index) {
            $(this).height(heights[index]);
        });
    }*/


    /* Ajax Search */
    /* -------------------------------------------------------------------- */

    function pacz_ajax_search() {
        if ($.exists('.search-ajax-input')) {
            $(".search-ajax-input").autocomplete({
                delay: 50,
                minLength: 2,
                messages: {
                    noResults: '',
                    results: function() {}
                },
                appendTo: $(".header-searchform-input"),
                source: function(req, response) {
                    $.getJSON(ajaxurl + '?callback=?&action=pacz_ajax_search', req, response);
                },
                select: function(event, ui) {
                    window.location.href = ui.item.link;
                }

            }).data("ui-autocomplete")._renderItem = function(ul, item) {


                return $("<li>").append("<a>" + item.image + "<span class='search-title'>" + item.label + "</span><span class='search-date'>" + item.date + "</span></a>").appendTo(ul);

            };
        }
    }

    pacz_ajax_search();



    /* Contact Form */
    /* -------------------------------------------------------------------- */

    function pacz_contact_form() {

        if ($.tools.validator != undefined) {
            $.tools.validator.addEffect("contact_form", function(errors) {
                $.each(errors, function(index, error) {
                    var input = error.input;

                    input.addClass('pacz-invalid');
                });
            }, function(inputs) {
                inputs.removeClass('pacz-invalid');
            });


            $(".captcha-change-image").on("click", function(e) {
                e.preventDefault();
                changeCaptcha();
            });

            $(".captcha-form").each(function() {
              $(this).on("focus", function() {
                $(this).attr("placeholder", pacz_captcha_placeholder).removeClass('contact-captcha-invalid contact-captcha-valid');
              });
            });

            var changeCaptcha = function() {
                $(".captcha-image").attr("src", pacz_theme_dir + "/captcha/captcha.php?" + Math.random());
            }

            var sendForm;
            var checkCaptcha = function(form, enteredCaptcha) {
                $.get(pacz_theme_dir + "/captcha/captcha-check.php", {
                    captcha: enteredCaptcha
                }).done(function(data) {
                    if (data != "ok") {
                        changeCaptcha();
                        form.find(".captcha-form").val("").addClass('contact-captcha-invalid').attr("placeholder",pacz_captcha_invalid_txt);
                    } else {
                        sendForm();
                        changeCaptcha();
                        form.find(".captcha-form").val("").addClass('contact-captcha-valid').attr("placeholder", pacz_captcha_correct_txt);
                    }
                });
            }

            $('.pacz-contact-form').validator({
                effect: 'contact_form'
            }).submit(function(e) {
                var form = $(this);
                if (!e.isDefaultPrevented()) {
                    // progressButton.loader(form);
                    // $(this).find('.pacz-contact-loading').fadeIn('slow');

                    var data = {
                        action: 'pacz_contact_form',
                        to: form.find('input[name="contact_to"]').val().replace("*", "@"),
                        name: form.find('input[name="contact_name"]').val(),
                        phone: form.find('input[name="contact_phone"]').val(),
                        email: form.find('input[name="contact_email"]').val(),
                        content: form.find('textarea[name="contact_content"]').val()
                    };

                    // $.post(ajaxurl, data, function(response) {
                    //     // form.find('.pacz-contact-loading').fadeOut('slow');
                    //     // form.find('.pacz-contact-success').delay(2000).fadeIn('slow').delay(8000).fadeOut();
                    //     // form.find('input#contact_email, input#contact_name, textarea').val("");

                    //     form.find('.pacz-contact-loading').fadeOut('slow');
                    //     form.find('input#contact_email, input#contact_name, textarea').val("");
                    //     progressButton.success(form);

                    // });

                    sendForm = function() {
                        progressButton.loader(form);
                        $.post(ajaxurl, data, function(response) {
                            form.find('.pacz-contact-loading').fadeOut('slow');
                            form.find('input').val("");
                            form.find('textarea').val('');
                            progressButton.success(form);
                        });
                    };

                    var enteredCaptcha = form.find('input[name="captcha"]').val();
                    if (form.find('.captcha-form').length) {
                        checkCaptcha(form, enteredCaptcha);
                    } else {
                        sendForm();
                    }

                    e.preventDefault();
                }
            });

        }
    }

    pacz_contact_form();


    $(this).find('.pacz-form-row input, .comment-form-row input, .pacz-login-form input').each(function() {

        $(this).focusin(function() {
            $(this).siblings('i').addClass('input-focused');
        });
        $(this).focusout(function() {
            $(this).siblings('i').removeClass('input-focused');
        });

    });



    /* Ajax Login Form */
    /* -------------------------------------------------------------------- */

    //function pacz_login_form() {

        $('form.pacz-login-form').each(function() {
            var $this = $(this);
            $this.on('submit', function(e) {
                $('p.pacz-login-status', $this).show().text(ajax_login_object.loadingmessage);
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajax_login_object.ajaxurl,
                    data: {
                        'action': 'ajaxlogin',
                        //calls wp_ajax_nopriv_ajaxlogin
                        'username': $('#username', $this).val(),
                        'password': $('#password', $this).val(),
                        'security': $('#security', $this).val()
                    },
                    success: function(data) {
                        $('p.pacz-login-status', $this).text(data.message);
                        if (data.loggedin === true) {
                            document.location.href = ajax_login_object.redirecturl;
                        }
                    }
                });
                e.preventDefault();
            });
        });
    //}

   // pacz_login_form();

    /* quick contact form function */
    /* -------------------------------------------------------------------- */
    var eventtype = mobilecheck() ? 'touchstart' : 'click';
    jQuery('.pacz-quick-contact-link').on(eventtype, function() {
        var $this = jQuery(this),
            $quickContact = jQuery('.pacz-quick-contact-overlay'),
            $quickContactInner = $quickContact.find('.pacz-quick-contact-inset');

        $quickContact.addClass('pacz-quick-contact-visible');

        return false;
    });
    jQuery('.pacz-quick-contact-overlay').on(eventtype, function() {
        $(this).removeClass('pacz-quick-contact-visible');
    });

    /* message box close function */
    /* -------------------------------------------------------------------- */

    $('.box-close-btn').on(eventtype, function() {
        $(this).parent().fadeOut(300);
        return false;
    });


    /* Smooth scroll using hash */
    /* -------------------------------------------------------------------- */
    function pacz_hash_scroll() {
        var headerHeight = classiadspro.modules.header.calcHeight();
        $(".pacz-smooth, .blog-comments").on('click', function(e) {
            TweenLite.to(window, 1.2, {
                scrollTo: {
                    y: $($(this).attr("href")).offset().top - (headerHeight + 2)
                },
                ease: Expo.easeInOut
            });

            e.preventDefault();
        });
    }

    /* Responsive Header Toolbar */
    /* -------------------------------------------------------------------- */
    function pacz_responsive_header_toolbar() {

        $('.pacz-toolbar-responsive-icon').on('click', function(e) {
            var $this = $(this),
                res_header_toolbar = $this.parents('.pacz-responsive-header-toolbar').prev('.pacz-header-toolbar');

            if (!$this.hasClass('active-header-toolbar')) {
                $this.addClass('active-header-toolbar');
                res_header_toolbar.slideToggle();
            } else {
                $this.removeClass('active-header-toolbar');
                res_header_toolbar.slideToggle();
            }
            e.preventDefault();
        });
    }

    /* Responsive Toolbar */
    /* -------------------------------------------------------------------- */
    

    /* Scroll function for main navigation on one page concept */
    /* -------------------------------------------------------------------- */



    function pacz_main_nav_scroll() {

        var lastId, topMenu = $(".main-navigation-ul, .pacz-responsive-nav"),
            menuItems = topMenu.find(".menu-item a"),
            headerHeight = classiadspro.modules.header.calcHeight(),
            href;

        menuItems.each(function() {
            var href_attr = $(this).attr('href');
            if (typeof href_attr !== 'undefined' && href_attr !== false) {
                href = href_attr.split('#')[0];
                if(typeof href_attr.split('#')[1] !== 'undefined' && href_attr.split('#')[1].length) {
                    $(this).addClass("one-page-nav-item");
                }
            } else {
                href = "";
            }

            if (href === window.location.href.split('#')[0] && (typeof $(this).attr("href").split('#')[1] !== 'undefined') && href !== "") {

                $(this).attr("href", "#" + $(this).attr("href").split('#')[1]);
                $(this).parent().removeClass("current-menu-item");
            }
        });

        var onePageMenuItems = $('.one-page-nav-item');

        var scrollItems = onePageMenuItems.map(function() {
            var item = $(this).attr("href");

            if (/^#\w/.test(item) && $(item).length) {
                return $(item);
            }
        });


        topMenu.on('click', '.one-page-nav-item', function(e) {
            var href = $(this).attr("href");
            if (typeof $(href).offset() !== 'undefined') {
                var href_top = $(href).offset().top;
            } else {
                var href_top = 0;
            }

            if($(window).width() < pacz_nav_res_width) {
                headerHeight = 0;
            }

            var offsetTop = href === "#" ? 0 : href_top - (headerHeight + 2);

            /*
             * We need to trigger click as it will close menu and pass another event 'pacz-closed-nav' which will unlock scrolling
             * blocked by sharp one pager
             */
            if($.exists('.responsive-nav-link.active-burger')) {
              $('.responsive-nav-link.active-burger').trigger('click');
            }

            console.log(offsetTop)

            $('html, body').stop().animate({
              scrollTop: offsetTop
            }, {
              duration: 1200,
              easing: "easeInOutExpo"
            });

            e.preventDefault();
        });


        var fromTop;
        var animationSet = function() {

            if (!scrollItems.length) {
                return false;
            }

            fromTop = scrollY + (headerHeight + 10);

            var cur = scrollItems.map(function() {
                if ($(this).offset().top < fromTop) { 
                    return this;
                }
            });
            //console.log(cur);
            cur = cur[cur.length - 1];
            var id = cur && cur.length ? cur[0].id : "";

            if (lastId !== id) {
                lastId = id;

                console.log(fromTop);

                onePageMenuItems.parent().removeClass("current-menu-item");
                //console.log(id);
                if (id.length) {
                    onePageMenuItems.filter("[href=#" + id + "]").parent().addClass("current-menu-item");
                    //console.log(id);
                }
            }
        };
        $(window).scroll(animationSet)
        // debouncedScrollAnimations.add(animationSet);
    }

});




})(jQuery);;
/*! fancyBox v2.1.5 fancyapps.com | fancyapps.com/fancybox/#license */
(function(s, H, f, w) {
    var K = f("html"),
        q = f(s),
        p = f(H),
        b = f.fancybox = function() {
            b.open.apply(this, arguments)
        },
        J = navigator.userAgent.match(/msie/i),
        C = null,
        t = H.createTouch !== w,
        u = function(a) {
            return a && a.hasOwnProperty && a instanceof f
        },
        r = function(a) {
            return a && "string" === f.type(a)
        },
        F = function(a) {
            return r(a) && 0 < a.indexOf("%")
        },
        m = function(a, d) {
            var e = parseInt(a, 10) || 0;
            d && F(a) && (e *= b.getViewport()[d] / 100);
            return Math.ceil(e)
        },
        x = function(a, b) {
            return m(a, b) + "px"
        };
    f.extend(b, {
        version: "2.1.5",
        defaults: {
            padding: 15,
            margin: 20,
            width: 800,
            height: 600,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 9999,
            maxHeight: 9999,
            pixelRatio: 1,
            autoSize: !0,
            autoHeight: !1,
            autoWidth: !1,
            autoResize: !0,
            autoCenter: !t,
            fitToView: !0,
            aspectRatio: !1,
            topRatio: 0.5,
            leftRatio: 0.5,
            scrolling: "auto",
            wrapCSS: "",
            arrows: !0,
            closeBtn: !0,
            closeClick: !1,
            nextClick: !1,
            mouseWheel: !0,
            autoPlay: !1,
            playSpeed: 3E3,
            preload: 3,
            modal: !1,
            loop: !0,
            ajax: {
                dataType: "html",
                headers: {
                    "X-fancyBox": !0
                }
            },
            iframe: {
                scrolling: "auto",
                preload: !0
            },
            swf: {
                wmode: "transparent",
                allowfullscreen: "true",
                allowscriptaccess: "always"
            },
            keys: {
                next: {
                    13: "left",
                    34: "up",
                    39: "left",
                    40: "up"
                },
                prev: {
                    8: "right",
                    33: "down",
                    37: "right",
                    38: "down"
                },
                close: [27],
                play: [32],
                toggle: [70]
            },
            direction: {
                next: "left",
                prev: "right"
            },
            scrollOutside: !0,
            index: 0,
            type: null,
            href: null,
            content: null,
            title: null,
            tpl: {
                wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                image: '<img class="fancybox-image" src="{href}" alt="" />',
                iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' +
                    (J ? ' allowtransparency="true"' : "") + "></iframe>",
                error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
                next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
                prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
            },
            openEffect: "fade",
            openSpeed: 250,
            openEasing: "swing",
            openOpacity: !0,
            openMethod: "zoomIn",
            closeEffect: "fade",
            closeSpeed: 250,
            closeEasing: "swing",
            closeOpacity: !0,
            closeMethod: "zoomOut",
            nextEffect: "elastic",
            nextSpeed: 250,
            nextEasing: "swing",
            nextMethod: "changeIn",
            prevEffect: "elastic",
            prevSpeed: 250,
            prevEasing: "swing",
            prevMethod: "changeOut",
            helpers: {
                overlay: !0,
                title: !0
            },
            onCancel: f.noop,
            beforeLoad: f.noop,
            afterLoad: f.noop,
            beforeShow: f.noop,
            afterShow: f.noop,
            beforeChange: f.noop,
            beforeClose: f.noop,
            afterClose: f.noop
        },
        group: {},
        opts: {},
        previous: null,
        coming: null,
        current: null,
        isActive: !1,
        isOpen: !1,
        isOpened: !1,
        wrap: null,
        skin: null,
        outer: null,
        inner: null,
        player: {
            timer: null,
            isActive: !1
        },
        ajaxLoad: null,
        imgPreload: null,
        transitions: {},
        helpers: {},
        open: function(a, d) {
            if (a && (f.isPlainObject(d) || (d = {}), !1 !== b.close(!0))) return f.isArray(a) || (a = u(a) ? f(a).get() : [a]), f.each(a, function(e, c) {
                var l = {},
                    g, h, k, n, m;
                "object" === f.type(c) && (c.nodeType && (c = f(c)), u(c) ? (l = {
                        href: c.data("fancybox-href") || c.attr("href"),
                        title: f("<div/>").text(c.data("fancybox-title") || c.attr("title")).html(),
                        isDom: !0,
                        element: c
                    },
                    f.metadata && f.extend(!0, l, c.metadata())) : l = c);
                g = d.href || l.href || (r(c) ? c : null);
                h = d.title !== w ? d.title : l.title || "";
                n = (k = d.content || l.content) ? "html" : d.type || l.type;
                !n && l.isDom && (n = c.data("fancybox-type"), n || (n = (n = c.prop("class").match(/fancybox\.(\w+)/)) ? n[1] : null));
                r(g) && (n || (b.isImage(g) ? n = "image" : b.isSWF(g) ? n = "swf" : "#" === g.charAt(0) ? n = "inline" : r(c) && (n = "html", k = c)), "ajax" === n && (m = g.split(/\s+/, 2), g = m.shift(), m = m.shift()));
                k || ("inline" === n ? g ? k = f(r(g) ? g.replace(/.*(?=#[^\s]+$)/, "") : g) : l.isDom && (k = c) :
                    "html" === n ? k = g : n || g || !l.isDom || (n = "inline", k = c));
                f.extend(l, {
                    href: g,
                    type: n,
                    content: k,
                    title: h,
                    selector: m
                });
                a[e] = l
            }), b.opts = f.extend(!0, {}, b.defaults, d), d.keys !== w && (b.opts.keys = d.keys ? f.extend({}, b.defaults.keys, d.keys) : !1), b.group = a, b._start(b.opts.index)
        },
        cancel: function() {
            var a = b.coming;
            a && !1 === b.trigger("onCancel") || (b.hideLoading(), a && (b.ajaxLoad && b.ajaxLoad.abort(), b.ajaxLoad = null, b.imgPreload && (b.imgPreload.onload = b.imgPreload.onerror = null), a.wrap && a.wrap.stop(!0, !0).trigger("onReset").remove(),
                b.coming = null, b.current || b._afterZoomOut(a)))
        },
        close: function(a) {
            b.cancel();
            !1 !== b.trigger("beforeClose") && (b.unbindEvents(), b.isActive && (b.isOpen && !0 !== a ? (b.isOpen = b.isOpened = !1, b.isClosing = !0, f(".fancybox-item, .fancybox-nav").remove(), b.wrap.stop(!0, !0).removeClass("fancybox-opened"), b.transitions[b.current.closeMethod]()) : (f(".fancybox-wrap").stop(!0).trigger("onReset").remove(), b._afterZoomOut())))
        },
        play: function(a) {
            var d = function() {
                    clearTimeout(b.player.timer)
                },
                e = function() {
                    d();
                    b.current && b.player.isActive &&
                        (b.player.timer = setTimeout(b.next, b.current.playSpeed))
                },
                c = function() {
                    d();
                    p.unbind(".player");
                    b.player.isActive = !1;
                    b.trigger("onPlayEnd")
                };
            !0 === a || !b.player.isActive && !1 !== a ? b.current && (b.current.loop || b.current.index < b.group.length - 1) && (b.player.isActive = !0, p.bind({
                "onCancel.player beforeClose.player": c,
                "onUpdate.player": e,
                "beforeLoad.player": d
            }), e(), b.trigger("onPlayStart")) : c()
        },
        next: function(a) {
            var d = b.current;
            d && (r(a) || (a = d.direction.next), b.jumpto(d.index + 1, a, "next"))
        },
        prev: function(a) {
            var d =
                b.current;
            d && (r(a) || (a = d.direction.prev), b.jumpto(d.index - 1, a, "prev"))
        },
        jumpto: function(a, d, e) {
            var c = b.current;
            c && (a = m(a), b.direction = d || c.direction[a >= c.index ? "next" : "prev"], b.router = e || "jumpto", c.loop && (0 > a && (a = c.group.length + a % c.group.length), a %= c.group.length), c.group[a] !== w && (b.cancel(), b._start(a)))
        },
        reposition: function(a, d) {
            var e = b.current,
                c = e ? e.wrap : null,
                l;
            c && (l = b._getPosition(d), a && "scroll" === a.type ? (delete l.position, c.stop(!0, !0).animate(l, 200)) : (c.css(l), e.pos = f.extend({}, e.dim, l)))
        },
        update: function(a) {
            var d = a && a.originalEvent && a.originalEvent.type,
                e = !d || "orientationchange" === d;
            e && (clearTimeout(C), C = null);
            b.isOpen && !C && (C = setTimeout(function() {
                var c = b.current;
                c && !b.isClosing && (b.wrap.removeClass("fancybox-tmp"), (e || "load" === d || "resize" === d && c.autoResize) && b._setDimension(), "scroll" === d && c.canShrink || b.reposition(a), b.trigger("onUpdate"), C = null)
            }, e && !t ? 0 : 300))
        },
        toggle: function(a) {
            b.isOpen && (b.current.fitToView = "boolean" === f.type(a) ? a : !b.current.fitToView, t && (b.wrap.removeAttr("style").addClass("fancybox-tmp"),
                b.trigger("onUpdate")), b.update())
        },
        hideLoading: function() {
            p.unbind(".loading");
            f("#fancybox-loading").remove()
        },
        showLoading: function() {
            var a, d;
            b.hideLoading();
            a = f('<div id="fancybox-loading"><div></div></div>').click(b.cancel).appendTo("body");
            p.bind("keydown.loading", function(a) {
                27 === (a.which || a.keyCode) && (a.preventDefault(), b.cancel())
            });
            b.defaults.fixed || (d = b.getViewport(), a.css({
                position: "absolute",
                top: 0.5 * d.h + d.y,
                left: 0.5 * d.w + d.x
            }));
            b.trigger("onLoading")
        },
        getViewport: function() {
            var a = b.current &&
                b.current.locked || !1,
                d = {
                    x: q.scrollLeft(),
                    y: q.scrollTop()
                };
            a && a.length ? (d.w = a[0].clientWidth, d.h = a[0].clientHeight) : (d.w = t && s.innerWidth ? s.innerWidth : q.width(), d.h = t && s.innerHeight ? s.innerHeight : q.height());
            return d
        },
        unbindEvents: function() {
            b.wrap && u(b.wrap) && b.wrap.unbind(".fb");
            p.unbind(".fb");
            q.unbind(".fb")
        },
        bindEvents: function() {
            var a = b.current,
                d;
            a && (q.bind("orientationchange.fb" + (t ? "" : " resize.fb") + (a.autoCenter && !a.locked ? " scroll.fb" : ""), b.update), (d = a.keys) && p.bind("keydown.fb", function(e) {
                var c =
                    e.which || e.keyCode,
                    l = e.target || e.srcElement;
                if (27 === c && b.coming) return !1;
                e.ctrlKey || e.altKey || e.shiftKey || e.metaKey || l && (l.type || f(l).is("[contenteditable]")) || f.each(d, function(d, l) {
                    if (1 < a.group.length && l[c] !== w) return b[d](l[c]), e.preventDefault(), !1;
                    if (-1 < f.inArray(c, l)) return b[d](), e.preventDefault(), !1
                })
            }), f.fn.mousewheel && a.mouseWheel && b.wrap.bind("mousewheel.fb", function(d, c, l, g) {
                for (var h = f(d.target || null), k = !1; h.length && !(k || h.is(".fancybox-skin") || h.is(".fancybox-wrap"));) k = h[0] && !(h[0].style.overflow &&
                    "hidden" === h[0].style.overflow) && (h[0].clientWidth && h[0].scrollWidth > h[0].clientWidth || h[0].clientHeight && h[0].scrollHeight > h[0].clientHeight), h = f(h).parent();
                0 !== c && !k && 1 < b.group.length && !a.canShrink && (0 < g || 0 < l ? b.prev(0 < g ? "down" : "left") : (0 > g || 0 > l) && b.next(0 > g ? "up" : "right"), d.preventDefault())
            }))
        },
        trigger: function(a, d) {
            var e, c = d || b.coming || b.current;
            if (c) {
                f.isFunction(c[a]) && (e = c[a].apply(c, Array.prototype.slice.call(arguments, 1)));
                if (!1 === e) return !1;
                c.helpers && f.each(c.helpers, function(d, e) {
                    if (e &&
                        b.helpers[d] && f.isFunction(b.helpers[d][a])) b.helpers[d][a](f.extend(!0, {}, b.helpers[d].defaults, e), c)
                })
            }
            p.trigger(a)
        },
        isImage: function(a) {
            return r(a) && a.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)
        },
        isSWF: function(a) {
            return r(a) && a.match(/\.(swf)((\?|#).*)?$/i)
        },
        _start: function(a) {
            var d = {},
                e, c;
            a = m(a);
            e = b.group[a] || null;
            if (!e) return !1;
            d = f.extend(!0, {}, b.opts, e);
            e = d.margin;
            c = d.padding;
            "number" === f.type(e) && (d.margin = [e, e, e, e]);
            "number" === f.type(c) && (d.padding = [c, c,
                c, c
            ]);
            d.modal && f.extend(!0, d, {
                closeBtn: !1,
                closeClick: !1,
                nextClick: !1,
                arrows: !1,
                mouseWheel: !1,
                keys: null,
                helpers: {
                    overlay: {
                        closeClick: !1
                    }
                }
            });
            d.autoSize && (d.autoWidth = d.autoHeight = !0);
            "auto" === d.width && (d.autoWidth = !0);
            "auto" === d.height && (d.autoHeight = !0);
            d.group = b.group;
            d.index = a;
            b.coming = d;
            if (!1 === b.trigger("beforeLoad")) b.coming = null;
            else {
                c = d.type;
                e = d.href;
                if (!c) return b.coming = null, b.current && b.router && "jumpto" !== b.router ? (b.current.index = a, b[b.router](b.direction)) : !1;
                b.isActive = !0;
                if ("image" ===
                    c || "swf" === c) d.autoHeight = d.autoWidth = !1, d.scrolling = "visible";
                "image" === c && (d.aspectRatio = !0);
                "iframe" === c && t && (d.scrolling = "scroll");
                d.wrap = f(d.tpl.wrap).addClass("fancybox-" + (t ? "mobile" : "desktop") + " fancybox-type-" + c + " fancybox-tmp " + d.wrapCSS).appendTo(d.parent || "body");
                f.extend(d, {
                    skin: f(".fancybox-skin", d.wrap),
                    outer: f(".fancybox-outer", d.wrap),
                    inner: f(".fancybox-inner", d.wrap)
                });
                f.each(["Top", "Right", "Bottom", "Left"], function(a, b) {
                    d.skin.css("padding" + b, x(d.padding[a]))
                });
                b.trigger("onReady");
                if ("inline" === c || "html" === c) {
                    if (!d.content || !d.content.length) return b._error("content")
                } else if (!e) return b._error("href");
                "image" === c ? b._loadImage() : "ajax" === c ? b._loadAjax() : "iframe" === c ? b._loadIframe() : b._afterLoad()
            }
        },
        _error: function(a) {
            f.extend(b.coming, {
                type: "html",
                autoWidth: !0,
                autoHeight: !0,
                minWidth: 0,
                minHeight: 0,
                scrolling: "no",
                hasError: a,
                content: b.coming.tpl.error
            });
            b._afterLoad()
        },
        _loadImage: function() {
            var a = b.imgPreload = new Image;
            a.onload = function() {
                this.onload = this.onerror = null;
                b.coming.width =
                    this.width / b.opts.pixelRatio;
                b.coming.height = this.height / b.opts.pixelRatio;
                b._afterLoad()
            };
            a.onerror = function() {
                this.onload = this.onerror = null;
                b._error("image")
            };
            a.src = b.coming.href;
            !0 !== a.complete && b.showLoading()
        },
        _loadAjax: function() {
            var a = b.coming;
            b.showLoading();
            b.ajaxLoad = f.ajax(f.extend({}, a.ajax, {
                url: a.href,
                error: function(a, e) {
                    b.coming && "abort" !== e ? b._error("ajax", a) : b.hideLoading()
                },
                success: function(d, e) {
                    "success" === e && (a.content = d, b._afterLoad())
                }
            }))
        },
        _loadIframe: function() {
            var a = b.coming,
                d = f(a.tpl.iframe.replace(/\{rnd\}/g, (new Date).getTime())).attr("scrolling", t ? "auto" : a.iframe.scrolling).attr("src", a.href);
            f(a.wrap).bind("onReset", function() {
                try {
                    f(this).find("iframe").hide().attr("src", "//about:blank").end().empty()
                } catch (a) {}
            });
            a.iframe.preload && (b.showLoading(), d.one("load", function() {
                f(this).data("ready", 1);
                t || f(this).bind("load.fb", b.update);
                f(this).parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show();
                b._afterLoad()
            }));
            a.content = d.appendTo(a.inner);
            a.iframe.preload ||
                b._afterLoad()
        },
        _preloadImages: function() {
            var a = b.group,
                d = b.current,
                e = a.length,
                c = d.preload ? Math.min(d.preload, e - 1) : 0,
                f, g;
            for (g = 1; g <= c; g += 1) f = a[(d.index + g) % e], "image" === f.type && f.href && ((new Image).src = f.href)
        },
        _afterLoad: function() {
            var a = b.coming,
                d = b.current,
                e, c, l, g, h;
            b.hideLoading();
            if (a && !1 !== b.isActive)
                if (!1 === b.trigger("afterLoad", a, d)) a.wrap.stop(!0).trigger("onReset").remove(), b.coming = null;
                else {
                    d && (b.trigger("beforeChange", d), d.wrap.stop(!0).removeClass("fancybox-opened").find(".fancybox-item, .fancybox-nav").remove());
                    b.unbindEvents();
                    e = a.content;
                    c = a.type;
                    l = a.scrolling;
                    f.extend(b, {
                        wrap: a.wrap,
                        skin: a.skin,
                        outer: a.outer,
                        inner: a.inner,
                        current: a,
                        previous: d
                    });
                    g = a.href;
                    switch (c) {
                        case "inline":
                        case "ajax":
                        case "html":
                            a.selector ? e = f("<div>").html(e).find(a.selector) : u(e) && (e.data("fancybox-placeholder") || e.data("fancybox-placeholder", f('<div class="fancybox-placeholder"></div>').insertAfter(e).hide()), e = e.show().detach(), a.wrap.bind("onReset", function() {
                                f(this).find(e).length && e.hide().replaceAll(e.data("fancybox-placeholder")).data("fancybox-placeholder", !1)
                            }));
                            break;
                        case "image":
                            e = a.tpl.image.replace(/\{href\}/g, g);
                            break;
                        case "swf":
                            e = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' + g + '"></param>', h = "", f.each(a.swf, function(a, b) {
                                e += '<param name="' + a + '" value="' + b + '"></param>';
                                h += " " + a + '="' + b + '"'
                            }), e += '<embed src="' + g + '" type="application/x-shockwave-flash" width="100%" height="100%"' + h + "></embed></object>"
                    }
                    u(e) && e.parent().is(a.inner) || a.inner.append(e);
                    b.trigger("beforeShow");
                    a.inner.css("overflow", "yes" === l ? "scroll" : "no" === l ? "hidden" : l);
                    b._setDimension();
                    b.reposition();
                    b.isOpen = !1;
                    b.coming = null;
                    b.bindEvents();
                    if (!b.isOpened) f(".fancybox-wrap").not(a.wrap).stop(!0).trigger("onReset").remove();
                    else if (d.prevMethod) b.transitions[d.prevMethod]();
                    b.transitions[b.isOpened ? a.nextMethod : a.openMethod]();
                    b._preloadImages()
                }
        },
        _setDimension: function() {
            var a = b.getViewport(),
                d = 0,
                e = !1,
                c = !1,
                e = b.wrap,
                l = b.skin,
                g = b.inner,
                h = b.current,
                c = h.width,
                k = h.height,
                n = h.minWidth,
                v = h.minHeight,
                p = h.maxWidth,
                q = h.maxHeight,
                t = h.scrolling,
                r = h.scrollOutside ? h.scrollbarWidth : 0,
                y = h.margin,
                z = m(y[1] + y[3]),
                s = m(y[0] + y[2]),
                w, A, u, D, B, G, C, E, I;
            e.add(l).add(g).width("auto").height("auto").removeClass("fancybox-tmp");
            y = m(l.outerWidth(!0) - l.width());
            w = m(l.outerHeight(!0) - l.height());
            A = z + y;
            u = s + w;
            D = F(c) ? (a.w - A) * m(c) / 100 : c;
            B = F(k) ? (a.h - u) * m(k) / 100 : k;
            if ("iframe" === h.type) {
                if (I = h.content, h.autoHeight && 1 === I.data("ready")) try {
                    I[0].contentWindow.document.location && (g.width(D).height(9999), G = I.contents().find("body"), r && G.css("overflow-x",
                        "hidden"), B = G.outerHeight(!0))
                } catch (H) {}
            } else if (h.autoWidth || h.autoHeight) g.addClass("fancybox-tmp"), h.autoWidth || g.width(D), h.autoHeight || g.height(B), h.autoWidth && (D = g.width()), h.autoHeight && (B = g.height()), g.removeClass("fancybox-tmp");
            c = m(D);
            k = m(B);
            E = D / B;
            n = m(F(n) ? m(n, "w") - A : n);
            p = m(F(p) ? m(p, "w") - A : p);
            v = m(F(v) ? m(v, "h") - u : v);
            q = m(F(q) ? m(q, "h") - u : q);
            G = p;
            C = q;
            h.fitToView && (p = Math.min(a.w - A, p), q = Math.min(a.h - u, q));
            A = a.w - z;
            s = a.h - s;
            h.aspectRatio ? (c > p && (c = p, k = m(c / E)), k > q && (k = q, c = m(k * E)), c < n && (c = n, k = m(c /
                E)), k < v && (k = v, c = m(k * E))) : (c = Math.max(n, Math.min(c, p)), h.autoHeight && "iframe" !== h.type && (g.width(c), k = g.height()), k = Math.max(v, Math.min(k, q)));
            if (h.fitToView)
                if (g.width(c).height(k), e.width(c + y), a = e.width(), z = e.height(), h.aspectRatio)
                    for (;
                        (a > A || z > s) && c > n && k > v && !(19 < d++);) k = Math.max(v, Math.min(q, k - 10)), c = m(k * E), c < n && (c = n, k = m(c / E)), c > p && (c = p, k = m(c / E)), g.width(c).height(k), e.width(c + y), a = e.width(), z = e.height();
                else c = Math.max(n, Math.min(c, c - (a - A))), k = Math.max(v, Math.min(k, k - (z - s)));
            r && "auto" === t && k < B &&
                c + y + r < A && (c += r);
            g.width(c).height(k);
            e.width(c + y);
            a = e.width();
            z = e.height();
            e = (a > A || z > s) && c > n && k > v;
            c = h.aspectRatio ? c < G && k < C && c < D && k < B : (c < G || k < C) && (c < D || k < B);
            f.extend(h, {
                dim: {
                    width: x(a),
                    height: x(z)
                },
                origWidth: D,
                origHeight: B,
                canShrink: e,
                canExpand: c,
                wPadding: y,
                hPadding: w,
                wrapSpace: z - l.outerHeight(!0),
                skinSpace: l.height() - k
            });
            !I && h.autoHeight && k > v && k < q && !c && g.height("auto")
        },
        _getPosition: function(a) {
            var d = b.current,
                e = b.getViewport(),
                c = d.margin,
                f = b.wrap.width() + c[1] + c[3],
                g = b.wrap.height() + c[0] + c[2],
                c = {
                    position: "absolute",
                    top: c[0],
                    left: c[3]
                };
            d.autoCenter && d.fixed && !a && g <= e.h && f <= e.w ? c.position = "fixed" : d.locked || (c.top += e.y, c.left += e.x);
            c.top = x(Math.max(c.top, c.top + (e.h - g) * d.topRatio));
            c.left = x(Math.max(c.left, c.left + (e.w - f) * d.leftRatio));
            return c
        },
        _afterZoomIn: function() {
            var a = b.current;
            a && ((b.isOpen = b.isOpened = !0, b.wrap.css("overflow", "visible").addClass("fancybox-opened"), b.update(), (a.closeClick || a.nextClick && 1 < b.group.length) && b.inner.css("cursor", "pointer").bind("click.fb", function(d) {
                f(d.target).is("a") || f(d.target).parent().is("a") ||
                    (d.preventDefault(), b[a.closeClick ? "close" : "next"]())
            }), a.closeBtn && f(a.tpl.closeBtn).appendTo(b.skin).bind("click.fb", function(a) {
                a.preventDefault();
                b.close()
            }), a.arrows && 1 < b.group.length && ((a.loop || 0 < a.index) && f(a.tpl.prev).appendTo(b.outer).bind("click.fb", b.prev), (a.loop || a.index < b.group.length - 1) && f(a.tpl.next).appendTo(b.outer).bind("click.fb", b.next)), b.trigger("afterShow"), a.loop || a.index !== a.group.length - 1) ? b.opts.autoPlay && !b.player.isActive && (b.opts.autoPlay = !1, b.play(!0)) : b.play(!1))
        },
        _afterZoomOut: function(a) {
            a = a || b.current;
            f(".fancybox-wrap").trigger("onReset").remove();
            f.extend(b, {
                group: {},
                opts: {},
                router: !1,
                current: null,
                isActive: !1,
                isOpened: !1,
                isOpen: !1,
                isClosing: !1,
                wrap: null,
                skin: null,
                outer: null,
                inner: null
            });
            b.trigger("afterClose", a)
        }
    });
    b.transitions = {
        getOrigPosition: function() {
            var a = b.current,
                d = a.element,
                e = a.orig,
                c = {},
                f = 50,
                g = 50,
                h = a.hPadding,
                k = a.wPadding,
                n = b.getViewport();
            !e && a.isDom && d.is(":visible") && (e = d.find("img:first"), e.length || (e = d));
            u(e) ? (c = e.offset(), e.is("img") &&
                (f = e.outerWidth(), g = e.outerHeight())) : (c.top = n.y + (n.h - g) * a.topRatio, c.left = n.x + (n.w - f) * a.leftRatio);
            if ("fixed" === b.wrap.css("position") || a.locked) c.top -= n.y, c.left -= n.x;
            return c = {
                top: x(c.top - h * a.topRatio),
                left: x(c.left - k * a.leftRatio),
                width: x(f + k),
                height: x(g + h)
            }
        },
        step: function(a, d) {
            var e, c, f = d.prop;
            c = b.current;
            var g = c.wrapSpace,
                h = c.skinSpace;
            if ("width" === f || "height" === f) e = d.end === d.start ? 1 : (a - d.start) / (d.end - d.start), b.isClosing && (e = 1 - e), c = "width" === f ? c.wPadding : c.hPadding, c = a - c, b.skin[f](m("width" ===
                f ? c : c - g * e)), b.inner[f](m("width" === f ? c : c - g * e - h * e))
        },
        zoomIn: function() {
            var a = b.current,
                d = a.pos,
                e = a.openEffect,
                c = "elastic" === e,
                l = f.extend({
                    opacity: 1
                }, d);
            delete l.position;
            c ? (d = this.getOrigPosition(), a.openOpacity && (d.opacity = 0.1)) : "fade" === e && (d.opacity = 0.1);
            b.wrap.css(d).animate(l, {
                duration: "none" === e ? 0 : a.openSpeed,
                easing: a.openEasing,
                step: c ? this.step : null,
                complete: b._afterZoomIn
            })
        },
        zoomOut: function() {
            var a = b.current,
                d = a.closeEffect,
                e = "elastic" === d,
                c = {
                    opacity: 0.1
                };
            e && (c = this.getOrigPosition(), a.closeOpacity &&
                (c.opacity = 0.1));
            b.wrap.animate(c, {
                duration: "none" === d ? 0 : a.closeSpeed,
                easing: a.closeEasing,
                step: e ? this.step : null,
                complete: b._afterZoomOut
            })
        },
        changeIn: function() {
            var a = b.current,
                d = a.nextEffect,
                e = a.pos,
                c = {
                    opacity: 1
                },
                f = b.direction,
                g;
            e.opacity = 0.1;
            "elastic" === d && (g = "down" === f || "up" === f ? "top" : "left", "down" === f || "right" === f ? (e[g] = x(m(e[g]) - 200), c[g] = "+=200px") : (e[g] = x(m(e[g]) + 200), c[g] = "-=200px"));
            "none" === d ? b._afterZoomIn() : b.wrap.css(e).animate(c, {
                duration: a.nextSpeed,
                easing: a.nextEasing,
                complete: b._afterZoomIn
            })
        },
        changeOut: function() {
            var a = b.previous,
                d = a.prevEffect,
                e = {
                    opacity: 0.1
                },
                c = b.direction;
            "elastic" === d && (e["down" === c || "up" === c ? "top" : "left"] = ("up" === c || "left" === c ? "-" : "+") + "=200px");
            a.wrap.animate(e, {
                duration: "none" === d ? 0 : a.prevSpeed,
                easing: a.prevEasing,
                complete: function() {
                    f(this).trigger("onReset").remove()
                }
            })
        }
    };
    b.helpers.overlay = {
        defaults: {
            closeClick: !0,
            speedOut: 200,
            showEarly: !0,
            css: {},
            locked: !t,
            fixed: !0
        },
        overlay: null,
        fixed: !1,
        el: f("html"),
        create: function(a) {
            var d;
            a = f.extend({}, this.defaults, a);
            this.overlay &&
                this.close();
            d = b.coming ? b.coming.parent : a.parent;
            this.overlay = f('<div class="fancybox-overlay"></div>').appendTo(d && d.lenth ? d : "body");
            this.fixed = !1;
            a.fixed && b.defaults.fixed && (this.overlay.addClass("fancybox-overlay-fixed"), this.fixed = !0)
        },
        open: function(a) {
            var d = this;
            a = f.extend({}, this.defaults, a);
            this.overlay ? this.overlay.unbind(".overlay").width("auto").height("auto") : this.create(a);
            this.fixed || (q.bind("resize.overlay", f.proxy(this.update, this)), this.update());
            a.closeClick && this.overlay.bind("click.overlay",
                function(a) {
                    if (f(a.target).hasClass("fancybox-overlay")) return b.isActive ? b.close() : d.close(), !1
                });
            this.overlay.css(a.css).show()
        },
        close: function() {
            q.unbind("resize.overlay");
            this.el.hasClass("fancybox-lock") && (f(".fancybox-margin").removeClass("fancybox-margin"), this.el.removeClass("fancybox-lock"), q.scrollTop(this.scrollV).scrollLeft(this.scrollH));
            f(".fancybox-overlay").remove().hide();
            f.extend(this, {
                overlay: null,
                fixed: !1
            })
        },
        update: function() {
            var a = "100%",
                b;
            this.overlay.width(a).height("100%");
            J ? (b = Math.max(H.documentElement.offsetWidth, H.body.offsetWidth), p.width() > b && (a = p.width())) : p.width() > q.width() && (a = p.width());
            this.overlay.width(a).height(p.height())
        },
        onReady: function(a, b) {
            var e = this.overlay;
            f(".fancybox-overlay").stop(!0, !0);
            e || this.create(a);
            a.locked && this.fixed && b.fixed && (b.locked = this.overlay.append(b.wrap), b.fixed = !1);
            !0 === a.showEarly && this.beforeShow.apply(this, arguments)
        },
        beforeShow: function(a, b) {
            b.locked && !this.el.hasClass("fancybox-lock") && (!1 !== this.fixPosition && f("*").filter(function() {
                return "fixed" ===
                    f(this).css("position") && !f(this).hasClass("fancybox-overlay") && !f(this).hasClass("fancybox-wrap")
            }).addClass("fancybox-margin"), this.el.addClass("fancybox-margin"), this.scrollV = q.scrollTop(), this.scrollH = q.scrollLeft(), this.el.addClass("fancybox-lock"), q.scrollTop(this.scrollV).scrollLeft(this.scrollH));
            this.open(a)
        },
        onUpdate: function() {
            this.fixed || this.update()
        },
        afterClose: function(a) {
            this.overlay && !b.coming && this.overlay.fadeOut(a.speedOut, f.proxy(this.close, this))
        }
    };
    b.helpers.title = {
        defaults: {
            type: "float",
            position: "bottom"
        },
        beforeShow: function(a) {
            var d = b.current,
                e = d.title,
                c = a.type;
            f.isFunction(e) && (e = e.call(d.element, d));
            if (r(e) && "" !== f.trim(e)) {
                d = f('<div class="fancybox-title fancybox-title-' + c + '-wrap">' + e + "</div>");
                switch (c) {
                    case "inside":
                        c = b.skin;
                        break;
                    case "outside":
                        c = b.wrap;
                        break;
                    case "over":
                        c = b.inner;
                        break;
                    default:
                        c = b.skin, d.appendTo("body"), J && d.width(d.width()), d.wrapInner('<span class="child"></span>'), b.current.margin[2] += Math.abs(m(d.css("margin-bottom")))
                }
                d["top" === a.position ? "prependTo" :
                    "appendTo"](c)
            }
        }
    };
    f.fn.fancybox = function(a) {
        var d, e = f(this),
            c = this.selector || "",
            l = function(g) {
                var h = f(this).blur(),
                    k = d,
                    l, m;
                g.ctrlKey || g.altKey || g.shiftKey || g.metaKey || h.is(".fancybox-wrap") || (l = a.groupAttr || "data-fancybox-group", m = h.attr(l), m || (l = "rel", m = h.get(0)[l]), m && "" !== m && "nofollow" !== m && (h = c.length ? f(c) : e, h = h.filter("[" + l + '="' + m + '"]'), k = h.index(this)), a.index = k, !1 !== b.open(h, a) && g.preventDefault())
            };
        a = a || {};
        d = a.index || 0;
        c && !1 !== a.live ? p.undelegate(c, "click.fb-start").delegate(c + ":not('.fancybox-item, .fancybox-nav')",
            "click.fb-start", l) : e.unbind("click.fb-start").bind("click.fb-start", l);
        this.filter("[data-fancybox-start=1]").trigger("click");
        return this
    };
    p.ready(function() {
        var a, d;
        f.scrollbarWidth === w && (f.scrollbarWidth = function() {
            var a = f('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"),
                b = a.children(),
                b = b.innerWidth() - b.height(99).innerWidth();
            a.remove();
            return b
        });
        f.support.fixedPosition === w && (f.support.fixedPosition = function() {
            var a = f('<div style="position:fixed;top:20px;"></div>').appendTo("body"),
                b = 20 === a[0].offsetTop || 15 === a[0].offsetTop;
            a.remove();
            return b
        }());
        f.extend(b.defaults, {
            scrollbarWidth: f.scrollbarWidth(),
            fixed: f.support.fixedPosition,
            parent: f("body")
        });
        a = f(s).width();
        K.addClass("fancybox-lock-test");
        d = f(s).width();
        K.removeClass("fancybox-lock-test");
        // f("<style type='text/css'>.fancybox-margin{margin-right:" + (d - a) + "px;}</style>").appendTo("head")
    })
})(window, document, jQuery);






/*!
 * Media helper for fancyBox
 * version: 1.0.6 (Fri, 14 Jun 2013)
 * @requires fancyBox v2.0 or later
 *
 * Usage:
 *     $(".fancybox").fancybox({
 *         helpers : {
 *             media: true
 *         }
 *     });
 *
 * Set custom URL parameters:
 *     $(".fancybox").fancybox({
 *         helpers : {
 *             media: {
 *                 youtube : {
 *                     params : {
 *                         autoplay : 0
 *                     }
 *                 }
 *             }
 *         }
 *     });
 *
 * Or:
 *     $(".fancybox").fancybox({,
 *         helpers : {
 *             media: true
 *         },
 *         youtube : {
 *             autoplay: 0
 *         }
 *     });
 *
 *  Supports:
 *
 *      Youtube
 *          http://www.youtube.com/watch?v=opj24KnzrWo
 *          http://www.youtube.com/embed/opj24KnzrWo
 *          http://youtu.be/opj24KnzrWo
 *          http://www.youtube-nocookie.com/embed/opj24KnzrWo
 *      Vimeo
 *          http://vimeo.com/40648169
 *          http://vimeo.com/channels/staffpicks/38843628
 *          http://vimeo.com/groups/surrealism/videos/36516384
 *          http://player.vimeo.com/video/45074303
 *      Metacafe
 *          http://www.metacafe.com/watch/7635964/dr_seuss_the_lorax_movie_trailer/
 *          http://www.metacafe.com/watch/7635964/
 *      Dailymotion
 *          http://www.dailymotion.com/video/xoytqh_dr-seuss-the-lorax-premiere_people
 *      Twitvid
 *          http://twitvid.com/QY7MD
 *      Twitpic
 *          http://twitpic.com/7p93st
 *      Instagram
 *          http://instagr.am/p/IejkuUGxQn/
 *          http://instagram.com/p/IejkuUGxQn/
 *      Google maps
 *          http://maps.google.com/maps?q=Eiffel+Tower,+Avenue+Gustave+Eiffel,+Paris,+France&t=h&z=17
 *          http://maps.google.com/?ll=48.857995,2.294297&spn=0.007666,0.021136&t=m&z=16
 *          http://maps.google.com/?ll=48.859463,2.292626&spn=0.000965,0.002642&t=m&z=19&layer=c&cbll=48.859524,2.292532&panoid=YJ0lq28OOy3VT2IqIuVY0g&cbp=12,151.58,,0,-15.56
 */
(function ($) {
    "use strict";

    //Shortcut for fancyBox object
    var F = $.fancybox,
        format = function( url, rez, params ) {
            params = params || '';

            if ( $.type( params ) === "object" ) {
                params = $.param(params, true);
            }

            $.each(rez, function(key, value) {
                url = url.replace( '$' + key, value || '' );
            });

            if (params.length) {
                url += ( url.indexOf('?') > 0 ? '&' : '?' ) + params;
            }

            return url;
        };

    //Add helper object
    F.helpers.media = {
        defaults : {
            youtube : {
                matcher : /(youtube\.com|youtu\.be|youtube-nocookie\.com)\/(watch\?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*)).*/i,
                params  : {
                    autoplay    : 1,
                    autohide    : 1,
                    fs          : 1,
                    rel         : 0,
                    hd          : 1,
                    wmode       : 'opaque',
                    enablejsapi : 1
                },
                type : 'iframe',
                url  : '//www.youtube.com/embed/$3'
            },
            vimeo : {
                matcher : /(?:vimeo(?:pro)?.com)\/(?:[^\d]+)?(\d+)(?:.*)/,
                params  : {
                    autoplay      : 1,
                    hd            : 1,
                    show_title    : 1,
                    show_byline   : 1,
                    show_portrait : 0,
                    fullscreen    : 1
                },
                type : 'iframe',
                url  : '//player.vimeo.com/video/$1'
            },
            metacafe : {
                matcher : /metacafe.com\/(?:watch|fplayer)\/([\w\-]{1,10})/,
                params  : {
                    autoPlay : 'yes'
                },
                type : 'swf',
                url  : function( rez, params, obj ) {
                    obj.swf.flashVars = 'playerVars=' + $.param( params, true );

                    return '//www.metacafe.com/fplayer/' + rez[1] + '/.swf';
                }
            },
            dailymotion : {
                matcher : /dailymotion.com\/video\/(.*)\/?(.*)/,
                params  : {
                    additionalInfos : 0,
                    autoStart : 1
                },
                type : 'swf',
                url  : '//www.dailymotion.com/swf/video/$1'
            },
            twitvid : {
                matcher : /twitvid\.com\/([a-zA-Z0-9_\-\?\=]+)/i,
                params  : {
                    autoplay : 0
                },
                type : 'iframe',
                url  : '//www.twitvid.com/embed.php?guid=$1'
            },
            twitpic : {
                matcher : /twitpic\.com\/(?!(?:place|photos|events)\/)([a-zA-Z0-9\?\=\-]+)/i,
                type : 'image',
                url  : '//twitpic.com/show/full/$1/'
            },
            instagram : {
                matcher : /(instagr\.am|instagram\.com)\/p\/([a-zA-Z0-9_\-]+)\/?/i,
                type : 'image',
                url  : '//$1/p/$2/media/?size=l'
            },
            google_maps : {
                matcher : /maps\.google\.([a-z]{2,3}(\.[a-z]{2})?)\/(\?ll=|maps\?)(.*)/i,
                type : 'iframe',
                url  : function( rez ) {
                    return '//maps.google.' + rez[1] + '/' + rez[3] + '' + rez[4] + '&output=' + (rez[4].indexOf('layer=c') > 0 ? 'svembed' : 'embed');
                }
            } 
        },

        beforeLoad : function(opts, obj) {
            var url   = obj.href || '',
                type  = false,
                what,
                item,
                rez,
                params;

            for (what in opts) {
                if (opts.hasOwnProperty(what)) {
                    item = opts[ what ];
                    rez  = url.match( item.matcher );

                    if (rez) {
                        type   = item.type;
                        params = $.extend(true, {}, item.params, obj[ what ] || ($.isPlainObject(opts[ what ]) ? opts[ what ].params : null));

                        url = $.type( item.url ) === "function" ? item.url.call( this, rez, params, obj ) : format( item.url, rez, params );

                        break;
                    }
                }
            }

            if (type) {
                obj.href = url;
                obj.type = type;

                obj.autoHeight = false;
            }
        }
    };

}(jQuery));



jQuery(document).ready(function(){
	jQuery('.alsp-masonry-grid').masonry({
  // set itemSelector so .grid-sizer is not used in layout
 itemSelector: '.grid-item',
  // use element for option
  //resize: true,
  columnWidth: 0,
 // gutter: 0,
  percentPosition: true,
  //horizontalOrder: true
  
});
//}

jQuery(".header-hover-style-1 .current-menu-item a.menu-item-link").append('<div class="nav-hover-style1"><span></span><span></span><span></span></div>');

	jQuery('.pacz-header-mainnavbar li.cat-item:has(ul.children)').addClass('dropdown-submenu');
	jQuery('.pacz-header-mainnavbar ul.children').addClass('dropdown-menu');
  jQuery('.pacz-header-mainnavbar li.cat-item').on("mouseenter", function(e){
    jQuery(this).children('ul.children').show();
    e.stopPropagation();
    e.preventDefault();
  });
  jQuery('pacz-header-mainnavbar li.cat-item').on("mouseleave", function(e){
    jQuery(this).children('ul.children').hide();
    e.stopPropagation();
    e.preventDefault();
  });
  
 /* $('.chosen').chosen({
    width: '100%',
    allow_single_deselect: true,
	disable_search_threshold: 10,
	no_results_text: 'Oops, nothing found!',
	rtl: true,
	
});*/
 jQuery('.pacz-select2').select2();
// $('.select2 span').addClass('needsclick')

/*var $owl = $( '.alsp-listings-block-content .owl-carousel, .alsp-categories-row.owl-carousel, testimonial-main .owl-carousel' );
	$owl.hide();
$owl.on('initialized.owl.carousel', function(event){ 
	$owl.show();
});
$owl.owlCarousel();*/

});