<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rol".
 *
 * @property int $id_rol
 * @property string $rol
 * @property string|null $descripcion
 *
 * @property RolUsuario[] $rolUsuarios
 */
class Rol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rol'], 'required'],
            [['rol', 'descripcion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_rol' => 'Id Rol',
            'rol' => 'Rol',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * Gets query for [[RolUsuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRolUsuarios()
    {
        return $this->hasMany(RolUsuario::className(), ['id_rol' => 'id_rol']);
    }
}
