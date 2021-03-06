<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-10">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              id="name"
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
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
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
                <div class="form-group">
                  <label for="name">Nombre</label>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    aria-describedby="nameHelp"
                    placeholder="Ingrese el nombre"
                    v-model="brand.name"
                    required
                  />
                  <small id="nameHelp" class="form-text text-muted"
                    >El nombre es requerido</small
                  >
                </div>
                <div class="form-group">
                  <label for="description">Descripcion</label>
                  <textarea
                    class="form-control"
                    id="description"
                    rows="5"
                    v-model="brand.description"
                    required
                  ></textarea>
                </div>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input"
                    id="customFile"
                    required
                    @change="onFileChange"
                  />
                  <label class="custom-file-label" for="customFile"
                    >Escoja una imagen</label
                  >
                  <div class="invalid-feedback">
                    Suba una imagen
                  </div>
                </div>

                <div class="card" v-if="brand.photo">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-10">Imagen subida</div>
                      <div class="col-2 text-rigth">
                        <button
                          type="button"
                          class="btn btn-danger"
                          @click="borrar_imagen()"
                        >
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </div>
                    </div>
                    <div class="row">
                      <div class="text-center col-6">
                        <img class="output w-100" :src="brand.photo" />
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
              <button type="button" class="btn btn-primary" @click="handleOk">
                Guardar
              </button>
            </div>
          </div>
        </div>
      </div>

      <table
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
        <paginate name="itemss" :list="itemss" :per="10" tag="tbody">
          <tr v-for="(item, key) in paginated('itemss')" :key="key">
            <td scope="row">{{ key + 1 }}</td>
            <td>{{ item.name }}</td>
            <td>
              <img
                class="output "
                :src="item.photo"
                width="100px"
                height="100px"
              />
            </td>
            <td>{{ item.state }}</td>
            <td>{{ item.father_id }}</td>
            <td>
              <button class="btn btn-warning" @click="editar(item)">
                <i class="fas fa-edit"></i>Editar
              </button>
              <button class="btn btn-danger" @click="borrar(item.id)">
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
</template>
<script>
import Axios from "axios";
// import { core } from '../../../config/pluginInit'
// import SocialPost from './Components/SocialPost'
// import { Posts } from '../../../FackApi/api/SocialPost'

// import AddSocialPost from './Components/AddSocialPost'
export default {
  name: "Brand",
  //   components: { AddSocialPost, SocialPost },
  mounted() {
    // core.index();
  },
  created() {
    this.index();
  },
  data() {
    return {
      brand: {
        id: 0,
        name: "",
        description: "",
        photo: "",
        state: 0,
        opciones: 0,
        father_id: 0,
        nameState: null
      },
      fields: [
        {
          key: "id",
          label: "#"
        },
        {
          key: "name",
          label: "Nombre"
        },
        {
          key: "photo",
          label: "Imagen"
        },
        {
          key: "state",
          label: "Estado"
        },
        {
          key: "father_id",
          label: "Padre"
        },
        {
          key: "opciones",
          label: "Opciones"
        }
      ],
      items: [],
      brand_inicial: {
        id: 0,
        name: "",
        description: "",
        photo: "",
        state: 0,
        father_id: 0,
        opciones: 0,
        nameState: null
      },
      modal: false,
      mostrr: "hide",
      submittedNames: [],
      currentPage: 1,
      per_page: 10,
      valorBuscar: "",
      paginate: ["itemss"]
    };
  },
  methods: {
    async index() {
      this.items = [];
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/categories`
      );
      let rpt = datos.data.map(obj => ({
        id: obj.id,
        name: obj.name,
        description: obj.description,
        photo: obj.photo ? `/api/v1/categories/imagen/${obj.photo}` : "",
        state: obj.state,
        father_id: obj.father_id,
        opciones: obj.id
      }));
      console.log(rpt);
      this.items = rpt;
      this.items.sort((a, b) => b.name - a.name);
    },
    async agregar() {
      console.log("agregar");
      // if(this.post.titulo.trim().length==0)
      //     return;
      // if(this.post.detalle.trim().length==0)
      //     return;
      // if(this.post.categoria_id==0)
      //     return;
      if (this.brand.id > 0) {
        // Editamos
        let datos = await Axios.put(
          `${process.env.MIX_MIX_APP_URL}/api/v1/categories/${this.brand.id}`,
          this.brand
        );
        console.log("rpt;", datos.data);
        if (datos.data.status == 1) {
          // alert('datos editados')
          this.limpiarCampos();
          // this.ocultar();
          this.index();
        }
      } else {
        // Agregamos
        // this.post.imagenes=this.imagenes
        // this.post.user_id=this.user_id
        let datos = await Axios.post(
          `${process.env.MIX_MIX_APP_URL}/api/v1/categories`,
          this.brand
        );
        console.log("rpt;", datos.data);
        if (datos.data.status == 1) {
          // alert('datos guardados')
          this.limpiarCampos();
          // this.ocultar();
          this.index();
        }
      }
    },
    toggleModal() {
      // We pass the ID of the button that we want to return focus to
      // when the modal has hidden
      //   this.$refs["modal"].toggle("#toggle-btn");
      $("#exampleModal").modal("toggle");
    },
    editar(brand_) {
      console.log(brand_);
      this.brand = brand_;
      this.toggleModal();
    },
    async delete(brand_id) {
      let datos = await Axios.delete(
        `${process.env.MIX_MIX_APP_URL}/api/v1/categories/${brand_id}`
      );
      console.log("rpt;", datos.data);
      if (datos.data.status == 1) {
        // alert('datos guardados')
        this.index();
      }
    },
    borrar(brand_id) {
      if (confirm("Estas seguro de borra este dato?")) {
        this.delete(brand_id);
      }
    },
    createImage(file) {
      const reader = new FileReader();
      reader.onload = e => {
        this.brand.photo = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    onFileChange(e) {
      console.log("generamos la imagen");
      this.selectedFile = e.target.files[0];
      this.createImage(this.selectedFile);
    },
    borrar_imagen() {
      this.brand.photo = "";
    },
    // Eventos para el modal
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.brand.nameState = valid;
      return valid;
    },
    resetModal() {
      this.brand.name = "";
      this.brand.nameState = null;
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
      this.submittedNames.push(this.brand.name);
      //llamamos al metodo para guardar o editar
      this.agregar();
      // Hide the modal manually
      //   this.$nextTick(() => {
      //     // this.$bvModal.hide("modal-prevent-closing");
      this.toggleModal();
      //   });
    },
    iniciarForm() {
      this.limpiarCampos();
      this.toggleModal();
    },
    limpiarCampos() {
      this.brand = {
        id: 0,
        name: "",
        description: "",
        photo: "",
        state: 0,
        father_id: 0,
        opciones: 0,
        nameState: null
      };
    }
  },
  computed: {
    row() {
      return this.items.length;
    },
    tituloModal() {
      if (this.brand.id > 0) {
        return "Editar Marca";
      } else {
        return "Nueva Marca";
      }
    },
    itemss() {
      return this.items.filter(valor => {
        return valor.name
          .toLowerCase()
          .includes(this.valorBuscar.toLowerCase());
      });
    }
  }
};
</script>
