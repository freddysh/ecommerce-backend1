<template>
  <b-row>
    <b-col sm="12">
      <div class="modal-dialog modal-xl" role="document"></div>
      <iq-card body-class="p-0 profile-page">
        <template v-slot:headerTitle> </template>
        <template v-slot:body>
          <b-row class="pt-2 mx-2 mb-2">
            <b-col cols="12">
              <b-row>
                <b-col cols="12" sm="10">
                  <b-form-input
                    id="name"
                    v-model="valorBuscar"
                    required
                    placeholder="Buscar"
                  ></b-form-input>
                </b-col>
                <b-col class="text-right" cols="12" sm="2">
                  <b-button
                    class="btn-block"
                    id="toggle-btn"
                    v-b-modal.modal-prevent-closing
                    variant="primary"
                    @click="iniciarForm()"
                    ><i class="las la-plus-circle"></i> Nuevo</b-button
                  >
                </b-col>
              </b-row>
              <b-modal
                id="modal-prevent-closing"
                ref="modal"
                :title="tituloModal"
                @ok="handleOk"
                ok-title="Guardar"
                cancel-title="Cerrar"
                size="lg"
              >
                <form ref="form" @submit.stop.prevent="handleSubmit">
                  <b-form-group
                    label="Nombre"
                    label-for="name"
                    invalid-feedback="El nombre es requerido"
                  >
                    <b-form-input
                      id="name"
                      v-model="brand.name"
                      required
                    ></b-form-input>
                  </b-form-group>
                </form>
              </b-modal>
            </b-col>
          </b-row>
          <b-table
            id="my-table"
            :items="itemss"
            :fields="fields"
            :per-page="per_page"
            :current-page="currentPage"
            responsive="sm"
            class="px-2"
          >
            <template #cell(opciones)="data">
              <b-button
                variant="warning"
                class="mb-3 mr-1"
                @click="editar(data.item)"
                ><i class="las la-edit"></i>Editar</b-button
              >
              <b-button
                variant="danger"
                class="mb-3 mr-1"
                @click="borrar(data.value)"
                ><i class="las la-trash-alt"></i>Eliminar</b-button
              >
            </template>
          </b-table>
          <b-pagination
            class="mx-4"
            v-model="currentPage"
            :total-rows="row"
            :per-page="per_page"
            aria-controls="my-table"
          ></b-pagination>
        </template>
      </iq-card>
    </b-col>
  </b-row>
</template>
<script>
import Axios from "axios";
// import { core } from "../../../config/pluginInit";
// import SocialPost from './Components/SocialPost'
// import { Posts } from '../../../FackApi/api/SocialPost'

// import AddSocialPost from './Components/AddSocialPost'
export default {
  name: "Brand",
  //   components: { AddSocialPost, SocialPost },
  mounted() {
    core.index();
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
      fields: [
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
      valorBuscar: ""
    };
  },
  methods: {
    async index() {
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/units`
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
          `${process.env.MIX_MIX_APP_URL}/api/v1/units/${this.brand.id}`,
          this.brand
        );
        console.log("rpt;", datos.data);
        if (datos.data.status == 1) {
          // alert('datos editados')
          this.brand = this.brand_inicial;
          // this.ocultar();
          this.index();
        }
      } else {
        // Agregamos
        // this.post.imagenes=this.imagenes
        // this.post.user_id=this.user_id
        let datos = await Axios.post(
          `${process.env.MIX_MIX_APP_URL}/api/v1/units`,
          this.brand
        );
        console.log("rpt;", datos.data);
        if (datos.data.status == 1) {
          // alert('datos guardados')
          this.brand = this.brand_inicial;
          // this.ocultar();
          this.index();
        }
      }
    },
    toggleModal() {
      // We pass the ID of the button that we want to return focus to
      // when the modal has hidden
      this.$refs["modal"].toggle("#toggle-btn");
    },
    editar(brand_) {
      console.log(brand_);
      this.brand = brand_;
      this.toggleModal();
    },
    async delete(brand_id) {
      let datos = await Axios.delete(
        `${process.env.MIX_MIX_APP_URL}/api/v1/units/${brand_id}`
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
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return;
      }
      // Push the name to submitted names
      this.submittedNames.push(this.brand.name);
      //llamamos al metodo para guardar o editar
      this.agregar();
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-prevent-closing");
      });
    },
    iniciarForm() {
      this.brand = this.brand_inicial;
    }
  },
  computed: {
    row() {
      return this.items.length;
    },
    tituloModal() {
      if (this.brand.id > 0) {
        return "Editar Unidad";
      } else {
        return "Nueva Unidad";
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
