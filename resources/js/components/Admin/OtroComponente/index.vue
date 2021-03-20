<template>
  <div class="card">
    <div class="card-header">
    </div>
    <div class="card-body">
      Hola
      <button
        type="button"
        class="btn btn-success btn-block"
        data-toggle="modal"
        @click="enviarEvento()"
      >
        <i class="las la-plus-circle"></i> Enviar evento
      </button>
    </div>
  </div>
</template>

<script>
import Axios from "axios";
export default {
  name: "Brand",
  mounted() {
    // core.index();
  },
  created() {},
  data() {
    return {};
  },
  methods: {
    enviarEvento() {
      this.$emit("escuchaEvento");
    }
  },
  computed: {}
};
</script>
