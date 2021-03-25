<template>
  <div class="card">
    <div class="p-2 card-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-warning">
              <div class="row">
                <div class="col-12">
                  ORDENES PARA EMPACAR
                  <i
                    class="fa fa-like"
                    aria-hidden="true"
                  ></i>
                </div>
                <div class="col-4 d-none">
                  <div class="form-group">
                    <select
                      class="form-control"
                      id="brand"
                      v-model="filtro"
                      aria-placeholder="Filtrar por"
                    >
                      <option
                        v-for="(item, key) in filtros"
                        :key="key"
                        :value="item.value"
                      >{{ item.text }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-4 d-none">
                  <div
                    class="form-group"
                    v-if="filtro == 5"
                  >
                    <input
                      type="text"
                      class="form-control"
                      id="name"
                      v-model="valorBuscar"
                      required
                      placeholder="Ingrese el nombre del cliente"
                    />
                  </div>

                  <div
                    class="form-group"
                    v-if="filtro == 4"
                  >
                    <date-picker
                      v-model="rango_fecha"
                      range
                    ></date-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="p-2 card-body bg-gradient-secondary">
              <div v-if="items && items.length > 0">
                <div
                  v-for="(item, key) in items"
                  :key="key"
                >
                  <div
                    class="card"
                    v-if="item.state == 2"
                  >
                    <div class="p-1 card-body">
                      <a :href="`../orders/entregar/show/${item.id}`">
                        <div class="row">
                          <div class="col-8 col-lg-8 text-primary text-bold">
                            {{ item.full_name }}
                          </div>
                          <div class="text-right col-4 col-lg-4 text-success text-bold">
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
              <span v-else>No se encontraron datos.</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Axios from "axios";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
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
      valorBuscar: "",
      rango_fecha: "",
      filtro: "1",
      filtros: [
        { value: "1", text: "Hoy dia" },
        { value: "2", text: "Ultimos 7 dias" },
        { value: "3", text: "Este mes" },
        { value: "4", text: "Entre fechas" },
        { value: "5", text: "Por cliente" }
      ],
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
        encamino_user: item.encamino_user,
        tax: item.tax,
        total: item.total,
        fecha_entrega: item.fecha_entrega,
        hora_entrega: item.hora_entrega
      }));
      console.log(rpt);
      this.items = rpt;
      //   this.items = rpt.filter(event => event.entregado_user == Date();
      //   this.items = rpt.data.filter(a => a.state == 1);

      //   console.log("fecha:" + fecha);
      this.items.sort((a, b) => b.fecha_entrega - a.fecha_entrega);
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
    itemss() {
      //   if (this.filtro == 1) {
      //     let fecha = this.moment().format("Y-MM-DD");
      //     console.log(`La fecha:${fecha}`);
      //     return this.items.filter(
      //       fila => this.moment(fila.encamino_user).format("Y-MM-DD") == fecha
      //     );
      //   }
      //   if (this.filtro == 2) {
      //     let fecha = this.moment().format("Y-MM-DD");
      //     let fecha7 = this.moment()
      //       .add(-7, "days")
      //       .format("Y-MM-DD");
      //     return this.items.filter(fila => {
      //       if (
      //         fecha7 <= this.moment(fila.encamino_user).format("Y-MM-DD") &&
      //         this.moment(fila.encamino_user).format("Y-MM-DD") <= fecha
      //       ) {
      //         return fila;
      //       }
      //     });
      //   }
      //   if (this.filtro == 3) {
      //     let mes = this.moment().format("MM");
      //     let anio = this.moment().format("Y");
      //     let primera_fecha = this.moment()
      //       .startOf("month")
      //       .format("YYYY-MM-DD");
      //     let segunda_fecha = this.moment()
      //       .endOf("month")
      //       .format("YYYY-MM-DD");
      //     return this.items.filter(fila => {
      //       if (
      //         primera_fecha <=
      //           this.moment(fila.encamino_user).format("Y-MM-DD") &&
      //         this.moment(fila.encamino_user).format("Y-MM-DD") <= segunda_fecha
      //       ) {
      //         return fila;
      //       }
      //     });
      //   }
      //   if (this.filtro == 4) {
      //     if (this.rango_fecha.length > 0) {
      //       let primera_fecha = this.moment(this.rango_fecha[0]).format(
      //         "YYYY-MM-DD"
      //       );
      //       let segunda_fecha = this.moment(this.rango_fecha[1]).format(
      //         "YYYY-MM-DD"
      //       );
      //       return this.items.filter(fila => {
      //         if (
      //           primera_fecha <=
      //             this.moment(fila.encamino_user).format("Y-MM-DD") &&
      //           this.moment(fila.encamino_user).format("Y-MM-DD") <= segunda_fecha
      //         ) {
      //           return fila;
      //         }
      //       });
      //     }
      //   }
      //   if (this.filtro == 5) {
      //     return this.items.filter(valor => {
      //       return valor.full_name
      //         .toLowerCase()
      //         .includes(this.valorBuscar.toLowerCase());
      //     });
      //   }
    }
  }
};
</script>
