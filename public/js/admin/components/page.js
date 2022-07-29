"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["components/page"],{

/***/ "./node_modules/vuetify-loader/lib/loader.js??ruleSet[1].rules[0].use!./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/js/components/Overviews/Page.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vuetify-loader/lib/loader.js??ruleSet[1].rules[0].use!./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/js/components/Overviews/Page.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _mixins_ComponentProperties__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../mixins/ComponentProperties */ "./resources/admin/js/mixins/ComponentProperties.js");
/* harmony import */ var _mixins_LazyImportProperties__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../mixins/LazyImportProperties */ "./resources/admin/js/mixins/LazyImportProperties.js");
/* harmony import */ var _ComponentLoading__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../ComponentLoading */ "./resources/admin/js/components/ComponentLoading.vue");
/* harmony import */ var _layout_Skeletons_SkeletonCard__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../layout/Skeletons/SkeletonCard */ "./resources/admin/js/layout/Skeletons/SkeletonCard.vue");
/* harmony import */ var _ComponentError__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../ComponentError */ "./resources/admin/js/components/ComponentError.vue");
/* harmony import */ var _layout_Skeletons_SkeletonDataTable__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../layout/Skeletons/SkeletonDataTable */ "./resources/admin/js/layout/Skeletons/SkeletonDataTable.vue");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }







