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
import axios from "axios";

const conexcionExitosa= () => {
  Swal.fire({
    title: "Conexcion Exitosa",
    iconHtml: '<i class="fas fa-check-circle"></i>',
    html: " <p><strong>Se ha agregado el router exitosamente</strong></p>",
    confirmButtonText: "ACEPTAR",
    confirmButtonColor: "#fa6c3c",
    iconColor: "#309cce",
    didClose: () => {
      // location.reload();
      //    esFavorito=true;
    },
  });
};

const conexcionErronea= () => {
  Swal.fire({
    title: "Conexcion Fallo",
    iconHtml: '<i class="fas fa-times"></i>',
    html: " <p><strong>Parece que algo salío mal</strong></p>",
    confirmButtonText: "ACEPTAR",
    confirmButtonColor: "#fa6c3c",
    iconColor: "#309cce",
    didClose: () => {
      // location.reload();
      //    esFavorito=true;
    },
  });
};


export default {
  methods: {
    addRouter() {
      Swal.fire({
        title: "Agregar Router",
        html:
          '<form id="routerForm" method=POST  action="routers/verificarCredencialesRouter">' +
          '<input name="ip" id="swal-input1" class="swal2-input" width="100%" placeholder="Identidad">' +
          '<input name="user" id="swal-input2" class="swal2-input" placeholder="Usuario">' +
          '<input name="pass" id="swal-input2" class="swal2-input" placeholder="Contraseña">' +
          "</form>",
        confirmButtonColor: "#fa6c3c",
        iconColor: "#309cce",
        preConfirm: () => {
          var formElement = document.getElementById("routerForm");
          let formData = new FormData(formElement);

          axios
            .post("routers/verificarCredencialesRouter", formData)
            .then(function (response) {
              // handle success
              conexcionExitosa();
              console.log(response);
            })
            .catch(function (error) {
              // handle error
              conexcionErronea();
              console.log(error);
            });
          return false;
        },
      });
    },
  },
};
</script>
