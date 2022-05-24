<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id_usuario
 * @property string $nombres_usuario
 * @property string $apellido_paterno_usuario
 * @property string $apellido_materno_usuario
 * @property string $genero_usuario
 * @property string|null $fecha_nacimiento_usuario
 * @property string|null $lugar_nacimiento_usuario
 * @property string|null $ubicacion_actual_usuario
 * @property string $ocupacion_usuario
 * @property string $correo_usuario
 * @property string|null $correo_alternativo_usuario
 * @property string|null $telefono_usuario
 * @property string $celular_usuario
 * @property string|null $ci_usuario
 * @property string|null $lugar_expedito_ci_usuario
 * @property string|null $imagen_usuario
 * @property string|null $estado_civil_usuario
 *
 * @property Integrante[] $integrantes
 * @property User[] $users
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombres_usuario', 'apellido_paterno_usuario', 'apellido_materno_usuario', 
            'genero_usuario', 'fecha_nacimiento_usuario', 'lugar_nacimiento_usuario', 
            'ubicacion_actual_usuario', 'ocupacion_usuario', 'correo_usuario', 
            'celular_usuario', 'estado_civil_usuario'], 'required'],
            [['nombres_usuario', 'apellido_paterno_usuario', 'apellido_materno_usuario', 'lugar_nacimiento_usuario', 'ubicacion_actual_usuario', 'ocupacion_usuario', 'correo_usuario', 'correo_alternativo_usuario', 'telefono_usuario', 'celular_usuario', 'ci_usuario', 'lugar_expedito_ci_usuario', 'imagen_usuario', 'estado_civil_usuario'], 'string'],
            [['correo_usuario', 'correo_alternativo_usuario','email'],'match','pattern'=>'/^[a-zA-Z0-9]\/'],
            [['fecha_nacimiento_usuario'], 'safe'],
            [['genero_usuario'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'nombres_usuario' => 'Nombres Usuario',
            'apellido_paterno_usuario' => 'Apellido Paterno Usuario',
            'apellido_materno_usuario' => 'Apellido Materno Usuario',
            'genero_usuario' => 'Genero Usuario',
            'fecha_nacimiento_usuario' => 'Fecha Nacimiento Usuario',
            'lugar_nacimiento_usuario' => 'Lugar Nacimiento Usuario',
            'ubicacion_actual_usuario' => 'Ubicacion Actual Usuario',
            'ocupacion_usuario' => 'Ocupacion Usuario',
            'correo_usuario' => 'Correo Usuario',
            'correo_alternativo_usuario' => 'Correo Alternativo Usuario',
            'telefono_usuario' => 'Telefono Usuario',
            'celular_usuario' => 'Celular Usuario',
            'ci_usuario' => 'Ci Usuario',
            'lugar_expedito_ci_usuario' => 'Lugar Expedito Ci Usuario',
            'imagen_usuario' => 'Imagen Usuario',
            'estado_civil_usuario' => 'Estado Civil Usuario',
        ];
    }

    /**
     * Gets query for [[Integrantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_usuario' => 'id_usuario']);
    }
}
