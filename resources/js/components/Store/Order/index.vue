<template>
  <div class="card">
    <div class="p-2 card-body">
      <div class="row">
        <div class="col-4">
          <div class="card">
            <div class="card-header bg-danger">
              NUEVOS PEDIDOS
            </div>
            <div class="p-2 card-body bg-gradient-secondary">
              <div v-for="(item, key) in items" :key="key">
                <div class="card" v-if="item.state == 1">
                  <div class="p-1 card-body">
                    <a :href="`../orders/list/show/${item.id}`">
                      <div class="row">
                        <div class="col-8 col-lg-8 text-primary text-bold">
                          {{ item.full_name }}
                        </div>
                        <div
                          class="text-right col-4 col-lg-4 text-success text-bold"
                        >
                          S/. {{ item.total }}
                        </div>
                        <div class="text-sm col-12 text-secondary text-bold">
                          Entregar:
                          {{
                            moment(`${item.fecha_entrega}.00:00:00`).format(
                              "dddd, Do MMMM YYYY"
                            )
                          }}
                          {{ item.hora_entrega }}
                        </div>
                      </div>
                      <div class="row">
                        <div class="text-sm text-gray col-12">
                          Creado:
                          {{
                            moment(item.created_at).format(
                              "dddd, Do MMMM YYYY, h:mm:ss a"
                            )
                          }}
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-header bg-warning">
              NUEVOS EN EMPACADO <i class="fa fa-cubes" aria-hidden="true"></i>
            </div>
            <div class="p-2 card-body bg-gradient-secondary">
              <div v-for="(item, key) in items" :key="key">
                <div class="card" v-if="item.state == 2">
                  <div class="p-1 card-body">
                    <a :href="`../orders/list/show/${item.id}`">
                      <div class="row">
                        <div class="col-8 col-lg-8 text-primary text-bold">
                          {{ item.full_name }}
                        </div>
                        <div
                          class="text-right col-4 col-lg-4 text-success text-bold"
                        >
                          S/. {{ item.total }}
                        </div>
                        <div class="text-sm col-12 text-secondary text-bold">
                          Entregar:
                          {{
                            moment(`${item.fecha_entrega}.00:00:00`).format(
                              "dddd, Do MMMM YYYY"
                            )
                          }}
                          {{ item.hora_entrega }}
                        </div>
                      </div>
                      <div class="row">
                        <div class="text-sm text-gray col-12">
                          Creado:
                          {{
                            moment(item.en_proceso_user).format(
                              "dddd, Do MMMM YYYY, h:mm:ss a"
                            )
                          }}
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-header bg-primary">
              NUEVOS EN ENCAMINO
              <i class="fa fa-truck" aria-hidden="true"></i>
            </div>
            <div class="p-2 card-body bg-gradient-secondary">
              <div v-for="(item, key) in items" :key="key">
                <div class="card" v-if="item.state == 3">
                  <div class="p-1 card-body">
                    <a :href="`../orders/list/show/${item.id}`">
                      <div class="row">
                        <div class="col-8 col-lg-8 text-primary text-bold">
                          {{ item.full_name }}
                        </div>
                        <div
                          class="text-right col-4 col-lg-4 text-success text-bold"
                        >
                          S/.
                          {{ numero(numero(item.total) + numero(item.tax)) }}
                        </div>
                        <div class="text-sm col-12 text-secondary text-bold">
                          Entregar:
                          {{
                            moment(`${item.fecha_entrega}.00:00:00`).format(
                              "dddd, Do MMMM YYYY"
                            )
                          }}
                          {{ item.hora_entrega }}
                        </div>
                      </div>
                      <div class="row">
                        <div class="text-sm text-gray col-12">
                          Creado:
                          {{
                            moment(item.dispached_user).format(
                              "dddd, Do MMMM YYYY, h:mm:ss a"
                            )
                          }}
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
  name: "Order",
  //   components: { AddSocialPost, SocialPost },
  mounted() {
    // core.index();
  },
  created() {
    this.index();
  },
  data() {
    return {
      order: {
        id: 0,
        code: "",
        fullname: "",
        state: 0,
        created_at: 0,
        total: 0,
        fecha_entrega: null,
        hora_entrega: null
        // nameState: null,
      },
      items: [],
      itemsEmpacado: [],
      order_inicial: {
        id: 0,
        code: "",
        fullname: "",
        state: 0,
        created_at: 0,
        total: 0,
        fecha_entrega: null,
        hora_entrega: null
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
        `${process.env.MIX_MIX_APP_URL}/api/v1/orders`
      );
      let rpt = datos.data.map(item => ({
        id: item.id,
        code: item.code,
        full_name: item.full_name,
        state: item.state,
        created_at: item.created_at,
        en_proceso_user: item.en_proceso_user,
        dispached_user: item.dispached_user,
        entregado_user: item.entregado_user,
        tax: item.tax,
        total: item.total,
        fecha_entrega: item.fecha_entrega,
        hora_entrega: item.hora_entrega
      }));
      console.log(rpt);
      this.items = rpt;
      //   this.items = rpt.data.filter(a => a.state == 1);
      this.items.sort((a, b) => a.fecha_entrega - b.fecha_entrega);
    },
    numero(num) {
      return Math.round(num * 100) / 100;
    }
    // async agregar() {
    //   console.log("agregar");
    //   // if(this.post.titulo.trim().length==0)
    //   //     return;
    //   // if(this.post.detalle.trim().length==0)
    //   //     return;
    //   // if(this.post.categoria_id==0)
    //   //     return;
    //   if (this.brand.id > 0) {
    //     // Editamos
    //     let datos = await Axios.put(
    //       `${process.env.MIX_MIX_APP_URL}/api/v1/brands/${this.brand.id}`,
    //       this.brand
    //     );
    //     console.log("rpt;", datos.data);
    //     if (datos.data.status == 1) {
    //       // alert('datos editados')
    //       this.limpiarCampos();
    //       // this.ocultar();
    //       this.index();
    //     }
    //   } else {
    //     // Agregamos
    //     // this.post.imagenes=this.imagenes
    //     // this.post.user_id=this.user_id
    //     let datos = await Axios.post(
    //       `${process.env.MIX_MIX_APP_URL}/api/v1/brands`,
    //       this.brand
    //     );
    //     console.log("rpt;", datos.data);
    //     if (datos.data.status == 1) {
    //       // alert('datos guardados')
    //       this.limpiarCampos();
    //       // this.ocultar();
    //       this.index();
    //     }
    //   }
    // },
    // toggleModal() {
    //   // We pass the ID of the button that we want to return focus to
    //   // when the modal has hidden
    //   //   this.$refs["modal"].toggle("#toggle-btn");
    //   $("#exampleModal").modal("toggle");
    // },
    // editar(brand_) {
    //   console.log(brand_);
    //   this.brand = brand_;
    //   this.toggleModal();
    // },
    // async delete(brand_id) {
    //   let datos = await Axios.delete(
    //     `${process.env.MIX_MIX_APP_URL}/api/v1/brands/${brand_id}`
    //   );
    //   console.log("rpt;", datos.data);
    //   if (datos.data.status == 1) {
    //     // alert('datos guardados')
    //     this.index();
    //   }
    // },
    // borrar(brand_id) {
    //   if (confirm("Estas seguro de borra este dato?")) {
    //     this.delete(brand_id);
    //   }
    // },
    // createImage(file) {
    //   const reader = new FileReader();
    //   reader.onload = e => {
    //     this.brand.photo = e.target.result;
    //   };
    //   reader.readAsDataURL(file);
    // },
    // onFileChange(e) {
    //   console.log("generamos la imagen");
    //   this.selectedFile = e.target.files[0];
    //   this.createImage(this.selectedFile);
    // },
    // borrar_imagen() {
    //   this.brand.photo = "";
    // },
    // // Eventos para el modal
    // checkFormValidity() {
    //   const valid = this.$refs.form.checkValidity();
    //   this.brand.nameState = valid;
    //   return valid;
    // },
    // resetModal() {
    //   this.brand.name = "";
    //   this.brand.nameState = null;
    // },
    // handleOk(bvModalEvt) {
    //   // Prevent modal from closing
    //   //   bvModalEvt.preventDefault();
    //   // Trigger submit handler
    //   this.handleSubmit();
    // },
    // handleSubmit() {
    //   // Exit when the form isn't valid
    //   //   if (!this.checkFormValidity()) {
    //   //     return;
    //   //   }
    //   // Push the name to submitted names
    //   this.submittedNames.push(this.brand.name);
    //   //llamamos al metodo para guardar o editar
    //   this.agregar();
    //   // Hide the modal manually
    //   //   this.$nextTick(() => {
    //   //     // this.$bvModal.hide("modal-prevent-closing");
    //   this.toggleModal();
    //   //   });
    // },
    // iniciarForm() {
    //   this.limpiarCampos();
    //   this.toggleModal();
    // },
    // limpiarCampos() {
    //   this.brand = {
    //     id: 0,
    //     name: "",
    //     // photo:'',
    //     state: 0,
    //     opciones: 0
    //   };
    // }
  },
  computed: {
    // row() {
    //   return this.items.length;
    // },
    // tituloModal() {
    //   if (this.brand.id > 0) {
    //     return "Editar Marca";
    //   } else {
    //     return "Nueva Marca";
    //   }
    // },
    // itemss() {
    //   return this.items.filter(valor => {
    //     return valor.name
    //       .toLowerCase()
    //       .includes(this.valorBuscar.toLowerCase());
    //   });
    // }
  }
};
</script>
