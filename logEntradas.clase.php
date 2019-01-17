<?php
require_once "dataobject.clase.php";

class LogEntradas extends DataObject {
    
    protected $data = array (
        "alias" => "",
        "pagURL" => "",
        "numVisitas" => "",
        "ultAcceso" => "");
    
    public static function getLogEntradas($alias) {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_ENTRADAS . " WHERE alias = :alias ORDER BY ultAcceso DESC";
       
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $alias, PDO::PARAM_STR);
            $st->execute();
            $logEntra = array();
            foreach ($st->fetchAll() as $row) {
                $logEntra[] = new LogEntradas($row);
            }
            parent::disconnect($conn);
            return $logEntra;
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexion fallida: " . $e->getMessage());
        }
    }
 
// Toma el alias y la URL y la contabiliza
    public function grabar() {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_ENTRADAS . " WHERE alias = :alias AND pagURL = :pagURL";
       
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $this->data["alias"], PDO::PARAM_STR);
            $st->bindValue(":pagURL", $this->data["pagURL"], PDO::PARAM_STR);
            $st->execute();
            if ($st->fetch() ) {
                $sql = "UPDATE " . TBL_ENTRADAS . " SET numVisitas = numVisitas + 1 WHERE alias = :alias AND pagURL = :pagURL";
                $st = $conn->prepare($sql);
                $st->bindValue(":alias", $this->data["alias"], PDO::PARAM_STR);
                $st->bindValue(":pagURL", $this->data["pagURL"], PDO::PARAM_STR);
                $st->execute();
            } else {
                $sql = "INSERT INTO " . TBL_ENTRADAS . " (alias, pagURL, numVisitas) VALUES (:alias, :pagURL, 1)";
                $st = $conn->prepare($sql);
                $st->bindValue(":alias", $this->data["alias"], PDO::PARAM_STR);
                $st->bindValue(":pagURL", $this->data["pagURL"], PDO::PARAM_STR);
                $st->execute();
            }
            
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexi0n fallida: " . $e->getMessage());
        }
    }
    
// Borrar todas las entradas de un usuario que se da de baja
    public function borrarDeUsuarios($alias) {
        $conn = parent::connect();
        $sql = "DELETE FROM " . TBL_ENTRADAS . " WHERE alias = :alias";
       
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":alias", $alias, PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexion fallida: " . $e->getMessage());
        }
    }
        
}
?>