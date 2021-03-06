<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace common\models\wechat\base;

use Yii;

/**
 * This is the base-model class for table "wechat_fans_mp".
 *
 * @property integer $mp_id
 * @property integer $fans_id
 * @property string $nickname
 * @property string $city
 * @property string $country
 * @property string $province
 * @property string $language
 * @property string $union_id
 * @property string $remark
 * @property integer $sex
 * @property integer $group_id
 * @property integer $subscribe_time
 * @property integer $updated_at
 *
 * @property \common\models\wechat\WechatFans $fans
 * @property string $aliasModel
 */
abstract class WechatFansMp extends \yii\db\ActiveRecord
{


    const SEX_MEN = 1;//男
    const SEX_WOMEN = 2;//女
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_fans_mp';
    }

    /**
     * Alias name of table for crud viewsLists all Area models.
     * Change the alias name manual if needed later
     * @return string
     */
    public function getAliasModel($plural=false)
    {
        if($plural){
            return Yii::t('common', 'WechatFansMps');
        }else{
            return Yii::t('common', 'WechatFansMp');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fans_id', 'sex', 'group_id', 'subscribe_time', 'updated_at'], 'integer'],
            [['country', 'group_id'], 'required'],
            [['nickname', 'province', 'remark'], 'string', 'max' => 255],
            [['city'], 'string', 'max' => 32],
            [['country'], 'string', 'max' => 512],
            [['language'], 'string', 'max' => 40],
            [['union_id'], 'string', 'max' => 30],
            [['fans_id'], 'exist', 'skipOnError' => true, 'targetClass' => WechatFans::className(), 'targetAttribute' => ['fans_id' => 'fans_id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mp_id' => Yii::t('common', 'Mp ID'),
            'fans_id' => Yii::t('common', 'Fans ID'),
            'nickname' => Yii::t('common', '身份证正反照片'),
            'city' => Yii::t('common', '城市区域'),
            'country' => Yii::t('common', '国家'),
            'province' => Yii::t('common', '省份'),
            'language' => Yii::t('common', '用户语言'),
            'union_id' => Yii::t('common', '备注'),
            'remark' => Yii::t('common', '备注'),
            'sex' => Yii::t('common', '性别 1男 2女'),
            'group_id' => Yii::t('common', '分组ID'),
            'subscribe_time' => Yii::t('common', '关注时间'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(
            parent::attributeHints(),
            [
            'mp_id' => Yii::t('common', 'Mp Id'),
            'fans_id' => Yii::t('common', 'Fans Id'),
            'nickname' => Yii::t('common', '身份证正反照片'),
            'city' => Yii::t('common', '城市区域'),
            'country' => Yii::t('common', '国家'),
            'province' => Yii::t('common', '省份'),
            'language' => Yii::t('common', '用户语言'),
            'union_id' => Yii::t('common', '备注'),
            'remark' => Yii::t('common', '备注'),
            'sex' => Yii::t('common', '性别 1男 2女'),
            'group_id' => Yii::t('common', '分组ID'),
            'subscribe_time' => Yii::t('common', '关注时间'),
            'updated_at' => Yii::t('common', 'Updated At'),
            ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFans()
    {
        return $this->hasOne(\common\models\wechat\WechatFans::className(), ['fans_id' => 'fans_id']);
    }

    /**
     * [optsSex description]
     * @return [type] [description]
     */
    public static function optsSex(){
        return [
            self::SEX_MEN       =>  Yii::t('common','男'),
            self::SEX_WOMEN     =>  Yii::t('common','女'),
        ];
    }
    /**
     * [getSexValueLabel description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function getSexValueLabel($value){
        $label = self::optsSex();
        if(isset($label[$value])){
            return $label[$value];
        }
        return $value;
    }

    /**
     * get column status enum value label
     * @param string $value
     * @return string
     */
    public static function getStatusValueLabel($value){
        $labels = self::optsStatus();
        if(isset($labels[$value])){
            return $labels[$value];
        }
        return $value;
    }




}
