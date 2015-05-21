<?php

namespace app\controllers;

use Yii;
use app\models\News;
use app\models\NewsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Category;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                    ],
		    [
                        'allow' => true,
			'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

	//save model twice, to know ID for file name
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    $this->saveFile($model);
	    if( !$model->filename || $model->save() )
                return $this->redirect(['view', 'id' => $model->id]);
        } 

	$categories = ArrayHelper::merge( [ '0' => '-'], ArrayHelper::map(Category::find()->all(), 'id', 'title'));
        return $this->render('create', [ 'model' => $model, 'categories' => $categories]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    $this->saveFile($model);
	    if( !$model->filename || $model->save() )
        	return $this->redirect(['view', 'id' => $model->id]);
        }

	$categories = ArrayHelper::merge( [ '0' => '-'], ArrayHelper::map(Category::find()->all(), 'id', 'title'));
        return $this->render('update', [
            'model' => $model, 'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	$model = $this->findModel($id);
	if( is_file( $model->filename ) )
	    unlink( $model->filename);

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an image from News.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if there is no model
     */

    public function actionClearImg($id)
    {
	$model = $this->findModel($id);
	if( is_file( $model->filename ) )
	    unlink( $model->filename);

        $model->filename = "";
	if( $model->save() )
	{
	    return $this->redirect(['index']);
	} else {
            throw new NotFoundHttpException('Can\'t errase image.');
        }
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Save file from user input.
     * @param News model
     * @return nothing
     */
    protected function saveFile(&$model)
    {
	$model->file = \yii\web\UploadedFile::getInstance($model, 'file');
        if ($model->file && $model->validate()) {
	    $model->filename = Yii::$app->params['pics_dir']. $model->id ."." . $model->file->extension;
            $model->file->saveAs( $model->filename );
        }
    }
}
