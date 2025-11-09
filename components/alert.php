<?php
// Componente para mostrar alertas con borde rojo
function mostrarAlerta($mensaje) {
    echo '<div class="alert alert-danger border border-danger rounded text-center" role="alert">'.htmlspecialchars($mensaje).'</div>';
}
?>