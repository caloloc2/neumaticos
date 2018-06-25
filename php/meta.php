<?php

/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
require 'conexion.php';

class Meta
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'meta'
     *
     * @param $idMeta Identificador del registro
     * @return array Datos del registro
     */
    public static function Consulta($sql)
    {
        $consulta = $sql;
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene los campos de una meta con un identificador
     * determinado
     *
     * @param $id_test Identificador de la meta
     * @return mixed
     */
    public static function Ejecutar($sql) {
        // Consulta de la meta
        $consulta = $sql;

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
                        
            return 1;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Obtiene los campos de una meta con un identificador
     * determinado
     *
     * @param $id_test Identificador de la meta
     * @return mixed
     */
    public static function Consulta_Unico($sql) {
        // Consulta de la meta
        $consulta = $sql;

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Insertar una nueva meta
     *
     * @param $id_test      identificador
     * @param $nombre       nuevo titulo
     * @param $edad         nueva descripcion 
     * @return PDOStatement
     */
    public static function Ejecutar_Sentencia($sql)
    {
        try{

            // Sentencia INSERT
            $comando = $sql;

            // Preparar la sentencia
            $sentencia = Database::getInstance()->getDb()->prepare($comando);

            return $sentencia->execute();

            return 1;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
        

    }

    /**
     * Insertar una nueva meta
     *
     * @param $id_test      identificador
     * @param $nombre       nuevo titulo
     * @param $edad         nueva descripcion 
     * @return PDOStatement
     */
    public static function Nuevo_Reporte($nombres, $placa, $llantas, $fecha)
    {
        // Sentencia INSERT
        $comando = "INSERT INTO clientes (nombres, placa, llantas, fecha) VALUES (?,?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($nombres, $placa, $llantas, $fecha));

    }

    /**
     * Insertar una nueva meta
     *
     * @param $id_test      identificador
     * @param $nombre       nuevo titulo
     * @param $edad         nueva descripcion 
     * @return PDOStatement
     */
    public static function Nuevo_Valor($id_cliente, $num_llanta, $sensor, $camara, $foto)
    {
        // Sentencia INSERT        
        $comando = "INSERT INTO valores (id_cliente, num_llanta, sensor, camara, foto) VALUES (?,?,?,?,?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($id_cliente, $num_llanta, $sensor, $camara, $foto));

    }
}

?>