# TPE_3
 ## Nombre de los integrantes del grupo:
 Tatiana Pereyra(tati25pereyra@gmail.com) 
 Zoe Gonzalez(zoegonzalez461@gmail.com).

 ## Descripcion y funcionalidad de la API: 
   La api esta pensada y desarrollada para trabajar con una base de datos de productos y categorias. Se desarrollaron los respectivos endpoints y metodos necesarios para que la api sea rest full.

## Metodo Login:
Para poder autenticarse, en la api se debe accerder al endpoint api/login. 
Luego se debe completar el body del request con los datos "UserName" y Password. Para que funcione, se debe completar "Webadmin" y "admin" respectivamente:
{
    {
        "UserName" = "Webadmin",
        "Password" = "admin"
    }
}

Esa es la forma visual que deberia tener el request antes de enviarlo. Se envia con el metodo _POST_.
Como respuesta, en caso de que los datos ingresados sean correctos y coincidan con los almacenados en la base de datos, se le brindara al usuario el token creado y el código de estado 200 que indica que se pudo autenticar correctamente:
{
    {
        "(token generado aleatoriamente)",
        200 OK
    }
}
En caso contrario, que el usuario no exista o la contraseña sea incorrecta devolverá dl mensaje de error y el codigo 404 que indica que no fue encontrado: 
{
    {
        "No se pudo autenticar al usuario",
        404 NOT FOUND
    }
}

