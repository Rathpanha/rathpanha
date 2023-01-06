$(document).ready(function(){
  $(".wrap-post-feed .post-feed-text").click(function(){
    $(this).addClass("show");
    $(".wrap-post-feed .post-feed-inputs").addClass("show");
  });
  
  $(".wrap-post-feed .post-feed-text[autofocus]").click();// Force autofocus

  $(document).click(function(e) {
    let container = $(".wrap-post-feed");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      $(".wrap-post-feed .post-feed-text").removeClass("show");
      $(".wrap-post-feed .post-feed-inputs").removeClass("show");
    }
  });
  
  $(".post-feed-thumbnail-input").change(function(e){
    let reader = new FileReader();
    let img = $(this).next("img");
    reader.onload = function (e) {
      // get loaded data and render thumbnail.
      img.attr("src", e.target.result);
    };

    if(typeof this.files[0] != "undefined") {
      // read the image file as a data URL.
      reader.readAsDataURL(this.files[0]);
    } else {
      console.log("Error while loading image.");
    }
  });
});
//Prevent form submit more than once when slow internet connection 
$(document).ready(function(){
	$("form").submit(function(e){
		$(this).find(":submit").attr("disabled", true);
	});
});(function ( $ ) {
	$.fn.RPImageUpload = function(options = {}){
		let elm = $(this);
		elm.attr("accept", "image/*");
		
		//Create image element
		let wrap_img = $("<div></div>");
		wrap_img.css("border", "1px solid #626567")
						.css("padding", "0.25rem")
						.css("position", "relative");
		let loading = $("<div>Loading Preview <i class='fas fa-cog fa-spin'></i></div>");
		loading.css("width", "100%")
					 .css("height", "100%")
					 .css("text-align", "right")
					 .css("background", "rgba(255, 255, 255, 0.8)")
					 .css("position", "absolute")
					 .css("top", 0)
					 .css("left", 0)
					 .css("display", "none")
					 .css("padding", "0.25rem")
					 .css("user-select", "none");
					 
		
		let img = $("<img src='" + options.img_default + "'/>");
		img.css("height", (typeof options.img_height === "undefined" ? "100px" : options.img_height)) 
			 .css("max-width", "100%")
			 .css("border", "1px dashed #626567")
			 .css("margin", "0.25rem")
			 .css("vertical-align", "top");
		
		wrap_img.append(loading).append(img);
		
		elm.change(function(){
			let reader = new FileReader();
			let srcOrientation;
			let srcBase64;
			
			reader.onload = function (e) {
				// get loaded data and render thumbnail.
				srcBase64 = e.target.result;
				resetOrientation(img, srcOrientation, srcBase64, function(){
					loading.hide();
				});
			};

			if(typeof this.files[0] != "undefined") {
				// read the image file as a data URL.
				reader.readAsDataURL(this.files[0]);
				loading.show();
				getOrientation(this.files[0], function(orientation){
					srcOrientation = orientation;
				});
			} else {
				img.attr("src", options.img_default);
			}
		});

		elm.before(wrap_img);
	};
	
	$.fn.RPImageUploadMultiple = function(options = {}){
		let elm = $(this);
		elm.attr("accept", "image/*");
		elm.prop("multiple", true);
		
		//Create image element
		let wrap_img = $("<div></div>");
		wrap_img.css("border", "1px solid #626567")
						.css("padding", "0.25rem")
						.css("position", "relative");
		let loading = $("<div>Loading Preview <i class='fas fa-cog fa-spin'></i></div>");
		loading.css("width", "100%")
					 .css("height", "100%")
					 .css("text-align", "right")
					 .css("background", "rgba(255, 255, 255, 0.8)")
					 .css("position", "absolute")
					 .css("top", 0)
					 .css("left", 0)
					 .css("display", "none")
					 .css("padding", "0.25rem")
					 .css("user-select", "none");
					 
		
		let img = $("<img src='" + options.img_default + "'/>");
		img.css("height", (typeof options.img_height === "undefined" ? "100px" : options.img_height)) 
			 .css("max-width", "100%")
			 .css("border", "1px dashed #626567")
			 .css("margin", "0.25rem")
			 .css("vertical-align", "top");
		
		wrap_img.append(loading).append(img);
		
		elm.change(function(){
			let images = this.files;
			let i = 0;
			
			function loadImage(images) {
				let new_img = img.clone();
				let reader = new FileReader();
				let srcOrientation;
				let srcBase64;
				
				reader.onload = function (e) {
					// get loaded data and render thumbnail.
					srcBase64 = e.target.result;
					resetOrientation(new_img, srcOrientation, srcBase64, function(){
						if(i === 0) { wrap_img.find("img").remove(); }
						wrap_img.append(new_img);
						if((i + 1) === images.length) { 
							loading.hide();
						} else {
							i++;
							loadImage(images);
						}
					});
				};

				if(typeof images[i] != "undefined") {
					// read the image file as a data URL.
					reader.readAsDataURL(images[i]);
					loading.show();
					getOrientation(images[i], function(orientation){
						srcOrientation = orientation;
					});
				} else {
					new_img.attr("src", options.img_default);
				}
			}
			
			loadImage(images);
		});

		elm.before(wrap_img);
	};
	
	function resetOrientation(img, srcOrientation, srcBase64, callback) {
		let img_temp = new Image();
		img_temp.onload = function() {
			let width = img_temp.width,
					height = img_temp.height,
					canvas = document.createElement('canvas'),
					ctx = canvas.getContext("2d");

			// set proper canvas dimensions before transform & export
			if (4 < srcOrientation && srcOrientation < 9) {
				canvas.width = height;
				canvas.height = width;
			} else {
				canvas.width = width;
				canvas.height = height;
			}

			// transform context before drawing image
			switch (srcOrientation) {
				case 2: ctx.transform(-1, 0, 0, 1, width, 0); break;
				case 3: ctx.transform(-1, 0, 0, -1, width, height); break;
				case 4: ctx.transform(1, 0, 0, -1, 0, height); break;
				case 5: ctx.transform(0, 1, 1, 0, 0, 0); break;
				case 6: ctx.transform(0, 1, -1, 0, height, 0); break;
				case 7: ctx.transform(0, -1, -1, 0, height, width); break;
				case 8: ctx.transform(0, -1, 1, 0, 0, width); break;
				default: break;
			}

			// draw image
			ctx.drawImage(img_temp, 0, 0);

			// export base64
			//console.log(canvas.toDataURL());
			img.attr("src", canvas.toDataURL());
			callback();
		};

		img_temp.src = srcBase64;
	}
	
	function getOrientation(file, callback) {
		var reader = new FileReader();
		reader.onload = function(e) {
			var view = new DataView(e.target.result);
			if (view.getUint16(0, false) != 0xFFD8) {
				return callback(-2);
			}
			var length = view.byteLength, offset = 2;
			while (offset < length) {
				if (view.getUint16(offset+2, false) <= 8) return callback(-1);
				var marker = view.getUint16(offset, false);
				offset += 2;
				if (marker == 0xFFE1) {
					if (view.getUint32(offset += 2, false) != 0x45786966) {
						return callback(-1);
					}

					var little = view.getUint16(offset += 6, false) == 0x4949;
					offset += view.getUint32(offset + 4, little);
					var tags = view.getUint16(offset, little);
					offset += 2;
					for (var i = 0; i < tags; i++) {
						if (view.getUint16(offset + (i * 12), little) == 0x0112) {
							return callback(view.getUint16(offset + (i * 12) + 8, little));
						}
					}
				}
				else if ((marker & 0xFF00) != 0xFF00) {
					break;
				}
				else{ 
					offset += view.getUint16(offset, false);
				}
			}
			return callback(-1);
		};
		reader.readAsArrayBuffer(file);
	}
}( jQuery ));$(document).ready(function(){
	var _inputs_range = $("input[type=range]");
	_inputs_range.each(function(){
		var self = $(this);
    
		var wrap_div = $("<div></div>");
		wrap_div.css("position", "relative")
				.css("height", "36px")
        .css("margin-bottom", "0.5rem");
        
    if(typeof self.attr("no-reset") === "undefined" && typeof self.attr("no-display-value") === "undefined") {
      wrap_div.css("border", "1px solid #AAA")
              .css("border-radius", "2px");
  
      self.css("position", "absolute")
          .css("left", "0px")
          .css("bottom", "0px")
          .css("height", "auto")
          .css("margin", "0.5rem 0rem");
    } else {
      self.css("margin", "0rem")
          .css("padding", "0rem");
    }

    if(typeof self.attr("no-display-value") === "undefined") {
      var value = $("<span>" + (self.val() == -1 ? "Not set" : self.val()) + "</span>");
      value.css("position", "absolute")
         .css("left", "4px")
         .css("top", "0px")
         .css("font-size", "0.9rem");
    }
    
    if(typeof self.attr("no-reset") === "undefined") {
      var clear = $("<span title='Reset'>✖</span>");
      clear.css("position", "absolute")
         .css("right", "4px")
         .css("top", "0px")
         .css("font-size", "0.9rem")
         .css("cursor", "pointer");
      clear.click(function(){
        self.prop("min", -1);
        self.val(-1);
        self.prev().text("Not set");
      });
    }

		self.after(wrap_div);
		wrap_div.append(value).append(self).append(clear);
	});
	
	$("input[type=range]").on("input change", function(){
		var self = $(this);  
		if(self.val() >= 0) {
			self.prop("min", 0);
		}
		
		self.prev().text(self.val());
	});
});$(document).ready(function(){	
	//Push scroll up for fixed nav 
	var elements = $('input,select,textarea');
	for(var i = elements.length; i--;)
		elements[i].addEventListener('invalid', function(){ 
			this.scrollIntoView(false); 
		});
});$(document).ready(function(){
	$(".nav_side").click(function(e){
		$(".side_menu").css("position", "fixed");
		$(".side_menu").toggle("slide", {direction: "up"}, 150);
	});
});
function onElementHeightChange(elm, callback){
    var lastHeight = elm.clientHeight, newHeight;
    (function run(){
        newHeight = elm.clientHeight;
        if( lastHeight != newHeight )
            callback();
        lastHeight = newHeight;

        if( elm.onElementHeightChangeTimer )
            clearTimeout(elm.onElementHeightChangeTimer);

        elm.onElementHeightChangeTimer = setTimeout(run, 0);
    })();
}$(document).ready(function(){
	$(".rp-image-list .items .wrap-img").click(function(){
		let img = $(this).find("img").clone();
		let elm_wrap = $("<div></div>");
		elm_wrap.addClass("rp-image-fullscreen");
		
		let elm_close = $("<div><i class='fas fa-times fa-2x'></i></div>");
		elm_close.addClass("rp-image-fullscreen-close");
		elm_close.click(function(){
			$(this).parent().remove();
		});
		
		elm_wrap.append(img).append(elm_close);
		$(document.body).append(elm_wrap);
	});
});
var RPScreen = {
  getSize: function(options){
    options = options || {};
    return RPScreen.calculateSize(options);
  },
  
  calculateSize: function(options){
    var screen = {};
    var forceWidth = options.forceWidth ? true : false;
    var forceHeight = options.forceHeight ? true : false;
    var width = typeof options.width === "undefined" ? window.innerWidth : options.width;
        width = typeof options.maxWidth !== "undefined" && width > options.maxWidth ? options.maxWidth : width;
    var height = typeof options.height === "undefined" ? window.innerHeight : options.height;
        height = typeof options.maxHeight !== "undefined" && height > options.maxHeight ? options.maxHeight : height;
    
    if(typeof options.ratio !== "undefined") {
      var ratioWidth = parseInt(options.ratio.split(":")[0]);
      var ratioHeight = parseInt(options.ratio.split(":")[1]);

      if(width >= height && !forceWidth) {
        width = height * (ratioWidth / ratioHeight);
      } else if(forceWidth) {
        height = width * (ratioHeight / ratioWidth);
      }

      if(width < height && !forceHeight) {
        height = width * (ratioHeight / ratioWidth);
      } else if(forceHeight) {
        width = height * (ratioWidth / ratioHeight);
      }
    }
    
    
    screen.width = width;
    screen.height = height;
    return screen;
  }
};$(document).ready(function() {
	$('.share .fa').click(function() {
		var href = window.location.origin + $(this).closest('.share').data('link');
		
		if ( $(this).hasClass('fa-facebook') ) {
			window.open('https://www.facebook.com/sharer/sharer.php?u=' + href, 'Facebook','width=626,height=436');
		} else if ( $(this).hasClass('fa-twitter') ) {
			window.open('https://twitter.com/share?url='+ href, 'Twitter','width=626,height=436');
		} else if ( $(this).hasClass('fa-google-plus') ) {
			window.open('https://plus.google.com/share?url=' + href, 'Google','width=626,height=436');
		}
	});
});$(document).ready(function(){
	$(".side-menu-toggle").click(function(e){
		$(".side-menu").toggleClass("show");
		$(".side-menu-cover").toggle();
		shrinkHeight();
		e.preventDefault();
	});
	
	$(".side-menu-cover").click(function(){
		$(".side-menu").toggleClass("show");
		$(this).toggle();
	});
	
	$(".side-menu .wrap-items .wrap-sub").each(function(){
		if($(this).find(".items.active").length > 0) {
			var ico_toggle = $("<i class='fas fa-caret-up fa-lg fa-fw toggle'></i>");
			$(this).prev().append(ico_toggle);
			$(this).show();
		} else {
			var ico_toggle = $("<i class='fas fa-caret-down fa-lg fa-fw toggle'></i>");
			$(this).prev().append(ico_toggle);
		}
	});
	
	$(".side-menu .wrap-items .items.parent").click(function(e){
		$($(this).find("i")[1]).toggleClass("fa-caret-down fa-caret-up");
		$(this).next().toggle("blind", 150);
		e.preventDefault();
	});
	
	function shrinkHeight() {
		var wScrollTop = $(window).scrollTop();
		var wHeight = $(window).outerHeight();
		var dHeight = $(document).outerHeight();
		var fHeight = dHeight - $("footer").position().top;
		var navHeight = $(".nav").outerHeight();
		var hHeight = $(".side-menu .side-menu-header").outerHeight();
		
		if((wScrollTop + wHeight) >= (dHeight - fHeight)) {
			var minusHeight = (wScrollTop + wHeight) - (dHeight - fHeight);
			$(".side-menu").css("height", "calc(100vh - " + (navHeight + minusHeight) + "px)");
			$(".side-menu .wrap-items").css("height", "calc(100vh - " + (navHeight + minusHeight + hHeight) + "px)");
			$(".side-menu-cover").css("height", "calc(100vh - " + (minusHeight + navHeight) + "px)");
		} else {
			$(".side-menu").css("height", "calc(100vh - " + navHeight + "px)");
			$(".side-menu .wrap-items").css("height", "calc(100vh - " + (navHeight + hHeight) + "px)");
			$(".side-menu-cover").css("height", "calc(100vh - " + navHeight + "px)")
		}
	}
	shrinkHeight();
	
	function showAdminMenu() {
		if($(window).width() > 768) {
			$(".side-menu.admin").addClass("show");
		} else {
			$(".side-menu.admin").removeClass("show");
		}
	}
	showAdminMenu();

	onElementHeightChange(document.body, function(){
		shrinkHeight();
		showAdminMenu();
	});
	
	$(window).scroll(function(){
		shrinkHeight();
	});
});$(document).ready(function(){
	$(".wrap-table").each(function(){
		let cur_down = false;
		let cur_x_pos = 0;
		let cur_y_pos = 0;
		let container = $(this);
		container.addClass("ds-grab");

		//Check if container is used or not
		if(typeof container === "undefined") {
			return;
		}

		$(window).mousemove(function(m){
			if(cur_down === true){
				let cal_pos_x = (cur_x_pos - m.pageX);
				let cal_pos_y = (cur_y_pos - m.pageY);
				container.scrollLeft(cal_pos_x);
				container.scrollTop(cal_pos_y);
			}
		});

		container.mousedown(function(m){
			container.removeClass("ds-grab");
			container.addClass("ds-grabbing");
			cur_down = true;
			cur_x_pos = m.pageX + $(this).scrollLeft();
			cur_y_pos = m.pageY + $(this).scrollTop();
      
      m.stopPropagation();
		});

		$(window).mouseup(function(){
			cur_down = false;
			container.removeClass("ds-grabbing");
			container.addClass("ds-grab");
		});
	});
});
$(document).ready(function(){
	//Scrolling
	var cur_down = false;
	var cur_x_pos = 0;
	var toolbar = $(".wrap-toolbar .toolbar");
	var item_width = toolbar.find(".item").outerWidth();
	
	//Check if toolbar is used or not
	if(typeof toolbar[0] === "undefined") {
		return;
	}
	
	$(window).mousemove(function(m){
		if(cur_down === true){
			var cal_pos = (cur_x_pos - m.pageX);
			toolbar.scrollLeft(cal_pos);
		}
	});
	
	toolbar.mousedown(function(m){
		cur_down = true;
		cur_x_pos = m.pageX + $(this).scrollLeft();
		down_scroll = $(this).scrollLeft();

		m.preventDefault();
	});
	
	$(window).mouseup(function(){
		cur_down = false;
		up_scroll = toolbar.scrollLeft();
	});
	
	//Button scroll
	//Generate buttons
	var left = $("<i class='fa fa-chevron-left fa-2x icons left'></i>");
	var right = $("<i class='fa fa-chevron-right fa-2x icons right'></i>");
	toolbar.parent().prepend(left).prepend(right);
	
	toolbar.scroll(function(){
		if($(this).scrollLeft() >= item_width) {
			left.show("fast");
		} else {
			left.hide("fast");
		}
		
		if($(this)[0].scrollWidth - $(this).outerWidth() > $(this).scrollLeft()) {
			right.show("fast");
		} else {
			right.hide("fast");
		}
	});
	
	left.click(function(){
		var scroll_x_pos = Math.ceil(Math.floor((toolbar.scrollLeft() - 1) / item_width) * item_width);
		toolbar.animate({scrollLeft : scroll_x_pos}, 50);
	});
	
	right.click(function(){
		var scroll_x_pos = Math.ceil(Math.ceil((toolbar.scrollLeft() + 1) / item_width) * item_width);
		toolbar.animate({scrollLeft : scroll_x_pos}, 50);
	});
	
	//Scroll to active item
	var active_item = toolbar.find(".item.active");
	if(active_item.length > 0 && active_item.position().left + active_item.outerWidth() > toolbar.outerWidth()) {
		toolbar.scrollLeft(active_item.position().left);
	} else {
		if(toolbar[0].scrollWidth > toolbar.outerWidth()) {
			right.show("fast");
		}
	}
	
	//Prevent clicking a when user scroll
	var down_scroll = 0;
	var up_scroll = 0;
	toolbar.find("a").each(function(){
		$(this).click(function(e){
			if(down_scroll != up_scroll) {
				e.preventDefault();
			}
		});
	});
	
	function showToolbar() {
		$(".wrap-toolbar").addClass("show");
	}
	showToolbar();
});function twoDigits(d) {
    if(0 <= d && d < 10) return "0" + d.toString();
    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
    return d.toString();
}

