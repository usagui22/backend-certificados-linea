<?php
namespace app\controllers;

use app\models\RolUsuario;
use app\models\Usuario;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class AuthController extends Controller{
    /**
     * @inheritDoc
     */
    public function init()
    {
        Yii::warning(getallheaders());
        parent::init();
    }

    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT');
            Yii::$app->end();
        }
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionLogin(){
        $params = Yii::$app->request->getBodyParams();
        $usuario = Usuario::find()
        ->where(["correo" => $params["correo"]])
        ->one();

        if($usuario){
            if(Yii::$app->getSecurity()->validatePassword($params['password'],$usuario->password_hash)){
                $response = [
                    "status" => true,
                    "msg" => "Login existoso"
                ];
            }else{
                Yii::$app->response->statusCode = 500;
                $response = [
                    "status" => false,
                    "msg"=> "Verifique sus datos"
                ];
            }
        }else{
            Yii::$app->response->statusCode = 500;
            $response = [
                "status" => false,
                "msg"=> "Verifique sus datos"
            ];
        }
        return $response;
    }
    public function actionRegister(){
        $res = null;
        $params = Yii::$app->getRequest()->getBodyParams();
        
        $usuario = Usuario::find()
            ->where(["correo" => $params["correo"]])
            ->one();
        if($usuario){
            Yii::$app->response->statusCode = 200;
            $res = [
                "status" => true,
                "msg" => "Login exitoso",
                //                "token" =>$usuario->access_token
            ];
        }else{
            $usuarioRegistrado = $this->registrarUsuario($params);
            if($usuarioRegistrado){
                Yii::$app->response->statusCode = 200;
                $res = [
                    "status" => true,
                    "msg" => "Login existoso",
                    //                    "token" => $usuarioRegistrado->access_token
                ];
            }else{
                Yii::$app->response->statusCode = 400;
                $res = [
                    "status" => false,
                    "msg" => "Revise sus datos",
                ];
            }
        }
        return $res;
    }

    public function actionLoginGoogle(){
        $res = null;
        $params = Yii::$app->getRequest()->getBodyParams();
        $usuario = Usuario::find()
            ->where(["correo" => $params["correo"]])
            ->one();
        if($usuario){
            Yii::$app->response->statusCode = 200;
            $res = [
                "status" => true,
                "msg" => "Login exitoso",
//                "token" =>$usuario->access_token
            ];
        }else{
            $usuarioRegistrado = $this->registrarUsuarioGoogle($params);
            if($usuarioRegistrado){
                Yii::$app->response->statusCode = 200;
                $res = [
                    "status" => true,
                    "msg" => "Login existoso",
//                    "token" => $usuarioRegistrado->access_token
                ];
            }else{
                Yii::$app->response->statusCode = 400;
                $res = [
                    "status" => false,
                    "msg" => "Revise sus datos",
                ];
            }
        }
        return $res;
    }

    protected function registrarUsuarioGoogle($data){
        $usuario = [
            "nombres"=>$data['nombres'],
            "apellido_paterno"=>$data['apellido_paterno'],
            "apellido_materno"=>$data['apellido_materno'],
            "correo"=>$data['correo'],
        ];
        $model = new Usuario($usuario);
        if($model->save()){
            if($this->asignarRol($model->id, "PTTE")){
                return $model;
            }else{
                return null;
            }
        }
    }
    protected function registrarUsuario($data){
        // $usuario = [
        //     "nombres"=>$data['nombres'],
        //     "apellido_paterno"=>$data['apellido_paterno'],
        //     "apellido_materno"=>$data['apellido_materno'],
        //     "genero"=>$data['genero'],
        //     "fecha_nacimiento" => $data['fecha_nacimiento'],
        //     "lugar_nacimiento" => $data['lugar_nacimiento'],
        //     "direccion_actual"=>$data['direccion_actual'],
        //     "ocupacion"=>$data['ocupacion'],
        //     "correo"=>$data['correo'],
        //     "correo_alternativo"=>$data['correo_aleternativo'],
        //     "telefono"=>$data['telefono'],
        //     "ci"=>$data['ci'],
        //     "lugar_expedto_ci"=>$data['lugar_expedito_ci'],
        //     "imagen"=>$data['imagen'],
        //     "estado_civil"=>$data['estado_civil'],
        // ];
        $contra = Yii::$app->getSecurity()->generatePasswordHash("123456789");
        print_r($contra);
        $model = new Usuario($data);
        if($model->save()){

            if($this->asignarRol($model->id, "PTTE")){
                return $model;
            }else{
                return null;
            }
        }
        return $model;
    }
    protected function asignarRol($id_usuario, $rol)
    {
        $data = [
            "id_usuario"=>$id_usuario,
            "id_rol"=>2
        ];
        $model = new RolUsuario($data);
        if($model->save()){
            return true;
        }else{
            return false;
        }
    }
}