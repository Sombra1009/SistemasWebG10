<?php
class FormularioJuegoCarrito
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
        $this->formId = "formularioCarrito";
        $this->producto = $producto;
    }

    public function gestiona()
    {
        $datos = &$_POST;

        if (!$this->formularioEnviado($datos)) {
            return $this->generaFormulario();
        }

        $this->procesaFormulario($datos);
        $esValido = $this->errores;

        if ($esValido) {
            return $this->generaFormulario($datos);
        }

        header("Location: {$this->action}");
        exit();
    }

    protected function formularioEnviado(&$datos)
    {
        return isset($datos['formId']) && $datos['formId'] == $this->formId;
    }

    protected function generaFormulario(&$datos = array())
    {
        $precio = $this->producto->precio * $this->producto->cantidad;
        $carrito = <<<EOS
        <div class="juegoCarrito">
            <img src='{$this->producto->productoAsociado()->imagen}' alt='imagen del producto' class=portada>

            <div class="item">
                <p class="tituloItem">{$this->producto->productoAsociado()->nombre}</p>
                <div class="cantidad">
                    <form action="{$this->action}" method="post" id="menos" >
                        <input type="hidden" name="id" value="{$this->producto->id}"/>
                        <input type="hidden" name="formId" value="{$this->formId}"/>
                        <input type="hidden" name="accion" value="menos" />
                        <input type="submit" class="menos" name="menos" value="-">
                    </form>
                    <p class="c">{$this->producto->cantidad}</p>
                    <form action="{$this->action}" method="post" id="mas" >
                        <input type="hidden" name="id" value="{$this->producto->id}"/>
                        <input type="hidden" name="formId" value="{$this->formId}" />
                        <input type="hidden" name="accion" value="mas" />
                        <input type="submit" class="mas" name="mas" value="+">
                    </form>
                    <p class="precio">{$precio}€</p>
                </div>
                
           </div>
           
        </div>
        EOS;

        return $carrito;
    }

    protected function procesaFormulario(&$datos)
    {
        if(isset($datos['accion']) && isset($datos['id'])){
            $producto = Orders_Item::buscaPorId($datos['id']);

            if($datos['accion'] == 'menos'){
                $producto->decrementaCantidad();
            }else if($datos['accion'] == 'mas'){
                $producto->incrementaCantidad();
            }
        }
        
    }
}
