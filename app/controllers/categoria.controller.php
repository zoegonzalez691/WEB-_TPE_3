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

        if($Categorias){
            return $this->view->response($Categorias, 200);

        }else{
            return $this->view->response("No se puedo encontrar la tabla categoria", 404);

        }
    }

    public function crearCategoria($req){
        $nombre = $req->body->especie_animal;
        $descripcion = $req->body->descripcion;

        if(empty($nombre) || empty($descripcion)){
            return $this->view->response("Faltan completar campos", 400);
        }

        $dato = $this->model->crearCategoria($nombre, $descripcion);
        
        if($dato){
            return $this->view->response("Se creo exitosamente la categoria deseada, con el id: $dato", 201);
        }else{
            return $this->view->response("Hubo un error al subir el archivo", 400);
        }

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
            return $this->view->response("No se pudo modificar la categoria con el id: $id. Verifique que la categoria exista y que no tenga productos asociados antes de intentar de nuevo", 404);
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
            return $this->view->response("Faltan completar campos", 400);
        }

        $categoriaEditada = $this->model->ModificarCat($id, $nombre, $descripcion);

        if(empty($categoriaEditada)){
            return $this->view->response("No se pudo modificar la categoria", 404);
        }
            
        return $this->view->response($categoriaEditada, 200);
        

    }


}