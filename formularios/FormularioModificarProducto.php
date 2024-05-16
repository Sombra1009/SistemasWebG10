<?php
class FormularioModificarProducto
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;
    private $producto;

    public function __construct($producto)
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "FormularioSubidaProducto";
        $this->producto = $producto;
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

        $check = "";
        if($this->producto->estado == 0){
            $check = 'checked';
        }

        $options = "";
        foreach (Categoria::getAllCategorias() as $categoria) {
            $options .= "<option value='{$categoria->id}'>{$categoria->nombre}</option>";
        }

        $nivelMax = Niveles::getMaxLevel();
        $html = <<<EOF
        <div class="sesion">
            <h1>MODIFICAR PRODUCTO</h1>
                
            <h2></h2>
            <form action="{$this->action}" method="post" id="modificarForm" enctype="multipart/form-data">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="{$this->producto->nombre}">
                <label for="descripcion">Descripcion:</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="{$this->producto->descripcion}">
                <label for="precio">Precio:</label>
                <input type="text" name="precio" id="precio" step="0.01" pattern="\d+(\.\d{1,2})?" placeholder="{$this->producto->precio}">
                <label for="stock">Stock:</label>
                <input type="number" name="stock" id="stock" min='1' placeholder="{$this->producto->stock}">
                <label for="imagen">Imagen:</label>
                <input type="file" accept=".png" name="imagen" id="imagen">
                <label for="userId">ID del usuario que sube el producto:</label>
                <input type="number" name="userId" id="userId" placeholder="{$this->producto->user_Id}">
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria">
                    {$options}
                </select>
                <label for="descuento">Descuento (cantidad de % de descuento):</label>
                <input type="number" name="descuento" id="descuento" placeholder="{$this->producto->descuento}">
                <label for="nivel">Nivel de usuario para el que va dirigido:</label>
                <input type="number" name="nivel" id="nivel" min="1" max="{$nivelMax}" placeholder="{$this->producto->nivel}">
                <label for="toggle">Estado del producto: </label>
                <input name="estado" id="estado" type="hidden" {$check}>
                <div class="toggle-cont">
                    <input class="toggle-input" id="toggle" name="toggle" type="checkbox" value="0" {$check}/>
                    
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

    protected function procesaFormulario(&$datos)
    {
        $this->errores = false;

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($nombre && !empty($nombre)) {
            $this->producto->cambiaNombre($nombre);
        }

        $descripcion = trim($datos['descripcion'] ?? '');
        $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($descripcion && !empty($descripcion)) {
            $this->producto->cambiaDescripcion($descripcion);
        }

        $precio = trim($datos['precio'] ?? '');
        $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($precio && !empty($precio)) {
            $this->producto->cambiaPrecio($precio);
        }

        $stock = trim($datos['stock'] ?? '');
        $stock = filter_var($stock, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($stock && !empty($stock)) {
            $this->producto->cambiaStock($stock);
        }

        if($datos['imagen']){
            $imagen = $datos['imagen']['tmp_name'];
            $imagen = filter_var($imagen, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (move_uploaded_file($imagen, "./productos/" . $this->producto->id . ".png")) {
                $this->producto->cambiaImagen("./productos/" . $this->producto->id . ".png");
            }
        }

        $userId = trim($datos['userId'] ?? '');
        $userId = filter_var($userId, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($userId && !empty($userId)) {
            $this->producto->cambiaUserId($userId);
        }

        $descuento = trim($datos['descuento'] ?? '');
        $descuento = filter_var($descuento, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (($descuento && !empty($descuento)) || $descuento == 0) {
            $this->producto->cambiaDescuento($descuento);
        }

        $nivel = trim($datos['nivel'] ?? '');
        $nivel = filter_var($nivel, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (($nivel && !empty($nivel))) {
            $this->producto->cambiaNivel($nivel);
        }

        $estado = trim($datos['toggle'] ?? 1);
        $estado = filter_var($estado, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (($estado && !empty($estado)) || $estado == 0) {
            $this->producto->cambiaEstado($estado);
        }

        $categoria = trim($datos['categoria'] ?? '');
        $categoria = filter_var($categoria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (($categoria && !empty($categoria))) {
            Categoria::cambiaCategoria($this->producto->id, $categoria);
        }
    }
}
