<?php

require_once 'conexion.php';

class Colecciones
{
    private static $instancia;
    private $dbh;
    private function __construct() {
        $this->dbh = Conexion::singleton_conexion();
    }
    public static function singleton_Colecciones() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
	# REGRESA TODAS LAS COLECCIONES
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function get_colecciones() {
        try {
            $query = $this->dbh->prepare('select * from colecciones');
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
            $this->dbh = null;
        }catch (PDOException $e){
            $e->getMessage();
        }
    }
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
	# REGRESA EL NOMBRE DE LA COLECCIÓN
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function get_coleccion($id) {
        
        try {
            $query = $this->dbh->prepare('select nombrecole from colecciones where id = ?');
            $query->bindParam(1, $id);
            $query->execute();
            return $query->fetchColumn();
            $this->dbh = null;
        }catch (PDOException $e){
            $e->getMessage();
        }
        
    }
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # COMPROBAR REGISTRO DE COLECCIÓN
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function comprobarColeccion($variable) {
        try {
            $query = $this->dbh->prepare('select * from colecciones where nombre=?');
            $query->bindParam(1, $variable);
            $query->execute();
            $this->dbh = null;
            if($query->rowCount() >= 1) {
                 return "<span class='text-danger'> Ya está registrado.</span>";
            }else{
                 return "";
            }
        }catch (PDOException $e){
            $e->getMessage();
        }
    }
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  AGREGAR
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function setColeccion($nombre,$carpeta){
        try {
            $query = $this->dbh->prepare('INSERT INTO colecciones values(null,?,?)');
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $carpeta);
            $query->execute();
            $this->dbh = null;
            
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  EDITAR
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function updateColeccion($nombre, $carpeta, $id)
    {
        try {
            $query = $this->dbh->prepare('update colecciones SET nombrecole = ?, carpeta = ? WHERE id = ?');
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $carpeta);
            $query->bindParam(3, $id);
            $query->execute();
            $this->dbh = null;
            return "1";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  ELIMINAR
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function delColeccion($id) {
        try {
            $query = $this->dbh->prepare('DELETE FROM colecciones WHERE id = ?');
            $query->bindParam(1, $id);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
    // Evita que el objeto se pueda clonar
    public function __clone() {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }

}
