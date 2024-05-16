<?php
class FormularioSubidaProducto
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
        $this->formId = "FormularioSubidaProducto";
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

        $options = "";
        foreach (Categoria::getAllCategorias() as $categoria) {
            $options .= "<option value='{$categoria->id}'>{$categoria->nombre}</option>";
        }

        $nivelMax = Niveles::getMaxLevel();
        $html = <<<EOF
        <div class="sesion">
            <h1>CREAR PRODUCTO</h1>
                
            <h2></h2>
            <form action="{$this->action}" method="post" id="modificarForm" enctype="multipart/form-data">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
                <label for="descripcion">Descripcion:</label>
                <input type="text" name="descripcion" id="descripcion" required>
                <label for="precio">Precio:</label>
                <input type="text" name="precio" id="precio" step="0.01" pattern="\d+(\.\d{1,2})?" required>
                <label for="stock">Stock:</label>
                <input type="number" name="stock" id="stock" min='1' required>
                <label for="imagen">Imagen:</label>
                <input type="file" accept=".png" name="imagen" id="imagen" required>
                <input type="hidden" name="userId" id="userId" value="{$_SESSION['id']}">
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria" required>
                    {$options}
                </select>
                <label for="descuento">Descuento (cantidad de % de descuento):</label>
                <input type="number" name="descuento" id="descuento" value="0" required>
                <label for="nivel">Nivel de usuario para el que va dirigido:</label>
                <input type="number" name="nivel" id="nivel" min="1" max="{$nivelMax}" value="1" required>
                <label for="toggle">Estado del producto: </label>
                <input name="estado" id="estado" type="hidden" value="1">
                <div class="toggle-cont">
                    <input class="toggle-input" id="toggle" name="toggle" type="checkbox" value="0"/>
                    
                    <label class="toggle-label" for="toggle">
                    <div class="cont-label-play">
                        <span class="label-play"></span>
                    </div>
                    </label>
                </div>
                <input type="submit" class="submit" value="Crear">
            </form>
        </div>
        EOF;
        return $html;
    }

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

        $precio = trim($datos['precio'] ?? '');
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$precio || empty($precio)) {
            $this->errores = true;
        }

        $stock = trim($datos['stock'] ?? '');
        $stock = filter_var($stock, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$stock || empty($stock)) {
            $this->errores = true;
        }

        if($datos['imagen']){
            $imagen = $datos['imagen']['tmp_name'];
            $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        $userId = trim($datos['userId'] ?? '');
        $userId = filter_var($userId, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$userId || empty($userId)) {
            $this->errores = true;
        }

        $descuento = trim($datos['descuento'] ?? '');
        $descuento = filter_var($descuento, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ((!$descuento || empty($descuento))  && $descuento != 0) {
            $this->errores = true;
        }

        $nivel = trim($datos['nivel'] ?? '');
        $nivel = filter_var($nivel, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ((!$nivel || empty($nivel))) {
            $this->errores = true;
        }

        $estado = trim($datos['toggle'] ?? 1);
        $estado = filter_var($estado, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ((!$estado || empty($estado)) && $estado != 0) {
            $this->errores = true;
        }

        $categoria = trim($datos['categoria'] ?? '');
        $categoria = filter_var($categoria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ((!$categoria || empty($categoria))) {
            $this->errores = true;
        }

        if(!$this->errores){
            $producto = Producto::creaProducto($nombre, $descripcion, $precio, $stock, $imagen, $userId, $descuento, $nivel, $estado);

            if(!$producto){
                $this->errores = true;
            }else{
                Categoria::addCategoriaJuego($producto->id, $categoria);
                move_uploaded_file($imagen, "./productos/".$producto->id.".png");
                $producto->cambiaImagen("./productos/".$producto->id.".png");
                header("Location: ./");
                exit();
            }
        }

    }
}
