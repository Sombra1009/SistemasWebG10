<?php
class FormularioLogin
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
        $this->formId = "formularioLogin";
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
        $error = '';
        if ($this->errores) {
            $error = '<p class="error">Usuario o contraseña incorrectos</p>';
        }

        $html = <<<EOF
        <div class="sesion">
            <h1>Inicio de sesión</h1>
            
            {$error}

            <form action="{$this->action}" method="post" id="{$this->formId}">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <label for="username">Usuario:</label>
                <input type="text" name="username" id="username" placeholder="Usuario">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="Password">
                <p>¿No tienes cuenta? <a href="registro.php">Crear cuenta</a></p>
                <input type="submit" value="Login">
            </form>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = false;
        $username = trim($datos['username'] ?? '');
        $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$username || empty($username)) {
            $this->errores = true;
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$password || empty($password)) {
            $this->errores = true;
        }

        if (!$this->errores) {
            $usuario = Usuario::login($username, $password);
            if (!$usuario) {
                $this->errores = true;
            } else {
                $_SESSION['id'] = $usuario->id;
                $_SESSION['username'] = $usuario->username;
                $_SESSION['mail'] = $usuario->mail;
                $_SESSION['password'] = $usuario->password;
                $_SESSION['role'] = $usuario->role;
                $_SESSION['fecha'] = $usuario->fecha;
                $_SESSION['nivel'] = $usuario->nivel;
                $_SESSION['xp'] = $usuario->xp;
                $_SESSION['monedas'] = $usuario->monedas;
            }
        }
    }
}
