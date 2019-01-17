<?php
require_once "dataobject.clase.php";

class Modelo extends DataObject {
    protected $data = array(
        "id_modelo" => "",
        "fabricante" => "",
        "nombre_modelo" => "",
        "motorizacion" => "",
        "combustible" => "",
        "potencia" => "",
        "consumo_extraurbano" => "",
        "consumo_mixto" => "",
        "consumo_urbano" => "",
        "emision_co2" => "",
        "deposito" => "",
        "cilindrada" => "",
        "velocidades" => "",
        "cambio" => "",
        "imagen" =>""
    );
    
    private $_marca = array(
        "aba"=>"Abarth","alf"=>"Alfa Romeo","asi"=>"Asia Motors","ast"=>"Aston Martin","aud"=>"Audi","aut"=>"Autobianchi","ben"=>"Bentley","bmw"=>"BMW","bug"=>"Bugatti","bui"=>"Buick","cad"=>"Cadillac", "che"=>"Chevrolet","chr"=>"Chrysler","cit"=>"Citroen","cor"=>"Corvette","dac"=>"Dacia","dae"=>"Daewo","dai"=>"Daihatsu", "dod"=>"Dodge","fer"=>"Ferrari","fia"=>"Fiat","for"=>"Ford","hon"=>"Honda","hyu"=>"Hyundai","inf"=>"Infiniti","inn"=>"Innocenti","jag"=>"Jaguar","jee"=>"Jeep","kia"=>"Kia","lad"=>"Lada","lam"=>"Lamborghini","lan"=>"Lancia","lar"=>"Land Rover","lex"=>"Lexus","lin"=>"Lincoln","lot"=>"Lotus","mas"=>"Maserati","maz"=>"Mazda","mer"=>"Mercedes Benz","mg"=>"MG","min"=>"Mini","mit"=>"Mitsubishi","mor"=>"Morgan","mor"=>"Morris","nis"=>"Nissan","ope"=>"Opel","peu"=>"Peugeot","pon"=>"Pontiac","por"=>"Porsche","ren"=>"Renault","rol"=>"Roll-Royce","rov"=>"Rover","saa"=>"Saab","sea"=>"Seat","sko"=>"Skoda","sma"=>"Smart","ssa"=>"SsangYong","sub"=>"Subaru","suz"=>"Suzuki","tal"=>"Talbot","tes"=>"Tesla","toy"=>"Toyota","tri"=>"Triumph","vok"=>"Volkswagen","vol"=>"Volvo","yug"=>"Yugo"
    );
    
    private $_combustible = array (
        "Diesel" => "Diesel",
        "Gasolina" => "Gasolina",
        "Hibrido" => "Hibrido"
    );
    
    private $_cambio = array (
        "Automatico" => "Automatico",
        "Manual" => "Manual",
    );
    
