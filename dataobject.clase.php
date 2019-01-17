<?php
require_once "config.php";
// DataObject es una clase abstracta de la que se pueden derivar clases para gestionar el acceso a la BD y recuperar datos
abstract class DataObject {
protected $data = array(); //$data tabla protegida con datos

// Constructor de clase, se llama siempre que se crea un nuevo objeto basado en una clase que se deriva de esta clase
public function __construct($data) { 
    foreach ($data as $key => $value) {
        if (array_key_exists($key, $this->data)) $this->data[$key] = $value;
    }
}        
            
// Metodo que acepta un nombre de campo y lo busca en la tabla $data, si lo encuentra devuelve su valor, si no da error*/
public function getValue($field) {
            if (array_key_exists($field, $this->data)) {
                return $this->data[$field];
            } else {
                die("Campo no encontrado");
            }
}

// Metodo que permite que codigo exterior recupere un valor de campo que se ha pasado por medio de la funcion php htmlspecialchars, esta funcion codifica caracteres < y > como &lt; y &gt;
public function getValueEncoded($field) {
            return htmlspecialchars($this->getValue($field));
}

// PDO Objetos de datos de PHP, extension para abrir la conexion de BD
// Metodo para crear conexión PDO a la BD
protected function connect() {
            try { //Try Catch gestiona errores de MySQL
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
                $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
// Establecer atributo PDO::ATTR_PERSISTENT en true permite que php mantenga la conexión mysql abierta para reutilizarla por otras partes de la aplicacion, mejora rendimiento
                $conn->setAttribute(PDO::ATTR_PERSISTENT, true);
// Establecer PDO::ERRMODE en PDO::ERRMODE_EXCEPTION le dice a PDO que lance excepciones siempre que ocurra un error de BD         
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Conexión fallida: " . $e->getMessage());
            }
            return $conn;
}    
            
// Metodo que toma un objeto PDO almacenado en $conn, le asigna cadena vacia y lo destruye, cerrando conexion a BD
protected function disconnect($conn) {
            $conn = "";
        }

}
?>