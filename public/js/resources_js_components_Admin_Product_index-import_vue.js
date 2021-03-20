(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_components_Admin_Product_index-import_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Admin/Product/index-import.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Admin/Product/index-import.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
 // import moment from 'moment';
// import { core } from "../../../config/pluginInit";
// import SocialPost from './Components/SocialPost'
// import { Posts } from '../../../FackApi/api/SocialPost'
// import AddSocialPost from './Components/AddSocialPost'

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Brand",
  //   components: { AddSocialPost, SocialPost },
  mounted: function mounted() {// core.index();
  },
  created: function created() {},
  data: function data() {
    return {
      loadder: false,
      import_file: null,
      test: {
        activeLabel: "Yes",
        inactiveLabel: "No",
        label: "Danger",
        "class": "danger",
        checked: true
      },
      product: {
        id: 0,
        code: "",
        name: "",
        url: "",
        description: ".",
        detail: ".",
        regular_price: 0,
        discount: 0,
        price: 0,
        stock: 0,
        limit: true,
        valido_desde: new Date().toISOString().substr(0, 16),
        valido_hasta: new Date().toISOString().substr(0, 16),
        unit: "",
        brand: "",
        categorias: [],
        photos: [],
        state: true,
        opciones: 0,
        nameState: null
      },
      fields_: [{
        key: "codigo",
        label: "Codigo"
      }, {
        key: "marca",
        label: "Marca"
      }, {
        key: "unidad",
        label: "Unidad"
      }, {
        key: "categoria",
        label: "Categoria"
      }, {
        key: "nombre",
        label: "Nombre"
      }, {
        key: "descripcion",
        label: "Descripcion"
      }, {
        key: "detalle",
        label: "Detalle"
      }, {
        key: "precio",
        label: "Precio regular"
      }, {
        key: "precio_web",
        label: "Precio venta"
      }, {
        key: "descuento",
        label: "Descuento"
      }, {
        key: "stock",
        label: "Stock"
      }, {
        key: "limite",
        label: "Limite"
      }, {
        key: "valido_desde",
        label: "Valido desde"
      }, {
        key: "valido_hasta",
        label: "Valido hasta"
      }],
      items: [],
      brands: [],
      units: [],
      categories: [],
      product_inicial: {
        id: 0,
        code: "",
        name: "",
        url: "",
        description: ".",
        detail: ".",
        regular_price: 0,
        discount: 0,
        price: 0,
        stock: 0,
        limit: true,
        valido_desde: new Date().toISOString().substr(0, 16),
        valido_hasta: new Date().toISOString().substr(0, 16),
        unit: "",
        brand: "",
        categorias: [],
        photos: [],
        state: true,
        opciones: 0,
        nameState: null
      },
      modal: false,
      mostrr: "hide",
      submittedNames: [],
      currentPage: 1,
      per_page: 10,
      valorBuscar: "",
      search: "",
      correctos: 0,
      advertencias: 0,
      errores: 0,
      codigo: null,
      mensaje: null,
      codigopre: null,
      mensajepre: null
    };
  },
  methods: {
    importarExcel1: function importarExcel1() {
      var _this = this;

      this.loadder = true;
      var formData = new FormData();
      formData.append("import_file", this.import_file);
      axios__WEBPACK_IMPORTED_MODULE_0___default().post("".concat("http://sistemaorion.green.com.pe", "/api/v1/products/importar-excel"), formData, {
        headers: {
          "content-type": "multipart/form-data"
        }
      }).then(function (response) {
        if (response.status === 200) {
          console.log("Excel" + response.data.state);
          _this.items = [];
          _this.items = response.data.datos;
          _this.correctos = response.data.correctos;
          _this.advertencias = response.data.advertencias;
          _this.errores = response.data.errores;
        } else {
          console.log("error al subir el excel");
        }

        _this.loadder = false;
      })["catch"](function (error) {
        // this.error = error.response.data
        _this.codigopre = 0;
        _this.mensajepre = "Error en el formato del archivo subido";
        _this.loadder = false;
      });
    },
    importarExcel1Ya: function importarExcel1Ya() {
      var _this2 = this;

      this.loadder = true;
      var formData = new FormData();
      formData.append("import_file", this.import_file);
      axios__WEBPACK_IMPORTED_MODULE_0___default().post("".concat("http://sistemaorion.green.com.pe", "/api/v1/products/importar-excel-ya"), formData, {
        headers: {
          "content-type": "multipart/form-data"
        }
      }).then(function (response) {
        if (response.status === 200) {
          console.log("respuest:" + response.data.state);
          _this2.items = [];
          _this2.correctos = 0;
          _this2.advertencias = 0;
          _this2.errores = 0;
          _this2.codigo = 1;
          _this2.mensaje = "Datos guardados correctamente";
        } else {
          console.log("error al subir el excel");
        }

        _this2.loadder = false;
      })["catch"](function (error) {
        // this.error = error.response.data
        _this2.codigo = 0;
        _this2.mensaje = "Error al guardar los datos";
        _this2.loadder = false;
      });
    },
    importarExcel: function importarExcel() {
      this.importarExcel1();
    },
    importarExcelYa: function importarExcelYa() {
      this.importarExcel1Ya();
    },
    onFileChange: function onFileChange(e) {
      this.import_file = e.target.files[0];
    }
  },
  computed: {// correctos() {
    //   return this.items.filter(obj => {
    //     return obj.categoria.error.error == 0||obj.categoria.error.error == 0;
    //   }).length;
    // },
    // advertencias() {
    //   return this.items.filter(obj => {
    //     return obj.categoria.error.error == 1;
    //   }).length;
    // },
    // errores() {
    //   return this.items.filter(obj => {
    //     return obj.categoria.error.error == 2;
    //   }).length;
    // }
  }
});

