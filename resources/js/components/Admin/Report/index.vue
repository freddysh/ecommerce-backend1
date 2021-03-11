<template>
  <div class="card">
    <div class="p-2 card-body">
      <div class="row">
        <div class="col-6">
          <span>Top(5) productos mas vendidos</span>

          <GChart
            type="PieChart"
            :data="top_chartData"
          />
        </div>
      </div>

      <div class="row">
        <div class="col-4">
          <span>Situacion actual de las ordenes</span>
          <table class="table table-striped table-sm table-responsive">
            <thead>
              <tr>
                <th>Fase</th>
                <th>Cantidad</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>Pendientes</td>
                <td>{{ pendiente }}</td>
              </tr>
              <tr>
                <td>Empacados</td>
                <td>{{ empacado }}</td>
              </tr>
              <tr>
                <td>En camino</td>
                <td>{{ encamino }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-8">

          <span>Situacion de las ordenes</span>
          <div class="row">
            <div class="col-5">
              <div
                class="btn-group"
                role="group"
                aria-label="Basic example"
              >
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="switcher(1)"
                >Dia</button>
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="switcher(2)"
                >Mes</button>
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="switcher(3)"
                >Año</button>
              </div>
            </div>
            <div class="col-6">
              <date-picker
                v-model="rango_fecha"
                range
              ></date-picker>
            </div>
            <div class="text-left col-1">
              <button
                type="button"
                class="btn btn-primary"
                @click="filtrar_ingresos()"
              ><i class="fas fa-search"></i></button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <line-chart :data="ingresos"></line-chart>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
import { GChart } from "vue-google-charts";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
// import AddSocialPost from './Components/AddSocialPost'
export default {
  name: "Order",
  components: {
    GChart,
    DatePicker
  },

  mounted() {
    // core.index();
  },
  created() {
    this.index();
    this.pendientes();
    this.empacados();
    this.encaminos();
    this.ingresos_();
  },
  data() {
    return {
      pendiente: 0,
      empacado: 0,
      encamino: 0,
      top_chartData: [["Producto", "Cantidad"]],
      ingresos: {},
      rango_fecha: Array(new Date(), new Date())
    };
  },
  methods: {
    async index() {
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/products/others/tops`
      );
      console.log("tops" + datos.data);
      let rpt = datos.data.map(item => [
        `${item.name} ${item.description}`,
        parseInt(item.cantidad)
      ]);
      console.log(rpt);
      rpt.forEach(element => {
        this.top_chartData.push(element);
      });
    },
    async pendientes() {
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/orders/others/pendientes`
      );
      this.pendiente = datos.data;
    },
    async empacados() {
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/orders/others/empacados`
      );
      this.empacado = datos.data;
    },
    async encaminos() {
      let datos = await Axios.get(
        `${process.env.MIX_MIX_APP_URL}/api/v1/orders/others/encamino`
      );
      this.encamino = datos.data;
    },
    async ingresos_() {
      let datos = await Axios.get(
        `${
          process.env.MIX_MIX_APP_URL
        }/api/v1/orders/others/ingresos/${this.moment(
          this.rango_fecha[0]
        ).format("YYYY-MM-DD")}/${this.moment(this.rango_fecha[1]).format(
          "YYYY-MM-DD"
        )}`
      );
      console.log("ingresos:" + datos.data);
      this.ingresos = datos.data;
    },
    numero(num) {
      return Math.round(num * 100) / 100;
    },
    switcher(opcion) {
      if (opcion == 1) {
        this.rango_fecha = Array(new Date(), new Date());
      }
      if (opcion == 2) {
        let primera_fecha = this.moment().startOf("month");
        let segunda_fecha = this.moment().endOf("month");
        this.rango_fecha = Array(
          new Date(primera_fecha),
          new Date(segunda_fecha)
        );
      }
      if (opcion == 3) {
        let primera_fecha = this.moment().startOf("year");
        let segunda_fecha = this.moment().endOf("year");

        this.rango_fecha = Array(
          new Date(primera_fecha),
          new Date(segunda_fecha)
        );
      }
    },
    filtrar_ingresos() {
      this.ingresos_();
    }
  },
  computed: {}
};
</script>
