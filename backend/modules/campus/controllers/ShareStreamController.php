<?php

namespace backend\modules\campus\controllers;

use Yii;
use yii\web\Response;
use backend\modules\campus\models\ShareStreamToGrade;
use backend\modules\campus\models\ShareStream;
use yii\helpers\Html;
/**
* This is the class for controller "ShareStreamController".
*/
class ShareStreamController extends \backend\modules\campus\controllers\base\ShareStreamController
{
   
    public function actionCreate(){
        $model = new ShareStream;
        $data = [];
        if($_POST){
            $data = $model->batch_create($_POST);
            if(empty($data->getErrors())){
                return $this->redirect(['index']);;
            }
        }
        return $this->render('create',['model'=>$model,'model1'=>$data]);
    }
    /**
     * 发布分享授权
     * @return [type] [description]
     */
    public function actionAuthorization($share_stream_id = FALSE)
    {
        $model = new ShareStreamToGrade;

        //获取默认授权班级数据
        $default_data = $model->data_init($share_stream_id);

        if($_POST){
            if (!$share_stream_id) {
                $share_stream_id = $_POST['ShareStreamToGrade']['share_stream_id'];
            }

            ShareStreamToGrade::deleteAll(
                ['share_stream_id'=>$share_stream_id]
            );

            $info = $model->batch_create($_POST['ShareStreamToGrade']);
Yii::$app->response->format = Response::FORMAT_JSON;
                return 200;

        }

        return $this->renderAjax('authorization',[
            'model'        =>$model,
            'default_data' =>$default_data
        ]);
    }

    public function actionAjaxForm(){
         $model = new ShareStreamToGrade;
        if($_GET['id']){
            $model = $model->getList($_GET['type_id'],$_GET['id']);
            foreach ($model as  $k=>$v) {
                 echo '<optgroup label = '.$k .'>';
                foreach ($v as $key => $value) {
                    //var_dump($value);exit;
                    echo Html::tag('option',Html::encode($value),array('value'=>$key));
                }
            }
        }
    }
}
