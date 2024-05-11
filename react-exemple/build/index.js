/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./component/App.jsx":
/*!***************************!*\
  !*** ./component/App.jsx ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   App: () => (/* binding */ App)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);

const {
  useState
} = wp.element;
function App() {
  const [currentDiv, setCurrentDiv] = useState(1);
  const handleContinue = () => {
    if (currentDiv < 3) {
      setCurrentDiv(currentDiv + 1);
    }
  };
  const handleBack = () => {
    if (currentDiv <= 3) {
      setCurrentDiv(currentDiv - 1);
    }
  };
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, currentDiv === 1 && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "transition-enter"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", null, "Div 1"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    onClick: handleContinue
  }, "Continuer")), currentDiv === 2 && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "transition-enter"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", null, "Div 2"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    onClick: handleContinue
  }, "Continuer"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    onClick: handleBack
  }, "Retour")), currentDiv === 3 && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "transition-enter"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", null, "Div 3"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    onClick: handleContinue
  }, "Continuer"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    onClick: handleBack
  }, "Retour")));
}
;

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***********************!*\
  !*** ./src/index.jsx ***!
  \***********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _component_App__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../component/App */ "./component/App.jsx");

// in src/index.js

// Added lines to use wp.element instead of importing React
const {
  render
} = wp.element;


// Render the app inside our shortcode's #app div
render((0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_component_App__WEBPACK_IMPORTED_MODULE_1__.App, null), document.getElementById('app'));
})();

/******/ })()
;
//# sourceMappingURL=index.js.map