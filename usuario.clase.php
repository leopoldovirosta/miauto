<?php
require_once "dataobject.clase.php";

class Usuario extends DataObject {
    protected $data = array(
        "alias" => "",
        "clave" => "",
        "antiguedad" => "",
        "nombre" => "",
        "apellidos" => "",
        "direccion" => "",
        "cp" => "",
        "localidad" => "",
        "email" => "",
        "telefono" => "",
        "web" => "",
        "sexo" =>"",
        "admin"=>"");
    
// Los metodos estaticos no necesitan funcionar con objetos de la clase, recupera una lista de usuarios ordenador por $order y comenzando por $inicioFila
    public static function getUsuarios($inicioFila, $numFilas, $order) {
        $conn = parent::connect();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_USUARIOS . " ORDER BY $order LIMIT :inicioFila, :numFilas";
        try {
            $st = $conn->prepare($sql);// Metodo prepare ejecuta consultas y devuelve objetos con los que trabajar
            $st->bindValue(":inicioFila", $inicioFila, PDO::PARAM_INT);//Metodo para comprobar que el valor del parametro es correcto, evita inyeccion sql, devuelve true o false
            $st->bindValue(":numFilas", $numFilas, PDO::PARAM_INT);
            $st->execute();// Metodo que ejecuta la consulta
            $usuarios = array();
            foreach ($st->fetchAll() as $fila) { // fetchAll devuelve la consulta como una tabla de tablas asociativas
                $usuarios[] = new Usuario($fila); // cada objeto contiene los datos de la fila y se almacena en la tabla usuarios
            }
            $st = $conn->query("SELECT found_rows() AS totalFilas"); // calcula el total de filas
            $fila = $st->fetch(); // obtiene una unica fila del conjunto resultado como una tabla asociativa clave - valor
            parent::disconnect($conn);
            return array($usuarios, $fila["totalFilas"]);
            
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
// Metodo para recuperar un registro por el alias
    public static function getUsuario($alias) {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_USUARIOS . " WHERE alias = :alias";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $alias, PDO::PARAM_STR);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return new Usuario($fila);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
    public function getSexo() {
        return ($this->data["sexo"] == "F") ? "Femenino" : "Masculino";
    }

// Metodo para comprobar que no se introduce un usuario con un alias que ya existe
    public static function getByAlias($alias) {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_USUARIOS . " WHERE alias = :alias";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $alias, PDO::PARAM_STR);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return new Usuario($fila);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
// Metodo para recuperar usuario por su email
    public static function getByEmail($email) {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_USUARIOS . " WHERE email = :email";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":email", $email, PDO::PARAM_STR);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return new Usuario($fila);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
//Metodo para añadir un usuario nuevo
    public function insert() {
        $conn = parent::connect();
        $sql = "INSERT INTO " . TBL_USUARIOS . " (alias, clave, nombre, apellidos, direccion, cp, localidad, email, telefono, web, sexo) VALUES (:alias, password(:clave), :nombre, :apellidos, :direccion, :cp, :localidad, :email, :telefono, :web, :sexo)";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $this->data["alias"], PDO::PARAM_STR);
            $st->bindValue(":clave", $this->data["clave"], PDO::PARAM_STR);
            $st->bindValue(":nombre", $this->data["nombre"], PDO::PARAM_STR);
            $st->bindValue(":apellidos", $this->data["apellidos"], PDO::PARAM_STR);
            $st->bindValue(":direccion", $this->data["direccion"], PDO::PARAM_STR);
            $st->bindValue(":cp", $this->data["cp"], PDO::PARAM_STR);
            $st->bindValue(":localidad", $this->data["localidad"], PDO::PARAM_STR);
            $st->bindValue(":email", $this->data["alias"], PDO::PARAM_STR);
            $st->bindValue(":telefono", $this->data["telefono"], PDO::PARAM_STR);
            $st->bindValue(":web", $this->data["web"], PDO::PARAM_STR);
            $st->bindValue(":sexo", $this->data["sexo"], PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
// Metodo para autenticarse y verificar que el usuario existe
    public function logarse() {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_USUARIOS . " WHERE alias = :alias AND clave = password(:clave)";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $this->data["alias"], PDO::PARAM_STR);
            $st->bindValue(":clave", $this->data["clave"], PDO::PARAM_STR);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return new Usuario($fila);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
        
//Metodo para actualizar un usuario
    public function update() {
        $conn = parent::connect();
        $sql = "UPDATE " . TBL_USUARIOS . " SET nombre = :nombre, apellidos = :apellidos, direccion = :direccion, cp = :cp, localidad = :localidad, email = :email, telefono = :telefono, web = :web, sexo = :sexo WHERE alias = :alias";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $this->data["alias"], PDO::PARAM_STR);
            $st->bindValue(":nombre", $this->data["nombre"], PDO::PARAM_STR);
            $st->bindValue(":apellidos", $this->data["apellidos"], PDO::PARAM_STR);
            $st->bindValue(":direccion", $this->data["direccion"], PDO::PARAM_STR);
            $st->bindValue(":cp", $this->data["cp"], PDO::PARAM_STR);
            $st->bindValue(":localidad", $this->data["localidad"], PDO::PARAM_STR);
            $st->bindValue(":email", $this->data["email"], PDO::PARAM_STR);
            $st->bindValue(":telefono", $this->data["telefono"], PDO::PARAM_STR);
            $st->bindValue(":web", $this->data["web"], PDO::PARAM_STR);
            $st->bindValue(":sexo", $this->data["sexo"], PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }

//Metodo para borrar un usuario
    public function borrar() {
        $conn = parent::connect();
        $sql = "DELETE FROM " . TBL_USUARIOS . " WHERE alias = :alias";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $this->data["alias"], PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }   
    
}
?>