<?php

namespace backend\controllers;

use Yii;
use common\models\Order;
use common\models\OrderSearch;
use common\models\OfflineOrder;
use common\models\EmailForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->today_search(Yii::$app->request->queryParams);//default query

        $searchModel_future = new OrderSearch();
        $dataProvider_future = $searchModel_future->future_search(Yii::$app->request->queryParams);//query, get records two days from now till 2years

        $searchModel_done = new OrderSearch();
        $dataProvider_done = $searchModel_done->completed_search(Yii::$app->request->queryParams); //get all orders that are  completed

        $searchModel_cancel = new OrderSearch();
        $dataProvider_cancel = $searchModel_done->canceled_search(Yii::$app->request->queryParams); //get all orders that are  completed

        //  $searchModel_done->order_status_id = 5; //completed order
      //  $time = date('Y-m-d H:i:s');
        //echo "<pre>";var_dump($dataProvider_done);echo "</br>";die();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider_done'=> $dataProvider_done,
            'dataProvider_future'=>$dataProvider_future,
            'dataProvider_cancel'=>$dataProvider_cancel,
        //    'time'=>$time,
      ]);

              /*  return $this->render('indextest', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'dataProvider_done'=> $dataProvider_done,
                    'dataProvider_future'=>$dataProvider_future,
                    'dataProvider_cancel'=>$dataProvider_cancel,
                //    'time'=>$time,
              ]);*/
    }

    public function actionHome(){
      $searchModel = new OrderSearch();
    //  $searchModel->order_status_id  = 1;//pending order
    //  $searchModel->order_id = 4416;
  //    $searchModel->start  = date('Y-m-d');
    //  $date = new \DateTime($searchModel->start);
  //    $searchModel->end = $date->modify('+1 day')->format('Y-m-d');
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);//default query

      $searchModel_future = new OrderSearch();
      $searchModel_future->order_status_id = 1;
      $start_date = date('Y-m-d');
      $date = new \DateTime(date('Y-m-d') );
      $searchModel_future->start = $date->modify('+2 day')->format('Y-m-d');
      $searchModel_future->end = $date->modify('+2 year')->format('Y-m-d');
      $dataProvider_future = $searchModel_future->search(Yii::$app->request->queryParams);//query, get records two days from now till 2years

    // print_r($searchModel_future->end);
    //  die();

      $searchModel_done = new OrderSearch();
      $searchModel_done->order_status_id = 5; //completed order
      $dataProvider_done = $searchModel_done->search(Yii::$app->request->queryParams); //get all orders that are  completed
    //  $time = date('Y-m-d H:i:s');


      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'dataProvider_done'=> $dataProvider_done,
          'dataProvider_future'=>$dataProvider_future,
      //    'time'=>$time,
      ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //Function changed status to Complete
    public function actionComplete($id,$off_detect){
        if ($off_detect == '77') {
          $data = OfflineOrder::find()->where(['id'=>$id])->one();
          $data->status = 5;
          $data->save(false);
        }else{
          $data = Order::find()->where(['order_id'=>$id])->one();
          $data->order_status_id = 5;
          $data->save(false);
        }

        Yii::$app->session->setFlash('success', "Order Completed");
        return $this->redirect(['index']);
    }

    //Function changed status to Cancel
    public function actionCancel($id,$off_detect){
        if ($off_detect == '77') {
          $data = OfflineOrder::find()->where(['id'=>$id])->one();
          $data->status = 7;
          $data->save(false);
        }else{
          $data = Order::find()->where(['order_id'=>$id])->one();
          $data->order_status_id = 7;
          $data->save(false);
        }

        Yii::$app->session->setFlash('success', "Order Cancelled");
        return $this->redirect(['index']);
    }

    //Function changed status to Shipped
    public function actionShip($id,$off_detect){
        if ($off_detect == '77') {
          $data = OfflineOrder::find()->where(['id'=>$id])->one();
          $data->status = 3;
          $data->save(false);
        }else{
          $data = Order::find()->where(['order_id'=>$id])->one();
          $data->order_status_id = 3;
          $data->save(false);
        }

        Yii::$app->session->setFlash('success', "Order Shipped");
        return $this->redirect(['index']);
    }

    public function actionEmail($id){

//      ini_set('max_execution_time', 180);
//      ini_set("memory_limit", "512M");
        $data = Order::find()->where(['order_id'=>$id])->one();
        $name = $data->firstname.' '. $data->lastname;
        $message = "<p>Greetings, {$name}</p>";
        $message .= "<p>The items has been delivered</p>";
        $message .= '<p>Thank you.</p>';

       $mail = Yii::$app->mailer->compose()
        //  ->setTo($data->email)
          ->setTo('eumerjoseph.ramos@yahoo.com')
          ->setFrom(['no-reply@cityflorist.com' => 'no-reply@cityflorist.com'])
      //    ->setCc($testcc) //temp
          ->setSubject('Item delivered')
          ->setHtmlBody($message);
          //->send()
       if ($mail->send() ) {
         Yii::$app->session->setFlash('success', "Email sent to customer");
       }else{
        Yii::$app->session->setFlash('error', "Email failed");
      }
      //  return $this->redirect(['index']);

    }

    //Function that sends an email to the customer
    //$id = order id of either offline or online Order
    //$invoice_no - invoice no. means to determine whether to use Online order or offline order
    public function actionCustomEmail($id,$invoice_no, $off_detect){
        $model = new EmailForm();

        if ($off_detct != '0') {
          $data = Order::find()->where(['order_id'=>$id])->one();
          $model->email = $data->email;
        }else{
          $data = OfflineOrder::find()->where(['id'=>$id])->one();
          $model->email = $data->email;
        }

        $model->title = 'Invoice:'.$invoice_no;

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
      //    $ccs = explode(",",$model->cc);
          $ccs = 'jerry@24hrscityflorist.com';
          $msg = nl2br($model->message);
        //  print_r($msg);
        //  die();
          $mail = Yii::$app->mailer->compose()
           //  ->setTo($data->email)
             ->setTo($model->email)
             ->setFrom(['no-reply@cityflorist.com' => 'no-reply@cityflorist.com'])
             ->setCc($ccs) //temp
             ->setSubject($model->title)
             ->setHtmlBody($msg)
             ->send();
        //  echo '<pre>';
        //  print_r($mail);die();
         if ($mail ) {
           Yii::$app->session->setFlash('success', "Email sent to customer");
         }else{
           Yii::$app->session->setFlash('error', "Email failed");
         }
         return $this->redirect(['index']);

        }else{
          return $this->renderAjax('_email', [
              'model' => $model,
          ]);
        }
    }

    //function update remarks on either offline or online orders
    public function actionUpdateRemark($id){
      $model = $this->findModel($id);
      if ($model->load(Yii::$app->request->post())   ) {
        $model->save(false);
        Yii::$app->session->setFlash('success', "Online order remark updated");
        return $this->redirect(['order/index']);
      }else{
        return $this->render('_remarks', [
            'model' => $model,
            //'modelLine'=>$modelLine,
            //'dataProvider'=>$dataProvider,
        ]);
      }

    }

    //function a dummy function
    public function actionTest($id){
      print_r($id);die();
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
