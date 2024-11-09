<?php

require_once 'app/models/categoria.model.php';
require_once 'app/views/categoria.views.php';

class CategoriaApiController{
    private $view;
    private $model;

    public function __construct(){
        $this->view = new CategoriaApiView();
        $this->model = new CategoriaApiModel();

    }

    public function getCategorias(){
        $Categorias = $this->model->getCategorias();
        return $this->view->response($Categorias, 200);
    }

    public function crearCategoria($req){
        $nombre = $req->body->especie_animal;
        $descripcion = $req->body->descripcion;

        if(empty($nombre) || empty($descripcion)){
            return $this->view->response("Faltan completar campos", 401);
        }

        $dato = $this->model->crearCategoria($nombre, $descripcion);

        return $this->view->response($dato, 200);

    }

    public function getCategoria($req){
        $id = $req->params->id;

        $categoria = $this->model->TraerCategoria($id);

        if(!$categoria){
            return $this->view->response("No existe la tarea con el id = $id", 404);
        }

        return $this->view->response($categoria, 200);
    }

    public function eliminarCategoria($req){
        $id = $req->params->id;

        $categoria = $this->model->TraerCategoria($id);

        if(!$categoria){
            return $this->view->response("No existe la categoria con el id = $id", 404);
        }
        else{
            $this->model->eliminarCategoria($id);
            return $this->view->response("Se a eliminado la categoria con id = $id", 200);
        }

    }

    public function editarCategoria($req){
        $id = $req->params->id;

        $categoria = $this->model->TraerCategoria($id);

        if(!$categoria){
            return $this->view->response("No existe categoria con id = $id", 404);
        }

        $nombre = $req->body->especie_animal;
        $descripcion = $req->body->descripcion;

        if(empty($nombre) || empty($descripcion)){
            return $this->view->response("Faltan completar campos", 401);
        }

        $idEditado = $this->model->ModificarCat($id, $nombre, $descripcion);

        return $this->view->response($idEditado, 200);

    }


}