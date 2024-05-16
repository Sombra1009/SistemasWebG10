<?php
class FormularioCompra
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;
    private $idProducto;

    public function __construct($id)
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "formularioLogin";
        $this->idProducto = $id;
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
            <form action="{$this->action}" method="post" id="compraForm{$this->idProducto}">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <input type="hidden" name="idProducto" id="idProducto" value="{$this->idProducto}" />
                <a onclick="confirmarCompra({$this->idProducto})">
                    <div class="button">
                        <div class="button-wrapper">
                            <div class="text">Comprar</div>
                            <span class="icon">
                            <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            class="bi bi-cart2"
                            viewBox="0 0 16 16">
                            <path
                            d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"
                            ></path>
                            </svg>
                            </span>
                        </div>
                    </div>
                </a>
            </form>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $carrito = Orders::buscaCarritoUser($_SESSION['id']);

        $idProducto = trim($datos['idProducto'] ?? '');
        $idProducto = filter_var($idProducto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$idProducto || empty($idProducto)) {
            $this->errores = true;
        }

        if(!$this->errores){
            $carrito->annadeProducto($idProducto);
        }
    }
}
