<?php
use yii\helpers\Html;
 // echo'<pre>';var_dump($category);
?>

<div class="gdu-content">
  <div class="row">
    <!-- 左边侧边栏 -->
    <?php
      echo $this->render('@frontend/themes/gedu/article/common/sidebarnew',[
       'category'=>$category
       ]);
    ?>
    <!-- 文章内容部分 -->
    <div class="col-md-8 ">

    <div class="box box-widget geu-content">
            <div class="box-header with-border box-header with-border ">
                <ol class="breadcrumb" style="margin-bottom: -10px">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                  <?php if(!empty($category['parent'])){?>
                  <li><?php echo Html::a($category['pare_name'],['article/index','category_id'=>$model->category_id])?></li>
                  <?php }?>
                  <li><?php echo Html::a($category['self'],['article/index','category_id'=>$model->category_id])?></li>
                  <li class="activeli"><?php echo $model->title;?></li>
                </ol>
            </div>
            <div class="box-body">
              <?php echo $model->body;?>
            </div>
      </div>
    </div>
  </div>
</div>