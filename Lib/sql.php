<?php

class Sql
{
    private $conn;
    private $limpiar_data;

    function __construct(Limpiar_data $limpiar_data)
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "atpbebidas";
        $this->limpiar_data = $limpiar_data;
        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        } catch (\Throwable $th) {
            die();
        }
    }

    private function contiene_parametros($parametros = array())
    {
        $contiene = false;
        try {
            if (isset($parametros['tabla']) == true && isset($parametros['where']) == true) {
                $contiene = true;
            }
        } catch (\Throwable $th) {
            die();
        }
        return $contiene;
    }

    private function cerrar_insertar($texto = '')
    {
        $datos = '';
        try {
            if (strlen($texto) > 0) {
                $datos = substr($texto, 0, -1);
                $datos = $datos . ')';
            }
        } catch (\Throwable $th) {
            die();
        }
        return $datos;
    }

    public function buscar_datos($parametros = array())
    {
        $datos = array();
        try {
            if (isset($parametros['campos']) == true && $this->contiene_parametros($parametros) == true) {
                $sql = "select " . $parametros['campos'] . " from " . $parametros['tabla'] . " where " . $this->limpiar_data->limpiar($parametros['where']);
                $coneccion = $this->conn->prepare($sql);
                $coneccion->execute();
                $datos = $coneccion->fetchAll(\PDO::FETCH_ASSOC);
            }
        } catch (\Throwable $th) {
            die();
        }
        return $datos;
    }

    public function borrar($parametros = array())
    {
        $datos = false;
        try {
            if ($this->contiene_parametros($parametros) == true) {
                $sql = 'delete from ' . $parametros['tabla'] . ' where ' . $this->limpiar_data->limpiar($parametros['where']);
                $coneccion = $this->conn->prepare($sql);
                $datos = $coneccion->execute();
            }
        } catch (\Throwable $th) {
            die();
        }
        return $datos;
    }

    public function insertar($parametros = array())
    {
        $estado = false;
        try {
            if (isset($parametros['tabla']) == true && isset($parametros['values']) == true) {
                $campos = '(';
                $values = '(';
                foreach ($parametros['values'] as $key => $value) {
                    $campos = $campos . $key . ',';
                    $values = $values . "'" . $this->limpiar_data->limpiar($value) . "'" . ',';
                }
                $campos = $this->cerrar_insertar($campos);
                $values = $this->cerrar_insertar($values);
                $sql = "INSERT INTO " . $parametros['tabla'] . ' ' . $campos . ' VALUES ' . $values;
                $coneccion = $this->conn->prepare($sql);
                $estado = $coneccion->execute();
            } 
        } catch (\Throwable $th) {
            die();
        }
        return $estado;
    }

    public function cambiar($parametros = array())
    {
        $estado = false;
        try {
            if ($this->contiene_parametros($parametros) == true) {
                $campos = '';
                foreach ($parametros['values'] as $key => $value) {
                    $campos = $campos . $key . '= ' . "'" . $this->limpiar_data->limpiar($value) . "',";
                }
                $campos = substr($campos, 0, -1);
                $sql = "UPDATE " . $parametros['tabla'] . " SET " . $campos . " WHERE " . $parametros['where'];
                $coneccion = $this->conn->prepare($sql);
                $estado = $coneccion->execute();
            }
        } catch (\Throwable $th) {
            die();
        }
        return $estado;
    }
}
