<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Integrante;

/**
 * integranteSearch represents the model behind the search form of `app\models\Integrante`.
 */
class integranteSearch extends Integrante
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_integrante', 'id_usuario', 'id_evento', 'id_tipo_valoracion'], 'integer'],
            [['tipo_integrante'], 'safe'],
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
        $query = Integrante::find();

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
            'id_integrante' => $this->id_integrante,
            'id_usuario' => $this->id_usuario,
            'id_evento' => $this->id_evento,
            'id_tipo_valoracion' => $this->id_tipo_valoracion,
        ]);

        $query->andFilterWhere(['ilike', 'tipo_integrante', $this->tipo_integrante]);

        return $dataProvider;
    }
}
