<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * usuarioSearch represents the model behind the search form of `app\models\Usuario`.
 */
class usuarioSearch extends Usuario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario'], 'integer'],
            [['nombres_usuario', 'apellido_paterno_usuario', 'apellido_materno_usuario', 'genero_usuario', 'fecha_nacimiento_usuario', 'lugar_nacimiento_usuario', 'ubicacion_actual_usuario', 'ocupacion_usuario', 'correo_usuario', 'correo_alternativo_usuario', 'telefono_usuario', 'celular_usuario', 'ci_usuario', 'lugar_expedito_ci_usuario', 'imagen_usuario', 'estado_civil_usuario'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Usuario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_usuario' => $this->id_usuario,
            'fecha_nacimiento_usuario' => $this->fecha_nacimiento_usuario,
        ]);

        $query->andFilterWhere(['ilike', 'nombres_usuario', $this->nombres_usuario])
            ->andFilterWhere(['ilike', 'apellido_paterno_usuario', $this->apellido_paterno_usuario])
            ->andFilterWhere(['ilike', 'apellido_materno_usuario', $this->apellido_materno_usuario])
            ->andFilterWhere(['ilike', 'genero_usuario', $this->genero_usuario])
            ->andFilterWhere(['ilike', 'lugar_nacimiento_usuario', $this->lugar_nacimiento_usuario])
            ->andFilterWhere(['ilike', 'ubicacion_actual_usuario', $this->ubicacion_actual_usuario])
            ->andFilterWhere(['ilike', 'ocupacion_usuario', $this->ocupacion_usuario])
            ->andFilterWhere(['ilike', 'correo_usuario', $this->correo_usuario])
            ->andFilterWhere(['ilike', 'correo_alternativo_usuario', $this->correo_alternativo_usuario])
            ->andFilterWhere(['ilike', 'telefono_usuario', $this->telefono_usuario])
            ->andFilterWhere(['ilike', 'celular_usuario', $this->celular_usuario])
            ->andFilterWhere(['ilike', 'ci_usuario', $this->ci_usuario])
            ->andFilterWhere(['ilike', 'lugar_expedito_ci_usuario', $this->lugar_expedito_ci_usuario])
            ->andFilterWhere(['ilike', 'imagen_usuario', $this->imagen_usuario])
            ->andFilterWhere(['ilike', 'estado_civil_usuario', $this->estado_civil_usuario]);

        return $dataProvider;
    }
}
