<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordValue $model
*/
    
$this->title = Yii::t('backend', 'Student Record Value') . " " . $model->student_record_value_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Record Value'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->student_record_value_id, 'url' => ['view', 'student_record_value_id' => $model->student_record_value_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud student-record-value-update">

    <h1>
        <?= Yii::t('backend', 'Student Record Value') ?>
        <small>
                        <?= $model->student_record_value_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'student_record_value_id' => $model->student_record_value_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
