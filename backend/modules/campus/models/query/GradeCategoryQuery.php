<?php

namespace backend\modules\campus\models\query;

/**
 * This is the ActiveQuery class for [[\backend\modules\campus\models\GradeCategroy]].
 *
 * @see \backend\modules\campus\models\GradeCategroy
 */
class GradeCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\GradeCategroy[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\GradeCategroy|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
