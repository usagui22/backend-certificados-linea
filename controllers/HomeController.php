<?php

namespace app\controllers;

use app\models\Usuario;
use Yii;
use yii\rest\ActiveController;

class HomeController extends ActiveController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin(){
        
        $id=Yii::$app->usuario->isGuest->getmygid;
        $usuario=Usuario::findOne($id);
        
    }
    

}
