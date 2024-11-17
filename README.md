# TPE_3
 ## Nombre de los integrantes del grupo:
 Tatiana Pereyra(tati25pereyra@gmail.com) 
 Zoe Gonzalez(zoegonzalez461@gmail.com).

 ## Descripcion y funcionalidad de la API: 
   La api esta pensada y desarrollada para trabajar con una base de datos de productos y categorias. Se desarrollaron los respectivos endpoints y metodos necesarios para que la api sea rest full.

## Metodo Login:
Para que el metodo funcione, se requiere la instalacion previa de composer (link de descarga: https://getcomposer.org/download/) y ejecutar en consola para que se descarguen los archivos vendor que permiten el correcto funcionamiento de los metodos con JWT.

    composer install

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

Cada token tiene una duracion de 1 hora desde que se creó antes de que expire.

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

"No se puedo encontrar la tabla categoria".

## Query Params:
Para la paginación de las mismas, se deben completar los datos por medio de query params: _api/categorias?pagina=1&cantidad=3_. Esto va a devolver un JSON con los datos de las categorias paginadas y datos de la paginacion ("cantidad" se utiliza para elegir cuantos elementos quiero ver por pagina, y "pagina" cuál página quiero ver). El ejemplo utilizado (donde pagina=1 y cantidad =3) devuelve el codigo 200 y el JSON:

    {
        "data": [
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
            }
        ],
        "Paginacion": {
            "Pagina": "1",
            "TotalPaginas": 3,
            "DatosPorPagina": "3",
            "TotalDatos": 9
        }
    }

Para poder ordenar los elementos, en el caso de categorias, se ordenan unicamente de forma ascendente(asc) o descendente(desc) segun su id. Tambien se aclara por medio de query params. _api/categorias?order=desc_ devolvera el arreglo con los elemetos invertidos, y el codigo 200:

    [
        {
            "id_categoria": 16,
            "especie_animal": "renacuajos",
            "descripcion": "anfibio"
        },
        {
            "id_categoria": 15,
            "especie_animal": "sapo",
            "descripcion": "anfibio"
        },
        {
            "id_categoria": 14,
            "especie_animal": "mulita",
            "descripcion": "animal de campo"
        },
        {
            "id_categoria": 13,
            "especie_animal": "mulita",
            "descripcion": "animal de"
        },
        {
            "id_categoria": 12,
            "especie_animal": "carpincho",
            "descripcion": "animal de campo"
        },
        {
            "id_categoria": 10,
            "especie_animal": "Peces",
            "descripcion": "Producto para animales acuaticos de agua dulce"
        },
        {
            "id_categoria": 9,
            "especie_animal": "Caninos",
            "descripcion": "Productos para la calidad de vida de caninos"
        },
        {
            "id_categoria": 2,
            "especie_animal": "Roedores",
            "descripcion": "Productos para roedores como hamsters o cobayos, entre otros"
        },
        {
            "id_categoria": 1,
            "especie_animal": "Felinos",
            "descripcion": "Productos aptos para felinos de diferentes edades y razas"
        }
    ]

## GET ID:
Para seleccionar y traer una categoría especifíca, se debe modificar el endpoint utilizando _api/categoria/id_. Devolvera una categoría correspondiente al id ingresado y el código 200.

    {
        "id_categoria": 1,
        "especie_animal": "Felinos",
        "descripcion": "Productos aptos para felinos de diferentes edades y razas"
    }

En caso de que el id ingresado no corresponda a alguna categoría, se devolverá el código 404 y el mensaje:

    "No existe la tarea con el id = id"

## Método POST, PUT y DELETE:
## Authorization:
Obligatoriamente para utilizar los metodos POST, PUT Y DELETE es necesario la autorizacion de token. Estos errores pueden repetirse en cualquiera de los 3 metodos mencionados.
Para crear y subir o modificar una categoria, primero es necesario el token. En el header del request se debe completar la parte de authorization.

    Authorization = Bearer <token que se generó al loguearse>.

Si el token no es ingresado, se va a mostrar el codigo 401 con el siguiente mensaje de error:

    "Falta el token de autorizacion" 

El caso de que el token haya sido ingresado, pero no tiene el formato esperado (se espera un token bearer), aparecerá el codigo 400 con el mensaje:

    "El token no tiene el formato esperado"

En caso de que el token ya expiró o sea incorrecto se mostraría el código 404 y el mensaje:

    "No se pudo autenticar el token"

Sin ingresar el token, no va a permitir que se pueda crear la categoría. 

## POST:
Para crear una nueva categoria (_api/categorias_), el body se debe completar con los datos y el formato que se ven en los arreglos anteriores devueltos: 

    {
        "especie_animal":"ejemplo",
        "descripcion":"ejemplo"
    }

En caso de que la categoria se pudo crear y subir se mostraria el codigo 201(created), y el id de la categoria creada: 

    "Se creo exitosamente la categoria deseada, con el id: 17"

En caso de que alguno de los campos no haya sido completado, va a devolver el codigo 400 y el mensaje:

    "Faltan completar campos"

Y en caso de que surja algún error relacionado a la base de datos, el código de estado que se mostraría sería nuevamente el 400, pero con el mensaje:

    "Hubo un error al subir los datos ingresados".

## PUT:
Para editar una categoria se accede a la misma mediante el id: _api/categoria/id_.

Si cuando se busca la categoría con ese id no se encuentra, va a devolver el código 404 y el mensaje:

    "No se pudo encontrar la categoria con el id: (id)."

En caso de que la categoría si exista, pero los campos no se llenaron, mostrará nuevamente el codigo 400 y el mensaje:

    "Faltan completar datos"

