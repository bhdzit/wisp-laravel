<template>
  <div class="box-header">
    <h3 class="box-title">Tabla de Routers</h3>
    <button class="btn btn-primary pull-right" @click="addRouter()">
      Agregar Routers
    </button>
  </div>
</template>
<script>
import Swal from "sweetalert2";
const RosApi = require("node-routeros").RouterOSAPI;
export default {
  methods: {
    addRouter() {
      Swal.fire({
        title: "Agregar Router",
        html:
          '<input id="swal-input1" class="swal2-input" width="100%" placeholder="Identidad">' +
          '<input id="swal-input2" class="swal2-input" placeholder="Usuario">' +
          '<input id="swal-input2" class="swal2-input" placeholder="Contraseña">',
        confirmButtonColor: "#fa6c3c",
        iconColor: "#309cce",
        preConfirm: () => {
          var MikroNode = require("mikronode");

          var device = new MikroNode("192.168.0.1");

          device
            .connect()
            .then(([login]) => {
              return login("username", "password");
            })
            .then(function (conn) {
              console.log("sdasd");
            });
          return false;
        },
      });
    },
  },
};
</script>
