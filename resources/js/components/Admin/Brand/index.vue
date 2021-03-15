<template>
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-10">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              id="name_buscar"
              v-model="valorBuscar"
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
          class="modal-dialog"
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
              <form>
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input
                    type="text"
                    class="form-control"
                    name="nombre"
                    placeholder="Ingrese el nombre"
                    v-model="brand.name"
                    v-validate="'required|alpha_spaces'"
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
            <td>{{ item.name }}</td>
            <td>{{ item.state }}</td>
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
        // photo:'',
        state: 0,
        opciones: 0
        // nameState: null,
      },
      fields_: [
        { key: "id", label: "#" },
        { key: "name", label: "Nombre" },
        // {key:'photo',label:'Imagen'},
        { key: "state", label: "Estado" },
        { key: "opciones", label: "Opciones" }
      ],
      items: [],
      brand_inicial: {
        id: 0,
        name: "",
        // photo:'',
        state: 0,
        opciones: 0
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
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/brands`
      );
      let rpt = datos.data.map(brand => ({
        id: brand.id,
        name: brand.name,
        //   photo:brand.photo,
        state: brand.state,
        opciones: brand.id
      }));
      console.log(rpt);
      this.items = rpt;
      this.items.sort((a, b) => b.name - a.name);
    },
    async agregar_() {
      if (this.brand.id > 0) {
        // Editamos
        let datos = await Axios.put(
          `${process.env.MIX_MIX_APP_URL}/api/v1/brands/${this.brand.id}`,
          this.brand
        );
        console.log("rpt;", datos.data);
        if (datos.data.status == 1) {
          this.limpiarCampos();
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
        let datos = await Axios.post(
          `${process.env.MIX_MIX_APP_URL}/api/v1/brands`,
          this.brand
        );
        console.log("rpt;", datos.data);
        if (datos.data.status == 1) {
          // alert('datos guardados')
          this.limpiarCampos();
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
      $("#exampleModal").modal("toggle");
    },
    editar(brand_) {
      console.log(brand_);
      this.brand = brand_;
      this.toggleModal();
    },
    async delete(brand_id) {
      let datos = await Axios.delete(
        `${process.env.MIX_MIX_APP_URL}/api/v1/brands/${brand_id}`
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
      //   if (confirm("Estas seguro de borra este dato?")) {
      //   }
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
    handleOk() {
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
      //   this.submittedNames.push(this.brand.name);
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
        // photo:'',
        state: 0,
        opciones: 0
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
