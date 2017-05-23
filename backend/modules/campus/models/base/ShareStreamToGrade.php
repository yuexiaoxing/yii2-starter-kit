<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\School;
use yii\helpers\ArrayHelper;

/**
 * This is the base-model class for table "share_stream_to_grade".
 *
 * @property integer $share_stream_id
 * @property string $school_id
 * @property string $grade_id
 * @property integer $status
 * @property integer $auditor_id
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $aliasModel
 */
abstract class ShareStreamToGrade extends \yii\db\ActiveRecord
{


    public $school_ids = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'share_stream_to_grade';
    }
    public static function getDb(){
        return Yii::$app->get('campus');
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
            [['share_stream_id'], 'required'],
            [['status', 'auditor_id'], 'integer'],
            ['status','default','value'=>10],
            [['school_id', 'grade_id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'share_stream_id' => Yii::t('backend', 'Share Stream ID'),
            'school_id' => Yii::t('backend', '学校 ID'),
            'grade_id' => Yii::t('backend', '班级id'),
            'status' => Yii::t('backend', '状态'),
            'updated_at' => Yii::t('backend', '更新时间'),
            'created_at' => Yii::t('backend', ' 创建时间'),
            'auditor_id' => Yii::t('backend', '审核者'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'grade_id' => Yii::t('backend', '审核人'),
            'status' => Yii::t('backend', '状态'),
            'auditor_id' => Yii::t('backend', '审核者'),
        ]);
    }
    /**
     * 获取授权展示的学校班级
     * @return [type] [description]
     */
    public function data_init($share_stream_id){
        $model = self::find()
        ->where(['share_stream_id'=>$share_stream_id])
        ->with(['school','grade'])
        ->groupBy(['grade_id'])
        ->asArray()
        ->all();
        $data = [];
        //.','.$value['school_id']
        foreach ($model as $key => $value) {
            $data['school'][$value['school_id']] = $value['school']['school_title'];
            $data['grade'][$value['grade_id']]   = $value['grade']['grade_name'];
        }
        return $data;
    }

    public function batch_create($data){

        if(empty($data['school_id']) && !isset($data['school_id'])){
            return false;
        }
        $datas = [];
        $school = $this->getGrades($data['school_id']);
       //获取班级
        foreach ($school as $key => $value) {
           if(isset($data['grade_id']) && !empty($data['grade_id'])){
                if(in_array($value['grade_id'],$data['grade_id'])){
                        $datas[]  = $value;
                        $this->school_ids[] = $value['school_id'];
                        continue;
                }
            }
            //var_dump($this->school_ids);exit;
            if(empty($this->school_ids) || !in_array($value['school_id'] ,$this->school_ids)){
                $datas[]  = $value;
            }else{
                continue;
            }

        }
         foreach ($datas as  $v) {
            $model = new $this;
            $v['share_stream_id'] = $data['share_stream_id'];
            $model->load($v,'');
            $model->save();
         }
         return true;
     }

    /**
     * 获取某个学校下边的全部班级
     * @param  [type] $school_id [description]
     * @return [type]            [description]
     */
    public function getGrades($school_id){
        return Grade::find()->select(['school_id','grade_id'])->where(['school_id'=>$school_id])->asArray()->all();
    }

    public function getSchool(){
        return $this->hasOne(School::className(),['school_id'=>'school_id']);
    }
    public function getGrade(){
        return $this->hasOne(Grade::className(),['grade_id'=>'grade_id']);
    }
    /**
     * 获取下拉框学校班级数据
     * @return [type] [description]
     */
    public function getList($type = 0, $id = []){
        if($type == 0){
             $school = School::find()
            ->asArray()
            ->all();
            return ArrayHelper::map($school,'school_id','school_title');
        }
        if($type == 1){
            $data = [];
            $grade = Grade::find()->where(['school_id'=>$id])->with('school')->asArray()->all();
          foreach ($grade as $key => $value) {
              // $keys = $value['grade_id'].','.$value['school']['school_id'];
               $data[$value['school']['school_title']][$value['grade_id']] = $value['grade_name'];

          }
          //var_dump($data);exit;
         return $data;
        }
    }
    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\query\ShareStreamToGradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\campus\models\query\ShareStreamToGradeQuery(get_called_class());
    }


}
