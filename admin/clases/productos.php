<?php

require_once 'conexion.php';

class Productos
{

    private static $instancia;
    private $dbh;
 
    private function __construct() {
        $this->dbh = Conexion::singleton_conexion();
    }
 
    public static function singleton_productos() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
	
	
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # COMPROBAR LA EXISTENCIA DEL PRODUCTO
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function get_producto($id) {
        try {
            $query = $this->dbh->prepare('select * from productos where id=?');
            $query->bindParam(1, $id);
            $query->execute();
            // return $query->fetchAll();
            return $query->fetchAll(PDO::FETCH_ASSOC);
            $this->dbh = null;
        }catch (PDOException $e){
            $e->getMessage();
        }
    }

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    # COMPROBAR QUE EL NOMBRE DEL PRODUCTO NO ESTE DUPLICADO
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function comprobarProducto($variable) {
        try {
            $query = $this->dbh->prepare('select * from productos where nombre=?');
            $query->bindParam(1, $variable);
            $query->execute();
            $this->dbh = null;


            //si existe el registro
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
    //  AGREGAR PRODUCTO
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-

    public function setProd($prod_data = array()){

        try {
            $query = $this->dbh->prepare('INSERT INTO productos values(null,?,?,?,?,?,?)');

            $query->bindParam(1, $prod_data[0]);
            $query->bindParam(2, $prod_data[1]);
            $query->bindParam(3, $prod_data[2]);
            $query->bindParam(4, $prod_data[3]);
            $query->bindParam(5, $prod_data[4]);
            $query->bindParam(6, $prod_data[5]);
            $query->execute();

            $query = $this->dbh->prepare('select * from productos');
            $query->execute();
            return $query->fetchAll();

            $this->dbh = null;
    
        }catch(PDOException $e){
            $e->getMessage();
        }

    }


    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  Editar
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    
    public function updateProd($prod_data=array())
    {
        try {
            $query = $this->dbh->prepare('UPDATE productos SET nombre = ?, composicion = ?, colores = ?, imagen = ?, medidas = ?, de = ? WHERE id = ?');
            $query->bindParam(1, $prod_data[0]);
            $query->bindParam(2, $prod_data[1]);
            $query->bindParam(3, $prod_data[2]);
            $query->bindParam(4, $prod_data[3]);
            $query->bindParam(5, $prod_data[4]);
            $query->bindParam(6, $prod_data[5]);
            $query->bindParam(7, $prod_data[6]);
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
    public function delProd($id) {
        try {
            $query = $this->dbh->prepare('DELETE FROM productos WHERE id = ?');
            $query->bindParam(1, $id);
            $query->execute();
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    //  CAMBIO DE COLECCIÓN
    //~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-~-
    public function cambioDeColeccion($IDs = array(), $nueva, $anterior) {

        // REMPLASA CADENAS
        // https://www.mysqltutorial.org/mysql-string-replace-function.aspx
        // UPDATE tbl_name SET field_name = REPLACE(field_name, string_to_find, string_to_replace) WHERE conditions;

        /*  REMPLASA MULTIPLES VALORES 
        https://stackoverflow.com/questions/25674737/mysql-update-multiple-rows-with-different-values-in-one-query
        UPDATE table_users
        SET cod_user = (case when user_role = 'student' then '622057'
                            when user_role = 'assistant' then '2913659'
                            when user_role = 'admin' then '6160230'
                        end),
            date = '12082014'
        WHERE user_role in ('student', 'assistant', 'admin') AND
            cod_office = '17389551';        
        */
        try {
            for($i=0;$i<count($IDs);$i++){
                $query = $this->dbh->prepare('UPDATE productos SET imagen = REPLACE(imagen, ?, ?) WHERE id = ?');
                // $query = $this->dbh->prepare('UPDATE productos SET nombre = ?, composicion = ?, colores = ?, imagen = ?, medidas = ?, de = ? WHERE id = ?');
                $query->bindParam(1, $anterior);
                $query->bindParam(2, $nueva);
                $query->bindParam(3, $IDs[$i]);
                $query->execute();
            }
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function prodPorColeccion($id){
// Sentencia original
//SELECT productos.nombre,colecciones.nombrecole FROM (`productos`) LEFT JOIN (`relacoleprod`,`colecciones`) ON (relacoleprod.idCole = colecciones.id AND productos.id = relacoleprod.idProd ) WHERE colecciones.id = 7;

        try {
            $query = $this->dbh->prepare("SELECT productos.id, productos.nombre, productos.composicion, productos.colores, productos.imagen, productos.medidas, productos.de FROM (productos) LEFT JOIN (relacoleprod,colecciones) ON (relacoleprod.idCole = colecciones.id AND productos.id = relacoleprod.idProd ) WHERE colecciones.id = ?");
            $query->bindParam(1,$id);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
            $this->dbh = null;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }


     // Evita que el objeto se pueda clonar
    public function __clone()
    {

        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);

    }

}
