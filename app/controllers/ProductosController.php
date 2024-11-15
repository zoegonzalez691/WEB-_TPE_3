<?php
  require_once 'app/models/ProductosModel.php';
  require_once 'app/views/ProductosView.php';
  //require_once 'app/controllers/user.controller.php';

class ProductosController{
    private $model;
    private $view;

    public function __construct(){
        $this->model= new ProductosModel();
        $this->view= new ProductosView();

    }
    //aca puedo crear una funcion aparte para el filtrado? porque si uso la misma funcion no me toma la url
    // cuando solo quiero traer todos los productos sin filtros
    public function obtenerProductos(){
        $filtroDestacado= 0;
        //de esta manera me toma como que destacado vale 1 aunque le ponga el valor 0 en la url porque esta seteado y el if lo transforma en 1
        if(isset($_GET['destacado'])){
            $filtroDestacado= $_GET['destacado']== 1;
            $productos= $this->model-> traerdestacados($filtroDestacado);

        }
        if (isset($_GET['sort']) && isset($_GET['order'])){
            $columna=$_GET['sort'];
            $orden= $_GET['order'];
            
                $productos=$this->model->ordenarProductos($columna,$orden);
            
            
        }
       // else
        //$productos= $this->model-> traerTodos();
        
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
    
    public function paginarProductos($req) {
        $maximoPag = $req->body->cantidad;
        $pagina = $req->body->pagina;
        
        $productos = $this->model->traerTodos();
        $cantidadTotal = count($productos);
    
        $totalPaginas = ceil($cantidadTotal / $maximoPag); //paginas totales para establecer los limites
    
        //ver que la pagina este en los limites
        if ($pagina < 1) {
            $pagina = 1;
        } elseif ($pagina > $totalPaginas) {
            $pagina = $totalPaginas;
        }
    
        $indice = ($pagina - 1) * $maximoPag; //Calcula el índice desde donde empezar a extraer elementos para la página solicitada
    
        $productosPaginados = array_slice($productos, $indice, $maximoPag);

        $respuesta = [
            'data' => $productosPaginados,
            'Paginacion' => [
                'Pagina' => $pagina,
                'Total de paginas' => $totalPaginas,
                'Datos por Pagina' => $maximoPag
            ]
        ];
    
        return $this->view->response($respuesta, 200);
    }
    
}

