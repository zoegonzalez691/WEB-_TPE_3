<?php

class CategoriaApiModel{
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

    public function getCategorias(){
        $pdo = $this->CrearConexion();
        $sql = "select * from categorias";
        $query = $pdo->prepare($sql);

        try {
            $query->execute();
            $categorias = $query->fetchAll(PDO::FETCH_OBJ);
            return $categorias;

        } catch (\Throwable $th) {
            return null;
        }
       
    }

    public function TraerCategoria($id) {
        $pdo = $this->CrearConexion();
        $sql = "SELECT * FROM categorias WHERE id_categoria = :id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $query->execute();
            $categoria = $query->fetch(PDO::FETCH_OBJ); // Retorna un solo objeto
            return $categoria;

        } catch (\Throwable $th) {
           return null;
        }
       
    }

    public function ModificarCat($id, $especie_animal, $descripcion){
        $pDO = $this->crearConexion();
        $sql = 'UPDATE categorias SET especie_animal = ?, descripcion = ? WHERE id_categoria = ?';
        $query = $pDO->prepare($sql);
        $query->execute([$especie_animal, $descripcion, $id]);

        if ($query->rowCount() > 0) { //si se modifico alguna fila
            $sql = 'SELECT * FROM categorias WHERE id_categoria = ?';//encontrar la fila modificada(que deberia ser la misma que el id)
            $query = $pDO->prepare($sql);
            $query->execute([$id]);
            
            return $query->fetch(PDO::FETCH_ASSOC); //devuelve la categoria ya editada
        } else {
            return false;
        }
    }

    public function eliminarCategoria($id){
        $pdo = $this->CrearConexion();
        $sql = 'DELETE FROM categorias WHERE id_categoria = ?';
        $query = $pdo->prepare($sql);
        try {
            $query->execute([$id]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function crearCategoria($nombre, $descripcion){
        $pdo = $this->CrearConexion();
        $sql = 'INSERT INTO categorias (especie_animal, descripcion) VALUES (?, ?)';
        $query = $pdo->prepare($sql);

        try {
            $query->execute([$nombre, $descripcion]);
            return $pdo->lastInsertId(); // Devuelve el último ID insertado

        } catch (\Throwable $th) {
            return null;
        }
    }
           
    public function ordenarCategorias($orden){
        $pdo = $this->CrearConexion(); 
        $sql = "SELECT * FROM categorias ORDER BY id_categoria $orden"; 
        $query = $pdo->prepare($sql);

        try {
            $query->execute();
            $categoriaOrdenada = $query->fetchAll(PDO::FETCH_OBJ);
            return $categoriaOrdenada;
        } catch (\Throwable $th) {
            return null;
        }

    }

}