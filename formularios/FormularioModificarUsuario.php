<script src="sweetalert2.js"></script>
<script src="scripts.js"></script>
<?php
class FormularioModificarUsuario
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;
    private $usuario;

    public function __construct($usuario)
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "FormularioModificarProducto";
        $this->usuario = $usuario;
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
            $error = $this->errores;
        }
        $max = Niveles::getMaxLevel();

        $html = <<<EOF
        <div class="sesion">
            <h1>MODIFICAR USUARIO</h1>
                
            <h2 class="red">{$error}</h2>
            <form action="{$this->action}" method="post" id="modificarForm">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <label for="username">Nombre:</label>
                <input type="text" name="username" id="username" placeholder="{$this->usuario->username}">
                <label for="mail">Mail:</label>
                <input type="text" name="mail" id="mail" placeholder="{$this->usuario->mail}">
                <label for="password">Contraseña:</label>
                <input type="text" name="password" id="password">
                <label for="role">Role:</label>
                <input type="number" name="role" id="role" min='0' max='3' placeholder="{$this->usuario->role}">
                <label for="nivel">Nivel:</label>
                <input type="number" name="nivel" id="nivel" min='1' max='{$max}' placeholder="{$this->usuario->nivel}">
                <label for="xp">Experiencia:</label>
                <input type="number" name="xp" id="xp" placeholder="{$this->usuario->xp}">
                <label for="monedas">Monedas:</label>
                <input type="number" name="monedas" id="monedas" min="0" placeholder="{$this->usuario->monedas}">
                <input type="submit" class="submit" value="Modificar">
            </form>
        </div>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = "";

        $username = trim($datos['username'] ?? '');
        $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($username && !empty($username)) {
            $this->usuario->cambiaUsername($username);
        }

        $mail = trim($datos['mail'] ?? '');
        $mail = filter_var($mail, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($mail && !empty($mail)) {
            $this->usuario->cambiaMail($mail);
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($password && !empty($password)) {
            $this->usuario->cambiaPassword($password);
        }

        $role = trim($datos['role'] ?? '');
        $role = filter_var($role, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (($role && !empty($role)) || $role == 0) {
            $this->usuario->cambiaRole($role);
        }

        $nivel = trim($datos['nivel'] ?? '');
        $nivel = filter_var($nivel, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($nivel && !empty($nivel)) {
            $this->usuario->cambiaNivel($nivel);
        }

        $xp = trim($datos['xp'] ?? '');
        $xp = filter_var($xp, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (($xp && !empty($xp)) || $xp == 0) {
            $this->usuario->cambiaXp($xp);
        }

        $monedas = trim($datos['monedas'] ?? '');
        $monedas = filter_var($monedas, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (($monedas && !empty($monedas)) || $monedas == 0) {
            $this->usuario->cambiaMonedas($monedas);
        }

    }
}
