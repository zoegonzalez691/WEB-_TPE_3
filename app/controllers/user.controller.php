<?php
require_once 'app/models/user.model.php';
require_once 'app/views/user.view.php';
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
            // Generar token único
            $token = bin2hex(random_bytes(16));
            $this->model->SubirToken($user->usuario_id, $token);

            return $this->view->response($token, 200);
        }

        return $this->view->response("No se pudo autenticar el usuario", 404);
    }
}
