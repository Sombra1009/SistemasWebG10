<?php
class FormularioParticiparSorteo
{
    private $errores;
    private $urlRedireccion;
    private $participa;
    private $action;
    private $formId;
    private $mensajeError;
    private $idSorteo;

    public function __construct($id)
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->participa = false;
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "formularioSorteo";
        $this->idSorteo = $id;
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
        $sorteo = Sorteo::buscaPorId($this->idSorteo);

        $html = <<<EOF

        <form method="POST" action="{$this->action}" id="{$this->formId}">
            <input type="hidden" name="formId" value="{$this->formId}">
            <input type="hidden" name="idSorteo" value="{$this->idSorteo}">
            <button type="button" onclick="confirmarSorteo()" class="foroButton">PARTICIPAR</button>
        </form>
            
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $idUsuario = $_SESSION['id'];

        $idSorteo = trim($datos['idSorteo'] ?? '');
        $idSorteo = filter_var($idSorteo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$idSorteo || empty($idSorteo)) {
            $this->errores = true;
        }

        if(!$this->errores){
            Sorteo::buscaPorId($idSorteo)->annadeUsuario($idUsuario);
        }

        
    }
}
