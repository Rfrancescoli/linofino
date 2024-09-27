<?php require_once '../header.php' ?>

<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Personas</h1>

    <!-- Contenido -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Datos de la persona</div>
          <div class="card-body">
            <table class="table table-striped-table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>DNI</th>
                  <th>Appelidos</th>
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
            <a href="registrar.php" class="btn btn-sm btn-primary">Registrar persona</a>
          </div>
        </div>
      </div> <!-- .col-md-12 -->
    </div> <!-- .row -->
    <!-- Fin contenido -->

  </div> <!-- .containter-fluid -->
</main>

<?php require_once '../footer.php' ?>