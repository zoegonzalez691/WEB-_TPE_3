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