Date.prototype.toMysqlFormat = function() {
    return this.getUTCFullYear() + "-" + twoDigits(1 + this.getUTCMonth()) + "-" + twoDigits(this.getUTCDate()) + " " + twoDigits(this.getUTCHours()) + ":" + twoDigits(this.getUTCMinutes()) + ":" + twoDigits(this.getUTCSeconds());
};App = {};
//Popup
App.Popup = {
	ShowBackground : function() {
		if (typeof App.Popup._background === "undefined") {
			App.Popup._background = $("<div></div>");
			App.Popup._background.css("background", "rgba(0, 0, 0, 0.9)")
                                             .css("position", "fixed")
                                             .css("width", "100%")
                                             .css("height", "100%")
                                             .css("left", 0)
                                             .css("top", 0)
                                             .css("z-index", 1000)
                                             .css("display", "flex");
			
			$(document.body).append(App.Popup._background);
		}
		
		App.Popup._background.show();
	},
	
	TurnBlockIntoPopup : function(id, position) {
		var obj = $(id);
    obj.css("overflow-y", "auto");
		// If we use to wrap it once, we don't need to do it again
		if ( obj.parent().data("wrap") === "done" ) return;
		
		obj.wrap("<div data-wrap='done' class='wrap-popup'></div>");
		var wrap = obj.parent();
		
		//If show at top position
		if(position == "top") {
			wrap.css("margin", "15% auto auto auto");
		}
			
		
		var title = obj.data("title");
		var titlebar = $("<div class='popup-title'><div class='title'>" + title + "</div></div>");
		var button_close = $("<div id='close-popup' class='popup-close'>×</div>");
		
		button_close.click(function() {
			$(".body_wrapper").removeClass("overflow_y_hidden");
			
			wrap.hide();
			App.Popup._background.hide();
		});
		
		titlebar.append(button_close);
		wrap.prepend(titlebar);
		App.Popup._background.append(wrap);
	},
	
	Show : function(id, position = "middle") {
    App.Popup.ShowBackground();
    App.Popup.TurnBlockIntoPopup(id, position);

    //Prevent body from scroll
    $(".body_wrapper").addClass("overflow_y_hidden");
    
    var wrap = $(id).parent();
    $(id).show();
    wrap.show();
	},
	
	Hide : function(id) {
    App.Popup._background.hide();
    $(id).parent().hide();
	}
};

