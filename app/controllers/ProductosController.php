<?php
  require_once 'app/models/ProductosModel.php';
  require_once 'app/views/ProductosView.php';
<<<<<<< HEAD
  require_once 'app/controllers/user.controller.php';
=======
  //require_once 'app/controllers/user.controller.php';
>>>>>>> 786703b732c34c48f102342df4a7a9a6db64e88a

class ProductosController{
    private $model;
    private $view;

    public function __construct(){
        $this->model= new ProductosModel();
        $this->view= new ProductosView();

    }

    public function obtenerProductos(){
        $filtroDestacado= 0;
        if(isset($_GET['destacado'])){
            $filtroDestacado= $_GET['destacado']== 1;
            $productos= $this->model-> traerDestacados($filtroDestacado);

        }
        else if (isset($_GET['sort']) && isset($_GET['order'])){
            $columna=$_GET['sort'];
            $orden= $_GET['order'];
            
            $productos=$this->model->ordenarProductos($columna,$orden);
        }
        else{
           $productos= $this->model-> traerTodos();
        }
        if($productos){
        return $this->view->response($productos, 200);
        }
        else{
            return $this->view->response('No se pudo encontrar la tabla', 404);
        }
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
       if(verificarUser()==200){
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
    }
    
    
    public function crearProducto($req){
       if(verificarUser()==200){
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
    }
    
    public function modificarProducto($req){
       if(verificarUser()==200){
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
    
    public function paginarProductos() {
    
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

