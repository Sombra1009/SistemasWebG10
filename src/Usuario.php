<?php
class Usuario{

    use MagicProperties;
    public static function actualiza($username, $mail, $password)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        if($password == ''){
            $query=sprintf("UPDATE usuario U SET username = '%s', mail='%s' WHERE U.id=%d"
            , $conn->real_escape_string($username)
            , $conn->real_escape_string($mail)
            , $_SESSION['id']
        );
        }else{
            $query=sprintf("UPDATE usuario U SET username = '%s', mail='%s', password='%s' WHERE U.id=%d"
            , $conn->real_escape_string($username)
            , $conn->real_escape_string($mail)
            , $conn->real_escape_string(self::hashPassword($password))
            , $_SESSION['id']
        );
        }
        
        if ( $conn->query($query) ) {
            $result = self::getUsuario($username);
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
    private function checkUsername($username){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT COUNT(*) FROM usuario U WHERE U.username='%s'", $conn->real_escape_string($username));
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
    private function checkMail($mail){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT COUNT(*) FROM usuario U WHERE U.mail='%s'", $conn->real_escape_string($mail));
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

    public static function levelUp($id){
        $usuario = false;
        $usuario = self::getUsuarioPorId($id);
        $usuario->cambiaXp($usuario->xp - Niveles::getMaxXp($usuario->nivel));
        $usuario->cambiaNivel($usuario->nivel + 1);
        $usuario->annadeMonedas(100);
        
        return $usuario;
    }

    public static function getHeaders(){
        $result = [];
        $result[] = 'ID';
        $result[] = 'Username';
        $result[] = 'Mail';
        $result[] = 'Role';
        $result[] = 'Fecha';
        $result[] = 'Nivel';
        $result[] = 'XP';
        $result[] = 'Monedas';
        $result[] = 'Verificar';

        return $result;
    }

    public function escribirTabla(){
        $tabla = <<<EOS
        <td> $this->id </td>
        <td> $this->username </td>
        <td> $this->mail </td>
        <td> $this->role </td>
        <td> $this->fecha </td>
        <td> $this->nivel </td>
        <td> $this->xp </td>
        <td> $this->monedas </td>
        EOS;
        if ($this->role == 0){
            $tabla .= <<<EOS
            <td>
                <form action="src/verificar.php" method="post">
                    <input type="hidden" name="id" value="$this->id">
                    <input class="add" type="submit" value="Verificar">
                </form>
            </td>
            EOS;
        }
        else{
            $tabla .= <<<EOS
            <td>
            </td>
            EOS;
        }

        $tabla .= <<<EOS
            <td> <a class="modify" href="ModificarUsuario.php?id={$this->id}"><img src="img/modificar.png" alt="Boton para modificar"></a> </td>
        EOS;
        return $tabla;
    }

    public static function getAllUsuarios(){
        $conn = BD::getInstance()->getConexionBd();
        $query = "SELECT * FROM usuario";
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Usuario($fila['id'], $fila['username'], $fila['mail'], $fila['password'], $fila['salt'], $fila['role'], $fila['created_at'], $fila['nivel'], $fila['xp'], $fila['monedas']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function borrarUsuario($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM usuario WHERE id=%d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        return $rs;
    }
    
    public static function esperaVerificarUsuario($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET role = 0 WHERE id=%d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        return $rs;
    }

    public static function verificarUsuario($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET role = 2 WHERE id=%d", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        return $rs;
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
                $result = new Usuario($fila['id'], $fila['username'], $fila['mail'], $fila['password'], $fila['salt'], $fila['role'], $fila['created_at'], $fila['nivel'], $fila['xp'], $fila['monedas']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    public static function getUsuarioPorId($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuario U WHERE U.id='%s'", $conn->real_escape_string($id));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['id'], $fila['username'], $fila['mail'], $fila['password'], $fila['salt'], $fila['role'], $fila['created_at'], $fila['nivel'], $fila['xp'], $fila['monedas']);
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
        $conn = BD::getInstance()->getConexionBd();
        $salt = $conn->real_escape_string(bin2hex(random_bytes(16)));
        $user = new Usuario('', $username, $mail, self::hashPassword($salt.$password), $salt, 1, '', 1, '', '');
        if ($user->checkUsuario()){
            if($user->guardar()){
                Orders::crearCarro($user->id);
                $result = self::getUsuario($username);
            }
            
        }
        return $result;
    }

    private function guardar(){
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuario(username, mail, password, salt, role, created_at, nivel, xp, monedas) VALUES ('%s', '%s', '%s', '%s', 1, NOW(), 1, 0, 0)"
            , $conn->real_escape_string($this->username)
            , $conn->real_escape_string($this->mail)
            , $conn->real_escape_string($this->password)
            , $conn->real_escape_string($this->salt)
        );
        if ( $conn->query($query)) {
            $result = true;
            $this->id = $conn->insert_id;
            $this->role = 1;
            $this->fecha = $conn->query("SELECT NOW()");
            $this->nivel = 1;
            $this->xp = 0;
            $this->monedas = 0;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function login($username, $password)
    {
        $usuario = self::getUsuario($username);
        if ($usuario && $usuario->compruebaPassword($usuario->getSalt().$password)) {
            return $usuario;
        }
        return false;
    }

    public function annadeMonedas($monedas){
        $this->monedas += $monedas;
        $conn = BD::getInstance()->getConexionBd();

        $conn->begin_transaction();
        $query = sprintf("UPDATE usuario SET monedas = %d WHERE id = %d", $conn->real_escape_string($this->monedas), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        $query = sprintf("INSERT historialMonedero (idUsuario,monedas,estado,fecha) VALUES (%d,%d,%d,NOW())", $conn->real_escape_string($this->id), $conn->real_escape_string($monedas), self::GANA_MONEDAS);
        $rs = $rs && $conn->query($query);

        if ($rs) {
            $conn->commit();
        } else {
            $conn->rollback();
        }

        return $rs;
    }

    public function quitaMonedas($monedas){
        $this->monedas -= $monedas;
        $conn = BD::getInstance()->getConexionBd();

        $conn->begin_transaction();

        $query = sprintf("UPDATE usuario SET monedas = %d WHERE id = %d", $conn->real_escape_string($this->monedas), $conn->real_escape_string($this->id));
        $rs = $conn->query($query);
        $query = sprintf("INSERT historialMonedero (idUsuario,monedas,estado,fecha) VALUES (%d,%d,%d,NOW())", $conn->real_escape_string($this->id), $conn->real_escape_string($monedas), self::PIERDE_MONEDAS);
        $rs = $rs && $conn->query($query);

        if ($rs) {
            $conn->commit();
        } else {
            $conn->rollback();
        }


        return $rs;
    }

    public function annadeXp($xp){
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

    public function cambiaUsername($username){
        if(!$this->checkUsername($username)){
            return false;
        }
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET username='%s' WHERE id=%d", $conn->real_escape_string($username), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
            $this->username = $username;
        }
        return $result;
    }

    public function cambiaMail($mail){
        if(!$this->checkMail($mail)){
            return false;
        }
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET mail='%s' WHERE id=%d", $conn->real_escape_string($mail), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
            $this->mail = $mail;
        }
        return $result;
    }

    public function cambiaPassword($password){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET password='%s' WHERE id=%d", $conn->real_escape_string(Self::hashPassword($this->getSalt().$password)), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
            $this->password = Self::hashPassword($this->getSalt().$password);
        }
        return $result;
    }

    public function cambiaRole($role){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET role=%d WHERE id=%d", $conn->real_escape_string($role), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
            $this->role = $role;
        }
        return $result;
    }

    public function cambiaNivel($nivel){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET nivel=%d WHERE id=%d", $conn->real_escape_string($nivel), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
            $this->nivel = $nivel;
        }
        return $result;
    }

    public function cambiaXp($xp){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET xp=%d WHERE id=%d", $conn->real_escape_string($xp), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
            $this->xp = $xp;
        }
        return $result;
    }

    public function cambiaMonedas($monedas){
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuario SET monedas=%d WHERE id=%d", $conn->real_escape_string($monedas), $conn->real_escape_string($this->id));
        $result = $conn->query($query);
        if (!$result) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        else{
            $this->monedas = $monedas;
        }
        return $result;
    }

    public const GANA_MONEDAS = 1;
    public const PIERDE_MONEDAS = 0;

    private $id;
    private $username;
    private $mail;
    private $password;
    private $role;
    private $fecha;
    private $nivel;
    private $xp;
    private $monedas;
    private $salt;

    public function __construct($id, $username, $mail, $password, $salt, $role, $fecha, $nivel, $xp, $monedas){
        $this->id = $id;
        $this->username = $username;
        $this->mail = $mail;
        $this->password = $password;
        $this->salt = $salt;
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

    public function getSalt(){
        return $this->salt;
    }
    public function setSalt($salt){
        $this->salt = $salt;
    }

}