<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecord $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '学生档案');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'student_record_id' => $model->student_record_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud student-record-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '学生档案') ?>
        <small>
            <?= $model->title ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', 'Edit'),
            [ 'update', 'student_record_id' => $model->student_record_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', 'Copy'),
            ['create', 'student_record_id' => $model->student_record_id, 'StudentRecord'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', 'Full list'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\StudentRecord'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            [
            'attribute'=>'user_id',
            'value'=>function($model){
                return isset($model->user->username) ? $model->user->username : '';
                }
            ],
            [
            'attribute'=>'school_id',
            'value'=>function($model){
            return isset($model->school->school_title) ? $model->school->school_title : '';
                }
            ],
            [
                'attribute'=>'grade_id',
                'value'=>function($model){
                    return isset($model->grade->grade_name) ? $model->grade->grade_name  : '';
                }
            ],
            [
                'attribute'=>'course_id',
                'label'    => '课程标题',
                'value'=>function($model){
                    return isset($model->course->title) ? $model->course->title  : '';
                }
            ],
            'title',
            'status',
            'sort',
            'updated_at:datetime',
            'created_at:datetime'
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'student_record_id' => $model->student_record_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->student_record_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\StudentRecord'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
