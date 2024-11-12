<?php
require_once 'app/models/user.model.php';
require_once 'app/views/user.view.php';

use \Firebase\JWT\JWT;
class UserApiController {
    private $model;
    private $view;

    public function __construct(){
        $this->model = new UsersApiModel();
        $this->view = new UserApiView();
    }

    public function verificarUser($req){
        $UserName = $req->body->UserName;
        $Password = $req->body->Password;

        $user = $this->model->GetUsuario($UserName);

        if ($user && password_verify($Password, $user->contraseña)) {
            // Generar datos del payload
            $payload = [
                'hora' => time(), //cuando se creo
                'exp' => time() + 3600, //cuando vence
                'user_id' => $user->id,
                'es_admin' => $user->es_admin //verifico si el usuario es admin
            ];

            // Llave secreta para firmar el token
            $secretKey = "trabajoWeb";

            // Generar el JWT
            $jwt = JWT::encode($payload, $secretKey, 'HS256');

            return $this->view->response(["token" => $jwt], 200);
        }

        return $this->view->response("No se pudo autenticar el usuario", 404);
    }
}

?>