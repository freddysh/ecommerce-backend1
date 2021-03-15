<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-10">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              id="nameBuscar"
              v-model="valorBuscar"
              required
              placeholder="Buscar"
            />
          </div>
        </div>
        <div class="text-right col-2">
          <!-- Button trigger modal -->
          <button
            type="button"
            class="btn btn-success btn-block"
            data-toggle="modal"
            @click="iniciarForm()"
          >
            <i class="las la-plus-circle"></i> Nuevo
          </button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <!-- Modal -->
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div
          class="modal-dialog modal-xl"
          role="document"
        >
          <div class="modal-content">
            <div class="modal-header">
              <h5
                class="modal-title"
                id="exampleModalLabel"
              >
                {{ tituloModal }}
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form ref="form">
                <div class="row">
                  <div class="col col-sm-12 col-md-4">
                    <div class="form-group">
                      <label for="code">Codigo</label>
                      <input
                        type="text"
                        class="form-control"
                        id="code"
                        name="codigo"
                        aria-describedby="nameHelp"
                        placeholder="Ingrese el codigo"
                        v-model="product.code"
                        v-validate="'required|alpha_num'"
                        :class="{'input': true, 'danger': errors.has('codigo') }"
                      />
                      <i
                        v-show="errors.has('codigo')"
                        class="fa fa-warning"
                      ></i>
                      <span
                        v-show="errors.has('codigo')"
                        class="help text-danger"
                      >{{ errors.first('codigo') }}</span>
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-4">
                    <div class="form-group">
                      <label for="name">Nombre</label>
                      <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="nombre"
                        aria-describedby="nameHelp"
                        placeholder="Ingrese el nombre"
                        v-model="product.name"
                        v-validate="'required'"
                        :class="{'input': true, 'danger': errors.has('nombre') }"
                      />
                      <i
                        v-show="errors.has('nombre')"
                        class="fa fa-warning"
                      ></i>
                      <span
                        v-show="errors.has('nombre')"
                        class="help text-danger"
                      >{{ errors.first('nombre') }}</span>
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-4">
                    <div class="form-group">
                      <label for="url">Url amigable</label>
                      <input
                        type="text"
                        class="form-control"
                        id="url"
                        name="url"
                        aria-describedby="urlHelp"
                        placeholder="Ingrese la url"
                        v-model="url"
                        v-validate="'required|alpha_dash'"
                        :class="{'input': true, 'danger': errors.has('url') }"
                      />

                      <i
                        v-show="errors.has('url')"
                        class="fa fa-warning"
                      ></i>
                      <span
                        v-show="errors.has('url')"
                        class="help text-danger"
                      >{{ errors.first('url') }}</span>
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-2">
                    <div class="form-group">
                      <label for="brand">Marca</label>
                      <select
                        class="form-control"
                        id="brand"
                        name="brand"
                        v-model="product.brand"
                      >
                        <option
                          v-for="(brand_, key) in brands"
                          :key="key"
                          :value="brand_.value"
                        >{{ brand_.text }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-2">
                    <div class="form-group">
                      <label for="unit">Unidad</label>
                      <select
                        class="form-control"
                        id="unit"
                        name="unit"
                        v-model="product.unit"
                      >
                        <option
                          v-for="(unit_, key) in units"
                          :key="key"
                          :value="unit_.value"
                        >{{ unit_.text }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-8">
                    <div>
                      <label class="typo__label">Categoria</label>
                      <multiselect
                        v-model="product.categorias"
                        :options="categories"
                        :searchable="true"
                        :close-on-select="false"
                        :show-labels="false"
                        placeholder="Escoja las categorias"
                        multiple
                      ></multiselect>
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-6">
                    <div class="form-group">
                      <label for="description">Descripcion</label>
                      <textarea
                        class="form-control"
                        id="description"
                        name="descripcion"
                        rows="5"
                        v-model="product.description"
                        v-validate="'required'"
                      ></textarea>
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-6">
                    <div class="form-group">
                      <label for="detail">Detalle</label>
                      <textarea
                        class="form-control"
                        id="detail"
                        name="detalle"
                        rows="5"
                        v-model="product.detail"
                        v-validate="'required'"
                      ></textarea>
                    </div>
                  </div>

                  <div class="col col-sm-12 col-md-4">
                    <div class="form-group">
                      <label for="url">Precio</label>
                      <input
                        type="number"
                        class="form-control"
                        id="price"
                        name="precio"
                        placeholder="Ingrese el precio"
                        v-model="product.price"
                        required
                        step="0.10"
                        min="1"
                        v-validate="'decimal:2'"
                      />
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-4">
                    <div class="form-group">
                      <label for="url">Descuento</label>
                      <input
                        type="number"
                        class="form-control"
                        id="discount"
                        name="descuento"
                        placeholder="Ingrese el descuento"
                        v-model="product.discount"
                        required
                        min="0"
                        v-validate="'decimal:2'"
                      />
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-4">
                    <div class="form-group">
                      <label for="url">Precio regular</label>
                      <input
                        type="number"
                        class="form-control"
                        id="regular_price"
                        name="precio regular"
                        placeholder="Ingrese el precio regular"
                        v-model="precio"
                        required
                        step="0.10"
                        min="0"
                        v-validate="'decimal:2'"
                      />
                    </div>
                  </div>
                  <div class="col col-sm-12 col-md-3">
                    <div class="form-group">
                      <label for="my-checkbox">El producto tiene limite de stock?</label>
                      <vs-switch v-model="product.limit" />
                    </div>
                  </div>
                  <div
                    class="col col-sm-12 col-md-3"
                    v-if="product.limit"
                  >
                    <div class="form-group">
                      <label for="url">Stock</label>
                      <input
                        type="number"
                        class="form-control"
                        id="stock"
                        placeholder="Ingrese el stock"
                        v-model="product.stock"
                        required
                        min="1"
                      />
                    </div>
                  </div>
                  <div
                    class="col col-sm-12 col-md-6"
                    v-if="product.limit"
                  >
                    <div class="form-group">
                      <label>Ingrese el rango de fechas:</label>
                      <date-picker
                        v-model="product.rango_fecha"
                        range
                      ></date-picker>
                    </div>
                  </div>
                  <div class="col col-sm-12">
                    <div class="custom-file">
                      <input
                        type="file"
                        class="custom-file-input"
                        id="photos"
                        name="imagen"
                        lang="es"
                        @change="onFileChanges"
                        v-validate="'image'"
                      />
                      <label
                        class="custom-file-label"
                        for="photos"
                      >Imagenes (solo formato jpg|jpeg)</label>
                    </div>
                  </div>

                  <div
                    class="col col-sm-12 col-md-3"
                    v-for="(imagen, key) in product.photos"
                    :key="key"
                  >
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">Imagen {{ key + 1 }}</div>
                          <div class="col-md-12">
                            <img
                              class="output w-50"
                              :src="imagen.imgSrc"
                            />
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label :for="`principal${key}`">Convertir en principal</label>
                              <vs-switch v-model="imagen.state" />
                            </div>
                          </div>
                          <div class="col-md-6">
                            <button
                              type="button"
                              class="btn btn-danger"
                              @click="borrar_imagen(imagen)"
                            >
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Cerrar
              </button>
              <button
                type="button"
                class="btn btn-primary"
                @click="agregar"
              >
                Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table
            class="table table-striped table-hover table-condensed"
            id="my-table"
          >
            <thead>
              <tr>
                <th
                  scope="col"
                  v-for="(item, key) in fields_"
                  :key="key"
                >
                  {{ item.label }}
                </th>
              </tr>
            </thead>
            <paginate
              name="itemss"
              :list="itemss"
              :per="10"
              tag="tbody"
            >
              <tr
                v-for="(item, key) in paginated('itemss')"
                :key="key"
              >
                <td scope="row">{{ key + 1 }}</td>
                <td>{{ item.code }}</td>
                <td>{{ item.name }}</td>
                <td>
                  <vs-switch
                    v-model="item.state"
                    @click="cambiar_estado(item.id, item.state)"
                  />
                </td>
                <td>
                  {{moment(item.created_at).format('MMMM Do YYYY, h:mm:ss a') }}
                </td>
                <td>
                  <img
                    v-if="obj.state"
                    v-for="(obj,key) in item.photos"
                    :key="key"
                    :src="obj.imgSrc"
                    width="50px"
                    height="50px"
                    alt=""
                  >
                  <span
                    class="text-gray-500"
                    v-if="item.photos.length==0"
                  >Sin imagen</span>
                </td>
                <td>
                  <button
                    class="btn btn-warning"
                    @click="editar(item)"
                  >
                    <i class="fas fa-edit"></i>Editar
                  </button>
                  <button
                    class="btn btn-danger"
                    @click="borrar(item.id)"
                  >
                    <i class="fas fa-trash-alt"></i> Eliminar
                  </button>
                </td>
              </tr>
            </paginate>
          </table>
          <paginate-links
            for="itemss"
            :classes="{ ul: 'pagination', li: 'page-item', a: 'page-link' }"
            :async="true"
            :show-step-links="true"
            :step-links="{
              next: 'Next',
              prev: 'Preview'
            }"
          ></paginate-links>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import Multiselect from "vue-multiselect";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

// import moment from 'moment';
// import { core } from "../../../config/pluginInit";
// import SocialPost from './Components/SocialPost'
// import { Posts } from '../../../FackApi/api/SocialPost'

// import AddSocialPost from './Components/AddSocialPost'
export default {
  name: "Brand",
  components: { Multiselect, DatePicker },
  mounted() {
    // core.index();
  },
  created() {
    this.index();
  },
  data() {
    return {
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
        rango_fecha: Array(new Date(), new Date()),
        photo: "",
        unit: "",
        brand: "",
        categorias: [],
        photos: [],
        state: true,
        opciones: 0,
        nameState: null,
        created_at: ""
      },
      fields_: [
        {
          key: "id",
          label: "#"
        },
        {
          key: "code",
          label: "Codigo"
        },
        {
          key: "name",
          label: "Nombre"
        },
        {
          key: "state",
          label: "Estado"
        },
        {
          key: "created_at",
          label: "Creado"
        },
        {
          key: "photo",
          label: "Miniatura(250px"
        },
        {
          key: "opciones",
          label: "Opciones"
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
        rango_fecha: Array(new Date(), new Date()),
        photo: "",
        unit: "",
        brand: "",
        categorias: [],
        photos: [],
        state: true,
        opciones: 0,
        nameState: null,
        created_at: ""
      },
      modal: false,
      mostrr: "hide",
      submittedNames: [],
      currentPage: 1,
      per_page: 10,
      valorBuscar: "",
      search: "",
      paginate: ["itemss"]
    };
  },
  methods: {
    async getBrands() {
      //   Obtenemos los productos
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/brands`
      );
      this.brands = datos.data.map(obj => ({
        id: obj.id,
        value: obj.name,
        text: obj.name,
        state: obj.state
      }));
    },
    async getUnits() {
      //   Obtenemos los productos
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/units`
      );
      this.units = datos.data.map(obj => ({
        id: obj.id,
        value: obj.name,
        text: obj.name,
        state: obj.state
      }));
    },
    async getCategories() {
      //   Obtenemos los productos
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/categories`
      );
      this.categories = datos.data.map(obj => obj.name);
    },
    async index() {
      //   this.product.valido_desde=new Date().toISOString();
      //   console.log('fecha:'+this.product.valido_desde);
      //   Obtenemos los productos
      //   this.items = [];
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/products`
      );

      let rpt = datos.data.map(obj => ({
        id: obj.id,
        code: obj.code,
        name: obj.name,
        url: obj.url,
        description: obj.description,
        detail: obj.detail,
        regular_price: obj.regular_price,
        discount: obj.discount,
        price: obj.price,
        stock: obj.stock,
        limit: obj.limit,
        rango_fecha:
          obj.valido_desde && obj.valido_hasta
            ? Array(new Date(obj.valido_desde), new Date(obj.valido_hasta))
            : Array(new Date(), new Date()),
        unit: obj.unit,
        brand: obj.brand,
        categorias: obj.categorias.map(categorias_ => categorias_.name),
        photos: obj.photos.map(phot => ({
          id: phot.id,
          imgSrc: phot.photo ? `/api/v1/products/imagen/${phot.photo}` : "",
          state: phot.state ? true : false
        })),
        state: obj.state ? true : false,
        opciones: obj.id,
        created_at: obj.created_at
      }));
      console.log(rpt);
      this.items = rpt;
      this.items.sort((a, b) => b.name - a.name);
      this.getBrands();
      this.getUnits();
      this.getCategories();
    },
    async agregar_() {
      console.log("agregar");
      // if(this.post.titulo.trim().length==0)
      //     return;
      // if(this.post.detalle.trim().length==0)
      //     return;
      // if(this.post.categoria_id==0)
      //     return;

      this.product.regular_price = this.precio;
      this.product.url = this.url;
      if (this.product.id > 0) {
        // Editamos
        let datos = await Axios.put(
          `${process.env.MIX_MIX_APP_URL}/api/v1/products/${this.product.id}`,
          this.product
        );
        console.log("rpt;", datos.data);
        if (datos.data.status == 1) {
          // alert('datos editados')
          this.limpiarCampos();
          // this.ocultar();
          this.index();
          Vue.$toast.open({
            message: "Datos guardados correctamente!",
            type: "success",
            duration: 6000,
            position: "top-right"
            // all of other options may go here
          });
        }
      } else {
        // Agregamos
        // this.post.imagenes=this.imagenes
        // this.post.user_id=this.user_id
        let datos = await Axios.post(
          `${process.env.MIX_MIX_APP_URL}/api/v1/products`,
          this.product
        );
        console.log("rpt;", datos.data);
        if (datos.data.status == 1) {
          // alert('datos guardados')
          this.limpiarCampos();
          // this.ocultar();
          this.index();
          Vue.$toast.open({
            message: "Datos guardados correctamente!",
            type: "success",
            duration: 6000,
            position: "top-right"
            // all of other options may go here
          });
        }
      }
    },
    agregar() {
      this.$validator.validate().then(result => {
        if (result) {
          this.agregar_();

          this.toggleModal();
        }
      });
    },
    toggleModal() {
      // We pass the ID of the button that we want to return focus to
      // when the modal has hidden
      this.$refs["modal"].toggle("#toggle-btn");
    },
    editar(brand_) {
      this.product = this.product_inicial;
      console.log("producto a editar:" + brand_);
      this.product = brand_;
      this.toggleModal();
    },
    async delete(brand_id) {
      let datos = await Axios.delete(
        `${process.env.MIX_MIX_APP_URL}/api/v1/products/${brand_id}`
      );
      console.log("rpt;", datos.data);
      if (datos.data.status == 1) {
        // alert('datos guardados')
        this.index();
      }
    },
    borrar(brand_id) {
      Vue.swal
        .fire({
          title: "Esta seguro de borrar este dato?",
          text: "No podrás revertir este paso!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, Borrar!",
          cancelButtonText: "Cancelar"
        })
        .then(result => {
          if (result.isConfirmed) {
            this.delete(brand_id);
          }
        });
    },
    async cambiar_estado(brand_id, valor) {
      console.log("evento switch" + brand_id + "," + valor);
      //   let valorswich = this.product.state ? 0 : 1;
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/products/swith-state/${brand_id}/${valor}`
      );

      console.log("rpt:", datos.data);
      if (datos.data.status == 1) {
        // alert('datos guardados')
        // this.index();
      }
    },
    // Eventos para el modal
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.product.nameState = valid;
      return valid;
    },
    resetModal() {
      this.product.name = "";
      this.product.nameState = null;
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      //   bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // Exit when the form isn't valid
      //   if (!this.checkFormValidity()) {
      //     return;
      //   }
      // Push the name to submitted names
      //   this.submittedNames.push(this.product.name);
      //llamamos al metodo para guardar o editar
      this.agregar();
      // Hide the modal manually
      this.$nextTick(() => {
        this.toggleModal();
      });
    },
    iniciarForm() {
      this.limpiarCampos();
      this.toggleModal();
    },
    limpiarCampos() {
      this.brand = {
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
        rango_fecha: Array(new Date(), new Date()),
        unit: "",
        brand: "",
        categorias: [],
        photos: [],
        state: true,
        opciones: 0,
        nameState: null
      };
    },
    toggleModal() {
      // We pass the ID of the button that we want to return focus to
      // when the modal has hidden
      //   this.$refs["modal"].toggle("#toggle-btn");
      $("#exampleModal").modal("toggle");
    },
    onOptionClick({ option, addTag }) {
      addTag(option);
      this.search = "";
    },
    borrar_imagen(value) {
      var indice = this.product.photos.indexOf(value);
      if (indice != -1) this.product.photos.splice(indice, 1);
    },
    onFileChanges(e) {
      // this.message = ''
      console.log("generamos la imagen");
      this.selectedFiles = e.target.files[0];
      this.createImages(this.selectedFiles);
    },
    createImages(file) {
      const reader = new FileReader();
      reader.onload = e => {
        // this.post.imagen_miniatura = e.target.result
        this.product.photos.push({
          id: 0,
          imgSrc: e.target.result,
          state: false
        });
      };
      reader.readAsDataURL(file);
    }
  },
  computed: {
    row() {
      return this.items.length;
    },
    tituloModal() {
      if (this.product.id > 0) {
        return "Editar Producto";
      } else {
        return "Nuevo Producto";
      }
    },
    itemss() {
      return this.items.filter(valor => {
        return valor.name
          .toLowerCase()
          .includes(this.valorBuscar.toLowerCase());
      });
    },
    url() {
      // Reemplaza los carácteres especiales | simbolos con un espacio
      let slug = "";
      slug = this.product.name;
      slug = slug
        .replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, " ")
        .toLowerCase();
      // Reemplaza los carácteres especiales | simbolos con un espacio
      slug = slug.replace(/á|Á/g, "a").toLowerCase();
      slug = slug.replace(/é|É/g, "e").toLowerCase();
      slug = slug.replace(/í|Í/g, "i").toLowerCase();
      slug = slug.replace(/ó|Ó/g, "o").toLowerCase();
      slug = slug.replace(/ú|Ú/g, "u").toLowerCase();
      slug = slug.replace(/ñ|Ñ/g, "n").toLowerCase();

      // Corta los espacios al inicio y al final del sluging
      slug = slug.replace(/^\s+|\s+$/gm, "");

      // Reemplaza el espacio con guión
      slug = slug.replace(/\s+/g, "-");
      return slug;
    },
    precio() {
      let valor = 0;
      valor =
        parseFloat(this.product.price) +
        (parseFloat(this.product.discount) * parseFloat(this.product.price)) /
          100;
      console.log("valor original" + valor);
      valor = parseFloat(valor).toFixed(2);
      console.log("valor 2 decimales" + valor);
      return valor;
    },
    //-- funciones para el select tag
    criteria() {
      // Compute the search criteria
      return this.search.trim().toLowerCase();
    },
    availableOptions() {
      const criteria = this.criteria;
      // Filter out already selected options
      const options = this.categories.filter(
        opt => this.product.categorias.indexOf(opt) === -1
      );
      if (criteria) {
        // Show only options that match criteria
        return this.categories.filter(
          opt => opt.toLowerCase().indexOf(criteria) > -1
        );
      }
      // Show all options available
      return options;
    },
    searchDesc() {
      if (this.criteria && this.availableOptions.length === 0) {
        return "No hay etiquetas que coincidan con sus criterios de búsqueda.";
      }
      return "";
    }
  }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
