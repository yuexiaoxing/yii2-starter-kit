<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\controllers\base;

use backend\modules\campus\models\FileStorageItem;
    use backend\modules\campus\models\search\FileStorageItemSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* FileStorageItemController implements the CRUD actions for FileStorageItem model.
*/
class FileStorageItemController extends Controller
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
                        'roles' => ['CampusFileStorageItemFull'],
                    ],
    [
    'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['CampusFileStorageItemView'],
                    ],
    [
    'allow' => true,
                        'actions' => ['update', 'create', 'delete'],
                        'roles' => ['CampusFileStorageItemEdit'],
                    ],
    
                ],
            ],
    ];
    }

/**
* Lists all FileStorageItem models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new FileStorageItemSearch;
    $dataProvider = $searchModel->search($_GET);

Tabs::clearLocalStorage();

Url::remember();
\Yii::$app->session['__crudReturnUrl'] = null;

return $this->render('index', [
'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
]);
}

/**
* Displays a single FileStorageItem model.
* @param integer $file_storage_item_id
*
* @return mixed
*/
public function actionView($file_storage_item_id)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($file_storage_item_id),
]);
}

/**
* Creates a new FileStorageItem model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new FileStorageItem;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'file_storage_item_id' => $model->file_storage_item_id]);
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
* Updates an existing FileStorageItem model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $file_storage_item_id
* @return mixed
*/
public function actionUpdate($file_storage_item_id)
{
$model = $this->findModel($file_storage_item_id);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing FileStorageItem model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $file_storage_item_id
* @return mixed
*/
public function actionDelete($file_storage_item_id)
{
try {
$this->findModel($file_storage_item_id)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$file_storage_item_id',',');
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
* Finds the FileStorageItem model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $file_storage_item_id
* @return FileStorageItem the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($file_storage_item_id)
{
if (($model = FileStorageItem::findOne($file_storage_item_id)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}