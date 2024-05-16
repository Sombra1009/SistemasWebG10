
<?php
class FormularioSubidaNoticia
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;

    public function __construct()
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "FormularioSubidaNoticia";
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
            <h1>CREAR NOTICIA</h1>
                
            <h2></h2>
            <form action="{$this->action}" method="post" id="modificarForm" enctype="multipart/form-data">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
                <label for="descripcion">Descripcion:</label>
                <input type="text" name="descripcion" id="descripcion" required>
                <label for="imagen">Imagen:</label>
                <input type="file" accept=".png" name="imagen" id="imagen" required>
                <input type="submit" class="submit" value="Crear">
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
        if (!$nombre || empty($nombre)) {
            $this->errores = true;
        }

        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$descripcion || empty($descripcion)) {
            $this->errores = true;
        }

        if($datos['imagen']){
            $imagen = $datos['imagen']['tmp_name'];
            $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        if(!$this->errores){
            $noticia = Noticia::insertaNoticia($nombre, $descripcion, $imagen);

            if(!$noticia){
                $this->errores = true;
            }else{
                move_uploaded_file($imagen, "./noticias/".$noticia->id.".png");
                $noticia->cambiaImagen("./noticias/".$noticia->id.".png");
                header("Location: ./");
                exit();
            }
        }

    }
}
