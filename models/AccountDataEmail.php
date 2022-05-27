<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AccountDataEmail extends Model
{
    public $name = "Sistema de certificado digital";
    public $email = "yurguen0071@gmail.com";
    public $subject = "Informacion de cuenta";
    public $body = "Body prueba";

    //    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }


    public function Account($usuario)
    {
        $email = $usuario['correo'];
        $nombres = $usuario['nombres'].' '.$usuario['apellido_paterno'].' '.$usuario['apellido_materno'];
        $pwd = $usuario['password_hash'];
        $content = "<h2 align='center'>Cuenta de participante</h2>";
        $content .= "<h4>Estimado ".$nombres." su cuenta se registro con exito en el evento EVENTO#1, las credenciales para ingrear a https://cert..ummss.com</h4>";
        $content .= "<div style='text-align:center'> <h6>Correo: " .$email." </h6><h6>Contraseña: ".$pwd." </h6></div>";
        $content .=" <P>Ingrese al sistema de certificados con las credenciales proporcionados, la contraseña es provisional puede cambiarla cuando lo requiera.</p>";

//        print_r($content);
//        exit();
        if ($this->validate()) {
            Yii::$app->mailer->compose("@app/mail/layouts/html", ["content"=>$content])
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
            return true;
        }
        return false;
    }
}