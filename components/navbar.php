<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="../public/logotipo.png" type="image/png">
  <link rel="stylesheet" type="text/css" href="../static/css/style.css">
  <link rel="stylesheet" type="text/css" href="../public/styles.css">
</head>
<body class="bg-light">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="barnav">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="../public/logotipo.png" alt="Logo" height="70"></a>
        <!-- Botón hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuExpandible" aria-controls="menuExpandible" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
   <!-- Menú expandible -->
        <div class="collapse navbar-collapse" id="menuExpandible">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link active" href="../main.php">INICIO</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/ClienteView.php">CLIENTES</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/VehiculoView.php">VEHÍCULOS</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/ServicioView.php">SERVICIOS</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/CitaView.php">CITAS</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/InventarioView.php">INVENTARIO</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/ProveedorView.php">PROVEEDORES</a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/NotificacionView.php">NOTIFICACIONES <span id="notif-badge" class="badge bg-danger ms-1 d-none">0</span></a></li>
            <li class="nav-item"><a class="nav-link active" href="../views/correoView.php">CORREO EMAIL</a></li>
          </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"><a href="../controller/UsuarioController.php?accion=logout" class="btn btn-danger">Cerrar sesión</a></li>
          </ul>
         <!--  <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Buscar">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
          </form> -->
        </div>
      </div>
  </nav>

  <style>
    /* Contenedor fijo para toasts */
    #notif-toasts { position: fixed; right: 1rem; bottom: 1rem; z-index: 1080; }
  </style>

  <div id="notif-toasts" aria-live="polite" aria-atomic="true"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    (function(){
      // Construye la URL del API intentando detectar la carpeta raíz del proyecto
      function apiUrl(){
        var parts = window.location.pathname.split('/');
        var idx = parts.indexOf('Taller_Mecanico_DSI_');
        var base = idx >= 0 ? ('/' + parts.slice(1, idx+1).join('/')) : '';
        return window.location.origin + base + '/controller/NotificacionController.php';
      }

      var API = apiUrl();
      var shown = new Set();

      // Actualiza el badge con el número de notificaciones no leídas
      async function updateBadge(){
        try{
          var res = await fetch(API + '?action=unread_count');
          if (!res.ok) return;
          var j = await res.json();
          var cnt = j.count || 0;
          var el = document.getElementById('notif-badge');
          if (!el) return;
          if (cnt > 0){ el.textContent = cnt; el.classList.remove('d-none'); }
          else { el.classList.add('d-none'); }
        }catch(e){ console.warn('badge update error', e); }
      }

      // Mostrar toasts para nuevas notificaciones (no marcamos como leídas automáticamente)
      async function fetchAndShow(){
        try{
          var res = await fetch(API + '?action=unread_list');
          if (!res.ok) return;
          var list = await res.json();
          for (var i=0;i<list.length;i++){
            var n = list[i];
            if (shown.has(n.id)) continue;
            showToast(n);
            shown.add(n.id);
          }
          updateBadge();
        }catch(e){ console.warn('notif fetch error', e); }
      }

      function showToast(n){
        var container = document.getElementById('notif-toasts');
        if (!container) return;
        var div = document.createElement('div');
        div.className = 'toast align-items-center text-bg-danger border-0 mb-2';
        div.setAttribute('role','alert');
        div.setAttribute('aria-live','assertive');
        div.setAttribute('aria-atomic','true');
        var inner = `
          <div class="d-flex">
            <div class="toast-body" style="cursor:pointer">${escapeHtml(n.mensaje || '')}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>`;
        div.innerHTML = inner;
        container.appendChild(div);
        var toast = new bootstrap.Toast(div, { delay: 10000 });

        // Cuando el usuario cierra el toast o hace click dentro, marcamos como leído
        div.addEventListener('hidden.bs.toast', function(){ markRead(n.id); updateBadge(); });

        // Click en el cuerpo marcará leído y cerrará el toast
        var body = div.querySelector('.toast-body');
        if (body){ body.addEventListener('click', function(){ try{ toast.hide(); }catch(e){} }); }

        toast.show();
      }

      function markRead(id){
        var fd = new FormData(); fd.append('action','mark_read'); fd.append('id', id);
        fetch(API, { method: 'POST', body: fd }).catch(()=>{});
      }

      function escapeHtml(s){ return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

      // Primer check y luego cada 20s
      updateBadge(); fetchAndShow();
      setInterval(function(){ updateBadge(); fetchAndShow(); }, 20000);
    })();
  </script>
</body>
</html>