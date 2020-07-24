/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*
Template Name: Ubold - Responsive Bootstrap 4 Admin Dashboard
Author: CoderThemes
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: Main Js File
*/
!function ($) {
  "use strict";

  var Components = function Components() {}; //initializing tooltip


  Components.prototype.initTooltipPlugin = function () {
    $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
  }, //initializing popover
  Components.prototype.initPopoverPlugin = function () {
    $.fn.popover && $('[data-toggle="popover"]').popover();
  }, //initializing toast
  Components.prototype.initToastPlugin = function () {
    $.fn.toast && $('[data-toggle="toast"]').toast();
  }, //initializing form validation
  Components.prototype.initFormValidation = function () {
    $(".needs-validation").on('submit', function (event) {
      $(this).addClass('was-validated');

      if ($(this)[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        return false;
      }

      return true;
    });
  }, // Counterup
  Components.prototype.initCounterUp = function () {
    var delay = $(this).attr('data-delay') ? $(this).attr('data-delay') : 100; //default is 100

    var time = $(this).attr('data-time') ? $(this).attr('data-time') : 1200; //default is 1200

    $('[data-plugin="counterup"]').each(function (idx, obj) {
      $(this).counterUp({
        delay: delay,
        time: time
      });
    });
  }, //peity charts
  Components.prototype.initPeityCharts = function () {
    $('[data-plugin="peity-pie"]').each(function (idx, obj) {
      var colors = $(this).attr('data-colors') ? $(this).attr('data-colors').split(",") : [];
      var width = $(this).attr('data-width') ? $(this).attr('data-width') : 20; //default is 20

      var height = $(this).attr('data-height') ? $(this).attr('data-height') : 20; //default is 20

      $(this).peity("pie", {
        fill: colors,
        width: width,
        height: height
      });
    }); //donut

    $('[data-plugin="peity-donut"]').each(function (idx, obj) {
      var colors = $(this).attr('data-colors') ? $(this).attr('data-colors').split(",") : [];
      var width = $(this).attr('data-width') ? $(this).attr('data-width') : 20; //default is 20

      var height = $(this).attr('data-height') ? $(this).attr('data-height') : 20; //default is 20

      $(this).peity("donut", {
        fill: colors,
        width: width,
        height: height
      });
    });
    $('[data-plugin="peity-donut-alt"]').each(function (idx, obj) {
      $(this).peity("donut");
    }); // line

    $('[data-plugin="peity-line"]').each(function (idx, obj) {
      $(this).peity("line", $(this).data());
    }); // bar

    $('[data-plugin="peity-bar"]').each(function (idx, obj) {
      var colors = $(this).attr('data-colors') ? $(this).attr('data-colors').split(",") : [];
      var width = $(this).attr('data-width') ? $(this).attr('data-width') : 20; //default is 20

      var height = $(this).attr('data-height') ? $(this).attr('data-height') : 20; //default is 20

      $(this).peity("bar", {
        fill: colors,
        width: width,
        height: height
      });
    });
  }, Components.prototype.initKnob = function () {
    $('[data-plugin="knob"]').each(function (idx, obj) {
      $(this).knob();
    });
  }, Components.prototype.initTippyTooltips = function () {
    if ($('[data-plugin="tippy"]').length > 0) tippy('[data-plugin="tippy"]');
  }, Components.prototype.initShowPassword = function () {
    $("[data-password]").on('click', function () {
      if ($(this).attr('data-password') == "false") {
        $(this).siblings("input").attr("type", "text");
        $(this).attr('data-password', 'true');
        $(this).addClass("show-password");
      } else {
        $(this).siblings("input").attr("type", "password");
        $(this).attr('data-password', 'false');
        $(this).removeClass("show-password");
      }
    });
  }, Components.prototype.initMultiDropdown = function () {
    $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
      if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
      }

      var $subMenu = $(this).next(".dropdown-menu");
      $subMenu.toggleClass('show');
      return false;
    });
  }, //initilizing
  Components.prototype.init = function () {
    this.initTooltipPlugin(), this.initPopoverPlugin(), this.initToastPlugin(), this.initFormValidation(), this.initCounterUp(), this.initPeityCharts(), this.initKnob();
    this.initTippyTooltips();
    this.initShowPassword();
    this.initMultiDropdown();
  }, $.Components = new Components(), $.Components.Constructor = Components;
}(window.jQuery), function ($) {
  "use strict";
  /**
  Portlet Widget
  */

  var Portlet = function Portlet() {
    this.$body = $("body"), this.$portletIdentifier = ".card", this.$portletCloser = '.card a[data-toggle="remove"]', this.$portletRefresher = '.card a[data-toggle="reload"]';
  }; //on init


  Portlet.prototype.init = function () {
    // Panel closest
    var $this = this;
    $(document).on("click", this.$portletCloser, function (ev) {
      ev.preventDefault();
      var $portlet = $(this).closest($this.$portletIdentifier);
      var $portlet_parent = $portlet.parent();
      $portlet.remove();

      if ($portlet_parent.children().length == 0) {
        $portlet_parent.remove();
      }
    }); // Panel Reload

    $(document).on("click", this.$portletRefresher, function (ev) {
      ev.preventDefault();
      var $portlet = $(this).closest($this.$portletIdentifier); // This is just a simulation, nothing is going to be reloaded

      $portlet.append('<div class="card-disabled"><div class="card-portlets-loader"></div></div>');
      var $pd = $portlet.find('.card-disabled');
      setTimeout(function () {
        $pd.fadeOut('fast', function () {
          $pd.remove();
        });
      }, 500 + 300 * (Math.random() * 5));
    });
  }, //
  $.Portlet = new Portlet(), $.Portlet.Constructor = Portlet;
}(window.jQuery), function ($) {
  'use strict';

  var App = function App() {
    this.$body = $('body'), this.$window = $(window);
  };
  /** 
   * Initlizes the controls
  */


  App.prototype.initControls = function () {
    // Preloader
    $(window).on('load', function () {
      $('#status').fadeOut();
      $('#preloader').delay(350).fadeOut('slow');
    });
    $('[data-toggle="fullscreen"]').on("click", function (e) {
      e.preventDefault();
      $('body').toggleClass('fullscreen-enable');

      if (!document.fullscreenElement &&
      /* alternative standard method */
      !document.mozFullScreenElement && !document.webkitFullscreenElement) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        }
      }
    });
    document.addEventListener('fullscreenchange', exitHandler);
    document.addEventListener("webkitfullscreenchange", exitHandler);
    document.addEventListener("mozfullscreenchange", exitHandler);

    function exitHandler() {
      if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
        console.log('pressed');
        $('body').removeClass('fullscreen-enable');
      }
    }
  }, //initilizing
  App.prototype.init = function () {
    $.Portlet.init();
    $.Components.init();
    this.initControls(); // init layout

    this.layout = $.LayoutThemeApp;
    this.rightBar = $.RightBar;
    this.rightBar.layout = this.layout;
    this.layout.rightBar = this.rightBar;
    this.layout.init();
    this.rightBar.init(this.layout); // showing the sidebar on load if user is visiting the page first time only

    var bodyConfig = this.$body.data('layout');

    if (window.sessionStorage && bodyConfig && bodyConfig.hasOwnProperty('showRightSidebarOnPageLoad') && bodyConfig['showRightSidebarOnPageLoad']) {
      var alreadyVisited = sessionStorage.getItem("_UBOLD_VISITED_");

      if (!alreadyVisited) {
        $.RightBar.toggleRightSideBar();
        sessionStorage.setItem("_UBOLD_VISITED_", true);
      }
    }
  }, $.App = new App(), $.App.Constructor = App;
}(window.jQuery), //initializing main application module
function ($) {
  "use strict";

  $.App.init();
}(window.jQuery); // Waves Effect

Waves.init(); // Feather Icons

feather.replace();

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /var/www/html/lawasan/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /var/www/html/lawasan/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });