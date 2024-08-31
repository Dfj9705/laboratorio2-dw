<?php

class Conexion
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'desarrollo_web', 'desarrollo', 'desarrollo_web');
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function getConexion()
    {
        return $this->conn;
    }

    public function cerrarConexion()
    {
        $this->conn->close();
    }
}
