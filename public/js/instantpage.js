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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/instantpage-3.0.0.js":
/*!*******************************************!*\
  !*** ./resources/js/instantpage-3.0.0.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*! instant.page v3.0.0 - (C) 2019 Alexandre Dieulot - https://instant.page/license */
var t, e;
var n = new Set(),
    o = document.createElement("link"),
    s = o.relList && o.relList.supports && o.relList.supports("prefetch") && window.IntersectionObserver && "isIntersecting" in IntersectionObserverEntry.prototype,
    i = "instantAllowQueryString" in document.body.dataset,
    r = "instantAllowExternalLinks" in document.body.dataset,
    a = "instantWhitelist" in document.body.dataset;
var c = 65,
    d = !1,
    l = !1,
    u = !1;

if ("instantIntensity" in document.body.dataset) {
  var _t = document.body.dataset.instantIntensity;
  if ("mousedown" == _t.substr(0, "mousedown".length)) d = !0, "mousedown-only" == _t && (l = !0);else if ("viewport" == _t.substr(0, "viewport".length)) navigator.connection && (navigator.connection.saveData || navigator.connection.effectiveType.includes("2g")) || ("viewport" == _t ? document.documentElement.clientWidth * document.documentElement.clientHeight < 45e4 && (u = !0) : "viewport-all" == _t && (u = !0));else {
    var _e = parseInt(_t);

    isNaN(_e) || (c = _e);
  }
}

if (s) {
  var _n = {
    capture: !0,
    passive: !0
  };

  if (l || document.addEventListener("touchstart", function (t) {
    e = performance.now();
    var n = t.target.closest("a");
    if (!f(n)) return;
    h(n.href);
  }, _n), d ? document.addEventListener("mousedown", function (t) {
    var e = t.target.closest("a");
    if (!f(e)) return;
    h(e.href);
  }, _n) : document.addEventListener("mouseover", function (n) {
    if (performance.now() - e < 1100) return;
    var o = n.target.closest("a");
    if (!f(o)) return;
    o.addEventListener("mouseout", m, {
      passive: !0
    }), t = setTimeout(function () {
      h(o.href), t = void 0;
    }, c);
  }, _n), u) {
    var _t2;

    (_t2 = window.requestIdleCallback ? function (t) {
      requestIdleCallback(t, {
        timeout: 1500
      });
    } : function (t) {
      t();
    })(function () {
      var t = new IntersectionObserver(function (e) {
        e.forEach(function (e) {
          if (e.isIntersecting) {
            var _n2 = e.target;
            t.unobserve(_n2), h(_n2.href);
          }
        });
      });
      document.querySelectorAll("a").forEach(function (e) {
        f(e) && t.observe(e);
      });
    });
  }
}

function m(e) {
  e.relatedTarget && e.target.closest("a") == e.relatedTarget.closest("a") || t && (clearTimeout(t), t = void 0);
}

function f(t) {
  if (t && t.href && (!a || "instant" in t.dataset) && (r || t.origin == location.origin || "instant" in t.dataset) && ["http:", "https:"].includes(t.protocol) && ("http:" != t.protocol || "https:" != location.protocol) && (i || !t.search || "instant" in t.dataset) && !(t.hash && t.pathname + t.search == location.pathname + location.search || "noInstant" in t.dataset)) return !0;
}

function h(t) {
  if (n.has(t)) return;
  var e = document.createElement("link");
  e.rel = "prefetch", e.href = t, document.head.appendChild(e), n.add(t);
}

/***/ }),

/***/ 1:
/*!*************************************************!*\
  !*** multi ./resources/js/instantpage-3.0.0.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Gitea\Limg\resources\js\instantpage-3.0.0.js */"./resources/js/instantpage-3.0.0.js");


/***/ })

/******/ });