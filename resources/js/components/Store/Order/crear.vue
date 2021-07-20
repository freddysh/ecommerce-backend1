<template>
  <div class="card-body">
    <div class="row">
      hola
    </div>
  </div>
</template>
<script>
import Axios from "axios";
export default {
  name: "CrearOrden",
  components: {},
  mounted() {},
  created() {
    this.index();
  },
  props: ["user_id"],
  data() {
    return {};
  },
  methods: {
    numero(num) {
      return Math.round(num * 100) / 100;
    }
  },
  computed: {}
};
</script>
