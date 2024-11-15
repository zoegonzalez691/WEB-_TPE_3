# TPE_3
 ## Nombre de los integrantes del grupo:
 Tatiana Pereyra(tati25pereyra@gmail.com) 
 Zoe Gonzalez(zoegonzalez461@gmail.com).

 ## Descripcion y funcionalidad de la API: 
   La api esta pensada y desarrollada para trabajar con una base de datos de productos y categorias. Se desarrollaron los respectivos endpoints y metodos necesarios para que la api sea rest full.

## Metodo Login:
Para poder autenticarse, en la api se debe accerder al endpoint _api/login_.
Luego se debe completar el body del request con los datos "UserName" y "Password". Para que funcione, se debe completar _"Webadmin"_ y _"admin"_ respectivamente:
[
    {
        "UserName" = "Webadmin",
        "Password" = "admin"
    }
]

Esa es la forma visual que deberia tener el request antes de enviarlo. Se envia con el metodo _POST_.
Como respuesta, en caso de que los datos ingresados sean correctos y coincidan con los almacenados en la base de datos, se le brindará al usuario el token creado y el código de estado 200 que indica que se pudo autenticar correctamente:

{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJob3JhIjoxNzMxNTkwNDQ5LCJleHAiOjE3MzE1OTQwNDksInVzZXJfaWQiOjEsImVzX2FkbWluIjoic2kifQ.vnKDu9vWu-dQsnCNlM0E1ukhFe4h-A5te_1gHjm4nZ4"
}

En caso contrario, que el usuario no exista o la contraseña sea incorrecta devolverá el mensaje de error y el codigo 404 que indica que no fue encontrado: 

"No se pudo autenticar el usuario"

## Métodos en Categoría:
## Método GET:
Por medio de la url _api/categoria_ y el metodo get se nos devolvera un JSON con todas las categorias en la tabla. En caso de que funcione y devuelva los resultados esperados se veria asi: 
[
    {
        "id_categoria": 1,
        "especie_animal": "Felinos",
        "descripcion": "Productos aptos para felinos de diferentes edades y razas"
    },
    {
        "id_categoria": 2,
        "especie_animal": "Roedores",
        "descripcion": "Productos para roedores como hamsters o cobayos, entre otros"
    },
    {
        "id_categoria": 9,
        "especie_animal": "Caninos",
        "descripcion": "Productos para la calidad de vida de caninos"
    },
    {
        "id_categoria": 10,
        "especie_animal": "Peces",
        "descripcion": "Producto para animales acuaticos de agua dulce"
    }
]
Acompañado del codigo de estado 200 que indica que todo salio bien.
En caso contrario, se mostraría el código 404 not foun, acompañado del mensaje de error:

"No se puedo encontrar la tabla categoria"

Para seleccionar y traer una categoría especifíca, se debe modificar el endpoint utilizando _api/categoria/id_. Devolvera una categoría correspondiente al id ingresado y el código 200.

{
    "id_categoria": 1,
    "especie_animal": "Felinos",
    "descripcion": "Productos aptos para felinos de diferentes edades y razas"
}

En caso de que el id ingresado no corresponda a alguna categoría, se devolverá el código 404 y el mensaje:

"No existe la tarea con el id = id"

## Método POST:




## Metodos en Productos:

## Metodo GET:

Por medio del endpoint /productos , se obtendra la coleccion de la tabla productos con todas sus columnas, en caso de efectuarse la vista retornara el codigo 200 y se vera un JSON de esta manera:
[
    {
        "id_producto": 1,
        "nombre": "Casa-Rascador",
        "descripcion": "Casa y rascador apto para gatos. \r\nAltura: 54cm \r\nViene tambien con un colgante para que juegue. \r\nColor a eleccion (Disponible en rosa, rojo, azul, violeta, naranja)",
        "imagen": "https://i.pinimg.com/236x/9f/3e/56/9f3e5682517588df04b6f4d398d3cdb1.jpg",
        "fk_categoria": 1,
        "precio": 25690,
        "destacado": 1
    },
    {
        "id_producto": 2,
        "nombre": "Casa-Jaula para hamster",
        "descripcion": "Jaula de tamaño considerable para que le des a tu hmaster la calidad de vida que mrece. \r\nCuenta con diferentes niveles para que el hasmter pueda divertirse.\r\nDisponibles en 5 diferentes colores.",
        "imagen": "https://i.pinimg.com/236x/86/77/e5/8677e5fa317970fddae3a47dbe37389b.jpg",
        "fk_categoria": 2,
        "precio": 17890,
        "destacado": 0
    },
    {
        "id_producto": 5,
        "nombre": "Comedero Elevado ",
        "descripcion": "Comedero elevado, de 30cm para perros de raza grande.\r\nApto para la prevencion de enfermedades relacionadas a la columna.",
        "imagen": "https://i.pinimg.com/564x/ae/9a/87/ae9a8752535d8a00ec151006133a94b9.jpg",
        "fk_categoria": 9,
        "precio": 0,
        "destacado": 1
    },
    {
        "id_producto": 6,
        "nombre": "Huesos de colores",
        "descripcion": "Huesos para cachorros de tela, apto para los dientes. Disponibles en diferentes colores (azul, verde, rosa, rojo, amarillo)",
        "imagen": "https://i.pinimg.com/474x/37/2d/9d/372d9ddbb3ffd1ebf1df4cfb1f549084.jpg",
        "fk_categoria": 9,
        "precio": 0,
        "destacado": 0
    }
]

En caso de no existir la tabla, la vista me retornara un mensaje de 'No se pudo encontrar la tabla Productos', con el codigo 404.

## Query Params:
## Filtro Destacado:
          Para traer los productos destacados debo pasar por la url el parametro get "?destacado=1", esto me devolvera un JSON con todos los productos destacados con el codigo 200, esto se vera asi:
          [
    {
        "id_producto": 1,
        "nombre": "Casa-Rascador",
        "descripcion": "Casa y rascador apto para gatos. \r\nAltura: 54cm \r\nViene tambien con un colgante para que juegue. \r\nColor a eleccion (Disponible en rosa, rojo, azul, violeta, naranja)",
        "imagen": "https://i.pinimg.com/236x/9f/3e/56/9f3e5682517588df04b6f4d398d3cdb1.jpg",
        "fk_categoria": 1,
        "precio": 25690,
        "destacado": 1
    },
    {
        "id_producto": 5,
        "nombre": "Comedero Elevado ",
        "descripcion": "Comedero elevado, de 30cm para perros de raza grande.\r\nApto para la prevencion de enfermedades relacionadas a la columna.",
        "imagen": "https://i.pinimg.com/564x/ae/9a/87/ae9a8752535d8a00ec151006133a94b9.jpg",
        "fk_categoria": 9,
        "precio": 0,
        "destacado": 1
    }
]
En caso de no encontrarse la tabla la vista retornara un mensaje 'No se pudo encontrar la tabla', con el codigo 404.

## Ordenamiento:

       




