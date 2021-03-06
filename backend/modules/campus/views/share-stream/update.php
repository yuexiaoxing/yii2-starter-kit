<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStream $model
*/
    
$this->title = Yii::t('backend', '分享消息流') . " " . $model->share_stream_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Share Stream'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->share_stream_id, 'url' => ['view', 'share_stream_id' => $model->share_stream_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud share-stream-update">

    <h1>
        <?= Yii::t('backend', '分享消息流') ?>
        <small>
                        <?= $model->share_stream_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'share_stream_id' => $model->share_stream_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    'shareToGrade'=>$shareToGrade,
     'message'=>isset($message) ? $message : NULL,
    ]); ?>

</div>
