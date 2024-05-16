<?php
require_once 'config.php';

$nombre = $_GET['nombre'] ?? '';

$cabecera = 'cabecera.php';

$contenidoPrincipal = <<<EOS
        <div class="sesion">
            <h1>Ganador del Sorteo:</h1>
                
            <h2 class="ganador">$nombre</h2>
            <form action="./">
                <input type="submit" class="submit" value="Aceptar">
            </form>
        </div>
        EOS;

require 'plantilla.php';