//Error
App.Error = {
  Create : function(parent_id, options = {})
  {
  //Don't create error div if already have
  if($(parent_id).find("._error").length > 0) {
    return;
  }
  
  error_div = $("<div class='_error'></div>");
  error_div.css("display", "none")
       .css("min-width", options.width != "" ? options.width : "auto");

  var ul = $("<ul></ul>");
  ul.css("margin", "0px");
  ul.css("padding", "10px 25px");

  error_div.append(ul);
  $(parent_id).prepend(error_div);
  },
  
  Add : function(parent_id, message, options = {}) {
    App.Error.Create(parent_id, options);
    var error_div = $(parent_id).find("._error");
    //If message already add don't
    var already_added = false;
    error_div.find("ul li").each(function(){
      if($(this).text() === message) {
        already_added = true;
      };
    });
      
      if(already_added) {
    $(document).scrollTop(0);
      return;
    }
      
    var li = $("<li><label class='m0'>" + message + "</label></li>");

    error_div.find("ul").append(li);
  
    App.Error.Show(parent_id);
  },
  
  Clear : function(parent_id) {
    $(parent_id).find("._error").find("ul").empty();
  },
  
  Show : function(parent_id) {
    if(!$(parent_id).find("._error").is(':visible')) {
      $(parent_id).find("._error").show();
    }
  
    $(document).scrollTop(0);
  },
  
  Hide : function(parent_id) {
    $(parent_id).find("._error").hide();
  }
};

