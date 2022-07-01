<?php
namespace app\controllers;

use app\models\AccountDataEmail;
use app\models\Rol;
use app\models\RolUsuario;
use app\models\Unidad;
use app\models\Usuario;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class UsuarioController extends Controller{
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
    private function verificarResponsable($id){
        $usuario = Unidad::find()
        ->where(["responsable"=>$id])
        ->one();

        if($usuario){
            return true;
        }else{
            return false;
        }
    }
    public function actionGetUsuarios(){
        $usuarios = Usuario::find()
        ->select(["id", "nombres", "apellido_materno", "apellido_paterno"])
        ->all();
        $array = [];
        foreach($usuarios as $usuario){
            $exist = $this->verificarResponsable($usuario["id"]);
            if(!$exist){
                array_push($array, $usuario);
            }
        }

        return [
            "status" => true,
            "usuarios" => $array
        ];
    }
    public function actionRegistrarExcel(){
        $res = null;
        $params = Yii::$app->request->getBodyParams();
        $excel = UtilController::getArrayExcel($params['excelb64']);
//        return $excel;
        $participantes = $excel['participantes'];
        $path = $excel['path'];
//        print_r($params);
//        exit();
        foreach ($participantes as $p){
            $exist = Usuario::find()->where(["correo" => $p["correo"]])->one();
            if(!$exist){
                $cuenta = $this->crearCuenta($p);
                if($cuenta){
                    Yii::$app->response->statusCode = 200;
                    $res =[
                        "status"=>true,
                        "msg" =>'cuentra creada exitosamente'
                    ];
                }else{
                    Yii::$app->response->statusCode = 400;
                    $res = [
                        "status" => false,
                        "msg" => "Algo salio mal al crear cuentas, envie nuevamente su archivo.",
                    ];
                }
            }
        }

//        $data =null;
//        $exist = Usuario::find()
//            ->where(["email" => $data["email"]])
//            ->one();
//
//        if($exist){
//
//        }else{
//            $cuenta = $this->crearCuenta($data);
//        }
        return $res;
    }

    protected  function crearCuenta($p){
//        print_r($p);
//        exit();
        $model = new Usuario();
        $model->nombres = $p['nombres'];
        $model->apellido_materno = $p['apellido_materno'];
        $model->apellido_paterno = $p['apellido_paterno'];
        $model->correo = $p['correo'];
        $pwd = UtilController::generatePassword();
        $model->password_hash = $pwd;
        if($model->save()){
            if(UtilController::asignarRol($model->id)){
                $email = new AccountDataEmail();
                if($email->Account($model)){
                return $model;
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }
        return $model;
    }
    
    public function actionDatos($id){
        $usuario = Usuario::findOne($id);
        $rolUser= RolUsuario::find()->where(['id_usuario'=>$usuario['id']])->one();
        $rol=Rol::findOne($rolUser['id_rol']);
        $response=[
            'nombres'=>$usuario->nombres,
            'apellido_paterno'=>$usuario->apellido_paterno,
            'apellido_materno'=>$usuario->apellido_materno,
            'rol'=>$rol->rol
        ];
        return $response;
    }
    
    public function actionEditarUsuario($id){
        $usuario=Usuario::findOne($id);
        $msj=null;
        $nuevo = Yii::$app->request->getBodyParams();
        if(!isset($nuevo)){
            $usuario->attributes=$nuevo;
            if($usuario->validate()){
                $usuario->save();
                $msj=["actualizado"=>true,"usuario"=>$usuario];
            }else{
                $msj=["actualizado"=>false,"usuario"=>$usuario->getErrors()];
            }
        }
        return $msj;
    }
    
    public function actionListarUsuario(){
        return Usuario::find()->all();
    }
    public function actionListarCargos(){
        $cargos=Rol::find()
        ->select(["id_rol","nombre"])        
        ->all();        
                
        return $cargos;
    }

    public function actionRegistrarUsuario(){
        $usuario=new Usuario();
        $params = Yii::$app->request->getBodyParams();
        $me="";
        if(isset($usuario)){
            $usuario->attributes=$params;                        
            $pass = UtilController::generatePassword();
            $usuario->password_hash = $pass;

            if($usuario->validate()){
                $usuario->save();
                $me=["ok"=>true,"usuario"=>$usuario];
                if(UtilController::asignarRol($usuario->id)){
                    $email = new AccountDataEmail();
                    if($email->Account($usuario)){
                    return $usuario;
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            }else{
                $me=["ok"=>false,"usuario"=>$usuario->getErrors()];
            }
        }
        return $me;
    }
   
}
