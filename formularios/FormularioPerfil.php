<?php
class FormularioPerfil
{
    private $errores;
    private $urlRedireccion;
    private $action;
    private $formId;
    private $roles;

    public function __construct()
    {
        $this->errores = false;
        $this->urlRedireccion = "./";
        $this->action = htmlspecialchars($_SERVER['REQUEST_URI']);
        $this->formId = "formularioPerfil";
        $this->roles[0] = "Miembro esperando validación";
        $this->roles[1] = "Miembro";
        $this->roles[2] = "Miembro Verificado";
        $this->roles[3] = "Administrador";
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
        $rol = '';
        $validacion = '';
        $subirNivel = '';
        $span = '';
        $maxXp = Niveles::getMaxXp($_SESSION['nivel']);
        if (isset($_SESSION['role'])) {
            $rol = $this->roles[$_SESSION['role']];
            if ($_SESSION['role'] == 1) {
                $validacion = <<<EOS
                <form action="{$this->action}" method="post" id="validarForm">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <input type="hidden" name="validar" value="validar" />
                <button class="verificar" type="button" onclick="confirmarValidacion()">
                    VERIFICAR
                    <div id="clip">
                        <div id="leftTop" class="corner"></div>
                        <div id="rightBottom" class="corner"></div>
                        <div id="rightTop" class="corner"></div>
                        <div id="leftBottom" class="corner"></div>
                    </div>
                    <span id="rightArrow" class="arrow"></span>
                    <span id="leftArrow" class="arrow"></span>
                </button>
                </form>
                EOS;
                $span = '<span class="rol">Si quieres verificarte como vendedor de VirtualVenture aprieta el boton al final de la página</span>';
            }
        }

        if (isset($_SESSION['role'])) {
            if (($_SESSION['xp'] >= Niveles::getMaxXp($_SESSION['nivel'])) && ($_SESSION['nivel'] < Niveles::getMaxLevel())) {
                $subirNivel = <<<EOS
                    <form action="{$this->action}" method="post" id="levelUpForm">
                        <input type="hidden" name="levelUp" value="levelUp">
                        <input type="hidden" name="formId" value="formularioPerfil">
                        <button class="subirNivel" onclick="subidaNivel()">Level Up</button>
                    </form>
                EOS;
            }
        }
        $n = Niveles::getMaxLevel();
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        <div class="sesion">
            <h1>PERFIL</h1>
                
                {$error}
            <form action="{$this->action}" method="post" id="modificarForm">
                <input type="hidden" name="formId" value="{$this->formId}" />
                <label for="username">Usuario:</label>
                <input type="text" name="username" id="username" placeholder="{$_SESSION['username']}">
                <label for="mail">Correo electrónico:</label>
                <input type="text" name="mail" id="mail" placeholder="{$_SESSION['mail']}">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="Contraseña">
                <label for="rol">Rol: {$span}</label>
                <input type="rol" name="rol" id="rol" placeholder="{$rol}" readonly>
                <label for="fecha">Fecha de creación:</label>
                <input type="fecha" name="fecha" id="fecha" placeholder="{$_SESSION['fecha']}" readonly>
                <label for="nivel">Nivel:</label>
                <input type="nivel" name="nivel" id="nivel" placeholder="{$_SESSION['nivel']}/{$n}" readonly>
                <label for="xp">Experiencia:</label>
                <input type="xp" name="xp" id="xp" placeholder="{$_SESSION['xp']}/{$maxXp}" readonly>
                <label for="monedas">Monedas:</label>
                <input type="monedas" name="monedas" id="monedas" placeholder="{$_SESSION['monedas']}" readonly>
                <input type="button" class="submit" onclick="confirmarModificacion()" value="Modificar">
            </form>

            {$subirNivel}

            <form action="{$this->action}" method="post" id="deleteForm" >
                <input type="hidden" name="formId" value="{$this->formId}" />
                <input type="hidden" name="eliminar" value="eliminar" />
                <button class="delete" type="button" onclick="confirmarDelete()">
                <span class="button__text">Delete</span>
                <span class="button__icon"><svg class="svg" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><title></title><path d="M112,112l20,320c.95,18.49,14.4,32,32,32H348c17.67,0,30.87-13.51,32-32l20-320" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path><line style="stroke:#fff;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px" x1="80" x2="432" y1="112" y2="112"></line><path d="M192,112V72h0a23.93,23.93,0,0,1,24-24h80a23.93,23.93,0,0,1,24,24h0v40" style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path><line style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" x1="256" x2="256" y1="176" y2="400"></line><line style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" x1="184" x2="192" y1="176" y2="400"></line><line style="fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px" x1="328" x2="320" y1="176" y2="400"></line></svg></span>
                </button>
            </form>
            
           {$validacion}
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        if (isset($datos['eliminar'])) {
            Usuario::borrarUsuario($_SESSION['id']);
            header("Location: ./CerrarSesion.php");
            exit();
        } else if (isset($datos['levelUp'])) {
            if (Usuario::levelUp($_SESSION['id'])) {
                $_SESSION['xp'] -= Niveles::getMaxXp($_SESSION['nivel']);
                $_SESSION['nivel'] += 1;
            } 
        } else if (isset($datos['validar'])) {
            Usuario::esperaVerificarUsuario($_SESSION['id']);
            $_SESSION['role'] = 0;
        } else {
            $this->errores = false;
            $usuario = Usuario::getUsuarioPorId($_SESSION['id']);
            $username = trim($datos['username'] ?? '');
            $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($username && !empty($username)) {
                if($usuario->cambiaUsername($username)){
                    $_SESSION['username'] = $username;
                }
            }

            $mail = trim($datos['mail'] ?? '');
            $mail = filter_var($mail, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($mail && !empty($mail)) {
                if($usuario->cambiaMail($mail)){
                    $_SESSION['mail'] = $mail;
                }
            }

            $password = trim($datos['password'] ?? '');
            $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($mail && !empty($mail)) {
                $usuario->cambiaPassword($password);
                $_SESSION['password'] = $usuario->password;
            }
        }
    }
}