//Prompt
App.Prompt = {
  prompt_result : false,
  wrap_prompt: null,

  Prepare : function(id) {
    if(!App.Prompt.prompt_result) {
      //Cerate prompt wrap background
      App.Prompt.wrap_prompt = $("<div></div>");
      App.Prompt.wrap_prompt.addClass("wrap-prompt");

      //Create inside div
      var prompt_div = $("<div></div>");
      prompt_div.addClass("prompt-div");		

      //Cerate title div
      var prompt_title = $("<div></div>");
      prompt_title.text($(id).data("title"));
      prompt_title.addClass("prompt-title");

      //Create text div
      var promp_text = $("<div></div>");
      promp_text.text($(id).data("text"));
      promp_text.addClass("prompt-text");

      //Cerate yes no button
      var yes_button = $("<button>Yes</button>");
      var no_button = $("<button>No</button>");

      //Add event to each button
      yes_button.click(function(){
        $(App.Prompt.wrap_prompt).remove();
        App.Prompt.wrap_prompt = null;
        App.Prompt.prompt_result = true;
        //If a tag redirect instead
        if($(id).is("a")) {
          window.location.href = $(id).attr("href");
        } else {
          $(id).click();
          App.Prompt.prompt_result = false;
        }
      });

      no_button.click(function(){
        $(App.Prompt.wrap_prompt).remove();
        App.Prompt.wrap_prompt = null;
        App.Prompt.prompt_result = false;
      });

      var yes_no_div = $("<div></div>");
      yes_no_div.addClass("prompt-button");

      //Append all elements
      App.Prompt.wrap_prompt.append(prompt_div);
      yes_no_div.append(yes_button, no_button);
      prompt_div.append(prompt_title, promp_text, yes_no_div);

      $(document.body).append(App.Prompt.wrap_prompt);
    }
    
    return App.Prompt.prompt_result;
  },
    
  Use : function(id) {
  if(App.Prompt.wrap_prompt === null) { //Prevent duplicate prompt popup
    return App.Prompt.Prepare(id);
  }
  
  return false;
  }
};

