
<?php
class FormularioModificarSorteo
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;
    private $sorteo;

    public function __construct($sorteo)
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "FormularioSubidaNoticia";
        $this->sorteo = $sorteo;
    }

    public function gestiona()
    {
        $datos = &$_POST;
        $datos['imagen'] = $_FILES['imagen'] ?? false;

        if (!$this->formularioEnviado($datos)) {
            return $this->generaFormulario();
        }

        $this->procesaFormulario($datos);
        $esValido = $this->errores;

        if ($esValido) {
            return $this->generaFormulario($datos);
        }

        header("Location: ./");
        exit();
    }

    protected function formularioEnviado(&$datos)
    {
        return isset($datos['formId']) && $datos['formId'] == $this->formId;
    }

    protected function generaFormulario(&$datos = array())
    {
        $error = '';
        if ($this->errores) {
        }

        $html = <<<EOF
        <div class="sesion">
            <h1>MODIFICAR SORTEO</h1>
                
            <h2></h2>
            <form action="{$this->action}" method="post" id="modificarForm" enctype="multipart/form-data">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre">
                <label for="descripcion">Descripcion:</label>
                <input type="text" name="descripcion" id="descripcion">
                <label for="imagen">Imagen:</label>
                <input type="file" accept=".png" name="imagen" id="imagen">
                <label for="idProducto">Id producto:</label>
                <input type="number" name="idProducto" id="idProducto">
                <label for="toggle">Estado: </label>
                <div class="toggle-cont">
                    <input class="toggle-input" id="toggle" name="toggle" type="checkbox" value="0"/>
                    
                    <label class="toggle-label" for="toggle">
                    <div class="cont-label-play">
                        <span class="label-play"></span>
                    </div>
                    </label>
                </div>
                <input type="submit" class="submit" value="Modificar">
            </form>
        </div>
        EOF;
        return $html;
    }

    private $nombre;
    private $descripcion;
    private $imagen;

    protected function procesaFormulario(&$datos)
    {
        $this->errores = false;

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($nombre && !empty($nombre)) {
            $this->sorteo->cambiaNombre($nombre);
        }

        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($descripcion && !empty($descripcion)) {
            $this->sorteo->cambiaDescripcion($descripcion);
        }

        if($datos['imagen']){
            $imagen = $datos['imagen']['tmp_name'];
            $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            move_uploaded_file($imagen, "./sorteo/".$this->sorteo->id.".png");
            $this->sorteo->cambiaImagen("./sorteo/".$this->sorteo->id.".png");
        }

        $idProducto = trim($datos['idProducto'] ?? '');
        $idProducto = filter_var($idProducto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($idProducto && !empty($idProducto)) {
            $this->sorteo->cambiaIdProducto($idProducto);
        }

        $estado = trim($datos['toggle'] ?? 1);
        $estado = filter_var($estado, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (($estado && !empty($estado)) || $estado == 0) {
            $this->sorteo->cambiaEstado($estado);
        }

    }
}