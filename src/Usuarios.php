<?php

class Usuario{

    public static function buscaUsuario($nombreUsuario)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuarios U WHERE U.nombreUsuario='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['hashed_password'], $fila['mail'], $fila['nivel'], $fila['role'], $fila['nombre'], $fila['xp']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    private static function cargaRoles($usuario)
    {
        $roles=[];
            
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.rol FROM RolesUsuario RU WHERE RU.usuario=%d"
            , $usuario->id
        );
        $rs = $conn->query($query);
        if ($rs) {
            $roles = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            $usuario->roles = [];
            foreach($roles as $rol) {
                $usuario->roles[] = $rol['rol'];
            }
            return $usuario;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
    
    public static function login($nombreUsuario, $password)
    {
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return self::cargaRoles($usuario);
        }
        return false;
    }

    private $password;
    private $email;
    private $nivel;
    private $role;
    private $nombre;
    private $xp;

    public function __construct($password, $email, $nivel, $role, $nombre, $xp){
        $this->password = $password;
        $this->email = $email;
        $this->nivel = $nivel;
        $this->role = $role;
        $this->nombre = $nombre;
        $this->xp = $xp;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setNivel($nivel){
        $this->nivel = $nivel;
    }
    public function getNivel(){
        return $this->nivel;
    }
    public function setRole($role){
        $this->role = $role;
    }
    public function getRole(){
        return $this->role;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setXp($xp){
        $this->xp = $xp;
    }
    public function getXp(){
        return $this->xp;
    }

}