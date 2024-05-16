<?php
class FormularioTarjeta
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;
    private $monedas;
    private $precio;
    private $productos;

    public function __construct($monedas, $precio, $productos)
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "formularioTarjeta";
        $this->monedas = $monedas;
        $this->precio = $precio;
        $this->productos = $productos;
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

        header("Location: index.php");
        exit();
    }

    protected function formularioEnviado(&$datos)
    {
        return isset($datos['formId']) && $datos['formId'] == $this->formId;
    }

    protected function generaFormulario(&$datos = array())
    {

        $html = <<<EOF
            <form action="{$this->action}" method="post">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <input type="hidden" name="monedas" id="monedas" value="{$this->monedas}" />
                <input type="hidden" name="precio" id="precio" value="{$this->precio}" />
                <input type="hidden" name="productos" id="productos" value="{$this->productos}" />
                <div class="containerTarjeta">
                    <button class="tarjeta">Comprar</button>
                </div>
            </form>
EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        if(isset($datos['monedas'])){
            $usuario = Usuario::getUsuarioPorId($_SESSION['id']);
            $carro = Orders::buscaCarritoUser($usuario->id);
            $carro->compraCarro();
            if($datos['monedas'] > 0){
                $usuario->quitaMonedas($datos['monedas']);
                $_SESSION['monedas'] = intval($usuario->monedas);
            }

            $usuario->annadeMonedas($datos['precio'] * 0.1);
            $_SESSION['monedas'] = intval($usuario->monedas);
            $usuario->annadeXp($datos['productos'] * 25);
            $_SESSION['xp'] = intval($usuario->xp);
        }
    }
}