/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Page",
  components: {
    ComponentLoading: _ComponentLoading__WEBPACK_IMPORTED_MODULE_2__["default"],
    Row: function Row() {
      return _objectSpread({
        component: __webpack_require__.e(/*! import() | components/layouts/row */ "components/layouts/row").then(__webpack_require__.bind(__webpack_require__, /*! ../Layouts/Row */ "./resources/admin/js/components/Layouts/Row.vue"))
      }, _mixins_LazyImportProperties__WEBPACK_IMPORTED_MODULE_1__["default"]);
    },
    Table: function Table() {
      return {
        component: __webpack_require__.e(/*! import() | components/overviews/table */ "components/overviews/table").then(__webpack_require__.bind(__webpack_require__, /*! ./Table */ "./resources/admin/js/components/Overviews/Table.vue")),
        loading: _layout_Skeletons_SkeletonDataTable__WEBPACK_IMPORTED_MODULE_5__["default"],
        delay: 0,
        error: _ComponentError__WEBPACK_IMPORTED_MODULE_4__["default"],
        timeout: 10000
      };
    },
    Card: function Card() {
      return {
        component: Promise.all(/*! import() | components/overviews/card */[__webpack_require__.e("css/admin/app"), __webpack_require__.e("components/overviews/card")]).then(__webpack_require__.bind(__webpack_require__, /*! ../Overviews/Card */ "./resources/admin/js/components/Overviews/Card.vue")),
        loading: _layout_Skeletons_SkeletonCard__WEBPACK_IMPORTED_MODULE_3__["default"],
        delay: 0,
        error: _ComponentError__WEBPACK_IMPORTED_MODULE_4__["default"],
        timeout: 10000
      };
    }
  },
  mixins: [_mixins_ComponentProperties__WEBPACK_IMPORTED_MODULE_0__["default"]],
  data: function data() {
    return {
      component: {},
      route: this.value.data.route,
      runLoader: this.value.data.runLoader,
      vuexNamespace: this.value.data.vuexNamespace,
      callbackDelay: this.value.data.callbackDelay,
      hasVuexNamespace: this.value.data.vuexNamespace !== undefined,
      hasCallbackDelay: this.value.data.callbackDelay !== undefined
    };
  },
  computed: {
    isLoad: function isLoad() {
      return Object.keys(this.overview).length !== 0;
    },
    overview: function overview() {
      if (this.vuexNamespace !== undefined) {
        return this.$store.getters["".concat(this.vuexNamespace, "/component")];
      }

      return this.component;
    }
  },
  created: function created() {
    var _this = this;

    this.$routeLoader.convertStringToRouteParams();

    if (this.route !== undefined) {
      this.load();
    }

    if (this.hasCallbackDelay) {
      this.interval = setInterval(function () {
        _this.load();
      }, this.callbackDelay);
    }

    if (this.runLoader !== undefined) {
      var vuexNamespace = typeof this.runLoader === 'string' ? this.runLoader : this.vuexNamespace;

      if (vuexNamespace !== undefined) {
        this.$routeLoader.runStateAction(vuexNamespace);
      }
    }
  },
  beforeDestroy: function beforeDestroy() {
    if (this.hasCallbackDelay) {
      clearInterval(this.interval);
    }
  },
  methods: {
    load: function load() {
      var _this2 = this;

      if (this.vuexNamespace !== undefined) {
        this.$store.dispatch("".concat(this.vuexNamespace, "/component"), this.route);
      } else {
        this.$api.call({
          url: this.route
        }).then(function (response) {
          _this2.component = response.data.component || {};
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/vuetify-loader/lib/loader.js??ruleSet[1].rules[0].use!./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/js/components/Overviews/Page.vue?vue&type=template&id=613a3d6f&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vuetify-loader/lib/loader.js??ruleSet[1].rules[0].use!./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/js/components/Overviews/Page.vue?vue&type=template&id=613a3d6f& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
      _c = _vm._self._c;

  return _c("div", [!_vm.isLoad ? [_c("ComponentLoading")] : _c(_vm.overview.componentName, {
    tag: "component",
    attrs: {
      value: _vm.overview
    }
  })], 2);
};

var staticRenderFns = [];
render._withStripped = true;


/***/ }),

/***/ "./resources/admin/js/components/Overviews/Page.vue":
/*!**********************************************************!*\
  !*** ./resources/admin/js/components/Overviews/Page.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Page_vue_vue_type_template_id_613a3d6f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Page.vue?vue&type=template&id=613a3d6f& */ "./resources/admin/js/components/Overviews/Page.vue?vue&type=template&id=613a3d6f&");
/* harmony import */ var _Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Page.vue?vue&type=script&lang=js& */ "./resources/admin/js/components/Overviews/Page.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Page_vue_vue_type_template_id_613a3d6f___WEBPACK_IMPORTED_MODULE_0__.render,
  _Page_vue_vue_type_template_id_613a3d6f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/admin/js/components/Overviews/Page.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/admin/js/components/Overviews/Page.vue?vue&type=script&lang=js&":
/*!***********************************************************************************!*\
  !*** ./resources/admin/js/components/Overviews/Page.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_vuetify_loader_lib_loader_js_ruleSet_1_rules_0_use_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vuetify-loader/lib/loader.js??ruleSet[1].rules[0].use!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Page.vue?vue&type=script&lang=js& */ "./node_modules/vuetify-loader/lib/loader.js??ruleSet[1].rules[0].use!./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/js/components/Overviews/Page.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_vuetify_loader_lib_loader_js_ruleSet_1_rules_0_use_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/admin/js/components/Overviews/Page.vue?vue&type=template&id=613a3d6f&":
/*!*****************************************************************************************!*\
  !*** ./resources/admin/js/components/Overviews/Page.vue?vue&type=template&id=613a3d6f& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vuetify_loader_lib_loader_js_ruleSet_1_rules_0_use_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_613a3d6f___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vuetify_loader_lib_loader_js_ruleSet_1_rules_0_use_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_613a3d6f___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vuetify_loader_lib_loader_js_ruleSet_1_rules_0_use_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Page_vue_vue_type_template_id_613a3d6f___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vuetify-loader/lib/loader.js??ruleSet[1].rules[0].use!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[3]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Page.vue?vue&type=template&id=613a3d6f& */ "./node_modules/vuetify-loader/lib/loader.js??ruleSet[1].rules[0].use!./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/admin/js/components/Overviews/Page.vue?vue&type=template&id=613a3d6f&");


/***/ })

}]);