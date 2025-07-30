<?php
class Cconexion{
    
    public static function conexionBD(){
        //datos de la BD
        $host ="localhost";
        $dbname = "mantenBodegas";
        $username = "postgres";
        $pasword = "1234";

        try{
            //Intento conectarme a la BD
            $conn = new PDO ("pgsql:host=$host, dbname=$dbname", $username, $pasword);
        }catch( PDOException $exp){
            //error
            echo ("No Se puede conectar, $exp");
        }
        //Devuelve conexion
        return $conn;
    }
}

?>