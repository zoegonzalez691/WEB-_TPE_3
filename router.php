<?php
require_once 'libs/router.php';
require_once 'app/controllers/categoria.controller.php';
require_once 'app/controllers/ProductosController.php';
require_once 'app/controllers/user.controller.php';

$router = new Router();

//autenticacion
$router->addRoute('login','POST','UserApiController','verificarUser');

//categorias:
$router->addRoute('categorias','GET','CategoriaApiController','getCategorias');
$router->addRoute('categorias','POST','CategoriaApiController','crearCategoria');
$router->addRoute('categoria/:id','GET','CategoriaApiController','getCategoria');
$router->addRoute('categoria/:id','DELETE','CategoriaApiController','eliminarCategoria');
$router->addRoute('categoria/:id','PUT','CategoriaApiController','editarCategoria');

//productos
$router->addRoute('productos',      'GET',      'ProductosController',    'obtenerProductos');
$router->addRoute('producto/:id',  'GET',      'ProductosController',    'obtenerProducto');
$router->addRoute('producto/:id',  'DELETE',   'ProductosController',    'eliminarProducto');
$router->addRoute('producto',      'POST',     'ProductosController',    'crearProducto');
$router->addRoute('producto/:id',  'PUT',      'ProductosController',    'modificarProducto');
$router->addRoute('productosPag',   'POST',     'ProductosController',    'paginarProductos');

// rutea
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);