<?php
class FormularioValidarCompra
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;
    private $precio;
    private $descuento;
    private $productos;

    public function __construct($precio, $productos)
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = "tarjetazo.php";
        $this->formId = "formularioValidarCompra";
        $this->precio = $precio;
        $this->descuento = false;
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
        $precio = $this->precio;
        $monedas = 0;
        $descuento = 0;

            if(($_SESSION['monedas'] / 100) <= $precio){
                $descuento = $precio - ($_SESSION['monedas'] / 100);
                $monedas = $_SESSION['monedas'];
            } else {
                $monedas = $precio * 100;
                $descuento = 0;
            }



        $html = <<<EOF
        <div class="total">
            <form action="{$this->action}" method="post" id="validarCompraForm">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <input type="hidden" name="precio" value="{$precio}" />
                <input type="hidden" name="productos" value="{$this->productos}" />
                <input type="hidden" name="precioDescuento" value="{$descuento}" />
                <input type="checkbox" name="monedas" id="monedas" value="{$monedas}">
                <label for="monedas">Monedas disponibles: {$_SESSION['monedas']} <span id="monedasDescuento" class="red" style="display: none">  -{$monedas}</span></label>
                <h2>Total: <span id="precioSinDescuento" style="display:inline">{$precio}</span><span id="precioDescuento" style='display: none'>{$descuento}</span>€</h2>
                <a onclick="confirmarCompra()">
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
        </div>
        <script>

            document.getElementById('monedas').addEventListener('change', function() {
                if (this.checked) {
                    document.getElementById('precioSinDescuento').style.display = 'none';
                    document.getElementById('precioDescuento').style.display = 'inline';
                    document.getElementById('monedasDescuento').style.display = 'inline';
                } else {
                    document.getElementById('precioSinDescuento').style.display = 'inline';
                    document.getElementById('precioDescuento').style.display = 'none';
                    document.getElementById('monedasDescuento').style.display = 'none';
                }
            });

            function confirmarCompra() {
                document.getElementById('validarCompraForm').submit();
            }
        </script>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $precio = $datos['precio'];
        if(isset($datos['monedas'])){
            $precio = $datos['precioDescuento'];
        }

        echo "hola";
        sleep(5);
    }
}
