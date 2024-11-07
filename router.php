<?php
require_once 'libs/router.php';
require_once 'app/controllers/categoria.controller.php';

$router = new Router();

//categorias:
$router->addRoute('categorias','GET','CategoriaApiController','getCategorias');
$router->addRoute('categorias','POST','CategoriaApiController','crearCategoria');
$router->addRoute('categoria/:id','GET','CategoriaApiController','getCategoria');
$router->addRoute('categoria/:id','DELETE','CategoriaApiController','eliminarCategoria');
$router->addRoute('categoria/:id','PUT','CategoriaApiController','editarCategoria');

//productos
$router->addRoute('productos',      'GET',      'ProductosApiController',    'obtenerProductos');
$router->addRoute('productos/:id',  'GET',      'ProductosApiController',    'obtenerProducto');
$router->addRoute('productos/:id',  'DELETE',   'ProductosApiController',    'eliminarProducto');
$router->addRoute('productos',      'POST',     'ProductosApiController',    'crearProducto');
$router->addRoute('productos/:id',  'PUT',      'ProductosApiController',    'modificarProducto');




// rutea
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);