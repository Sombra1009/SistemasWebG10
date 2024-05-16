<?php

class FormularioRegistro
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
        $this->formId = "formularioRegistro";
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
            $error = '<p class="error">Usuario existente</p>';
        }

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        <div class="sesion">
            <h1>CREAR CUENTA</h1>

            <p>Regístrese para acceder a sus claves, interactuar en el foro y poder comprar sus juegos favoritos</p>
                
                {$error}
            <form action="{$this->action}" method="post" id="{$this->formId}">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <label for="username">Usuario:</label>
                <input type="text" name="username" id="username" placeholder="Usuario" required>
                <label for="mail">Correo electrónico:</label>
                <input type="text" name="mail" id="mail" placeholder="Correo electrónico" required>
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="Contraseña" required>
                <p>¿Ya tienes cuenta? <a href="IniciarSesion.php">Inicia sesión</a></p>
                <input type="submit" value="Registrarse">
            </form>

            <p>Al crear una cuenta, aceptas nuestros <a href="img/servicio.pdf">Términos de servicio</a> y <a href="img/privacidad.pdf">Política de privacidad</a></p>
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

        $mail = trim($datos['mail'] ?? '');
        $mail = filter_var($mail, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$mail || empty($mail)) {
            $this->errores = true;
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$password || empty($password)) {
            $this->errores = true;
        }

        if (!$this->errores) {
            $usuario = Usuario::crearUsuario($username, $mail, $password);

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