    public static function getModelos($inicioFila, $numFilas, $order) {
        $conn = parent::connect();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MODELOS . " ORDER BY $order LIMIT :inicioFila, :numFilas";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":inicioFila", $inicioFila, PDO::PARAM_INT);
            $st->bindValue(":numFilas", $numFilas, PDO::PARAM_INT);
            $st->execute();
            $modelos = array();
            foreach ($st->fetchAll() as $fila) {
                $modelos[] = new Modelo($fila);
            }
            $st = $conn->query("SELECT found_rows() AS totalFilas"); // calcula el total de filas
            $fila = $st->fetch(); // obtiene una unica fila del conjunto resultado como una tabla asociativa clave - valor
            parent::disconnect($conn);
            return array($modelos, $fila["totalFilas"]);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
public static function getModelosIndex() {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_MODELOS . " ORDER BY id_modelo DESC LIMIT 9";
        try {
            $st = $conn->prepare($sql);
            $st->execute();
            $modelos = array();
            foreach ($st->fetchAll() as $fila) {
                $modelos[] = new Modelo($fila);
            }
            parent::disconnect($conn);
            return array($modelos);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }    

// Metodo para recuperar todos los registros
    public static function getTodosModelo() {
        $conn = parent::connect();
        $sql = "SELECT id_modelo, fabricante, nombre_modelo, motorizacion FROM " . TBL_MODELOS. " ORDER BY fabricante, nombre_modelo DESC";
        try {
            $st = $conn->prepare($sql);
            $st->execute();
            $modelos = array();
            foreach ($st->fetchAll() as $fila) {
                $modelos[] = new Modelo($fila);
            }
            parent::disconnect($conn);
            return $modelos;
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
 
    
// Metodo para recuperar un registro por el id
    public static function getModelo($modeloID) {
        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_MODELOS . " WHERE id_modelo = :modeloID";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":modeloID", $modeloID, PDO::PARAM_INT);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return new Modelo($fila);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
// Metodo para recuperar un registro por el id_repostaje
    public static function getModeloRepos($repostajeID) {
        $conn = parent::connect();
        $sql = "SELECT M.fabricante, M.nombre_modelo, M.motorizacion FROM " . TBL_MODELOS . " M, " . TBL_VEHICULOS . " V, " . TBL_REPOSTAJES . " R WHERE R.id_vehiculo = V.id_vehiculo AND V.id_modelo = M.id_modelo AND id_repostaje = :repostajeID";
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":repostajeID", $repostajeID, PDO::PARAM_INT);
            $st->execute();
            $fila = $st->fetch();
            parent::disconnect($conn);
            if ($fila) return new Modelo($fila);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexión fallida: " . $e->getMessage());
        }
    }
    
    public function getMarca() {
        return($this->_marca[$this->data["fabricante"]]);
    }
    
// recupera los valores de la tabla privada _marca    
    public function getMarcaClave() {
        return $this->_marca;
    }
    
    public function getModeloCombustible() {
        return $this->_combustible;
    }
    
    public function getModeloCambio() {
        return $this->_cambio;
    }    
    
//Metodo para añadir un modelo nuevo
    public function nuevo() {
        $conn = parent::connect();
        $sql = "INSERT INTO " . TBL_MODELOS . " (fabricante, nombre_modelo, motorizacion, combustible, potencia, consumo_extraurbano, consumo_mixto, consumo_urbano, emision_co2, deposito, cilindrada, velocidades, cambio, imagen) VALUES (:fabricante, :nombre_modelo, :motorizacion, :combustible, :potencia, :consumo_extraurbano, :consumo_mixto, :consumo_urbano, :emision_co2, :deposito, :cilindrada, :velocidades, :cambio, :imagen)";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":fabricante", $this->data["fabricante"], PDO::PARAM_STR);
            $st->bindValue(":nombre_modelo", $this->data["nombre_modelo"], PDO::PARAM_STR);
            $st->bindValue(":motorizacion", $this->data["motorizacion"], PDO::PARAM_STR);
            $st->bindValue(":combustible", $this->data["combustible"], PDO::PARAM_STR);
            $st->bindValue(":potencia", $this->data["potencia"], PDO::PARAM_INT);
            $st->bindValue(":consumo_extraurbano", $this->data["consumo_extraurbano"], PDO::PARAM_STR);
            $st->bindValue(":consumo_mixto", $this->data["consumo_mixto"], PDO::PARAM_STR);
            $st->bindValue(":consumo_urbano", $this->data["consumo_urbano"], PDO::PARAM_STR);
            $st->bindValue(":emision_co2", $this->data["emision_co2"], PDO::PARAM_INT);
            $st->bindValue(":deposito", $this->data["deposito"], PDO::PARAM_INT);
            $st->bindValue(":cilindrada", $this->data["cilindrada"], PDO::PARAM_INT);
            $st->bindValue(":velocidades", $this->data["velocidades"], PDO::PARAM_INT);
            $st->bindValue(":cambio", $this->data["cambio"], PDO::PARAM_STR);
            $st->bindValue(":imagen", $this->data["imagen"], PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexion fallida: " . $e->getMessage());
        }
    }

//Metodo para actualizar un modelo
    public function update() {
        $conn = parent::connect();
        $sql = "UPDATE " . TBL_MODELOS . " SET fabricante = :fabricante, nombre_modelo = :nombre_modelo, motorizacion = :motorizacion, combustible = :combustible, potencia = :potencia, consumo_extraurbano = :consumo_extraurbano, consumo_mixto = :consumo_mixto, consumo_urbano = :consumo_urbano, emision_co2 = :emision_co2, deposito = :deposito, cilindrada = :cilindrada, velocidades = :velocidades, cambio = :cambio, imagen = :imagen WHERE id_modelo = :id_modelo";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_modelo", $this->data["id_modelo"], PDO::PARAM_INT);
            $st->bindValue(":fabricante", $this->data["fabricante"], PDO::PARAM_STR);
            $st->bindValue(":nombre_modelo", $this->data["nombre_modelo"], PDO::PARAM_STR);
            $st->bindValue(":motorizacion", $this->data["motorizacion"], PDO::PARAM_STR);
            $st->bindValue(":combustible", $this->data["combustible"], PDO::PARAM_STR);
            $st->bindValue(":potencia", $this->data["potencia"], PDO::PARAM_INT);
            $st->bindValue(":consumo_extraurbano", $this->data["consumo_extraurbano"], PDO::PARAM_STR);
            $st->bindValue(":consumo_mixto", $this->data["consumo_mixto"], PDO::PARAM_STR);
            $st->bindValue(":consumo_urbano", $this->data["consumo_urbano"], PDO::PARAM_STR);
            $st->bindValue(":emision_co2", $this->data["emision_co2"], PDO::PARAM_INT);
            $st->bindValue(":deposito", $this->data["deposito"], PDO::PARAM_INT);
            $st->bindValue(":cilindrada", $this->data["cilindrada"], PDO::PARAM_INT);
            $st->bindValue(":velocidades", $this->data["velocidades"], PDO::PARAM_INT);
            $st->bindValue(":cambio", $this->data["cambio"], PDO::PARAM_STR);
            $st->bindValue(":imagen", $this->data["imagen"], PDO::PARAM_STR);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexion fallida: " . $e->getMessage());
        }
    }

//Metodo para borrar un modelo
    public function borrar() {
        $conn = parent::connect();
        $sql = "DELETE FROM " . TBL_MODELOS . " WHERE id_modelo = :id_modelo";
        
        try {
            $st = $conn->prepare($sql);
            $st->bindValue(":id_modelo", $this->data["id_modelo"], PDO::PARAM_INT);
            $st->execute();
            parent::disconnect($conn);
        } catch (PDOException $e) {
            parent::disconnect($conn);
            die("Conexion fallida: " . $e->getMessage());
        }
    }   

    
}
?>