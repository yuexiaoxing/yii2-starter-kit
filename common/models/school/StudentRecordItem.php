<?php

namespace common\models\school;

use Yii;

/**
 * This is the model class for table "{{%student_record_item}}".
 *
 * @property integer $student_record_item_id
 * @property integer $student_record_title_id
 * @property integer $student_record_id
 * @property string $body
 * @property integer $status
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $created_at
 */
class StudentRecordItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student_record_item}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('campus');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_record_title_id', 'student_record_id', 'body', 'updated_at', 'created_at'], 'required'],
            [['student_record_title_id', 'student_record_id', 'status', 'sort', 'updated_at', 'created_at'], 'integer'],
            [['body'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student_record_item_id' => Yii::t('common', '自增ID'),
            'student_record_title_id' => Yii::t('common', '标题ID'),
            'student_record_id' => Yii::t('common', '学员档案ID'),
            'body' => Yii::t('common', '学员档案条目描述'),
            'status' => Yii::t('common', '1：正常；0标记删除；2待审核；'),
            'sort' => Yii::t('common', '默认与排序'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\StudentRecordItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\StudentRecordItemQuery(get_called_class());
    }
}
