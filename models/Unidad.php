<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unidad".
 *
 * @property int $id_unidad
 * @property string $nombre_unidad
 * @property string $abreviatura_unidad
 * @property string $telefono_unidad
 * @property string $pagina_referencia_unidad
 * @property string|null $correo_contacto_unidad
 * @property string|null $telefono_alternativo_unidad
 * @property string $ubicacion_unidad
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
            [['nombre_unidad', 'abreviatura_unidad', 'telefono_unidad', 'pagina_referencia_unidad', 'ubicacion_unidad'], 'required'],
            [['nombre_unidad'],'max'=>25],
            [['abreviatura_unidad'],'max'=>8],
            [['telefono_unidad','telefono_alternativo_unidad'],'max'=>20,'min'=>13],            
            [['correo_contacto_unidad'],'email','match','pattern'=>'/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/'],
            [['pagina_referencia_unidad'],'match','pattern'=>'/^(http+s?:\/\/)?(www\.)?[a-zA-Z.-]+\.[A-Za-z0-9./-]+$/'],
            [['ubicacion_unidad'],'match','pattern'=>'/^[A-Za-z0-9]+[+a-zA-Z0-9\s,]+\.?[A-Za-z\s.,]+$/'],
            [['nombre_unidad', 'abreviatura_unidad', 'telefono_unidad', 'pagina_referencia_unidad', 'correo_contacto_unidad', 'telefono_alternativo_unidad', 'ubicacion_unidad'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_unidad' => 'Id Unidad',
            'nombre_unidad' => 'Nombre Unidad',
            'abreviatura_unidad' => 'Abreviatura Unidad',
            'telefono_unidad' => 'Telefono Unidad',
            'pagina_referencia_unidad' => 'Pagina Referencia Unidad',
            'correo_contacto_unidad' => 'Correo Contacto Unidad',
            'telefono_alternativo_unidad' => 'Telefono Alternativo Unidad',
            'ubicacion_unidad' => 'Ubicacion Unidad',
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
