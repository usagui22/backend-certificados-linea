<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "integrante".
 *
 * @property int $id_integrante
 * @property int $id_usuario
 * @property int $id_evento
 * @property int|null $id_tipo_valoracion
 * @property string|null $tipo_integrante
 *
 * @property Evento $evento
 * @property TipoValoracion $tipoValoracion
 * @property Usuario $usuario
 */
class Integrante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'integrante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_evento'], 'required'],
            [['id_usuario', 'id_evento', 'id_tipo_valoracion'], 'default', 'value' => null],
            [['id_usuario', 'id_evento', 'id_tipo_valoracion'], 'integer'],
            [['tipo_integrante'], 'string'],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['id_evento' => 'id_evento']],
            [['id_tipo_valoracion'], 'exist', 'skipOnError' => true, 'targetClass' => TipoValoracion::className(), 'targetAttribute' => ['id_tipo_valoracion' => 'id_tipo_valoracion']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_integrante' => 'Id Integrante',
            'id_usuario' => 'Id Usuario',
            'id_evento' => 'Id Evento',
            'id_tipo_valoracion' => 'Id Tipo Valoracion',
            'tipo_integrante' => 'Tipo Integrante',
        ];
    }

    /**
     * Gets query for [[Evento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::className(), ['id_evento' => 'id_evento']);
    }

    /**
     * Gets query for [[TipoValoracion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoValoracion()
    {
        return $this->hasOne(TipoValoracion::className(), ['id_tipo_valoracion' => 'id_tipo_valoracion']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id_usuario' => 'id_usuario']);
    }
}
