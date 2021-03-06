<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "users_to_school".
 *
 * @property integer $user_to_school_id
 * @property integer $user_id
 * @property integer $school_id
 * @property integer $user_title_id_at_school
 * @property integer $status
 * @property integer $sort
 * @property integer $school_user_type
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $aliasModel
 */
abstract class UserToSchool extends \yii\db\ActiveRecord
{

    const SCHOOL_USER_TYPE_TEACHER  = 20; //老师
    const SCHOOL_USER_TYPE_STUDENTS = 10; // 学生
    const SCHOOL_USER_TYPE_DIRECTOR = 30; //主任
    const SCHOOL_USER_TYPE_LEADER   = 40; //校长
    const SCHOOL_USER_TYPE_WORKER   = 50; //职工

    const SCHOOL_STATUS_ACTIVE  = 1; //正常
    const SCHOOL_STATUS_CLOSE   = 0; //关闭
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
    */
    public static function getDb()
    {
        return Yii::$app->get('campus');
    }

    public static function optsUserType(){
        return [
            self::SCHOOL_USER_TYPE_LEADER   => '校长',
            self::SCHOOL_USER_TYPE_DIRECTOR => '主任',
            self::SCHOOL_USER_TYPE_TEACHER  => '老师',
            self::SCHOOL_USER_TYPE_STUDENTS => '学生',
            self::SCHOOL_USER_TYPE_WORKER   => '职工',
        ];
    }
    public static function optsUserStatus(){
        return [
            self::SCHOOL_STATUS_ACTIVE   => '正常',
            self::SCHOOL_STATUS_CLOSE => '关闭',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
       preg_match("/dbname=([^;]+)/i", self::getDb()->dsn, $matches);
       return  $matches[1].'.users_to_school';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'school_id'], 'required'],
            [['user_id', 'school_id', 'user_title_id_at_school', 'status', 'sort', 'school_user_type'], 'integer'],
        /*    [
                'school_user_type','integer','when'=>function($model,$attribute){
                    $models = self::find()->where([
                            'user_id'=>$model->user_id,
                            'school_user_type'=>$model->school_user_type,
                            'school_id'       => $model->school_id,
                        ])->one();
                    if($models && ($models->user_to_school_id != $model->user_to_school_id)){
                        $model->addError($attribute,'用户在此学校已拥改职称,请去列表查看');
                    }
                }
            ]*/
        //     [['user_id', 'school_id'], 'unique', 'targetAttribute' => ['user_id', 'school_id'], 'message' => 'The combination of 用户ID and 学校ID has already been taken.']
         ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_to_school_id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', '用户'),
            'school_id' => Yii::t('common', '学校'),
            'user_title_id_at_school' => Yii::t('common', '用户在学校的描述性展示Title，没有逻辑'),
            'status' => Yii::t('common', '状态'),
            'sort' => Yii::t('common', '显示排序'),
            'school_user_type' => Yii::t('common', '用户关系'),
            'updated_at' => Yii::t('common', '更新时间'),
            'created_at' => Yii::t('common', '创建时间'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'user_id' => Yii::t('common', '用户ID'),
            'school_id' => Yii::t('common', '学校ID'),
            'user_title_id_at_school' => Yii::t('common', '用户在学校的描述性展示Title，没有逻辑'),
            'status' => Yii::t('common', '1：正常；0标记删除；2待审核；3已经转班; '),
            'sort' => Yii::t('common', '显示排序'),
            'school_user_type' => Yii::t('common', '用户关系类型：用户类型：教师；学生；家长；'),
        ]);
    }

    public function getUser(){
        return  $this->hasOne(\common\models\User::className(),['id'=>'user_id']);
    }
    public function getSchool(){
        return  $this->hasOne(\backend\modules\campus\models\School::className(),['school_id'=>'school_id']);
    }
    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\query\UesrToSchool the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\campus\models\query\UserToSchool(get_called_class());
    }


}
