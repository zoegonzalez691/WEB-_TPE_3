<?php
require_once 'app/models/ProductosModel.php';
require_once 'app/views/ProductosView.php';

class ProductosApiController{
    private $model;
    private $view;

    public function __construct(){
        $this->model= new ProductosApiModel();
        $this->view= new ProductosApiView();

    }

    public function obtenerProductos(){
        $productos= $this->model-> traerTodos();
        
        return $this->view->response($productos, 200);
    }
    
    public function obtenerProducto($req){ 
        $id= $req->params->id;
        $producto= $this->model->traerPorID($id);
        if(!$producto){
            return $this->view->response("No existe con el id:".$id, 404);
        }
        return $this->view->response($producto, 200);
    }
    
    public function eliminarProducto($req){
        $id= $req->params->id;
        $producto= $this->model->traerPorID($id);
        if(!$producto){
            return $this->view->response("No existe con el id:".$id, 404);
        }
        else{
            $this->model->eliminarProducto($id);
            return $this->view->response("Se pudo eliminar correctamente", 200);
        }  
    }
    
    public function crearProducto($req){
        $nombre= $req->body->nombre;
        $descripcion= $req->body->descripcion;
        $precio= $req->body->precio;
        $destacado= $req->body->destacado;
        $imagen= $req->body->imagen;
        $categoria= $req->body->fk_categoria;
        if(empty($descripcion)|| empty($nombre)|| empty($precio)||empty($detacado)|| empty($imagen)|| empty($categoria)){
            return $this->view->response("Faltan completar campos", 401);
        }
        $dato=$this->model-> guardarProductos($nombre,$descripcion,$precio,$destacado,$imagen,$categoria);
        return $this->view->response($dato);
    }
    
    public function modificarProducto($req){
        $id= $req->params->id;
        $producto= $this->model->traerPorID($id);
        if(!$producto){
            return $this->view->response("No existe producto con el id:".$id, 404);
        }
        $nombre= $req->body->nombre;
        $descripcion= $req->body->descripcion;
        $precio= $req->body->precio;
        $destacado= $req->body->destacado;
        $imagen= $req->body->imagen;
        $categoria= $req->body->fk_categoria;
        if(empty($descripcion)|| empty($nombre)|| empty($precio)||empty($detacado)|| empty($imagen)|| empty($categoria)){
           return $this->view->response("Faltan completar campos", 401);
        }
        $modificado= $this->model->guardarCambiosProducto($nombre,$descripcion,$precio,$destacado,$imagen,$categoria,$id);
        $this->view->response($modificado, 200);
        
    }
    
}

