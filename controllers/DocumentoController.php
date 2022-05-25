<?php
namespace app\controllers;

use app\models\Documento;
use app\models\Evento;
use app\models\Plantilla;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class DocumentoController extends Controller{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'crear-documento' => ['POST'],
                        'actualizar-documento'=>['POST'],
                        'eliminar-documento'=>['POST','GET']
                    ],
                ],
            ]
        );
    }

    public function actionCrearDocumento()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $documento = new Documento();
        $params=Yii::$app->request->getBodyParams();        
        $clave="crypt";
        //$this->ruleta(5);
        //$clave=crypt();
        if (isset($params)) {
            $documento['tipo_documento']=$params['tipo_documento'];
            $documento['hash']=Yii::$app->getSecurity()->generatePasswordHash($clave);
            //$documento['hash']=sha1($clave);
            //$documento['confirmado']=preguntarEstado();
            $documento['id_tipo_documento']=$this->selectTipo($params['nombre_documento']);
            $documento['id_evento']=$this->selectEvento($params['nombre_evento']);
            if ($documento->validate()&&$documento->save()) {
                return $documento;
              
            }else {
                return $documento->getErrors();
                }
        }          
    }

    public function actionActualizarDocumento($id_ac)
    {
        $documento = Documento::findOne($id_ac);        
        
        if(isset($documento)){
            $documento->tipo_documento=Yii::$app->request->getBodyParam('tipo_documento');
            if($documento->validate()){
                $documento->save();
                return $documento;        
            }else{
                return $documento->getErrors();
            }
        }        
        
    }

    public function actionEliminarDocumento($id_doc_eli)
    {        
        return Documento::findOne($id_doc_eli)->delete()?print_r("eliminado exitosamente"):print_r("id no encontrado");
    }

    private function selectEvento($nameEvento){
        $id_res=null;
        $evento=Evento::find()
        ->select('id_evento')
        ->where(['nombre_evento' => $nameEvento])
        ->one();
        $id_res=$evento['id_evento'];
        return $id_res;
    }
    private function selectTipo($nameTipo)
    {   
        $id_encontrado=null;
        $tipo=Plantilla::find()
        ->select('id_tipo_documento')
        ->where(['nombre_documento'=>$nameTipo])
        ->one();
        $id_encontrado = $tipo['id_tipo_documento'];
        return $id_encontrado;
    }
    // private function ruleta($vueltas){
    //     $claveRes=null;  
    //     $banco="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    //     if($vueltas>=1){
    //         for($v=1;$v<=$vueltas;$v++){
    //             $claveRes=str_shuffle($banco);
    //         }
    //     }
    //     return $claveRes;
    // }
}