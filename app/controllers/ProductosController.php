<?php
  require_once 'app/models/ProductosModel.php';
  require_once 'app/views/ProductosView.php';
  
  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;

class ProductosController{
    private $model;
    private $view;

    public function __construct(){
        $this->model= new ProductosModel();
        $this->view= new ProductosView();

    }

    public function verificarToken($token) {
        $secretKey = "trabajoWeb";
    
        try {
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

            if ($decoded->exp < time()) {
                return false;
            }
    
            return true;
    
        } catch (\Exception $e) {
            
        }
    }

    public function obtenerProductos(){
        $filtroDestacado= 0;
        if(isset($_GET['destacado'])){
            $filtroDestacado= $_GET['destacado'];
            $productos= $this->model-> traerDestacados($filtroDestacado);

        }
        else if (isset($_GET['sort']) && isset($_GET['order'])){
            $columna=$_GET['sort'];
            $orden= $_GET['order'];
            
            $productos=$this->model->ordenarProductos($columna,$orden);
        }
        else if(isset($_GET['pagina'])&& isset($_GET['cantidad'])){
            $pagina = $_GET['pagina'];
            $cantidad = $_GET['cantidad'];

            $productos = $this->model->traerTodos();
            $cantidadTotal = count($productos);
    
            $totalPaginas = ceil($cantidadTotal / $cantidad);
    
            if ($pagina > $totalPaginas) {
                $pagina = $totalPaginas;
            }
    
            $indice = ($pagina - 1) * $cantidad;
    
            $productosPaginados = array_slice($productos, $indice, $cantidad);
    
            $respuesta = [
                'data' => $productosPaginados,
                'Paginacion' => [
                    'Pagina' => $pagina,
                    'TotalPaginas' => $totalPaginas,
                    'DatosPorPagina' => $cantidad,
                    'TotalDatos' => $cantidadTotal
                ]
            ];
    
            return $this->view->response($respuesta, 200);
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
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } else {
            return $this->view->response("Falta el token de autorización", 401);
        }
        $position = strpos($authHeader, 'Bearer ');
        if ($position === 0) {
            $token = substr($authHeader, 7);
        } else {
            return $this->view->response("El token no tiene el formato esperado", 400);
        }
        $Token = $this->verificarToken($token);
        
        if (!$Token) {
            return $this->view->response("No se pudo autenticar el token", 404);
        }

        $id= $req->params->id;
        $producto= $this->model->traerPorID($id);
        if(!$producto){
            return $this->view->response("No existe el producto con el id:".$id, 404);
        }
        else{
            $this->model->eliminarProducto($id);
            return $this->view->response("Se pudo eliminar correctamente el producto con el id:".$id, 200);
        }  
    
    }
    
    
    public function crearProducto($req){
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } else {
            return $this->view->response("Falta el token de autorización", 401);
        }
        $position = strpos($authHeader, 'Bearer ');
        if ($position === 0) {
            $token = substr($authHeader, 7);
        } else {
            return $this->view->response("El token no tiene el formato esperado", 400);
        }
        $Token = $this->verificarToken($token);
        
        if (!$Token) {
            return $this->view->response("No se pudo autenticar el token", 404);
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
        $dato=$this->model-> guardarProductos($nombre,$descripcion,$precio,$destacado,$imagen,$categoria);
        if($dato){
            return $this->view->response('Se creo exitosamente el producto',$dato,201);
        }
        else{
            return $this->view->response('Ocurrio un error al crear el producto', 401);
        }
    }
    
    
    public function modificarProducto($req){
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } else {
            return $this->view->response("Falta el token de autorización", 401);
        }
        $position = strpos($authHeader, 'Bearer ');
        if ($position === 0) {
            $token = substr($authHeader, 7);
        } else {
            return $this->view->response("El token no tiene el formato esperado", 400);
        }
        $Token = $this->verificarToken($token);
        
        if (!$Token) {
            return $this->view->response("No se pudo autenticar el token", 404);
        }
        
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
        //$categoria= $req->body->fk_categoria;
        if(empty($descripcion)|| empty($nombre)|| empty($precio)||empty($destacado)|| empty($imagen)){
           return $this->view->response("Faltan completar campos", 401);
        }
        $modificado= $this->model->guardarCambiosProducto($nombre,$descripcion,$precio,$destacado,$imagen,$id);
        if($modificado){
        $this->view->response($modificado, 200);
        }
        else{
            $this->view->response('Ocurrio un error al modificar el producto',500);
        }
    }

    
}

