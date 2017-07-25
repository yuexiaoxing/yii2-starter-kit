<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\controllers\base;

use backend\modules\campus\models\CoursewareToFile;
use backend\modules\campus\models\Courseware;
use backend\modules\campus\models\search\CoursewareSearch;
use common\components\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use Yii;

/**
* CoursewareController implements the CRUD actions for Courseware model.
*/
class CoursewareController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
    return [
    'access' => [
    'class' => AccessControl::className(),
    'rules' => [
    [
    'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['CampusCoursewareFull'],
                    ],
    [
    'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['CampusCoursewareView'],
                    ],
    [
    'allow' => true,
                        'actions' => ['update', 'create', 'delete'],
                        'roles' => ['CampusCoursewareEdit'],
                    ],
    
                ],
            ],
    ];
    }

/**
* Lists all Courseware models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new CoursewareSearch;
    $dataProvider = $searchModel->search($_GET);
    //var_dump(!Yii::$app->user->can('manager'));exit;
    if((Yii::$app->user->can('manager')) || (Yii::$app->user->can('E_manager')) ){
    }else{
        $dataProvider->query->andWhere([
                'status'=>Courseware::COURSEWARE_STATUS_VALID
        ]);
    }
    Tabs::clearLocalStorage();

    Url::remember();
    \Yii::$app->session['__crudReturnUrl'] = null;

    return $this->render('index', [
    'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
    ]);
}

/**
* Displays a single Courseware model.
* @param integer $courseware_id
*
* @return mixed
*/
public function actionView($courseware_id)
{
    $model = $this->findModel($courseware_id);
    $counts = CoursewareToFile::find()->where(['courseware_id'=>$courseware_id])->count();
    if($model->file_counts != $counts){
        $model->file_counts = $counts;
        $model->save();
    }
    

    \Yii::$app->session['__crudReturnUrl'] = Url::previous();
    Url::remember();
    Tabs::rememberActiveState();

    return $this->render('view', [
    'model' => $model,
    ]);
}

/**
* Creates a new Courseware model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
    $model = new Courseware;
    //$model->setJsonBody();exit;
    try {
    if ($model->load($_POST)) {
        //$model->data = [];
        //var_dump($model->save());exit;
        // if(!empty($model->target) && !empty($model->process)){
        //     $body = ArrayHelper::merge(['target'=>$model->target],['process'=>$model->process]);
        //     //var_dump($body);exit;
        //     $model->body = json_encode($body,JSON_UNESCAPED_UNICODE);
            if($model->save()){
                return $this->redirect(['view', 'courseware_id' => $model->courseware_id]);
            }
        //}
    } elseif (!\Yii::$app->request->isPost) {
    $model->load($_GET);
    }
    } catch (\Exception $e) {
    $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
    $model->addError('_exception', $msg);
    }
    return $this->render('create', ['model' => $model]);
}

/**
* Updates an existing Courseware model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $courseware_id
* @return mixed
*/
public function actionUpdate($courseware_id)
{
    $model = $this->findModel($courseware_id);
    $model->getJsonBody();
    if($model->target == NULL){
        $model->target = $model->body;
    }
    //var_dump($model->process);exit;
    // if($model->body){
    //     $data = json_decode($model->body,true);
    //     $model->process = isset($data['process']) ? $data['process'] : '';
    //     $model->target = isset($data['target']) ? $data['target'] : $model->body;
    // }
    $model->body = [];
    if ($model->load($_POST)) {
        
        // if(!empty($model->target) && !empty($model->process)){
        //     $body = ArrayHelper::merge(['target'=>$model->target],['process'=>$model->process]);
        //     //var_dump($body);exit;
        //     $model->body = json_encode($body,JSON_UNESCAPED_UNICODE);
            if($model->save()){
                //return $this->redirect(['view', 'courseware_id' => $model->courseware_id]);
                return $this->redirect(Url::previous());
            //}
        }
    } else {
    return $this->render('update', [
    'model' => $model,
    ]);
    }
}

/**
* Deletes an existing Courseware model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $courseware_id
* @return mixed
*/
public function actionDelete($courseware_id)
{
try {
$this->findModel($courseware_id)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$courseware_id',',');
if ($isPivot == true) {
return $this->redirect(Url::previous());
} elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
Url::remember(null);
$url = \Yii::$app->session['__crudReturnUrl'];
\Yii::$app->session['__crudReturnUrl'] = null;

return $this->redirect($url);
} else {
return $this->redirect(['index']);
}
}

/**
* Finds the Courseware model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $courseware_id
* @return Courseware the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($courseware_id)
{
if (($model = Courseware::findOne($courseware_id)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
