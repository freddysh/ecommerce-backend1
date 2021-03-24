<template>
  <div class="row">
    <div class="col-12">
      <button
        class="btn btn-primary"
        @click="drawMarkers"
      >Draw Markers</button>
      <button
        class="btn btn-primary"
        @click="drawDirecction"
      >Draw Direction</button>
      <button
        class="btn btn-primary"
        @click="clearMap"
      >Clear Map</button>
    </div>
    <div class="col-12">
      <gmap-map
        :center="center"
        :zoom="16"
        style="width: 100%; height: 400px"
      >
        <gmap-marker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          :title="m.title"
          :clickable="true"
          :draggable="true"
          @click="center"
        ></gmap-marker>
      </gmap-map>
    </div>
  </div>

</template>
<script>
export default {
  data() {
    return {
      lat: 0,
      lng: 0,
      center: { lat: this.latitude, lng: this.longitude },
      miUbicacion: { lat: -13.519239, lng: -71.979004 },
      cliente: { lat: this.latitude, lng: this.longitude },
      markers: [],
      location: null,
      gettingLocation: false,
      errorStr: null
    };
  },

  props: {
    latitude: Number,
    longitude: Number,
    title: String
  },
  created() {
    // this.locateMe();
  },
  mounted() {
    this.MiLocalizacion();
    // this.geolocate();
  },
  methods: {
    drawMarkers() {},
    drawDirecction() {},
    clearMap() {},
    async MiLocalizacion() {
      await this.$getLocation({
        enableHighAccuracy: true, //defaults to false
        timeout: 5000, //defaults to Infinity
        maximumAge: 0 //defaults to 0
      }).then(coordinates => {
        console.log(coordinates);
      });
      var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
      };
      await navigator.geolocation.getCurrentPosition(
        this.success,
        this.error,
        options
      );
    },
    async success(pos) {
      var crd = pos.coords;

      console.log("Your current position is:");
      console.log(`Latitude : ${crd.latitude}`);
      console.log(`Longitude: ${crd.longitude}`);
      console.log(`More or less ${crd.accuracy} meters.`);
      this.miUbicacion = { lat: crd.latitude, lng: crd.longitude };

      await this.markers.push({
        position: { lat: this.latitude, lng: this.longitude },
        title: this.title
      });
      await this.markers.push({
        position: { lat: crd.latitude, lng: crd.longitude },
        title: "Mi ubicacion"
      });
    },
    async error(err) {
      console.warn(`ERROR(${err.code}): ${err.message}`);
    },
    // async getLocation() {
    //   return new Promise((resolve, reject) => {
    //     if (!("geolocation" in navigator)) {
    //       reject(new Error("Geolocation is not available."));
    //     }

    //     navigator.geolocation.getCurrentPosition(
    //       pos => {
    //         resolve(pos);
    //       },
    //       err => {
    //         reject(err);
    //       }
    //     );
    //   });
    // },
    // async locateMe() {
    //   this.gettingLocation = true;
    //   try {
    //     this.gettingLocation = false;
    //     this.location = await this.getLocation();
    //   } catch (e) {
    //     this.gettingLocation = false;
    //     this.errorStr = e.message;
    //   }
    // },
    // async geolocate() {
    //   console.log("Iniciando...");
    //   if (await navigator.geolocation) {
    //     //check if geolocation is available
    //     await navigator.geolocation.getCurrentPosition(
    //       position =>
    //         function() {
    //           console.log(
    //             `${position.coords.latitude},${position.coords.longitude}`
    //           );
    //           this.lat = position.coords.latitude;
    //           this.lng = position.coords.longitude;
    //           console.log("tag", "se agrego la ubicacion");
    //           //   console.log("ubicacion:");
    //           //   this.miUbicacion.lat = 12123;
    //           //     (this.miUbicacion.lat = position.coords.latitude);
    //           //   this.miUbicacion.lng = position.coords.longitude;
    //           //   console.log("buscando mi ubicacion:" + this.miUbicacion);
    //         }
    //     );
    //     this.miUbicacion = { lat: 4343434, lng: 56565656 };
    //     console.log("ubicacion1:" + this.miUbicacion);
    //   }

    //   console.log("Terminando...");
    // },
    async agregarPuntos() {
      await this.markers.push({
        position: { lat: this.latitude, lng: this.longitude },
        title: this.title
      });
      await this.markers.push({
        position: this.miUbicacion,
        title: "Mi ubicacion"
      });
    }
  }
};
</script>
