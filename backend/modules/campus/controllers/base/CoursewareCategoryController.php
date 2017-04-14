<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/358b0e44f1c1670b558e36588c267e47
 *
 * @package default
 */


// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\controllers\base;

use backend\modules\campus\models\CoursewareCategory;
use backend\modules\campus\models\search\CoursewareCategorySearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
 * CoursewareCategoryController implements the CRUD actions for CoursewareCategory model.
 */
class CoursewareCategoryController extends Controller
{


	/**
	 *
	 * @var boolean whether to enable CSRF validation for the actions in this controller.
	 * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	 */
	public $enableCsrfValidation = false;

	/**
	 *
	 * @inheritdoc
	 * @return unknown
	 */
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'view', 'create', 'update', 'delete'],
						'roles' => ['CampusCoursewareCategoryFull'],
					],
					[
						'allow' => true,
						'actions' => ['index', 'view'],
						'roles' => ['CampusCoursewareCategoryView'],
					],
					[
						'allow' => true,
						'actions' => ['update', 'create', 'delete'],
						'roles' => ['CampusCoursewareCategoryEdit'],
					],

				],
			],
		];
	}


	/**
	 * Lists all CoursewareCategory models.
	 *
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel  = new CoursewareCategorySearch;
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
	 * Displays a single CoursewareCategory model.
	 *
	 * @param integer $category_id
	 * @return mixed
	 */
	public function actionView($category_id) {
		\Yii::$app->session['__crudReturnUrl'] = Url::previous();
		Url::remember();
		Tabs::rememberActiveState();

		return $this->render('view', [
				'model' => $this->findModel($category_id),
			]);
	}


	/**
	 * Creates a new CoursewareCategory model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new CoursewareCategory;

		try {
			if ($model->load($_POST) && $model->save()) {
				return $this->redirect(['view', 'category_id' => $model->category_id]);
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}

		$parent_category = CoursewareCategory::find()
		    ->where(['status' => CoursewareCategory::CATEGORY_STATUS_OPEN])
		    ->asArray()->all();
		$parent_category = ArrayHelper::map($parent_category,'category_id','name');

		return $this->render('create', [
			'model' => $model,
			'parent_category' => $parent_category
		]);
	}


	/**
	 * Updates an existing CoursewareCategory model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $category_id
	 * @return mixed
	 */
	public function actionUpdate($category_id) {
		$model = $this->findModel($category_id);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			$parent_category = CoursewareCategory::find()
				->where(['<>','category_id',$model->category_id])
			    ->andWhere(['status' => CoursewareCategory::CATEGORY_STATUS_OPEN])
			    ->asArray()->all();
			$parent_category = ArrayHelper::map($parent_category,'category_id','name');
			return $this->render('update', [
					'model' => $model,
					'parent_category' => $parent_category
				]);
		}
	}


	/**
	 * Deletes an existing CoursewareCategory model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $category_id
	 * @return mixed
	 */
	public function actionDelete($category_id) {
		try {
			$this->findModel($category_id)->delete();
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			\Yii::$app->getSession()->addFlash('error', $msg);
			return $this->redirect(Url::previous());
		}


		// TODO: improve detection
		$isPivot = strstr('$category_id', ',');
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
	 * Finds the CoursewareCategory model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @throws HttpException if the model cannot be found
	 * @param integer $category_id
	 * @return CoursewareCategory the loaded model
	 */
	protected function findModel($category_id) {
		if (($model = CoursewareCategory::findOne($category_id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}


}
