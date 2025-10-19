<?php
    // Navbar
    include '../components/navbar.php';

require_once '../model/Cliente.php';
$clienteModel = new Cliente();
$clientes = $clienteModel->obtenerClientes();
?>
<head>
    <title>Enviar Correo </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

    <div class="container py-5">
    <h2 class="text-center mb-4">Formulario para Envío de Notificaciones por Correo Electrónico</h2>
    <!-- Card con el formulario -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Enviar correo al cliente</h5>
        </div>
        <div class="card-body">
            <form id="contact_form" enctype="multipart/form-data">
              <!--   <div class="mb-3">    
                    <label class="form-label">Ingresa el correo electronico: <span class="text-danger"> * </span></label>
                    <input class="form-control" type="email" id="correo" placeholder="fulanito@gmail.com" name="correo" />
                </div> --> 
                <div class="mb-3">
    <label class="form-label">Selecciona el correo destinatario: <span class="text-danger"> * </span></label>
    <select class="form-control" id="correo" name="correo" required>
        <option value="">-- Selecciona un correo de un cliente --</option>
        <?php while($cliente = $clientes->fetch_assoc()): ?>
            <option value="<?= $cliente['correo'] ?>"><?= $cliente['nombre'] ?> (<?= $cliente['correo'] ?>)</option>
        <?php endwhile; ?>
    </select>
</div>

                <div class="mb-3">
                    <!-- Correo del destinatario -->
                    <label class="form-label">Ingresa el asunto del correo: <span class="text-danger"> * </span></label>
                    <input class="form-control" type="text" id="subject" placeholder="Su vehiculo esta listo!" name="subject"/>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ingresa un mensaje:  <span class="text-danger"> * </span></label>
                    <textarea class="form-control" id="message" placeholder="Se completo exitosamente el servicio de cambio de aceite, puede pasar a recoger su vehiculo!." name="message"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ingresa un mensaje:  <span class="text-danger"> * </span></label>
                    <input class="form-control" type="file" id="archivo" name="archivo" />
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="button" id="submit" value="send">Enviar</button>
                    <div id="loader" class="text-center mt-3" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Enviando...</span>
                    </div>
                    <p>Enviando correo, por favor espera...</p>
                    </div>
                    <div id="response" class="mt-3 text-center fw-bold"></div>
                </div>      
            </form>
        </div>
    </div>
</div> 

        <!-- ....//.... -->
<script src="../static/js/submission.js"></script>
