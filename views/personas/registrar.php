<?php require_once '../header.php' ?>

<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Personas</h1>

    <!-- Contenido -->
    <div class="row">
      <div class="col-md-12">
        <form action="" autocomplete="off" id="formulario-personas">
          <div class="card">
            <div class="card-header">Datos de la persona</div>
            <div class="card-body">
              <!-- Fila 1 -->
              <div class="row g-3 mb-3">
                <div class="col-md-2">
                  <div class="input-group">
                    <div class="form-floating">
                      <input type="text" class="form-control" maxlength="8" id="dni" autofocus>
                      <label for="dni" class="form-label">DNI</label>
                    </div>
                    <button type="button" id="buscar-dni" class="btn btn-sm btn-outline-success"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="apellidos" required>
                    <label for="apellidos" class="form-label">Apellidos</label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nombres" maxlength="40" required>
                    <label for="nombres" class="form-label">Nombres</label>
                  </div>
                </div>
              </div>
              <!-- Fin Fila 1 -->
              <!-- Fila 2 -->
              <div class="row g-3">
                <div class="col-md-2">
                  <div class="form-floating">
                    <input type="text" class="form-control" pattern="[0-9]+" title="Solo se permiten números"
                      minlength="9" maxlength="9" id="telefono" required>
                    <label for="telefono" class="form-label">Teléfono</label>
                  </div>
                </div>
                <div class="col-md-10">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="direccion" required>
                    <label for="direccion" class="form-label">Dirección</label>
                  </div>
                </div>
              </div>

              <!-- Fin fila 2 -->
            </div>
            <div class="card-footer text-end">
              <button type="submit" class="btn btn-sm btn-primary">Registrar</button>
              <button type="reset" class="btn btn-sm btn-outline-secondary">Cancelar</button>
              <a href="index.php" class="btn btn-sm btn-outline-primary">Mostrar lista</a>
            </div>
          </div> <!-- .card -->
        </form> <!-- fin formulario -->
      </div> <!-- .col-md-12 -->
    </div> <!-- .row -->
    <!-- Fin contenido -->

  </div> <!-- .container-fluid -->
</main>

<?php require_once '../footer.php' ?>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    //Paso 01: Crear un función de referencia GLOBAL
    function $(object = null) { return document.querySelector(object); }

    //Funciones
    //Lógica de comunicación con el API
    function buscarDNI() {
      console.log("Estoy buscando espérate...")
    }

    //Evento Registrar Persona
    $("#formulario-personas").addEventListener("submit", (event) => {
      event.preventDefault();

      if (confirm("¿Seguro de proceder?")) {
        console.log("Guardado correctamente");
      }
    });

    //Evento buscar PERSONA API
    $("#dni").addEventListener("keypress", (event) => {
      if (event.keyCode == 13) { buscarDNI(); }
    });

    $("#buscar-dni").addEventListener("click", buscarDNI);

  });
</script>

<!-- No olvidar -->
</body>

</html>