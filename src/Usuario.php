<?php

class Usuario{

    use MagicProperties;
    private static function actualiza($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("UPDATE users U SET username = '%s', nombre='%s', password='%s' WHERE U.id=%d"
            , $conn->real_escape_string($usuario->username)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $usuario->id
        );
        if ( $conn->query($query) ) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $result;
    }
    
    //---------------------------------------------------------------------------

    private function checkUsuario(){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT COUNT(*) FROM usuario U WHERE U.username='%s' OR U.mail='%s'", $conn->real_escape_string($this->username), $conn->real_escape_string($this->mail));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila['COUNT(*)'] == 0) {
                $result = true;
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function getUsuario($username)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.username='%s'", $conn->real_escape_string($username));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['id'], $fila['username'], $fila['mail'], $fila['password'], $fila['role'], $fila['created_at'], $fila['nivel'], $fila['xp'], $fila['monedas']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public static function crearUsuario($username, $mail, $password){
        $result = false;
        $user = new Usuario('', $username, $mail, self::hashPassword($password), 1, '', 1, '', '');
        if ($user->checkUsuario()){
            $result = $user->guardar();
            Orders::crearCarro($user->id);
        }
        return $result;
    }

    private function guardar(){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuario(username, mail, password, role, created_at, nivel, xp, monedas) VALUES ('%s', '%s', '%s', 1, NOW(), 1, 0, 0)"
            , $conn->real_escape_string($this->username)
            , $conn->real_escape_string($this->mail)
            , $conn->real_escape_string($this->password)
        );
        if ( $conn->query($query)) {
            $result = true;
            $this->id = $conn->insert_id;
            $this->fecha = $conn->query("SELECT NOW()");
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function login($username, $password)
    {
        $usuario = self::getUsuario($username);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }

    public function añadeMonedas($monedas){
        $this->monedas += $monedas;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET monedas = %d WHERE id = %d", $conn->real_escape_string($this->monedas), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);

        return $rs;
    }

    public function quitaMonedas($monedas){
        $this->monedas -= $monedas;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET monedas = %d WHERE id = %d", $conn->real_escape_string($this->monedas), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);

        return $rs;
    }

    public function añadeXp($xp){
        $this->xp += $xp;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT xpLevel FROM niveles WHERE nivel = %d", $conn->real_escape_string($this->nivel));
        $rs = $conn->query($query);

        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($this->xp >= $fila['xpLevel']) {
                if ($this->nivel < 5){
                    $this->nivel++;
                    $this->xp -= $fila['xpLevel'];
                }
                else {
                    $this->xp = $fila['xpLevel'];
                }
                
            }
            $query = sprintf("UPDATE usuario SET nivel = %d, xp = %d WHERE id = %d", $conn->real_escape_string($this->nivel), $conn->real_escape_string($this->xp), $conn->real_escape_string($this->id));
            $rs = $conn->query($query);
        }

        return $rs;
    }


    private $id;
    private $username;
    private $mail;
    private $password;
    private $role;
    private $fecha;
    private $nivel;
    private $xp;
    private $monedas;

    public function __construct($id, $username, $mail, $password, $role, $fecha, $nivel, $xp, $monedas){
        $this->id = $id;
        $this->username = $username;
        $this->mail = $mail;
        $this->password = $password;
        $this->role = $role;
        $this->fecha = $fecha;
        $this->nivel = $nivel;
        $this->xp = $xp;
        $this->monedas = $monedas;
    }
    
    public function getId(){
        return $this->id;
    }
    public function getUsername(){
        return $this->username;
    }       
    public function getMail(){
        return $this->mail;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getRole(){
        return $this->role;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getNivel(){
        return $this->nivel;
    }
    public function getXp(){
        return $this->xp;
    }
    public function getMonedas(){
        return $this->monedas;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setUsername($username){
        $this->username = $username;
    }
    public function setMail($mail){
        $this->mail = $mail;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function setRole($role){
        $this->role = $role;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }
    public function setNivel($nivel){
        $this->nivel = $nivel;
    }
    public function setXp($xp){
        $this->xp = $xp;
    }
    public function setMonedas($monedas){
        $this->monedas = $monedas;
    }

}