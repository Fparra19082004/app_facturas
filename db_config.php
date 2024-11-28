<?php
class ConexionBD {
    private $host;
    private $dbname;
    private $usuario;
    private $password;
    private $conexion;

    public function __construct($host, $dbname, $usuario, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->usuario = $usuario;
        $this->password = $password;
    }

    public function conectar() {
        try {
			$dsn = "mysql:host=$this->host;dbname=$this->dbname";
            $this->conexion = new PDO($dsn, $this->usuario, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
            die();
        }
    }
   
    public function prepararConsulta($consulta) {
        return $this->conexion->prepare($consulta);
    }
    
    public function desconectar() {
        $this->conexion = null;
        echo "Conexión cerrada.";
    }
}