<?php
require_once 'config/config.php';

   class ProductosModel {
      protected $db;
      protected $orderBy;

     private function crearConexion () {
  
      try {
         $this->db =
         new PDO(
         "mysql:host=".dbHost.
         ";dbname=".dbName.";charset=utf8", 
         User, Password);
         $this->_deploy();
      } catch (\Throwable $th) {
          die($th);
      }

      return $this->db;
  }

   private function _deploy(){
      $query = $this->db->query('SHOW TABLES');
      $tables = $query->fetchAll();
      if(count($tables) == 0) {
         $sql =<<<END
        SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
        START TRANSACTION;
        SET time_zone = "+00:00";

        -- Crear la tabla `categorias`
        CREATE TABLE `categorias` (
            `id_categoria` int(11) NOT NULL,
            `especie_animal` varchar(100) NOT NULL,
            `descripcion` text DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Insertar datos en la tabla `categorias`
        INSERT INTO `categorias` (`id_categoria`, `especie_animal`, `descripcion`) VALUES
        (1, 'Felinos', 'Productos aptos para felinos de diferentes edades y razas'),
        (2, 'Roedores', 'Productos para roedores como hamsters o cobayos, entre otros'),
        (9, 'Caninos', 'Productos para la calidad de vida de caninos'),
        (10, 'Peces', 'Producto para animales acuaticos de agua dulce');

        -- Crear la tabla `productos`
        CREATE TABLE `productos` (
            `id_producto` int(11) NOT NULL,
            `nombre` varchar(100) NOT NULL,
            `descripcion` text NOT NULL,
            `imagen` varchar(250) NOT NULL,
            `fk_categoria` int(11) NOT NULL,
            `precio` float NOT NULL,
            `destacado` tinyint(1) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Insertar datos en la tabla `productos`
        INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `imagen`, `fk_categoria`, `precio`, `destacado`) VALUES
        (1, 'Casa-Rascador', 'Casa y rascador apto para gatos.', 'https://i.pinimg.com/236x/9f/3e/56/9f3e5682517588df04b6f4d398d3cdb1.jpg', 1, 25690, 1),
        (2, 'Casa-Jaula para hamster', 'Jaula de tamaño considerable para hamster.', 'https://i.pinimg.com/236x/86/77/e5/8677e5fa317970fddae3a47dbe37389b.jpg', 2, 17890, 0),
        (5, 'Comedero Elevado', 'Comedero elevado para perros de raza grande.', 'https://i.pinimg.com/564x/ae/9a/87/ae9a8752535d8a00ec151006133a94b9.jpg', 9, 0, 1),
        (6, 'Huesos de colores', 'Huesos para cachorros.', 'https://i.pinimg.com/474x/37/2d/9d/372d9ddbb3ffd1ebf1df4cfb1f549084.jpg', 9, 0, 0);

        -- Crear la tabla `usuarios`
        CREATE TABLE `usuarios` (
            `usuario_id` int(200) NOT NULL,
            `nombre` varchar(25) NOT NULL,
            `mail` varchar(50) NOT NULL,
            `es_admin` tinytext DEFAULT NULL,
            `contraseña` text NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Insertar datos en la tabla `usuarios`
        INSERT INTO `usuarios` (`usuario_id`, `nombre`, `mail`, `es_admin`, `contraseña`) VALUES
        (1, 'Webadmin', 'webadmin@gmail.com', 'si', '$2y$10$yELDzZN/41wsn/kn5jpRhOGXt9MGcalVhmUgdr5PsTJGWk54IZbiG');

        -- Añadir índices y claves primarias
        ALTER TABLE `categorias`
          ADD PRIMARY KEY (`id_categoria`);

        ALTER TABLE `productos`
          ADD PRIMARY KEY (`id_producto`),
          ADD KEY `fk_categoria` (`fk_categoria`);

        -- AUTO_INCREMENT para las tablas
        ALTER TABLE `categorias`
          MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

        ALTER TABLE `productos`
          MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

        -- Añadir restricciones de clave foránea
        ALTER TABLE `productos`
          ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categorias` (`id_categoria`);

        COMMIT;
        END;
   
      $this->db->query($sql);
      }
   }
    public function ordenarProductos($columna,$orden){
      $db= $this->crearConexion();
      $sentencia= $db->prepare("SELECT * FROM productos ORDER BY $columna $orden");
      $sentencia->execute();
      $productos= $sentencia->fetchAll(PDO::FETCH_OBJ);

      return $productos;
    }

      public function traerTodos(){
         $db = $this->crearConexion();

         $sentencia = $db->prepare("SELECT * FROM productos");
         $sentencia->execute();
         $productos= $sentencia->fetchAll(PDO::FETCH_OBJ);

         return $productos;
      }

      public function traerDestacados($filtro){
         $db= $this->crearConexion();

         $sentencia= $db->prepare("SELECT * FROM productos WHERE destacado = ?");
         $sentencia->execute([$filtro]);
         $productosDestacados= $sentencia-> fetchAll(PDO::FETCH_OBJ);

         return $productosDestacados;
      }

      public function traerPorID($id){
         $db= $this->crearConexion();
         $sentencia= $db->prepare("SELECT productos.*, categorias.especie_animal AS categoria
                                   FROM productos 
                                   JOIN categorias 
                                   ON productos.fk_categoria=id_categoria
                                   WHERE id_producto= ?");
         $sentencia->execute([$id]);
         $producto= $sentencia->fetch(PDO::FETCH_OBJ);

         return $producto;
      }

      public function TraerProductosCategoria($categoria){
        $db = $this->crearConexion();
        $sql = "SELECT * FROM productos WHERE 
                  fk_categoria = '$categoria' ";
         $query = $db->prepare($sql);
         $query->execute();
     
         $productos = $query->fetchAll(PDO::FETCH_OBJ);
     
         return $productos;


      }

      public function eliminarProducto($id){
         $db = $this-> crearConexion();
         $sentencia= $db-> prepare("DELETE FROM productos WHERE id_producto = ?");
         $sentencia-> execute([$id]);
      } 

      public function guardarProductos($nombre,$descripcion,$precio,$destacado,$imagen,$categoria){
         $db= $this->crearConexion();
         $sentencia= $db->prepare("INSERT INTO productos (`nombre`,`descripcion`,`precio`, `destacado`,`imagen`,`fk_categoria`) 
         VALUES(?,?,?,?,?,?)");
         try{
            $sentencia->execute([$nombre,$descripcion,$precio,$destacado,$imagen,$categoria]);
            $productoNuevo= $sentencia-> fetch(PDO::FETCH_OBJ);
     
            return $productoNuevo;
            }
            catch(\Throwable $th){
            echo $th;
            die(__file__);
            return null;
            }
      }

   
      public function guardarCambiosProducto($nombre,$descripcion,$precio,$destacado,$imagen,$categoria,$id){
         $db= $this->crearConexion();
        
         $sentencia= $db->prepare("UPDATE productos SET `nombre`= ?, `descripcion`= ?,`imagen`=?,`fk_categoria`=?,`precio`= ?,`destacado`=? WHERE id_producto= ?");
         try{
            $sentencia->execute([$nombre,$descripcion,$imagen,$categoria,$precio,$destacado,$id]);
            $productoModificado= $sentencia->fetch(PDO::FETCH_OBJ);
      
            return $productoModificado;
         }
         catch(\Throwable $th){
            echo $th;
            die(__file__);
            return null;
         }
      }
      
}