//Notification
App.Notification = {
	Prepare: function(){
		var badge;
		if($(".badge").length === 1) {
			badge = $(".badge");
			badge.text(parseInt(badge.text()) + 1);
		} else {
			badge = $("<div class='badge'>0</div>");
			badge.text(parseInt(badge.text()) + 1);
			$(".notifications").prepend(badge);
		} 
		
		$(".notifications > i").addClass("animated");
	},
	
	Add: function(message = {}){
		App.Notification.Prepare();
		
		var item = '<a class="items unread" title="' + message.text + '" href="' + message.link + '">' +
						'<img class="img" src="' + message.thumbnail + '"/>' +
						'<div class="message">' +
							'<div class="text">' + message.description + '</div>' +
							'<div class="elapse-time"><i class="fas fa-clock fw"></i> Just now</div>' +
						'</div>' +
					'</a>';
					
		$(".notifications > .wrapper > .wrapper-items").prepend(item);
		$(".notifications > .wrapper > .wrapper-items > .no-notification").remove();
		$(".notifications > .wrapper > .footer").text("Show all notifications");
	}
};$.fn.dragScroll = function(options = {}){
  var cur_down = false;
  var cur_x_pos = 0;
  var cur_y_pos = 0;
  var container = $(this);
  container.addClass("ds-grab");

  //Check if container is used or not
  if(typeof container === "undefined") {
    return;
  }

  $(window).mousemove(function(m){
    if(cur_down === true){
      var cal_pos_x = (cur_x_pos - m.pageX);
      var cal_pos_y = (cur_y_pos - m.pageY);
      container.scrollLeft(cal_pos_x);
      container.scrollTop(cal_pos_y);
    }
  });

  container.mousedown(function(m){
    container.removeClass("ds-grab");
    container.addClass("ds-grabbing");
    cur_down = true;
    cur_x_pos = m.pageX + $(this).scrollLeft();
    cur_y_pos = m.pageY + $(this).scrollTop();
    
    m.preventDefault();
  });

  $(window).mouseup(function(){
    cur_down = false;
    container.removeClass("ds-grabbing");
    container.addClass("ds-grab");
  });
}