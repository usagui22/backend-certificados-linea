<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unidad".
 *
 * @property int $id_unidad
 * @property string $nombre
 * @property string $abreviacion
 * @property string $telefono
 * @property string $sitio_web
 * @property string|null $correo
 * @property string|null $telefono_alternativo
 * @property string $direccion
 * @property int $responsable
 *
 * @property Evento[] $eventos
 */
class Unidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'abreviacion', 'telefono', 'sitio_web', 'direccion'], 'required'],
            [['nombre', 'abreviacion', 'telefono', 'sitio_web', 'correo', 'telefono_alternativo', 'direccion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_unidad' => 'Id Unidad',
            'nombre' => 'Nombre',
            'abreviacion' => 'Abreviacion',
            'telefono' => 'Telefono',
            'sitio_web' => 'Sitio Web',
            'correo' => 'Correo',
            'telefono_alternativo' => 'Telefono Alternativo',
            'direccion' => 'Direccion',
            'responsable' => 'Responsable',
        ];
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::className(), ['id_unidad' => 'id_unidad']);
    }
}
