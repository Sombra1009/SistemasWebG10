<?php
class FormularioResenna
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
        $this->formId = "formularioResenna";
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

        header("Location: juego.php?id=" . $this->idProducto);
        exit();
    }

    protected function formularioEnviado(&$datos)
    {
        return isset($datos['formId']) && $datos['formId'] == $this->formId;
    }

    protected function generaFormulario(&$datos = array())
    {

        $html = <<<EOF
            <h2 class="containerTittle">Reseña</h2>
            <div class="containerResenna">
                <form action="{$this->action}" method="post">
                    <input type="hidden" name="formId" value="{$this->formId}" />
                    <input type="hidden" name="idProducto" id="idProducto" value="{$this->idProducto}" />
                    <textarea name="resenna" id="resenna" placeholder="Escribe tu reseña" cols="70" rows="10"></textarea>
                    <div class="rating">
                        <input type='radio' hidden name='rate' id='rating_5' value="5" data-idx='0'>	
                        <label for='rating_5'></label>
                    
                        <input type='radio' hidden name='rate' id='rating_4' value="4" data-idx='1'>
                        <label for='rating_4'></label>
                    
                        <input type='radio' hidden name='rate' id='rating_3' value="3" data-idx='2'>
                        <label for='rating_3'></label>
                
                        <input type='radio' hidden name='rate' id='rating_2' value="2" data-idx='3'>
                        <label for='rating_2'></label>
                    
                        <input type='radio' hidden name='rate' id='rating_1' value="1" data-idx='4'>
                        <label for='rating_1'></label>
                    </div>
                    <button class="resenna" type="submit">Enviar</button>
                </form>
            </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $resenna = trim($datos['resenna'] ?? '');
        $resenna = filter_var($resenna, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $rate = trim($datos['rate'] ?? 0);
        $rate = filter_var($rate, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        Comentario::introducirComentario($_SESSION['id'], $datos['idProducto'], $resenna, $rate);
    }
}
