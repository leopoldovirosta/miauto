<?php
require_once "dataobject.clase.php";

class Repostaje extends DataObject {
    protected $data = array(
        "id_repostaje" => "",
        "id_vehiculo" => "",
        "fecha" => "",
        "odometro" => "",
        "odometro_final" => "",
        "combustible" => "",
        "cantidad" => "",
        "precio_total" => "",
        "precio_litro" => "",
        "observaciones" => "",
        "estacion" => "",
        "consumo" => ""
    );
    
     private $_combustible = array (
        "Diesel" => "Diesel",
        "Gasolina 95" => "Gasolina 95",
        "Gasolina 98" => "Gasolina 98"
    );
    
    public static function getRepos($inicioFila, $numFilas, $order) {
        $conn = parent::connect();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_REPOSTAJES . " ORDER BY $order LIMIT :inicioFila, :numFilas";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":inicioFila", $inicioFila, PDO::PARAM_INT);
            $st->bindValue(":numFilas", $numFilas, PDO::PARAM_INT);
            $st->execute();
            $autos = array();
            foreach ($st->fetchAll() as $fila) { // fetchAll devuelve la consulta como una tabla de tablas asociativas
                $repos[] = new Repostaje($fila); 
            }
            $st = $conn->query("SELECT found_rows() AS totalFilas"); // calcula el total de filas
            $fila = $st->fetch(); // obtiene una unica fila del conjunto resultado como una tabla asociativa clave - valor
            parent::disconnect($conn);
            return array($repos, $fila["totalFilas"]);
            
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
    public static function getReposIndex() {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_REPOSTAJES . " ORDER BY id_repostaje DESC LIMIT 9";
        try {
            $st = $conn->prepare($sql);
            $st->execute();
            $autos = array();
            foreach ($st->fetchAll() as $fila) { // fetchAll devuelve la consulta como una tabla de tablas asociativas
                $repos[] = new Repostaje($fila); 
            }
            parent::disconnect($conn);
            return array($repos);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    

// Ver repostajes por el id_vehiculo    
    public static function getReposVehiculo($id_vehiculo, $inicioFila, $numFilas, $order) {
        $conn = parent::connect();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_REPOSTAJES . " WHERE id_vehiculo = :id_vehiculo ORDER BY $order LIMIT :inicioFila , :numFilas";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_vehiculo", $id_vehiculo, PDO::PARAM_INT);
            $st->bindValue(":inicioFila", $inicioFila, PDO::PARAM_INT);
            $st->bindValue(":numFilas", $numFilas, PDO::PARAM_INT);
            $st->execute();
            $autos = array();
            foreach ($st->fetchAll() as $fila) { // fetchAll devuelve la consulta como una tabla de tablas asociativas
                $repos[] = new Repostaje($fila); 
            }
            $st = $conn->query("SELECT found_rows() AS totalFilas"); // calcula el total de filas
            $fila = $st->fetch(); // obtiene una unica fila del conjunto resultado como una tabla asociativa clave - valor
            parent::disconnect($conn);
            return array($repos, $fila["totalFilas"]);
            
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
// Metodo para recuperar un registro por el id_repostaje
    public static function getRepo($id_repostaje) {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_REPOSTAJES . " WHERE id_repostaje = :id_repostaje"; 
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_repostaje", $id_repostaje, PDO::PARAM_INT);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return new Repostaje($fila);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
// Metodo para recuperar el odometro del ultimo repostaje
    public static function getUltimo($id_vehiculo) {
        $conn = parent::connect();
        $sql = "SELECT odometro_final FROM " . TBL_REPOSTAJES . " WHERE id_vehiculo = :id_vehiculo ORDER BY id_repostaje DESC LIMIT 1";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_vehiculo", $id_vehiculo, PDO::PARAM_INT);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return $fila[0];
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
    public function getCombustible() {
        return $this->_combustible;
    }
    
//Metodo para añadir un nuevo repostaje
    public function insert() {
        $conn = parent::connect();
        $sql = "INSERT INTO " . TBL_REPOSTAJES . " (id_vehiculo, fecha, odometro, odometro_final, combustible, cantidad, precio_total, precio_litro, observaciones, estacion, consumo) VALUES (:id_vehiculo, :fecha, :odometro, :odometro_final, :combustible, :cantidad, :precio_total, :precio_litro, :observaciones, :estacion, :consumo)";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_vehiculo", $this->data["id_vehiculo"], PDO::PARAM_INT);
            $st->bindValue(":fecha", $this->data["fecha"], PDO::PARAM_STR);
            $st->bindValue(":odometro", $this->data["odometro"], PDO::PARAM_INT);
            $st->bindValue(":odometro_final", $this->data["odometro_final"], PDO::PARAM_INT);
            $st->bindValue(":combustible", $this->data["combustible"], PDO::PARAM_STR);
            $st->bindValue(":cantidad", $this->data["cantidad"], PDO::PARAM_STR);
            $st->bindValue(":precio_total", $this->data["precio_total"], PDO::PARAM_STR);
            $st->bindValue(":precio_litro", $this->data["precio_litro"], PDO::PARAM_STR);
            $st->bindValue(":observaciones", $this->data["observaciones"], PDO::PARAM_STR);
            $st->bindValue(":estacion", $this->data["estacion"], PDO::PARAM_STR);
            $st->bindValue(":consumo", $this->data["consumo"], PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }

//Metodo para actualizar un repostaje
    public function update() {
        $conn = parent::connect();
        $sql = "UPDATE " . TBL_REPOSTAJES . " SET fecha = :fecha, odometro = :odometro, odometro_final = :odometro_final, combustible = :combustible, cantidad = :cantidad, precio_total = :precio_total, precio_litro = :precio_litro, observaciones = :observaciones, estacion = :estacion, consumo = :consumo  WHERE id_repostaje = :id_repostaje";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_repostaje", $this->data["id_repostaje"], PDO::PARAM_INT);
            $st->bindValue(":fecha", $this->data["fecha"], PDO::PARAM_STR);
            $st->bindValue(":odometro", $this->data["odometro"], PDO::PARAM_INT);
            $st->bindValue(":odometro_final", $this->data["odometro_final"], PDO::PARAM_INT);
            $st->bindValue(":combustible", $this->data["combustible"], PDO::PARAM_STR);
            $st->bindValue(":cantidad", $this->data["cantidad"], PDO::PARAM_STR);
            $st->bindValue(":precio_total", $this->data["precio_total"], PDO::PARAM_STR);
            $st->bindValue(":precio_litro", $this->data["precio_litro"], PDO::PARAM_STR);
            $st->bindValue(":observaciones", $this->data["observaciones"], PDO::PARAM_STR);
            $st->bindValue(":estacion", $this->data["estacion"], PDO::PARAM_STR);
            $st->bindValue(":consumo", $this->data["consumo"], PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }

//Metodo para borrar un repostaje
    public function borrar() {
        $conn = parent::connect();
        $sql = "DELETE FROM " . TBL_REPOSTAJES . " WHERE id_repostaje = :id_repostaje";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_repostaje", $this->data["id_repostaje"], PDO::PARAM_INT);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }   

//Metodo para comprobar que un vehiculo tiene repostajes, en ese caso no se puede borrar
    public function reposExiste($id_vehiculo) {
        $conn = parent::connect();
        $sql = "SELECT count(*) as totalFilas FROM " . TBL_REPOSTAJES . " WHERE id_vehiculo = " . $id_vehiculo;
        
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
    
}
?>