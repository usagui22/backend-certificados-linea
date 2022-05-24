<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property string $nombres
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $genero
 * @property string $fecha_nacimiento
 * @property string|null $lugar_nacimiento
 * @property string|null $ubicacion_actual
 * @property string $ocupacion
 * @property string $correo
 * @property string|null $correo_alternativo
 * @property string|null $telefono
 * @property string|null $celular
 * @property string $ci
 * @property string|null $lugar_expedito_ci
 * @property string|null $imagen
 * @property string|null $estado_civil
 * @property int $id
 *
 * @property Integrante[] $integrantes
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
            [['nombres', 'apellido_paterno', 'apellido_materno', 'genero', 'fecha_nacimiento', 'ocupacion', 'correo', 'ci'], 'required'],
            [['nombres', 'apellido_paterno', 'apellido_materno', 'lugar_nacimiento', 'ubicacion_actual', 'ocupacion', 'correo', 'correo_alternativo', 'telefono', 'celular', 'ci', 'lugar_expedito_ci', 'imagen', 'estado_civil'], 'string'],
            [['fecha_nacimiento'], 'safe'],
            [['genero'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nombres' => 'Nombres',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'genero' => 'Genero',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'lugar_nacimiento' => 'Lugar Nacimiento',
            'ubicacion_actual' => 'Ubicacion Actual',
            'ocupacion' => 'Ocupacion',
            'correo' => 'Correo',
            'correo_alternativo' => 'Correo Alternativo',
            'telefono' => 'Telefono',
            'celular' => 'Celular',
            'ci' => 'Ci',
            'lugar_expedito_ci' => 'Lugar Expedito Ci',
            'imagen' => 'Imagen',
            'estado_civil' => 'Estado Civil',
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[Integrantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrante::className(), ['id_usuario' => 'id']);
    }
}
