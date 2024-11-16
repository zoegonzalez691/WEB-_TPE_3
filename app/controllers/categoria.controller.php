<?php
require_once 'app/models/categoria.model.php';
require_once 'app/views/categoria.views.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class CategoriaApiController{
    private $view;
    private $model;

    public function __construct(){
        $this->view = new CategoriaApiView();
        $this->model = new CategoriaApiModel();

    }

    public function verificarToken($token) {
        $secretKey = "trabajoWeb";
    
        try {
            // Decodificar el token
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
    
            // Verificar si el token ha expirado
            if ($decoded->exp < time()) {
                return false;
            }
    
            return true;
    
        } catch (\Exception $e) {
            //$e
        }
    }
    

    public function getCategorias() {
        //paginacion
        if(isset($_GET['pagina'])&& isset($_GET['cantidad'])){
            $pagina = $_GET['pagina'];
            $cantidad = $_GET['cantidad'];

            $categorias = $this->model->getCategorias();
            $cantidadTotal = count($categorias);
    
            $totalPaginas = ceil($cantidadTotal / $cantidad);
    
            if ($pagina > $totalPaginas) {
                $pagina = $totalPaginas;
            }
    
            $indice = ($pagina - 1) * $cantidad;
    
            $categoriasPaginadas = array_slice($categorias, $indice, $cantidad);
    
            $respuesta = [
                'data' => $categoriasPaginadas,
                'Paginacion' => [
                    'Pagina' => $pagina,
                    'TotalPaginas' => $totalPaginas,
                    'DatosPorPagina' => $cantidad,
                    'TotalDatos' => $cantidadTotal
                ]
            ];
    
            return $this->view->response($respuesta, 200);

        //Muestra los resultados segun el orden que le indiquen
        }else if (isset($_GET['order'])){
            $orden= $_GET['order'];
            
            $categoriasOrdenadas=$this->model->ordenarCategorias($orden);

            return $this->view->response($categoriasOrdenadas, 200);

        } else{
            //muestra todas las categorias si no se ingresa ningun query params
            $categorias = $this->model->getCategorias();
            if ($categorias) {
                return $this->view->response($categorias, 200);
            } else {
                return $this->view->response("No se pudo encontrar la tabla 'categoria'", 404);
            }
         }
    }
    

    public function crearCategoria($req){
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } else {
            return $this->view->response("Falta el token de autorización", 401);
        }
        
        // Verificar si el encabezado tiene el prefijo "Bearer " al inicio
        $position = strpos($authHeader, 'Bearer ');
        if ($position === 0) {
            // Extraer el token eliminando el prefijo "Bearer "
            $token = substr($authHeader, 7);
        } else {
            return $this->view->response("El token no tiene el formato esperado", 400);
        }
        
        // Ahora verifica el token
        $Token = $this->verificarToken($token);
        
        if (!$Token) {
            return $this->view->response("No se pudo autenticar el token", 404);
        }
        
        //Una vez que el token es validado, se continua con la ejecucion

        $nombre = $req->body->especie_animal;
        $descripcion = $req->body->descripcion;

        if(empty($nombre) || empty($descripcion)){
            return $this->view->response("Faltan completar campos", 400);
        }
        
        $dato = $this->model->crearCategoria($nombre, $descripcion);
        
        if($dato){
            return $this->view->response("Se creo exitosamente la categoria deseada, con el id: $dato", 201);
        }else{
            return $this->view->response("Hubo un error al subir los datos ingresados", 400);
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
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } else {
            return $this->view->response("Falta el token de autorización", 401);
        }
        
        // Verificar si el encabezado tiene el prefijo "Bearer " al inicio
        $position = strpos($authHeader, 'Bearer ');
        if ($position === 0) {
            // Extraer el token eliminando el prefijo "Bearer "
            $token = substr($authHeader, 7);
        } else {
            return $this->view->response("El token no tiene el formato esperado", 400);
        }
        
        // Ahora verifica el token
        $Token = $this->verificarToken($token);
        
        if (!$Token) {
            return $this->view->response("No se pudo autenticar el token", 404);
        }

        //elimina la categoria

        $id = $req->params->id;

        $categoria = $this->model->TraerCategoria($id);

        if(!$categoria){
            return $this->view->response("No se pudo modificar la categoria con el id: $id. Verifique que la categoria exista y que no tenga productos asociados antes de intentar de nuevo", 404);
        }
        else{
            $this->model->eliminarCategoria($id);
            return $this->view->response("Se ha eliminado la categoria con id = $id", 200);
        }

    }

    public function editarCategoria($req){
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        } else {
            return $this->view->response("Falta el token de autorización", 401);
        }
        
        // Verificar si el encabezado tiene el prefijo "Bearer " al inicio
        $position = strpos($authHeader, 'Bearer ');
        if ($position === 0) {
            // Extraer el token eliminando el prefijo "Bearer "
            $token = substr($authHeader, 7);
        } else {
            return $this->view->response("El token no tiene el formato esperado", 400);
        }
        
        // Ahora verifica el token
        $Token = $this->verificarToken($token);
        
        if (!$Token) {
            return $this->view->response("No se pudo autenticar el token", 404);
        }

        //edicion de categoria

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

        if(!$categoriaEditada){
            return $this->view->response("No se pudo modificar la categoria", 404);
        }
            
        return $this->view->response($categoriaEditada, 200);
        

    }

}