/***/ }),

/***/ "./resources/js/components/Admin/Product/index-import.vue":
/*!****************************************************************!*\
  !*** ./resources/js/components/Admin/Product/index-import.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _index_import_vue_vue_type_template_id_543507ab___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index-import.vue?vue&type=template&id=543507ab& */ "./resources/js/components/Admin/Product/index-import.vue?vue&type=template&id=543507ab&");
/* harmony import */ var _index_import_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index-import.vue?vue&type=script&lang=js& */ "./resources/js/components/Admin/Product/index-import.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__.default)(
  _index_import_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__.default,
  _index_import_vue_vue_type_template_id_543507ab___WEBPACK_IMPORTED_MODULE_0__.render,
  _index_import_vue_vue_type_template_id_543507ab___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Admin/Product/index-import.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/Admin/Product/index-import.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/components/Admin/Product/index-import.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_import_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index-import.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Admin/Product/index-import.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_index_import_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__.default); 

/***/ }),

/***/ "./resources/js/components/Admin/Product/index-import.vue?vue&type=template&id=543507ab&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/Admin/Product/index-import.vue?vue&type=template&id=543507ab& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_import_vue_vue_type_template_id_543507ab___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_import_vue_vue_type_template_id_543507ab___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_index_import_vue_vue_type_template_id_543507ab___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./index-import.vue?vue&type=template&id=543507ab& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Admin/Product/index-import.vue?vue&type=template&id=543507ab&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Admin/Product/index-import.vue?vue&type=template&id=543507ab&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/Admin/Product/index-import.vue?vue&type=template&id=543507ab& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "card" }, [
    _c("div", { staticClass: "card-header" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-10" }, [
          _c("div", { staticClass: "custom-file" }, [
            _c("input", {
              staticClass: "custom-file-input",
              attrs: { type: "file", id: "photos", lang: "es" },
              on: { change: _vm.onFileChange }
            }),
            _vm._v(" "),
            _c(
              "label",
              { staticClass: "custom-file-label", attrs: { for: "photos" } },
              [_vm._v("Imagenes (solo formato jpg|jpeg)")]
            )
          ])
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "text-right col-2" }, [
          _vm.errores == 0 && (_vm.correctos > 0 || _vm.advertencias > 0)
            ? _c(
                "button",
                {
                  staticClass: "btn btn-success btn-block",
                  attrs: { type: "button" },
                  on: {
                    click: function($event) {
                      return _vm.importarExcelYa()
                    }
                  }
                },
                [
                  _c("i", { staticClass: "las la-file-excel" }),
                  _vm._v(" Importar ya!\n        ")
                ]
              )
            : _c(
                "button",
                {
                  staticClass: "btn btn-primary btn-block",
                  attrs: { id: "btn-importar" },
                  on: {
                    click: function($event) {
                      return _vm.importarExcel()
                    }
                  }
                },
                [
                  _c("i", { staticClass: "las la-file-excel" }),
                  _vm._v(" Vista Previa\n        ")
                ]
              )
        ])
      ])
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "card-body" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col-4 text-success" }, [
          _vm._v("Correctos:" + _vm._s(_vm.correctos))
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 text-warning" }, [
          _vm._v("Advertencias:" + _vm._s(_vm.advertencias))
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-4 text-danger" }, [
          _vm._v("Errores:" + _vm._s(_vm.errores))
        ])
      ]),
      _vm._v(" "),
      _vm.codigo == 1
        ? _c("p", [
            _c("b", { staticClass: "text-success" }, [
              _vm._v(_vm._s(_vm.mensaje))
            ])
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm.codigo == 0
        ? _c("p", [
            _c("b", { staticClass: "text-danger" }, [
              _vm._v(_vm._s(_vm.mensaje))
            ])
          ])
        : _vm._e(),
      _vm._v(" "),
      _vm.codigopre == 0
        ? _c("p", [
            _c("b", { staticClass: "text-danger" }, [
              _vm._v(_vm._s(_vm.mensajepre))
            ])
          ])
        : _vm._e(),
      _vm._v(" "),
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "text-center col-12" }, [
          _vm.loadder
            ? _c(
                "div",
                {
                  staticClass: "spinner-border text-primary",
                  staticStyle: { width: "3rem", height: "3rem" },
                  attrs: { role: "status" }
                },
                [_c("span", { staticClass: "sr-only" }, [_vm._v("Loading...")])]
              )
            : _vm._e()
        ]),
        _vm._v(" "),
        !_vm.loadder
          ? _c("div", { staticClass: "col-12" }, [
              _vm.items
                ? _c(
                    "table",
                    {
                      staticClass:
                        "table table-striped table-hover table-condensed table-responsive",
                      attrs: { id: "my-table" }
                    },
                    [
                      _c("thead", [
                        _c(
                          "tr",
                          _vm._l(_vm.fields_, function(item, key) {
                            return _c(
                              "th",
                              { key: key, attrs: { scope: "col" } },
                              [
                                _vm._v(
                                  "\n                " +
                                    _vm._s(item.label) +
                                    "\n              "
                                )
                              ]
                            )
                          }),
                          0
                        )
                      ]),
                      _vm._v(" "),
                      _c(
                        "tbody",
                        _vm._l(_vm.items, function(item, key) {
                          return _c("tr", { key: key }, [
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.codigo.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.codigo.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.codigo.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.codigo.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.codigo.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.codigo.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.codigo.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.marca.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.marca.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.marca.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.marca.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.marca.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.marca.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.marca.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.unidad.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.unidad.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.unidad.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.unidad.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.unidad.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.unidad.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.unidad.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.categoria.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.categoria.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.categoria.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.categoria.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.categoria.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.categoria.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.categoria.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.nombre.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.nombre.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.nombre.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.nombre.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.nombre.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.nombre.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.nombre.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(
                                  " " + _vm._s(item.descripcion.dato) + " "
                                )
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.descripcion.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.descripcion.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.descripcion.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.descripcion.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.descripcion.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.descripcion.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.detalle.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.detalle.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.detalle.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.detalle.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.detalle.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.detalle.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.detalle.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.precio.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.precio.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.precio.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.precio.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.precio.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.precio.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.precio.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.precio_web.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.precio_web.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.precio_web.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.precio_web.error.error == 1
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.precio_web.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.precio_web.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.precio_web.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.descuento.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.descuento.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.descuento.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.descuento.error.error == 1
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.descuento.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.descuento.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.descuento.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.stock.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.stock.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.stock.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.stock.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.stock.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.stock.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.stock.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(" " + _vm._s(item.limite.dato) + " ")
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.limite.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.limite.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.limite.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.limite.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.limite.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.limite.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(
                                  " " + _vm._s(item.valido_desde.dato) + " "
                                )
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.valido_desde.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.valido_desde.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.valido_desde.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.valido_desde.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.valido_desde.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.valido_desde.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ]),
                            _vm._v(" "),
                            _c("td", [
                              _c("span", [
                                _vm._v(
                                  " " + _vm._s(item.valido_hasta.dato) + " "
                                )
                              ]),
                              _c("br"),
                              _vm._v(" "),
                              item.valido_hasta.error.error == 0
                                ? _c("span", { staticClass: "text-success" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.valido_hasta.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.valido_hasta.error.error == 1
                                ? _c("span", { staticClass: "text-warning" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.valido_hasta.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : item.valido_hasta.error.error == 2
                                ? _c("span", { staticClass: "text-danger" }, [
                                    _vm._v(
                                      "\n                  " +
                                        _vm._s(item.valido_hasta.error.msj) +
                                        "\n                "
                                    )
                                  ])
                                : _vm._e()
                            ])
                          ])
                        }),
                        0
                      )
                    ]
                  )
                : _vm._e()
            ])
          : _vm._e()
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js":
/*!********************************************************************!*\
  !*** ./node_modules/vue-loader/lib/runtime/componentNormalizer.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ normalizeComponent)
/* harmony export */ });
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () {
        injectStyles.call(
          this,
          (options.functional ? this.parent : this).$root.$options.shadowRoot
        )
      }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functional component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}


/***/ })

}]);