<?php require_once '../header.php' ?>

<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Usuarios</h1>

    <!-- Contenido -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Datos de la persona</div>
          <div class="card-body">
            <table class="table table-striped-table-sm" id="tabla-usuarios">
              <thead>
                <tr>
                  <th>#</th>
                  <th>DNI</th>
                  <th>Apellidos</th>
                  <th>Nombres</th>
                  <th>Dirección</th>
                  <th>Teléfono</th>
                  <th>Operaciones</th>
                </tr>
              </thead>
              <tbody>
                <!-- Datos dinámicos -->
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <a href="registrar.php" class="btn btn-sm btn-primary">Registrar usuario</a>
          </div>
        </div>
      </div> <!-- .col-md-12 -->
    </div> <!-- .row -->
    <!-- Fin contenido -->

  </div> <!-- .containter-fluid -->
</main>

<?php require_once '../footer.php' ?>

<script>
  document.addEventListener("DOMContentLoaded", () => {

    function $(object = null) {
      return document.querySelector(object);
    } //Simula ser JQuery

    async function obtenerDatos() {
      const response = await fetch(`../../app/controllers/Usuario.controller.php?operation=getAll`, {
        method: 'GET'
      });
      const data = await response.json();
      console.log(data);

      if (data.length > 0) {
        let numeroFila = 1;
        data.forEach(element => {
          const direccion = (element.direccion == null) ? '' : element.direccion;
          const nuevaFila = `
        <tr>
          <td>${numeroFila}</td>
          <td>${element.dni}</td>
          <td>${element.apellidos}</td>
          <td>${element.nombres}</td>
          <td>${direccion}</td>
          <td>${element.telefono}</td>
          <td>
            <a href='#' data-idusuario='${element.idusuario}' class='btn btn-sm btn-danger delete'>Eliminar</a>
            <a href='#' data-idusuario='${element.idusuario}' class='btn btn-sm btn-info edit'>Editar</a>
            <a href='#' data-idusuario='${element.idusuario}' class='btn btn-sm btn-secondary info'>Info</a>
          </td>
        </tr>
        `;
          numeroFila++;
          $("#tabla-usuarios tbody").innerHTML += nuevaFila;
        });
      }

      // Funcionará con: Eliminar, Editar, Info
      const botonesAccion = document.querySelectorAll("#tabla-usuarios tbody a");
      botonesAccion.forEach(element => {
        element.addEventListener("click", (event) => {
          // PASO 01: Capturar el IDUSUARIO (siempre existe)
          const idusuario = parseInt(element.getAttribute("data-idusuario"));

          // PASO 02: ¿Qué opción estás haciendo?
          // const tmp = event.target.classList;
          const clases = event.target.classList;

          // PASO 03: Identificando la clase
          if (clases.contains("delete")) {
            //Proceso de eliminar
            console.log("Eliminar: ", idusuario)
          } else if (clases.contains("edit")) {
            //Proceso de editar
            console.log("Editar: ", idusuario)
          } else if (clases.contains("info")) {
            //Proceso de info
            console.log("Info: ", idusuario)
          }
        });
      });
    }

    obtenerDatos();
  });
</script>