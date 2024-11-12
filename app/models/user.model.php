<?php
require_once 'config/config.php';

class UsersApiModel{

    private function CrearConexion(){
        try{
        $db =
            new PDO(
            "mysql:host=".dbHost.
            ";dbname=".dbName.";charset=utf8", 
            User, Password);
        }catch(\Throwable $th) {
            die($th);
        }

        return $db;
    }

    public function GetUsuario($nombre) {
        $pdo = $this->CrearConexion();
        $sql = "SELECT * FROM usuarios WHERE nombre = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$nombre]);
    
        $usuario = $query->fetch(PDO::FETCH_OBJ);
    
        return $usuario; 
    
    }

}

    