En caso de que suceda un error con la base de datos y no se pueda modificar la categoría, se va a mostrar el codigo 400 y el mensaje: 

    "No se pudo modificar la categoría"

Si la categoría se pudo modificar correctamente, mostrara el codigo 200 y la categoria con los datos modificados:

    {
        "id_categoria": 16,
        "especie_animal": "Tortugas",
        "descripcion": "Existen tortugas terrestres y acuaticas"
    }

## DELETE:

Para eliminar la categoria, tambien se accede mediante el id: _api/categoria/id_. El mayor problema que puede haber relacionado a eliminar una categoria, se debe a que no se va a poder eliminar si tiene productos asociados.

En caso de que el id sea incorrecto o no se pueda eliminar (ya que tiene productos asociados) devolverá el código 404 y el mensaje:

    "No se puede eliminar la categoría con el id: (id). Verifique que la categoria exista y no tenga productos asociados antes de intentar de nuevo"

Si se pudo eliminar, el codigo será 200: 

    "Se ha eliminado la categoria con id = 17"

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
Para traer los productos destacados debo pasar por la url el parametro get "?destacado=1", esto me devolvera un JSON con todos los productos destacados con el codigo 200, se verá asi:

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
Los productos podran ordenarse de forma ascendente o descendente mediante cualquiera de sus columnas, para hacerlo se debe pasar el parametro con las palabras clave sort(para indicar mediante que columna quiero hacer el ordenamiento), y la palabra order(para indicar en que orden quiero que me traigan los productos), en la url se debe ver asi: ?sort=precio&order=asc, esta accion me va a retornar el siguiente JSON y el codigo 200 en caso de ejecutarse correctamente:

    [
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
            "id_producto": 1,
            "nombre": "Casa-Rascador",
            "descripcion": "Casa y rascador apto para gatos. \r\nAltura: 54cm \r\nViene tambien con un colgante para que juegue. \r\nColor a eleccion (Disponible en rosa, rojo, azul, violeta, naranja)",
            "imagen": "https://i.pinimg.com/236x/9f/3e/56/9f3e5682517588df04b6f4d398d3cdb1.jpg",
            "fk_categoria": 1,
            "precio": 25690,
            "destacado": 1
        }
    ]

En caso de ocurrir algun error se retornara el codigo 404, con el mensaje 'No se pudo encontrar la tabla'.

## Paginacion:
Para obtener los Productos paginados debo cargar los parametros mediante la url con las palabras clave pagina(indica la pagina que quiero ver), y cantidad(indica la cantidad de productos que quiero ver por pagina), quedaria algo asi ?pagina=2&cantidad=2, esto retornaria un JSON con el codigo 200 en caso de ejecutarse correctamente, que se vera asi:

    "data": 
        [
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
        ],
        "Paginacion": {
            "Pagina": "2",
            "TotalPaginas": 2,
            "DatosPorPagina": "2",
            "TotalDatos": 4
        }


## Metodo GET con ID:
mediante el endpoint producto/:id, se obtendra especificamente el producto solicitado, por ejemplo, "producto/5" en caso de ejecutarse correctamente se devolvera un arreglo con todos los datos del producto y el codigo 200:

    {
        "id_producto": 5,
        "nombre": "Comedero Elevado ",
        "descripcion": "Comedero elevado, de 30cm para perros de raza grande.\r\nApto para la prevencion de enfermedades relacionadas a la columna.",
        "imagen": "https://i.pinimg.com/564x/ae/9a/87/ae9a8752535d8a00ec151006133a94b9.jpg",
        "fk_categoria": 9,
        "precio": 0,
        "destacado": 1,
        "categoria": "Caninos"
    }

En caso de no existir el producto con el id solicitado se retornara el mensaje 'No existe con el id:'.$id y el codigo 401.

## Metodos DELETE,POST,PUT:
Para poder acceder a utilizar estos metodos será obligatorio que el usuario esté autorizado *ver Authorization*.

## Metodo DELETE:
Para eliminar un producto se utilizara el endpoint producto/:id con el metodo delete, por ejemplo, producto/3, en caso de efectuarse la eliminacion se me retornara un mensaje 'se pudo eliminar correctamente el producto con el id:'.$id y el codigo 200, en caso de que el producto a eliminar no existiera me retornaran un mensaje de 'el producto con el id:'.$id .no existe con el codigo 404.

## Metodo PUT:
Para modificar un producto se hará mediante el endpoint producto/:id el cual indicara cual es el producto a modificar,con el metodo PUT, en caso  de existir el producto se tomaran todos los datos que el usuario envia mediante el body para efectuar la modificacion, en caso que haya algun campo vacio  se notificara con el mensaje 'Faltan completar campos', y el codigo 401.
Si estan todos los datos correctamente se confirmara la modificacion mostrando el producto modificado y el codigo 200. En caso de que ocurra cualquier error inseperado con la modificacion se enviara un mensaje 'Ocurrio un error al modificar el producto' y el codigo 500.
Si el producto a modificar no existe se enviara el mensaje 'No existe el producto con el id'.$id, con el codigo 404.

## Metodo POST: 
Para añadir un nuevo producto se usara el endpoint api/producto con el metodo POST, se tomaran los datos que el usuario haya ingresado desde el body, en caso de existir algun campo vacio se enviara un mensaje 'Faltan completar campos ' y el codigo 401.
Si existe el Producto, quiere decir que se creo exitosamente, se enviara el mensaje 'se creo exitosamente', acompañado del nuevo producto y el codigo 201. Si el producto no existe se enviara una notificacion de error 'Ocurrio un error al crear el producto' con el codigo 401.


       




