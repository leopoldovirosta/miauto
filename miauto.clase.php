<?php
require_once "dataobject.clase.php";

class MiAuto extends DataObject {
    protected $data = array(
        "id_vehiculo" => "",
        "alias" => "",
        "tipo" => "",
        "id_modelo" => "",
        "color" => "",
        "manufacturado" => "",
        "odometro" => "",
        "imagen" => "",
        "repostajes" => ""
    );
    
    private $_tipo = array (
        "automovil" => "Automovil",
        "comercial" => "Comercial",
        "motocicleta" => "Motocicleta",
        "quad" => "Quad"
    );
    
    public static function getAutos($inicioFila, $numFilas, $order) {
        $conn = parent::connect();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_VEHICULOS . " ORDER BY $order LIMIT :inicioFila, :numFilas";
        try {
            $st = $conn->prepare($sql);// Metodo prepare ejecuta consultas y devuelve objetos con los que trabajar
            $st->bindValue(":inicioFila", $inicioFila, PDO::PARAM_INT);//Metodo para comprobar que el valor del parametro es correcto, evita inyeccion sql, devuelve true o false
            $st->bindValue(":numFilas", $numFilas, PDO::PARAM_INT);
            $st->execute();// Metodo que ejecuta la consulta
            $autos = array();
            foreach ($st->fetchAll() as $fila) { // fetchAll devuelve la consulta como una tabla de tablas asociativas
                $autos[] = new MiAuto($fila); // cada objeto contiene los datos de la fila y se almacena en la tabla autos
            }
            $st = $conn->query("SELECT found_rows() AS totalFilas"); // calcula el total de filas
            $fila = $st->fetch(); // obtiene una unica fila del conjunto resultado como una tabla asociativa clave - valor
            parent::disconnect($conn);
            return array($autos, $fila["totalFilas"]);
            
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }

// Ver los vehiculos propiedad de cada alias    
    public static function getAutosAlias($alias, $inicioFila, $numFilas, $order) {
        $conn = parent::connect();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_VEHICULOS . " WHERE alias = '" . $alias ."' ORDER BY $order LIMIT :inicioFila, :numFilas";
        try {
            $st = $conn->prepare($sql);// Metodo prepare ejecuta consultas y devuelve objetos con los que trabajar
            $st->bindValue(":inicioFila", $inicioFila, PDO::PARAM_INT);//Metodo para comprobar que el valor del parametro es correcto, evita inyeccion sql, devuelve true o false
            $st->bindValue(":numFilas", $numFilas, PDO::PARAM_INT);
            $st->execute();// Metodo que ejecuta la consulta
            $autos = array();
            foreach ($st->fetchAll() as $fila) { // fetchAll devuelve la consulta como una tabla de tablas asociativas
                $autos[] = new MiAuto($fila); // cada objeto contiene los datos de la fila y se almacena en la tabla autos
            }
            $st = $conn->query("SELECT found_rows() AS totalFilas"); // calcula el total de filas
            $fila = $st->fetch(); // obtiene una unica fila del conjunto resultado como una tabla asociativa clave - valor
            parent::disconnect($conn);
            return array($autos, $fila["totalFilas"]);
            
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }    
    
// Metodo para recuperar un registro por el id
    public static function getAuto($id_vehiculo) {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_VEHICULOS . " WHERE id_vehiculo = :id_vehiculo";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_vehiculo", $id_vehiculo, PDO::PARAM_STR);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return new MiAuto($fila);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
// Metodo para recuperar el id_vehiculo y el id_modelo por el alias
    public static function getVehiculoModelo($alias) {
        $conn = parent::connect();
        $sql = "SELECT id_vehiculo, id_modelo FROM " . TBL_VEHICULOS . " WHERE alias = '" . $alias. "'";
    
        try {
            $st = $conn->prepare($sql);
            $st->execute();
            $modelos = array();
            foreach ($st->fetchAll() as $fila) {
                $modelos[] = new MiAuto($fila);
            }
            parent::disconnect($conn);
            return $modelos;
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
        
    public function getTipo() {
        return $this->_tipo;
    }
    
// Metodo para recuperar el id_vehiculo del último insertado
    public static function getVehiculoUltimo() {
        $conn = parent::connect();
        $sql = "SELECT id_vehiculo FROM " . TBL_VEHICULOS . " ORDER BY id_vehiculo DESC LIMIT 1";
    
        try {
            $st = $conn->prepare($sql);
            $st->execute();
            $modelos = array();
            foreach ($st->fetchAll() as $fila) {
                $modelos[] = new MiAuto($fila);
            }
            parent::disconnect($conn);
            return $modelos;
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }

//Metodo para comprobar que un usuario tiene vehiculos, en ese caso no se puede borrar
    public function userVehiculos($alias) {
        $conn = parent::connect();
        $sql = "SELECT count(*) as totalFilas FROM " . TBL_VEHICULOS . " WHERE alias = '" . $alias ."'";
        
        try {
            $st = $conn->query($sql);
            $fila = $st->fetch();
            parent::disconnect($conn);
            return $fila["totalFilas"];
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
//Metodo para comprobar que un modelo tiene vehiculos asignados, en ese caso no se puede borrar
    public function userModelos($id_modelo) {
        $conn = parent::connect();
        $sql = "SELECT count(*) as totalFilas FROM " . TBL_VEHICULOS . " WHERE id_modelo = " . $id_modelo;
        
        try {
            $st = $conn->query($sql);
            $fila = $st->fetch();
            parent::disconnect($conn);
            return $fila["totalFilas"];
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }  
    
//Metodo para añadir un auto nuevo a un usuario
    public function insert() {
        $conn = parent::connect();
        $sql = "INSERT INTO " . TBL_VEHICULOS . " (alias, tipo, id_modelo, color, manufacturado, odometro, imagen) VALUES (:alias, :tipo, :id_modelo, :color, :manufacturado, :odometro, :imagen)";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $this->data["alias"], PDO::PARAM_STR);
            $st->bindValue(":tipo", $this->data["tipo"], PDO::PARAM_STR);
            $st->bindValue(":id_modelo", $this->data["id_modelo"], PDO::PARAM_INT);
            $st->bindValue(":color", $this->data["color"], PDO::PARAM_STR);
            $st->bindValue(":manufacturado", $this->data["manufacturado"], PDO::PARAM_STR);
            $st->bindValue(":odometro", $this->data["odometro"], PDO::PARAM_INT);
            $st->bindValue(":imagen", $this->data["imagen"], PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
        
//Metodo para actualizar un usuario
    public function update() {
        $conn = parent::connect();
        $sql = "UPDATE " . TBL_VEHICULOS . " SET tipo = :tipo, id_modelo = :id_modelo, color = :color, manufacturado = :manufacturado, imagen = :imagen WHERE id_vehiculo = :id_vehiculo";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":tipo", $this->data["tipo"], PDO::PARAM_STR);
            $st->bindValue(":id_modelo", $this->data["id_modelo"], PDO::PARAM_INT);
            $st->bindValue(":color", $this->data["color"], PDO::PARAM_STR);
            $st->bindValue(":manufacturado", $this->data["manufacturado"], PDO::PARAM_STR);
            $st->bindValue(":imagen", $this->data["imagen"], PDO::PARAM_STR);
            $st->bindValue(":id_vehiculo", $this->data["id_vehiculo"], PDO::PARAM_INT);
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
        $sql = "DELETE FROM " . TBL_VEHICULOS . " WHERE id_vehiculo = :id_vehiculo";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_vehiculo", $this->data["id_vehiculo"], PDO::PARAM_INT);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }   
        
    
}
?>