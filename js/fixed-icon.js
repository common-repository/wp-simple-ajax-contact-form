
(function ($) {
	var ColorPicker = function () {


			HexToRGB = function (hex) {
				var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
				return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
			},
			HexToHSB = function (hex) {
				return RGBToHSB(HexToRGB(hex));
			},
			RGBToHSB = function (rgb) {
				var hsb = {
					h: 0,
					s: 0,
					b: 0
				};
				var min = Math.min(rgb.r, rgb.g, rgb.b);
				var max = Math.max(rgb.r, rgb.g, rgb.b);
				var delta = max - min;
				hsb.b = max;
				if (max != 0) {
					
				}
				hsb.s = max != 0 ? 255 * delta / max : 0;
				if (hsb.s != 0) {
					if (rgb.r == max) {
						hsb.h = (rgb.g - rgb.b) / delta;
					} else if (rgb.g == max) {
						hsb.h = 2 + (rgb.b - rgb.r) / delta;
					} else {
						hsb.h = 4 + (rgb.r - rgb.g) / delta;
					}
				} else {
					hsb.h = -1;
				}
				hsb.h *= 60;
				if (hsb.h < 0) {
					hsb.h += 360;
				}
				hsb.s *= 100/255;
				hsb.b *= 100/255;
				return hsb;
			},


			restoreOriginal = function () {
				var cal = $(this).parent();
				var col = cal.data('colorpicker').origColor;
				cal.data('colorpicker').color = col;
				fillRGBFields(col, cal.get(0));
				fillHexFields(col, cal.get(0));
				fillHSBFields(col, cal.get(0));
				setSelector(col, cal.get(0));
				setHue(col, cal.get(0));
				setNewColor(col, cal.get(0));
			};
		return {
			init: function (opt) {
				opt = $.extend({}, defaults, opt||{});
				if (typeof opt.color == 'string') {
					opt.color = HexToHSB(opt.color);
				} else if (opt.color.r != undefined && opt.color.g != undefined && opt.color.b != undefined) {
					opt.color = RGBToHSB(opt.color);
				} else if (opt.color.h != undefined && opt.color.s != undefined && opt.color.b != undefined) {
					opt.color = fixHSB(opt.color);
				} else {
					return this;
				}

			},



		};
	}();
	$.fn.extend({
		ColorPicker: ColorPicker.init,
		ColorPickerHide: ColorPicker.hidePicker,
		ColorPickerShow: ColorPicker.showPicker,
		ColorPickerSetColor: ColorPicker.setColor
	});
})(jQuery)



jQuery.noConflict()(function($){
             $('.slide-out-div').tabSlideOut({
                 tabHandle: '.handle',                              //class of the element that will be your tab
                 pathToTabImage: '',          //path to the image for the tab (optionaly can be set using css)
                 imageHeight: '100px',                               //height of tab image
                 imageWidth: '50px',                               //width of tab image    
                tabLocation: 'left',                               //side of screen where tab lives, top, right, bottom, or left
                 speed: 300,                                        //speed of animation
                 action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
                 topPos: '100px',                                   //position from the top
                 fixedPosition: true                               //options: true makes it stick(fixed position) on scroll
             });
         });
		 



	



	
	

(function($){
    $.fn.tabSlideOut = function(callerSettings) {
        var settings = $.extend({
            tabHandle: '.handle',
            speed: 300, 
            action: 'click',
            tabLocation: 'left',
            topPos: '200px',
            leftPos: '20px',
            fixedPosition: false,
            positioning: 'absolute',
            pathToTabImage: null,
            imageHeight: null,
            imageWidth: null,
            onLoadSlideOut: false                       
        }, callerSettings||{});

        settings.tabHandle = $(settings.tabHandle);
        var obj = this;



        var properties = {
                    containerWidth: parseInt(obj.outerWidth(), 10) + 'px',
                    containerHeight: parseInt(obj.outerHeight(), 10) + 'px',
                    tabWidth: parseInt(settings.tabHandle.outerWidth(), 10) + 'px',
                    tabHeight: parseInt(settings.tabHandle.outerHeight(), 10) + 'px'
                };


        




        //functions for animation events
        
        settings.tabHandle.click(function(event){
            event.preventDefault();
        });
        
        var slideIn = function() {
            
            if (settings.tabLocation === 'top') {
                obj.animate({top:'-' + properties.containerHeight}, settings.speed).removeClass('open');
            } else if (settings.tabLocation === 'left') {
                obj.animate({left: '-' + properties.containerWidth}, settings.speed).removeClass('open');
            } else if (settings.tabLocation === 'right') {
                obj.animate({right: '-' + properties.containerWidth}, settings.speed).removeClass('open');
            } else if (settings.tabLocation === 'bottom') {
                obj.animate({bottom: '-' + properties.containerHeight}, settings.speed).removeClass('open');
            }    
            
        };
        
        var slideOut = function() {
            
            if (settings.tabLocation == 'top') {
                obj.animate({top:'-3px'},  settings.speed).addClass('open');
            } else if (settings.tabLocation == 'left') {
                obj.animate({left:'-3px'},  settings.speed).addClass('open');
            } else if (settings.tabLocation == 'right') {
                obj.animate({right:'-3px'},  settings.speed).addClass('open');
            } else if (settings.tabLocation == 'bottom') {
                obj.animate({bottom:'-3px'},  settings.speed).addClass('open');
            }
        };


        var clickAction = function(){
            settings.tabHandle.click(function(event){
                if (obj.hasClass('open')) {
                    slideIn();
                } else {
                    slideOut();
                }
            });
            
          /* clickScreenToClose();*/
        };
        


        //choose which type of action to bind
        if (settings.action === 'click') {
            clickAction();
        }


        
    };
})(jQuery);