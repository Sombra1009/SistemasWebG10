<script src="sweetalert2.js"></script>
<script src="scripts.js"></script>
<?php
class FormularioSubidaPost
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;
    private $idForo;

    public function __construct($id)
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "FormularioSubidaPost";
        $this->idForo = $id;
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
        $error = '';
        if ($this->errores) {
            $error = $this->errores;
        }
        $max = Niveles::getMaxLevel();

        $html = <<<EOF
        <div class="escribir">
            <form action="{$this->action}" method="post" id="modificarForm">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <input type="text" name="post" id="post" placeholder="Escribe aquí..." required>
                <button class="send" type="submit">
                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path fill="currentColor" d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>
                            </svg>
                        </div>
                    </div>
                    <span>Send</span>
                </button>
            </form>
        </div>
EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        if(isset($datos['post']) && isset($_SESSION['id'])){
            Post::creaPost($_SESSION['id'], $this->idForo, $datos['post']);
            Usuario::getUsuarioPorId($_SESSION['id'])->annadeXp(10);
            $_SESSION['xp'] = Usuario::getUsuarioPorId($_SESSION['id'])->xp;
        }
    }
}
