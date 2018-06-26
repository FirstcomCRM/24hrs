<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use common\models\Tests;
use common\models\OfflineOrder;

class TestsController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $searchModel = new Tests();
        $industry = $searchModel->getIndustry();
        //$dummy = [];
      // echo '<pre>';
        //print_r($industry);die();
    /*  foreach ($industry as $k => $v) {
        $dummy [] = $v['value'];
      }
      echo '<pre>';
      print_r($dummy);
      die();*/
      //  print_r(gettype($industry));die();
        $dataProvider = $searchModel->getResults(Yii::$app->request->queryParams);
    //    print_r($dataProvider);die();
    //    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      //  print_r($dataProvider);die();
    //    $searchModel->industry = 'test';
    //    print_r($test);die();
        return $this->render('index',[
          'searchModel'=>$searchModel,
          'industry'=>$industry,
          'dataProvider'=>$dataProvider,
        ]);

      /*  ini_set("memory_limit", "64M");
        $dates = new \DateTime();
        $ndate = $dates->format('Y-m-d');
      //  $ndate = $dates->modify('-1 day')->format('Y-m-d');
        Yii::$app->db->createCommand()->update('offline_order',['status'=>5],['status'=>1,'delivery_date'=>$ndate] )->execute();

        $query = new Query();
        $data = $query->select('a.order_id,a.order_status_id,b.delivery_date,b.collection_date')
            ->from('order a')
            ->where(['a.order_status_id'=>1, 'b.delivery_date'=>$ndate])
            ->orWhere(['a.order_status_id'=>1, 'b.collection_date'=>$ndate])
          //  ->andWhere(['b.delivery_date'=>$ndate])
            ->leftJoin('order_product b', 'b.order_id = a.order_id')
            ->groupBy('a.order_id')
            ->all();
        foreach ($data as $key => $value) {
          Yii::$app->db->createCommand()->update('order',['order_status_id'=>5],['order_id'=>$value['order_id'] ] )->execute();
          echo 'coode executed'.$ndate;
        }
        die('work');*/
    }

    public function actionTest(){
      //die();
      $searchModel = new Tests();
      $searchModel->refreshToken();
      Yii::$app->session->setFlash('success', "Token Refreshed");
      return $this->redirect(['index']);
    }

}
