// /*!
// Waypoints - 4.0.1
// Copyright © 2011-2016 Caleb Troughton
// Licensed under the MIT license.
// https://github.com/imakewebthings/waypoints/blob/master/licenses.txt
// */
// !function(){"use strict";function t(o){if(!o)throw new Error("No options passed to Waypoint constructor");if(!o.element)throw new Error("No element option passed to Waypoint constructor");if(!o.handler)throw new Error("No handler option passed to Waypoint constructor");this.key="waypoint-"+e,this.options=t.Adapter.extend({},t.defaults,o),this.element=this.options.element,this.adapter=new t.Adapter(this.element),this.callback=o.handler,this.axis=this.options.horizontal?"horizontal":"vertical",this.enabled=this.options.enabled,this.triggerPoint=null,this.group=t.Group.findOrCreate({name:this.options.group,axis:this.axis}),this.context=t.Context.findOrCreateByElement(this.options.context),t.offsetAliases[this.options.offset]&&(this.options.offset=t.offsetAliases[this.options.offset]),this.group.add(this),this.context.add(this),i[this.key]=this,e+=1}var e=0,i={};t.prototype.queueTrigger=function(t){this.group.queueTrigger(this,t)},t.prototype.trigger=function(t){this.enabled&&this.callback&&this.callback.apply(this,t)},t.prototype.destroy=function(){this.context.remove(this),this.group.remove(this),delete i[this.key]},t.prototype.disable=function(){return this.enabled=!1,this},t.prototype.enable=function(){return this.context.refresh(),this.enabled=!0,this},t.prototype.next=function(){return this.group.next(this)},t.prototype.previous=function(){return this.group.previous(this)},t.invokeAll=function(t){var e=[];for(var o in i)e.push(i[o]);for(var n=0,r=e.length;r>n;n++)e[n][t]()},t.destroyAll=function(){t.invokeAll("destroy")},t.disableAll=function(){t.invokeAll("disable")},t.enableAll=function(){t.Context.refreshAll();for(var e in i)i[e].enabled=!0;return this},t.refreshAll=function(){t.Context.refreshAll()},t.viewportHeight=function(){return window.innerHeight||document.documentElement.clientHeight},t.viewportWidth=function(){return document.documentElement.clientWidth},t.adapters=[],t.defaults={context:window,continuous:!0,enabled:!0,group:"default",horizontal:!1,offset:0},t.offsetAliases={"bottom-in-view":function(){return this.context.innerHeight()-this.adapter.outerHeight()},"right-in-view":function(){return this.context.innerWidth()-this.adapter.outerWidth()}},window.Waypoint=t}(),function(){"use strict";function t(t){window.setTimeout(t,1e3/60)}function e(t){this.element=t,this.Adapter=n.Adapter,this.adapter=new this.Adapter(t),this.key="waypoint-context-"+i,this.didScroll=!1,this.didResize=!1,this.oldScroll={x:this.adapter.scrollLeft(),y:this.adapter.scrollTop()},this.waypoints={vertical:{},horizontal:{}},t.waypointContextKey=this.key,o[t.waypointContextKey]=this,i+=1,n.windowContext||(n.windowContext=!0,n.windowContext=new e(window)),this.createThrottledScrollHandler(),this.createThrottledResizeHandler()}var i=0,o={},n=window.Waypoint,r=window.onload;e.prototype.add=function(t){var e=t.options.horizontal?"horizontal":"vertical";this.waypoints[e][t.key]=t,this.refresh()},e.prototype.checkEmpty=function(){var t=this.Adapter.isEmptyObject(this.waypoints.horizontal),e=this.Adapter.isEmptyObject(this.waypoints.vertical),i=this.element==this.element.window;t&&e&&!i&&(this.adapter.off(".waypoints"),delete o[this.key])},e.prototype.createThrottledResizeHandler=function(){function t(){e.handleResize(),e.didResize=!1}var e=this;this.adapter.on("resize.waypoints",function(){e.didResize||(e.didResize=!0,n.requestAnimationFrame(t))})},e.prototype.createThrottledScrollHandler=function(){function t(){e.handleScroll(),e.didScroll=!1}var e=this;this.adapter.on("scroll.waypoints",function(){(!e.didScroll||n.isTouch)&&(e.didScroll=!0,n.requestAnimationFrame(t))})},e.prototype.handleResize=function(){n.Context.refreshAll()},e.prototype.handleScroll=function(){var t={},e={horizontal:{newScroll:this.adapter.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.adapter.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};for(var i in e){var o=e[i],n=o.newScroll>o.oldScroll,r=n?o.forward:o.backward;for(var s in this.waypoints[i]){var a=this.waypoints[i][s];if(null!==a.triggerPoint){var l=o.oldScroll<a.triggerPoint,h=o.newScroll>=a.triggerPoint,p=l&&h,u=!l&&!h;(p||u)&&(a.queueTrigger(r),t[a.group.id]=a.group)}}}for(var c in t)t[c].flushTriggers();this.oldScroll={x:e.horizontal.newScroll,y:e.vertical.newScroll}},e.prototype.innerHeight=function(){return this.element==this.element.window?n.viewportHeight():this.adapter.innerHeight()},e.prototype.remove=function(t){delete this.waypoints[t.axis][t.key],this.checkEmpty()},e.prototype.innerWidth=function(){return this.element==this.element.window?n.viewportWidth():this.adapter.innerWidth()},e.prototype.destroy=function(){var t=[];for(var e in this.waypoints)for(var i in this.waypoints[e])t.push(this.waypoints[e][i]);for(var o=0,n=t.length;n>o;o++)t[o].destroy()},e.prototype.refresh=function(){var t,e=this.element==this.element.window,i=e?void 0:this.adapter.offset(),o={};this.handleScroll(),t={horizontal:{contextOffset:e?0:i.left,contextScroll:e?0:this.oldScroll.x,contextDimension:this.innerWidth(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:e?0:i.top,contextScroll:e?0:this.oldScroll.y,contextDimension:this.innerHeight(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};for(var r in t){var s=t[r];for(var a in this.waypoints[r]){var l,h,p,u,c,d=this.waypoints[r][a],f=d.options.offset,w=d.triggerPoint,y=0,g=null==w;d.element!==d.element.window&&(y=d.adapter.offset()[s.offsetProp]),"function"==typeof f?f=f.apply(d):"string"==typeof f&&(f=parseFloat(f),d.options.offset.indexOf("%")>-1&&(f=Math.ceil(s.contextDimension*f/100))),l=s.contextScroll-s.contextOffset,d.triggerPoint=Math.floor(y+l-f),h=w<s.oldScroll,p=d.triggerPoint>=s.oldScroll,u=h&&p,c=!h&&!p,!g&&u?(d.queueTrigger(s.backward),o[d.group.id]=d.group):!g&&c?(d.queueTrigger(s.forward),o[d.group.id]=d.group):g&&s.oldScroll>=d.triggerPoint&&(d.queueTrigger(s.forward),o[d.group.id]=d.group)}}return n.requestAnimationFrame(function(){for(var t in o)o[t].flushTriggers()}),this},e.findOrCreateByElement=function(t){return e.findByElement(t)||new e(t)},e.refreshAll=function(){for(var t in o)o[t].refresh()},e.findByElement=function(t){return o[t.waypointContextKey]},window.onload=function(){r&&r(),e.refreshAll()},n.requestAnimationFrame=function(e){var i=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||t;i.call(window,e)},n.Context=e}(),function(){"use strict";function t(t,e){return t.triggerPoint-e.triggerPoint}function e(t,e){return e.triggerPoint-t.triggerPoint}function i(t){this.name=t.name,this.axis=t.axis,this.id=this.name+"-"+this.axis,this.waypoints=[],this.clearTriggerQueues(),o[this.axis][this.name]=this}var o={vertical:{},horizontal:{}},n=window.Waypoint;i.prototype.add=function(t){this.waypoints.push(t)},i.prototype.clearTriggerQueues=function(){this.triggerQueues={up:[],down:[],left:[],right:[]}},i.prototype.flushTriggers=function(){for(var i in this.triggerQueues){var o=this.triggerQueues[i],n="up"===i||"left"===i;o.sort(n?e:t);for(var r=0,s=o.length;s>r;r+=1){var a=o[r];(a.options.continuous||r===o.length-1)&&a.trigger([i])}}this.clearTriggerQueues()},i.prototype.next=function(e){this.waypoints.sort(t);var i=n.Adapter.inArray(e,this.waypoints),o=i===this.waypoints.length-1;return o?null:this.waypoints[i+1]},i.prototype.previous=function(e){this.waypoints.sort(t);var i=n.Adapter.inArray(e,this.waypoints);return i?this.waypoints[i-1]:null},i.prototype.queueTrigger=function(t,e){this.triggerQueues[e].push(t)},i.prototype.remove=function(t){var e=n.Adapter.inArray(t,this.waypoints);e>-1&&this.waypoints.splice(e,1)},i.prototype.first=function(){return this.waypoints[0]},i.prototype.last=function(){return this.waypoints[this.waypoints.length-1]},i.findOrCreate=function(t){return o[t.axis][t.name]||new i(t)},n.Group=i}(),function(){"use strict";function t(t){this.$element=e(t)}var e=window.jQuery,i=window.Waypoint;e.each(["innerHeight","innerWidth","off","offset","on","outerHeight","outerWidth","scrollLeft","scrollTop"],function(e,i){t.prototype[i]=function(){var t=Array.prototype.slice.call(arguments);return this.$element[i].apply(this.$element,t)}}),e.each(["extend","inArray","isEmptyObject"],function(i,o){t[o]=e[o]}),i.adapters.push({name:"jquery",Adapter:t}),i.Adapter=t}(),function(){"use strict";function t(t){return function(){var i=[],o=arguments[0];return t.isFunction(arguments[0])&&(o=t.extend({},arguments[1]),o.handler=arguments[0]),this.each(function(){var n=t.extend({},o,{element:this});"string"==typeof n.context&&(n.context=t(this).closest(n.context)[0]),i.push(new e(n))}),i}}var e=window.Waypoint;window.jQuery&&(window.jQuery.fn.waypoint=t(window.jQuery)),window.Zepto&&(window.Zepto.fn.waypoint=t(window.Zepto))}();;
// window.bioEp = {
//   // Private variables
//   bgEl: {},
//   popupEl: {},
//   closeBtnEl: {},
//   shown: false,
//   overflowDefault: "visible",
//   transformDefault: "",
//
//   // Popup options
//   width: 800,
//   height: 420,
//   html: "",
//   css: "",
//   fonts: [],
//   delay: 2,
//   showOnDelay: false,
//   cookieExp: 0,
//   showOncePerSession: false,
//   onPopup: null,
//
//   // Object for handling cookies, taken from QuirksMode
//   // http://www.quirksmode.org/js/cookies.html
//   cookieManager: {
//     // Create a cookie
//     create: function(name, value, days, sessionOnly) {
//       var expires = "";
//
//       if(sessionOnly)
//         expires = "; expires=0"
//       else if(days) {
//         var date = new Date();
//         date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
//         expires = "; expires=" + date.toGMTString();
//       }
//
//       document.cookie = name + "=" + value + expires + "; path=/";
//     },
//
//     // Get the value of a cookie
//     get: function(name) {
//       var nameEQ = name + "=";
//       var ca = document.cookie.split(";");
//
//       for(var i = 0; i < ca.length; i++) {
//         var c = ca[i];
//         while (c.charAt(0) == " ") c = c.substring(1, c.length);
//         if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
//       }
//
//       return null;
//     },
//
//     // Delete a cookie
//     erase: function(name) {
//       this.create(name, "", -1);
//     }
//   },
//
//   // Handle the bioep_shown cookie
//   // If present and true, return true
//   // If not present or false, create and return false
//   checkCookie: function() {
//     // Handle cookie reset
//     if(this.cookieExp <= 0) {
//       // Handle showing pop up once per browser session.
//       if(this.showOncePerSession && this.cookieManager.get("bioep_shown_session") == "true")
//         return true;
//
//       this.cookieManager.erase("bioep_shown");
//       return false;
//     }
//
//     // If cookie is set to true
//     if(this.cookieManager.get("bioep_shown") == "true")
//       return true;
//
//     return false;
//   },
//
//   // Add font stylesheets and CSS for the popup
//   addCSS: function() {
//     // Add font stylesheets
//     for(var i = 0; i < this.fonts.length; i++) {
//       var font = document.createElement("link");
//       font.href = this.fonts[i];
//       font.type = "text/css";
//       font.rel = "stylesheet";
//       document.head.appendChild(font);
//     }
//
//     // Base CSS styles for the popup
//     var css = document.createTextNode(
//       "#bio_ep_bg {display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #000; opacity: 0.7; z-index: 10001;}" +
//       "#bio_ep {display: none; position: fixed; width: " + this.width + "px; height: auto; font-family: 'Titillium Web', sans-serif; font-size: 16px; left: 50%; top: 50%; transform: translateX(-50%) translateY(-50%); -webkit-transform: translateX(-50%) translateY(-50%); -ms-transform: translateX(-50%) translateY(-50%); background-color: #fff; box-shadow: 0px 1px 4px 0 rgba(0,0,0,0.5); z-index: 10002;}" +
//       "#bio_ep_close {position: absolute; left: 100%; margin: -8px 0 0 -12px; padding: 5px; width: 40px; height: 40px; color: #fff; font-size: 20px; font-weight: bold; text-align: center; border-radius: 50%; background-color: #5c5c5c; cursor: pointer;}" +
//       this.css
//     );
//
//     // Create the style element
//     var style = document.createElement("style");
//     style.type = "text/css";
//     style.appendChild(css);
//
//     // Insert it before other existing style
//     // elements so user CSS isn't overwritten
//     document.head.appendChild(style);
//   },
//
//   // Add the popup to the page
//   addPopup: function() {
//     // Add the background div
//     this.bgEl = document.createElement("div");
//     this.bgEl.id = "bio_ep_bg";
//     document.body.appendChild(this.bgEl);
//
//     // Add the popup
//     if(document.getElementById("bio_ep"))
//       this.popupEl = document.getElementById("bio_ep");
//     else {
//       this.popupEl = document.createElement("div");
//       this.popupEl.id = "bio_ep";
//       this.popupEl.innerHTML = this.html;
//       document.body.appendChild(this.popupEl);
//     }
//
//     // Add the close button
//     if(document.getElementById("bio_ep_close"))
//       this.closeBtnEl = document.getElementById("bio_ep_close");
//     else {
//       this.closeBtnEl = document.createElement("div");
//       this.closeBtnEl.id = "bio_ep_close";
//       this.closeBtnEl.appendChild(document.createTextNode("X"));
//       this.popupEl.insertBefore(this.closeBtnEl, this.popupEl.firstChild);
//     }
//   },
//
//   // Show the popup
//   showPopup: function() {
//     if(this.shown) return;
//
//     this.bgEl.style.display = "block";
//     this.popupEl.style.display = "block";
//
//     // Handle scaling
//     this.scalePopup();
//
//     // Save body overflow value and hide scrollbars
//     this.overflowDefault = document.body.style.overflow;
//     document.body.style.overflow = "hidden";
//
//     this.shown = true;
//
//     this.cookieManager.create("bioep_shown", "true", this.cookieExp, false);
//     this.cookieManager.create("bioep_shown_session", "true", 0, true);
//
//     if(typeof this.onPopup === "function") {
//       this.onPopup();
//     }
//   },
//
//   // Hide the popup
//   hidePopup: function() {
//     this.bgEl.style.display = "none";
//     this.popupEl.style.display = "none";
//
//     // Set body overflow back to default to show scrollbars
//     document.body.style.overflow = this.overflowDefault;
//   },
//
//   // Handle scaling the popup
//   scalePopup: function() {
//     var margins = { width: 40, height: 40 };
//     var popupSize = { width: bioEp.popupEl.offsetWidth, height: bioEp.popupEl.offsetHeight };
//     var windowSize = { width: window.innerWidth, height: window.innerHeight };
//     var newSize = { width: 0, height: 0 };
//     var aspectRatio = popupSize.width / popupSize.height;
//
//     // First go by width, if the popup is larger than the window, scale it
//     if(popupSize.width > (windowSize.width - margins.width)) {
//       newSize.width = windowSize.width - margins.width;
//       newSize.height = newSize.width / aspectRatio;
//
//       // If the height is still too big, scale again
//       if(newSize.height > (windowSize.height - margins.height)) {
//         newSize.height = windowSize.height - margins.height;
//         newSize.width = newSize.height * aspectRatio;
//       }
//     }
//
//     // If width is fine, check for height
//     if(newSize.height === 0) {
//       if(popupSize.height > (windowSize.height - margins.height)) {
//         newSize.height = windowSize.height - margins.height;
//         newSize.width = newSize.height * aspectRatio;
//       }
//     }
//
//     // Set the scale amount
//     var scaleTo = newSize.width / popupSize.width;
//
//     // If the scale ratio is 0 or is going to enlarge (over 1) set it to 1
//     if(scaleTo <= 0 || scaleTo > 1) scaleTo = 1;
//
//     // Save current transform style
//     if(this.transformDefault === "")
//       this.transformDefault = window.getComputedStyle(this.popupEl, null).getPropertyValue("transform");
//
//     // Apply the scale transformation
//     this.popupEl.style.transform = this.transformDefault + " scale(" + scaleTo + ")";
//   },
//
//   // Event listener initialisation for all browsers
//   addEvent: function (obj, event, callback) {
//     if(obj.addEventListener)
//       obj.addEventListener(event, callback, false);
//     else if(obj.attachEvent)
//       obj.attachEvent("on" + event, callback);
//   },
//
//   // Load event listeners for the popup
//   loadEvents: function() {
//     // Track mouseout event on document
//     this.addEvent(document, "mouseout", function(e) {
//       e = e ? e : window.event;
//
//       // If this is an autocomplete element.
//       if(e.target.tagName.toLowerCase() == "input")
//         return;
//
//       // Get the current viewport width.
//       var vpWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
//
//       // If the current mouse X position is within 50px of the right edge
//       // of the viewport, return.
//       if(e.clientX >= (vpWidth - 50))
//         return;
//
//       // If the current mouse Y position is not within 50px of the top
//       // edge of the viewport, return.
//       if(e.clientY >= 50)
//         return;
//
//       // Reliable, works on mouse exiting window and
//       // user switching active program
//       var from = e.relatedTarget || e.toElement;
//       if(!from)
//         bioEp.showPopup();
//     }.bind(this));
//
//     // Handle the popup close button
//     this.addEvent(this.closeBtnEl, "click", function() {
//       bioEp.hidePopup();
//     });
//
//     // Handle window resizing
//     this.addEvent(window, "resize", function() {
//       bioEp.scalePopup();
//     });
//   },
//
//   // Set user defined options for the popup
//   setOptions: function(opts) {
//     this.width = (typeof opts.width === 'undefined') ? this.width : opts.width;
//     this.height = (typeof opts.height === 'undefined') ? this.height : opts.height;
//     this.html = (typeof opts.html === 'undefined') ? this.html : opts.html;
//     this.css = (typeof opts.css === 'undefined') ? this.css : opts.css;
//     this.fonts = (typeof opts.fonts === 'undefined') ? this.fonts : opts.fonts;
//     this.delay = (typeof opts.delay === 'undefined') ? this.delay : opts.delay;
//     this.showOnDelay = (typeof opts.showOnDelay === 'undefined') ? this.showOnDelay : opts.showOnDelay;
//     this.cookieExp = (typeof opts.cookieExp === 'undefined') ? this.cookieExp : opts.cookieExp;
//     this.showOncePerSession = (typeof opts.showOncePerSession === 'undefined') ? this.showOncePerSession : opts.showOncePerSession;
//     this.onPopup = (typeof opts.onPopup === 'undefined') ? this.onPopup : opts.onPopup;
//   },
//
//   // Ensure the DOM has loaded
//   domReady: function(callback) {
//     (document.readyState === "interactive" || document.readyState === "complete") ? callback() : this.addEvent(document, "DOMContentLoaded", callback);
//   },
//
//   // Initialize
//   init: function(opts) {
//     // Handle options
//     if(typeof opts !== 'undefined')
//       this.setOptions(opts);
//
//     // Add CSS here to make sure user HTML is hidden regardless of cookie
//     this.addCSS();
//
//     // Once the DOM has fully loaded
//     this.domReady(function() {
//       // Handle the cookie
//       if(bioEp.checkCookie()) return;
//
//       // Add the popup
//       bioEp.addPopup();
//
//       // Load events
//       setTimeout(function() {
//         bioEp.loadEvents();
//
//         if(bioEp.showOnDelay)
//           bioEp.showPopup();
//       }, bioEp.delay * 1000);
//     });
//   }
// }
// ;
// (function ($) {
//   Drupal.behaviors.modalPopup = {
//     attach: function (context, settings) {
//       if (settings.ctas.modal_popup) {
//         var block_id = "#block-block-" + settings.ctas.modal_popup.delta;
//         if (block_id === '#block-block-cta_modal_winter_2017') {
//           block_id = '#block-ctas-cta-modal-winter-2017';
//         }
//
//         $(block_id)
//           .once()
//           .addClass('cta-processed modal-popup')
//           .hide()
//           .appendTo('body');
//
//         // Log the number of vists.
//         var already_donated = localStorage.getItem('commondreams.cta.already_donated');
//         if (!already_donated) {
//           var count = 1;
//           if (localStorage.getItem('commondreams.cta.' + block_id + '.page_views')) {
//             count = localStorage.getItem('commondreams.cta.' + block_id + '.page_views');
//             count++;
//             localStorage.setItem('commondreams.cta.' + block_id + '.page_views', count);
//           }
//           else {
//             localStorage.setItem('commondreams.cta.' + block_id + '.page_views', 1);
//           }
//
//           if (settings.ctas.modal_popup.after_page_views) {
//             if (count === parseFloat(settings.ctas.modal_popup.after_page_views)) {
//               $(block_id).show();
//               bioEp.init({
//                 html: '',
//                 css: '',
//                 showOnDelay: true
//               });
//               // Restart the count.
//               //localStorage.setItem('commondreams.cta.' + block_id + '.page_views', 1);
//             }
//
//           }
//         }
//         else {
//           $(block_id).remove();
//         }
//
//         // Already donated button.
//         $(block_id).find(".already_donated").click(function() {
//           localStorage.setItem('commondreams.cta.already_donated', 1);
//           bioEp.hidePopup();
//           // Hide all other ctas.
//           $(".cta-processed").hide();
//         });
//
//         // Extra close modal functionality.
//         $("#close-modal").click(function(e) {
//           bioEp.hidePopup();
//           e.preventDefault();
//         });
//
//       }
//     }
//   }
// })(jQuery);
// ;
