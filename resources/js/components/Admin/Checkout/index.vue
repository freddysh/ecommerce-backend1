<template>
  <div class="card">
    <div class="card-header">
      Checkout de pagos
    </div>
    <div class="card-body">
      <!-- Modal -->
      Modalida de pago

      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          name="exampleRadios"
          id="exampleRadios1"
          value="0"
          :checked="radio==0?'true':'false'"
          v-model="radio"
        >
        <label
          class="form-check-label"
          for="exampleRadios1"
        >
          Pago contra entrega
        </label>
      </div>
      <div class="form-check">
        <input
          class="form-check-input"
          type="radio"
          name="exampleRadios"
          id="exampleRadios2"
          value="1"
          :checked="radio==1?'true':'false'"
          v-model="radio"
        >
        <label
          class="form-check-label"
          for="exampleRadios2"
        >
          Pago con tarjeta
        </label>
      </div>

      <hr>
      <div class="row">
        <div
          v-if="radio==0"
          class="col-12"
        >
          <button class="btn btn-danger"><i class="far fa-thumbs-up"></i> Realizar pedido</button>
        </div>
        <div
          v-if="radio==1"
          class="col-12"
        >
          <button
            class="btn btn-primary"
            @click="PagoTarjeta()"
          ><i
              v-if="!loader"
              class="fas fa-credit-card"
            ></i>
            <div
              v-if="loader"
              class="spinner-border text-secondary"
              role="status"
            >
              <span class="sr-only">Loading...</span>
            </div>
            Pagar con tarjeta
          </button>

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
// import "https://pocpaymentserve.s3.amazonaws.com/payform.min.css";
export default {
  name: "Brand",
  //   components: { AddSocialPost, SocialPost },
  mounted() {},
  created() {},
  data() {
    return {
      radio: 0,
      modalidadPago: 0,
      configuration: {
        callbackurl: "",
        sessionkey: "",
        channel: "",
        merchantid: "",
        purchasenumber: "",
        amount: "",
        language: "",
        font: "",
        recurrencemaxamount: ""
      },
      pay: null,
      elementStyles: {
        base: {
          color: "#666666",
          fontWeight: 700,
          fontFamily: "'Montserrat', sans-serif",
          fontSize: "16px",
          fontSmoothing: "antialiased",
          placeholder: {
            color: "#999999"
          },
          autofill: {
            color: "#e39f48"
          }
        },
        invalid: {
          color: "#E25950",
          "::placeholder": {
            color: "#FFCCA5"
          }
        }
      },
      card: null,
      cardNumber: null,
      cardExpiry: null,
      cardCvc: null,
      loader: false
      //   payform: null
    };
  },
  methods: {
    sendPayment() {
      let data = {
        name: "Juan",
        lastName: "Perez",
        email: "jperez@test.com"
      };
      /* Caso de uso: Control unificado */
      payform
        .createToken([this.cardNumber, this.cardExpiry, this.cardCvc], data)
        .then(function(response) {
          /* Tú código aquí */
        })
        .catch(function(error) {
          /* Tú código aquí */
        });
    },
    PagoTarjeta() {
      this.loader = true;
      this.inicio2();
      this.loader = false;
    },
    async inicio() {
      await this.$loadScript(
        "https://pocpaymentserve.s3.amazonaws.com/payform.min.js"
      )
        .then(res => {
          // Código en caso de que tu script cargue
          Axios.get(`${process.env.MIX_MIX_APP_URL}/api/v1/payment-desacoplado`)
            .then(datos => {
              this.configuration = datos.data;
              payform.setConfiguration(this.configuration);
              this.card = payform.createElement(
                "card",
                {
                  style: elementStyles,
                  placeholder: "Número de tarjeta"
                },
                "txtTarjeta"
              );

              this.cardNumber = payform.createElement(
                "card-number",
                {
                  style: elementStyles,
                  placeholder: "Número de tarjeta"
                },
                "txtNumeroTarjeta"
              );
              this.cardExpiry = payform.createElement(
                "card-expiry",
                {
                  style: elementStyles,
                  placeholder: "MM/YY"
                },
                "txtFechaVencimiento"
              );

              this.cardCvc = payform.createElement(
                "card-cvc",
                {
                  style: elementStyles,
                  placeholder: "CVC"
                },
                "txtCvv"
              );
            })
            .catch(() => {
              // Código en caso de que la carga de tu script fallé
            });
        })
        .catch(() => {
          // Código en caso de que la carga de tu script fallé
        });
    },
    async inicio2() {
      await this.$loadScript(
        "https://static-content-qas.vnforapps.com/v2/js/checkout.js"
      )
        .then(res => {
          // Código en caso de que tu script cargue
          // primero enviamos a guardar la orden y recojemos el id de la orden
          let orderId = 253;
          Axios.get(
            `${process.env.MIX_MIX_APP_URL}/api/v1/payment-desacoplado/${orderId}`
          )
            .then(datos => {
              // primero enviamos a guardar la orden y recojemos el id de la orden

              this.configuration = datos.data;
              //   payform.setConfiguration(this.configuration);
              VisanetCheckout.configure({
                sessiontoken: this.configuration.sessionkey,
                channel: this.configuration.channel,
                merchantid: this.configuration.merchantid,
                purchasenumber: this.configuration.purchasenumber,
                amount: this.configuration.amount,
                expirationminutes: "20",
                timeouturl: "about:blank",
                merchantlogo: "https://orion.com.pe/images/logo-orion.png",
                formbuttoncolor: "#000000",
                cardholdername: this.configuration.name,
                cardholderlastname: this.configuration.lastname,
                cardholderemail: this.configuration.email,
                action: this.configuration.callbackurl,
                complete: function(params) {
                  alert(JSON.stringify(params));
                }
              });
              VisanetCheckout.open();
            })
            .catch(() => {
              // Código en caso de que la carga de tu script fallé
            });
        })
        .catch(() => {
          // Código en caso de que la carga de tu script fallé
        });
    }
  },
  computed: {}
};
</script>
<style  scoped>
@import "https://pocpaymentserve.s3.amazonaws.com/payform.min.css";
</style>
