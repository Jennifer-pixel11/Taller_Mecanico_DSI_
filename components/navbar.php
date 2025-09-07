<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/Taller_Mecanico_DSI_/static/css/style.css">
  <link rel="stylesheet" type="text/css" href="/Taller_Mecanico_DSI_/public/styles.css">
</head>
<body class="bg-light">

<!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="barnav">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="/Taller_Mecanico_DSI_/public/logotipo.png" alt="Logo" height="70"></a>
        <!-- Botón hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuExpandible" aria-controls="menuExpandible" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
   <!-- Menú expandible -->
        <div class="collapse navbar-collapse" id="menuExpandible">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="/Taller_Mecanico_DSI_/main.php">INICIO</a></li>
            <li class="nav-item"><a class="nav-link active" href="/Taller_Mecanico_DSI_/model/Inventario.php">INVENTARIO</a></li>
            <li class="nav-item"><a class="nav-link active" href="/Taller_Mecanico_DSI_/views/ServicioView.php">SERVICIOS</a></li>
            <li class="nav-item"><a class="nav-link active" href="/Taller_Mecanico_DSI_/views/ProveedorView.php">PROVEEDORES</a></li>
            <li class="nav-item"><a class="nav-link active" href="/Taller_Mecanico_DSI_/views/CitaView.php">CITAS</a></li>
            <li class="nav-item"><a class="nav-link active" href="/Taller_Mecanico_DSI_/views/NotificacionView.php">NOTIFICACIONES</a></li>
          </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"><a href="controller/UsuarioController.php?accion=logout" class="btn btn-danger">Cerrar sesión</a></li>
          </ul>
         <!--  <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Buscar">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
          </form> -->
        </div>
      </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>