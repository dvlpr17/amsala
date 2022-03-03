<?php

require_once 'conexion.php';

class ColeProd
{

    private static $instancia;
    private $dbh;
 
    private function __construct() {
        $this->dbh = Conexion::singleton_conexion();
    }
 
    public static function singleton_coleProd() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
	
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  Agregar
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

    public function setColeProd($idCole,$idProd){

        try {
            $query = $this->dbh->prepare('INSERT INTO relacoleprod values(null,?,?)');

            $query->bindParam(1, $idCole);
            $query->bindParam(2, $idProd);
            $query->execute();
            $this->dbh = null;
    
        }catch(PDOException $e){
            $e->getMessage();
        }

    }


    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  ACTUALIZAR
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

    public function updateColeProd($idCole,$idProd){

        try {
            
            $query = $this->dbh->prepare('UPDATE relacoleprod SET idCole = ? WHERE idProd = ?');

            $query->bindParam(1, $idCole);
            $query->bindParam(2, $idProd);
            
            $query->execute();
            $this->dbh = null;
            
            // return "1";
            return "<h1> Ya quedo registrado.</h1>";

        } catch (PDOException $e) {
            $e->getMessage();
        }

    }

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  ELIMINAR
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    
    public function delColeProd($id) {
        try {
            $query = $this->dbh->prepare('DELETE FROM relacoleprod WHERE idProd = ?');
            $query->bindParam(1, $id);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  REGRESA TODOS LOS IDs AFECTADOS CON EL CAMBIO NOMBRE DE COLECCIÓN
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    
    public function IDs($id) {
        try {
            
            $query = $this->dbh->prepare('SELECT idProd FROM relacoleprod WHERE idCole=?');
            $query->bindParam(1, $id);
            $query->execute();
            // return $query->fetchColumn();
            return $query->fetchAll();
            $this->dbh = null;

        } catch (PDOException $e) {
            $e->getMessage();
        }
    }




}
