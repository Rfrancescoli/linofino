<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login']['estado']){
  header("Location:http://localhost/linofino/views");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Login - SB Admin</title>
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
                  <form id="form-login" autocomplete="off">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="nomusuario" type="text" autofocus required />
                      <label for="nomusuario">Nombre de usuario</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="claveacceso" type="password" required/>
                      <label for="claveacceso">Password</label>
                    </div>
                    <div class="form-check mb-3">
                      <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                      <label class="form-check-label" for="inputRememberPassword">Recordar contraseña</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <a class="small" href="password.html">Olvidaste tu contraseña?</a>
                      <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small"><a href="#">Versión 1.0</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="layoutAuthentication_footer">
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2023</div>
            <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", ()=> {
      function $(object = null) {return document.querySelector(object);}

      async function login() {
        const parametros = new FormData();
        parametros.append("operation", "login");
        parametros.append("nomusuario", $("#nomusuario").value);
        parametros.append("claveacceso", $("#claveacceso").value);

        const response = await fetch(`./app/controllers/Usuario.controller.php`, {
          method: 'POST',
          body: parametros
        });
        const data = await response.json();

        if (data.login){
          window.location.href = './views';
        }else{
          alert(data.mensaje);
        }
      }
      $("#form-login").addEventListener("submit", async (event) =>{
        event.preventDefault();
        await login();
      });
    });
  </script>
</body>

</html>