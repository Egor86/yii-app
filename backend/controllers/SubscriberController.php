<?php

namespace backend\controllers;

use common\models\Coupon;
use Yii;
use common\models\Subscriber;
use backend\models\search\SubscriberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubscriberController implements the CRUD actions for Subscriber model.
 */
class SubscriberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'sorting' => [
                'class' => \kotchuprik\sortable\actions\Sorting::className(),
                'query' => Subscriber::find(),
                'orderAttribute' => 'sort_by'

            ]
        ];
    }
    /**
     * Lists all Subscriber models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubscriberSearch();
//        $list_id = 'd4e475d3f6';        TODO: create cron extention to update  mail_chimp_status periodically
//        $emails = Subscriber::find()->select('mail_chimp_leid')->asArray()->all();
//        $email_list = [];
//
//        for($i = 0; $i < count($emails); $i++){
//            $email_list[]['leid'] = $emails[$i]['mail_chimp_leid'];
//        }
//
//        $mailchimp = new \Mailchimp(\Yii::$app->params['mailchimpAPIkey']);
//        $list_id = $mailchimp->lists->memberInfo($list_id, $email_list);
//
//        for ($j = 0; $j < count($list_id['data']); $j++){
//            $subscriber = Subscriber::findOne(['mail_chimp_leid' => $list_id['data'][$j]['leid']]);
//            if ($subscriber){
//                if($subscriber->mail_chimp_status != $list_id['data'][$j]['status']){
//                    $subscriber->mail_chimp_status = $list_id['data'][$j]['status'];
//                    $subscriber->save();
//                }
//            }
//        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subscriber model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
//        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Subscriber model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subscriber();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Subscriber model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Subscriber model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Subscriber model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subscriber the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscriber::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
