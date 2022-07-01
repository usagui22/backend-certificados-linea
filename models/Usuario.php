<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property string $nombres
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string|null $genero
 * @property string|null $fecha_nacimiento
 * @property string|null $lugar_nacimiento
 * @property string|null $direccion_actual
 * @property string|null $ocupacion
 * @property string|null $correo
 * @property string|null $correo_alternativo
 * @property string|null $telefono
 * @property string|null $celular
 * @property string|null $ci
 * @property string|null $lugar_expedito_ci
 * @property string|null $imagen
 * @property string|null $estado_civil
 * @property int $id
 * @property string|null $password_hash
 * @property string|null $created_at
 * @property string|null $update_at
 * @property int|null $id_rol
 * @property int|null $codsis
 *
 * @property Integrante[] $integrantes
 * @property Rol $rol
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
            [['nombres', 'apellido_paterno', 'apellido_materno'], 'required'],
            [['nombres', 'apellido_paterno', 'apellido_materno', 'lugar_nacimiento', 'direccion_actual', 'ocupacion', 'correo', 'correo_alternativo', 'telefono', 'celular', 'ci', 'lugar_expedito_ci', 'imagen', 'estado_civil', 'password_hash'], 'string'],
            [['fecha_nacimiento', 'created_at', 'update_at'], 'safe'],
            [['id_rol', 'codsis'], 'default', 'value' => null],
            [['id_rol', 'codsis'], 'integer'],
            [['genero'], 'string', 'max' => 1],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['id_rol' => 'id_rol']],
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
            'direccion_actual' => 'Direccion Actual',
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
            'password_hash' => 'Password Hash',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'id_rol' => 'Id Rol',
            'codsis' => 'Codsis',
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

    /**
     * Gets query for [[Rol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id_rol' => 'id_rol']);
    }
}
