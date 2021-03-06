<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-10">
          <div class="custom-file">
            <input
              type="file"
              class="custom-file-input"
              id="photos"
              lang="es"
              @change="onFileChange"
            />
            <label class="custom-file-label" for="photos"
              >Imagenes (solo formato jpg|jpeg)</label
            >
          </div>
        </div>

        <div class="text-right col-2">
          <!-- Button trigger modal -->
          <button
            v-if="errores == 0 && (correctos > 0 || advertencias > 0)"
            type="button"
            class="btn btn-success btn-block"
            @click="importarExcelYa()"
          >
            <i class="las la-file-excel"></i> Importar ya!
          </button>
          <button
            v-else
            class="btn btn-primary btn-block"
            id="btn-importar"
            @click="importarExcel()"
          >
            <i class="las la-file-excel"></i> Importar
          </button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-4 text-success">Correctos:{{ correctos }}</div>
        <div class="col-4 text-warning">Advertencias:{{ advertencias }}</div>
        <div class="col-4 text-danger">Errores:{{ errores }}</div>
      </div>
      <p v-if="codigo == 1">
        <b class="text-success">{{ mensaje }}</b>
      </p>

      <p v-if="codigo == 0">
        <b class="text-danger">{{ mensaje }}</b>
      </p>
      <p v-if="codigopre == 0">
        <b class="text-danger">{{ mensajepre }}</b>
      </p>
      <div class="row">
        <div class="col-12">
          <table
            v-if="items"
            class="table table-striped table-hover table-condensed"
            id="my-table"
          >
            <thead>
              <tr>
                <th scope="col" v-for="(item, key) in fields" :key="key">
                  {{ item.label }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, key) in items" :key="key">
                <td>
                  <span> {{ item.codigo.dato }} </span><br />
                  <span
                    v-if="item.codigo.error.error == 0"
                    class="text-success"
                  >
                    {{ item.codigo.error.msj }}
                  </span>
                  <span
                    v-else-if="item.codigo.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.codigo.error.msj }}
                  </span>
                  <span
                    v-else-if="item.codigo.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.codigo.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.marca.dato }} </span><br />
                  <span v-if="item.marca.error.error == 0" class="text-success">
                    {{ item.marca.error.msj }}
                  </span>
                  <span
                    v-else-if="item.marca.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.marca.error.msj }}
                  </span>
                  <span
                    v-else-if="item.marca.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.marca.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.unidad.dato }} </span><br />
                  <span
                    v-if="item.unidad.error.error == 0"
                    class="text-success"
                  >
                    {{ item.unidad.error.msj }}
                  </span>
                  <span
                    v-else-if="item.unidad.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.unidad.error.msj }}
                  </span>
                  <span
                    v-else-if="item.unidad.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.unidad.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.categoria.dato }} </span><br />
                  <span
                    v-if="item.categoria.error.error == 0"
                    class="text-success"
                  >
                    {{ item.categoria.error.msj }}
                  </span>
                  <span
                    v-else-if="item.categoria.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.categoria.error.msj }}
                  </span>
                  <span
                    v-else-if="item.categoria.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.categoria.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.nombre.dato }} </span><br />
                  <span
                    v-if="item.nombre.error.error == 0"
                    class="text-success"
                  >
                    {{ item.nombre.error.msj }}
                  </span>
                  <span
                    v-else-if="item.nombre.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.nombre.error.msj }}
                  </span>
                  <span
                    v-else-if="item.nombre.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.nombre.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.descripcion.dato }} </span><br />
                  <span
                    v-if="item.descripcion.error.error == 0"
                    class="text-success"
                  >
                    {{ item.descripcion.error.msj }}
                  </span>
                  <span
                    v-else-if="item.descripcion.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.descripcion.error.msj }}
                  </span>
                  <span
                    v-else-if="item.descripcion.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.descripcion.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.detalle.dato }} </span><br />
                  <span
                    v-if="item.detalle.error.error == 0"
                    class="text-success"
                  >
                    {{ item.detalle.error.msj }}
                  </span>
                  <span
                    v-else-if="item.detalle.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.detalle.error.msj }}
                  </span>
                  <span
                    v-else-if="item.detalle.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.detalle.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.precio.dato }} </span><br />
                  <span
                    v-if="item.precio.error.error == 0"
                    class="text-success"
                  >
                    {{ item.precio.error.msj }}
                  </span>
                  <span
                    v-else-if="item.precio.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.precio.error.msj }}
                  </span>
                  <span
                    v-else-if="item.precio.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.precio.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.precio_web.dato }} </span><br />
                  <span
                    v-if="item.precio_web.error.error == 0"
                    class="text-success"
                  >
                    {{ item.precio_web.error.msj }}
                  </span>
                  <span
                    v-else-if="item.precio_web.error.error == 1"
                    class="text-danger"
                  >
                    {{ item.precio_web.error.msj }}
                  </span>
                  <span
                    v-else-if="item.precio_web.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.precio_web.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.stock.dato }} </span><br />
                  <span v-if="item.stock.error.error == 0" class="text-success">
                    {{ item.stock.error.msj }}
                  </span>
                  <span
                    v-else-if="item.stock.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.stock.error.msj }}
                  </span>
                  <span
                    v-else-if="item.stock.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.stock.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.limite.dato }} </span><br />
                  <span
                    v-if="item.limite.error.error == 0"
                    class="text-success"
                  >
                    {{ item.limite.error.msj }}
                  </span>
                  <span
                    v-else-if="item.limite.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.limite.error.msj }}
                  </span>
                  <span
                    v-else-if="item.limite.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.limite.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.valido_desde.dato }} </span><br />
                  <span
                    v-if="item.valido_desde.error.error == 0"
                    class="text-success"
                  >
                    {{ item.valido_desde.error.msj }}
                  </span>
                  <span
                    v-else-if="item.valido_desde.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.valido_desde.error.msj }}
                  </span>
                  <span
                    v-else-if="item.valido_desde.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.valido_desde.error.msj }}
                  </span>
                </td>
                <td>
                  <span> {{ item.valido_hasta.dato }} </span><br />
                  <span
                    v-if="item.valido_hasta.error.error == 0"
                    class="text-success"
                  >
                    {{ item.valido_hasta.error.msj }}
                  </span>
                  <span
                    v-else-if="item.valido_hasta.error.error == 1"
                    class="text-warning"
                  >
                    {{ item.valido_hasta.error.msj }}
                  </span>
                  <span
                    v-else-if="item.valido_hasta.error.error == 2"
                    class="text-danger"
                  >
                    {{ item.valido_hasta.error.msj }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
// import moment from 'moment';
// import { core } from "../../../config/pluginInit";
// import SocialPost from './Components/SocialPost'
// import { Posts } from '../../../FackApi/api/SocialPost'

// import AddSocialPost from './Components/AddSocialPost'
export default {
  name: "Brand",
  //   components: { AddSocialPost, SocialPost },
  mounted() {
    // core.index();
  },
  created() {},
  data() {
    return {
      import_file: null,
      test: {
        activeLabel: "Yes",
        inactiveLabel: "No",
        label: "Danger",
        class: "danger",
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
      fields: [
        {
          key: "codigo",
          label: "Codigo"
        },
        {
          key: "marca",
          label: "Marca"
        },
        {
          key: "unidad",
          label: "Unidad"
        },
        {
          key: "categoria",
          label: "Categoria"
        },
        {
          key: "nombre",
          label: "Nombre"
        },
        {
          key: "descripcion",
          label: "Descripcion"
        },
        {
          key: "detalle",
          label: "Detalle"
        },
        {
          key: "precio",
          label: "Precio"
        },
        {
          key: "precio_web",
          label: "Precio web"
        },
        {
          key: "stock",
          label: "Stock"
        },
        {
          key: "limite",
          label: "Limite"
        },
        {
          key: "valido_desde",
          label: "Valido desde"
        },
        {
          key: "valido_hasta",
          label: "Valido hasta"
        }
      ],
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
    importarExcel1() {
      let formData = new FormData();
      formData.append("import_file", this.import_file);
      Axios.post(
        `${process.env.MIX_MIX_APP_URL}/api/v1/products/importar-excel`,
        formData,
        {
          headers: { "content-type": "multipart/form-data" }
        }
      )
        .then(response => {
          if (response.status === 200) {
            this.items = [];
            this.items = response.data.datos;
            this.correctos = response.data.correctos;
            this.advertencias = response.data.advertencias;
            this.errores = response.data.errores;
          } else {
            console.log("error al subir el excel");
          }
        })
        .catch(error => {
          // this.error = error.response.data

          this.codigopre = 0;
          this.mensajepre = "Error en el formato del archivo subido";
        });
    },
    importarExcel1Ya() {
      let formData = new FormData();
      formData.append("import_file", this.import_file);
      Axios.post(
        `${process.env.MIX_MIX_APP_URL}/api/v1/products/importar-excel-ya`,
        formData,
        {
          headers: { "content-type": "multipart/form-data" }
        }
      )
        .then(response => {
          if (response.status === 200) {
            this.items = [];
            this.correctos = 0;
            this.advertencias = 0;
            this.errores = 0;
            this.codigo = 1;
            this.mensaje = "Datos guardados correctamente";
          }
        })
        .catch(error => {
          // this.error = error.response.data
          this.codigo = 0;
          this.mensaje = "Error al guardar los datos";
        });
    },
    importarExcel() {
      this.importarExcel1();
    },
    importarExcelYa() {
      this.importarExcel1Ya();
    },
    onFileChange(e) {
      this.import_file = e.target.files[0];
    }
  },
  computed: {
    // correctos() {
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
};
</script>
