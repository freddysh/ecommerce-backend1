<template>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div
          v-if="item"
          class="col-sm-12 col-md-4"
        >
          <h4>Datos de generales</h4>
          <p class="py-0 my-0">
            <span class="text-gray">Codigo:</span> {{ item.code }}
          </p>
          <p class="py-0 my-0">
            <span class="text-gray">Estado:</span>
            <span
              class="badge badge-danger"
              v-if="item.state == 1"
            >En tienda</span>
            <span
              class="badge badge-warning"
              v-if="item.state == 2"
            >En empacado</span>
            <span
              class="badge badge-primary"
              v-if="item.state == 3"
            >En camino</span>
            <span
              class="badge badge-success"
              v-if="item.state == 4"
            >Entregado</span>
          </p>
          <p
            class="py-0 my-0"
            v-if="item.state == 1"
          >
            <span class="text-gray">Fecha de creacion:</span>
            {{
              moment(`${item.created_at}`).format("dddd, Do MMMM YYYY HH:mm:ss")
            }}
          </p>
          <p
            class="py-0 my-0"
            v-if="item.state == 2"
          >
            <span class="text-gray">Fecha de creacion:</span>
            {{
              moment(`${item.en_proceso_user}`).format(
                "dddd, Do MMMM YYYY HH:mm:ss"
              )
            }}
          </p>
          <p
            class="py-0 my-0"
            v-if="item.state == 3"
          >
            <span class="text-gray">Fecha de creacion:</span>
            {{
              moment(`${item.dispached_user}`).format(
                "dddd, Do MMMM YYYY HH:mm:ss"
              )
            }}
          </p>

          <p
            class="py-0 my-0"
            v-if="item.state == 4"
          >
            <span class="text-gray">Fecha de creacion:</span>
            {{
              moment(`${item.entregado_user}`).format(
                "dddd, Do MMMM YYYY HH:mm:ss"
              )
            }}
          </p>
        </div>
        <div
          v-if="item"
          class="col-sm-12 col-md-4"
        >
          <h4>Datos de factura</h4>
          <p class="py-0 my-0">
            <span class="text-gray">Cliente:</span> {{ item.cliente.name }}
          </p>
          <p class="py-0 my-0">
            <span class="text-gray">Email:</span> {{ item.cliente.email }}
          </p>
          <p class="py-0 my-0">
            <span class="text-gray">Direccion:</span>
            {{ item.cliente.address }}
          </p>
          <p class="py-0 my-0">
            <span class="text-gray">Celular:</span> {{ item.cliente.phone }}
          </p>
          <p class="py-0 my-0">
            <span class="text-gray">Metodo de pago:</span>
            {{ item.cliente.phone }}
          </p>
        </div>
        <div
          v-if="item"
          class="col-sm-12 col-md-4"
        >
          <h4>Datos de envio</h4>
          <p class="py-0 my-0">
            <span class="text-gray">Cliente:</span> {{ item.cliente.name }}
          </p>
          <p class="py-0 my-0">
            <span class="text-gray">Celular:</span> {{ item.cliente.phone }}
          </p>

          <p class="py-0 my-0">
            <span class="text-gray">Direccion:</span> {{ item.address }}
          </p>

          <p class="py-0 my-0">
            <span class="text-gray">Fecha de entrega:</span>
            {{ item.fecha_entrega }}
            {{ item.hora_entrega }}
          </p>
        </div>
        <hr />
        <div class="col-sm-12">
          <table class="table table-striped table-hover table-condensed table-sm">
            <thead>
              <tr>
                <th>Codigo</th>
                <th>Producto</th>
                <th class="text-right">P.U(S/.)</th>
                <th class="text-right">Cant.</th>
                <th class="text-right">SubTotal(S/.)</th>
              </tr>
            </thead>
            <tbody v-if="item">
              <tr
                v-for="(producto, key) in item.productos_ordenados"
                :key="key"
              >
                <td>{{ producto.producto.code }}</td>
                <td>
                  {{ producto.producto.name }} -
                  {{ producto.producto.detail }}
                </td>
                <td class="text-right">{{ numero(producto.pu) }}</td>
                <td class="text-right">{{ producto.quantity }}</td>
                <td class="text-right">
                  {{ numero(numero(producto.quantity) * numero(producto.pu)) }}
                </td>
              </tr>
              <tr>
                <td
                  colspan="4"
                  class="text-right text-bold"
                >SubTotal</td>
                <td class="text-right">{{ subTotal }}</td>
              </tr>
              <tr>
                <td
                  colspan="4"
                  class="text-right text-bold"
                >Costo de envio</td>
                <td class="text-right">{{ item.tax }}</td>
              </tr>
              <tr>
                <td
                  colspan="4"
                  class="text-right text-bold"
                >Total</td>
                <td class="text-right">
                  {{ numero(numero(subTotal) + numero(item.tax)) }}
                </td>
              </tr>
            </tbody>
          </table>
          <div
            v-if="item"
            class="row"
          >
            <div class="col-12">
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
                          <label for="mensaje">Mensaje</label>
                          <input
                            type="text"
                            class="form-control"
                            id="mensaje"
                            name="mensaje"
                            placeholder="Ingrese el mensaje"
                            v-model="mensaje"
                            v-validate="'required'"
                            :class="{'input': true, 'danger': errors.has('mensaje') }"
                          />
                          <i
                            v-show="errors.has('mensaje')"
                            class="fa fa-warning"
                          ></i>
                          <span
                            v-show="errors.has('mensaje')"
                            class="help text-danger"
                          >{{ errors.first('mensaje') }}</span>
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
                        @click="cancelar"
                      >
                        Guardar
                      </button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div
              class="text-right col-6"
              v-if="item.state == 1"
            >
              <button
                type="button"
                class="btn btn-danger btn-lg"
                data-toggle="modal"
                @click="iniciarForm(-1)"
              >
                Rechazar nueva orden
              </button>
            </div>
            <div
              class="text-right col-6"
              v-if="item.state == 3"
            >
              <button
                type="button"
                class="btn btn-danger btn-lg"
                data-toggle="modal"
                @click="iniciarForm(-2)"
              >
                Cancelar entrega
              </button>
            </div>
            <div class="text-left col-6">
              <button
                v-if="item.state == 1"
                class="btn btn-success btn-lg"
                @click="enviarEmpacado"
              >
                <i
                  class="fa fa-cubes"
                  aria-hidden="true"
                ></i>
                Enviar para empacar
              </button>
              <button
                v-if="item.state == 2"
                class="btn btn-success btn-lg"
                @click="enviarEncamino"
              >
                <i
                  class="fa fa-truck"
                  aria-hidden="true"
                ></i>
                Enviar para entregar
              </button>
              <button
                v-if="item.state == 3"
                class="btn btn-success btn-lg"
                @click="enviarEntrega"
              >
                <i
                  class="fa fa-handshake-o"
                  aria-hidden="true"
                ></i>
                Realizar entrega
              </button>
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
// import GoogleMapLoader from "./GoogleMapLoader";
// import GoogleMapMarker from "./GoogleMapLoader";
// import GoogleMapLine from "./GoogleMapLoader";
// import { mapSettings } from "../../../constants/mapSettings";
export default {
  //   name: "Order",
  components: {
    // GoogleMapLoader,
    // GoogleMapMarker,
    // GoogleMapLine
  },
  mounted() {
    // core.index();
  },
  created() {
    this.index();
  },
  props: ["order_id", "user_id"],
  data() {
    return {
      apiKey: "AIzaSyC216yD_VOkh3YKnnNV6pbIQF2f-GDT7Ms",
      markers: [
        { id: "a", position: { lat: 3, lng: 101 } },
        { id: "b", position: { lat: 5, lng: 99 } },
        { id: "c", position: { lat: 6, lng: 97 } }
      ],
      lines: [
        {
          id: "1",
          path: [
            { lat: 3, lng: 101 },
            { lat: 5, lng: 99 }
          ]
        },
        {
          id: "2",
          path: [
            { lat: 5, lng: 99 },
            { lat: 6, lng: 97 }
          ]
        }
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
      item: null,
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
      paginate: ["itemss"],
      mensaje: "",
      state_mensaje: -1,
      tituloModal: "Rechazar nueva orden"
    };
  },
  methods: {
    numero(num) {
      return Math.round(num * 100) / 100;
    },
    async index() {
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/orders/${this.order_id}`
      );
      this.item = datos.data;
      //   this.items.sort((a, b) => a.fecha_entrega - b.fecha_entrega);
    },
    rechazar() {},
    enviarEmpacado() {
      Vue.swal
        .fire({
          title: "Esta seguro de guardar los datos?",
          text: "No podrás revertir este paso!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, Proceder!",
          cancelButtonText: "Cancelar"
        })
        .then(result => {
          if (result.isConfirmed) {
            this.enviarDatos(2);
          }
        });
      //   if (confirm("Estas seguro de borra este dato?")) {
      //   }

      //   if (confirm("Esta seguro de guardar los datos?")) {
      //     this.enviarDatos(2);
      //   }
    },
    enviarEncamino() {
      //   if (confirm("Esta seguro de guardar los datos?")) {
      //     this.enviarDatos(3);
      //   }

      Vue.swal
        .fire({
          title: "Esta seguro de guardar los datos?",
          text: "No podrás revertir este paso!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, Proceder!",
          cancelButtonText: "Cancelar"
        })
        .then(result => {
          if (result.isConfirmed) {
            this.enviarDatos(3);
          }
        });
    },
    enviarEntrega() {
      //   if (confirm("Esta seguro de guardar los datos?")) {
      //     this.enviarDatos(4);
      //   }

      Vue.swal
        .fire({
          title: "Esta seguro de guardar los datos?",
          text: "No podrás revertir este paso!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, Proceder!",
          cancelButtonText: "Cancelar"
        })
        .then(result => {
          if (result.isConfirmed) {
            this.enviarDatos(4);
          }
        });
    },
    async enviarDatos(state) {
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/orders/enviar/${this.item.id}/${state}/${this.user_id}`
      );
      console.log("rpt;uouo", datos.data);
      if (datos.data.status == 1) {
        // alert('datos editados')
        if (state == 2) {
          window.location.href = "../../list";
        } else if (state == 3) {
          window.location.href = "../../list";
        } else if (state == 4) {
          window.location.href = "../../entregar";
        }
      } else {
        alert("Ocurrio un error, vuelva a intentarlo mas tarde");
      }
    },
    iniciarForm(state) {
      this.state_mensaje = state;
      if (state == -2) {
        this.tituloModal = "Cancelar entrega";
      } else {
        this.tituloModal = "Rechazar nueva orden";
      }
      this.limpiarCampos();
      this.toggleModal();
    },
    limpiarCampos() {
      this.mensaje = "";
    },
    toggleModal() {
      $("#exampleModal").modal("toggle");
    },
    cancelar() {
      //   this.state_mensaje = state;
      this.$validator.validate().then(result => {
        if (result) {
          this.enviarDatosMensaje();
          this.toggleModal();
        }
      });
    },
    async enviarDatosMensaje() {
      let mensajito = {
        id: this.item.id,
        user_id: this.user_id,
        state: this.state_mensaje,
        mensaje: this.mensaje
      };
      let datos = await Axios.post(
        `${process.env.MIX_MIX_APP_URL}/api/v1/orders/enviar`,
        mensajito
      );
      console.log("respuesta:", datos.data);
      if (datos.data.status == 1) {
        // alert('datos editados')
        if (this.state_mensaje == -1) {
          window.location.href = "../../list";
        } else if (this.state_mensaje == -2) {
          window.location.href = "../../entregar";
        }
      } else {
        alert("Ocurrio un error, vuelva a intentarlo mas tarde");
      }
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
    subTotal() {
      if (this.item.productos_ordenados) {
        return this.item.productos_ordenados.reduce(
          (p, c) =>
            this.numero(
              this.numero(p) + this.numero(c.quantity) * this.numero(c.pu)
            ),
          0
        );
      }
    },
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
    // },
    mapConfig() {
      return {
        ...mapSettings,
        center: this.mapCenter
      };
    },
    mapCenter() {
      return this.markers[1].position;
    }
  }
};
</script>
