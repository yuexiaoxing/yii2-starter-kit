<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\school\StudentRecordTitle;

/**
 * StudentRecordTitleSearch represents the model behind the search form about `common\models\school\StudentRecordTitle`.
 */
class StudentRecordTitleSearch extends StudentRecordTitle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_record_title_id', 'status', 'sort', 'updated_at', 'created_at'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = StudentRecordTitle::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'student_record_title_id' => $this->student_record_title_id,
            'status' => $this->status,
            'sort' => $this->sort,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
