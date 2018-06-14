<?php

namespace console\controllers;

use Yii;
use yii\db\Command;
use yii\console\Controller;
use common\models\OfflineOrder;
use common\models\Order;
use common\models\OrderProduct;

class CronController extends Controller
{

    public function actionSetCompleted(){
      $dates = new \DateTime();
      $ndate = $dates->modify('-1 day')->format('Y-m-d');
  //    Yii::$app->db->createCommand()->update('offline_order',['status'=>5],'status=1' )->execute();
      Yii::$app->db->createCommand()->update('offline_order',['status'=>5],['status'=>1,'delivery_date'=>$ndate] )->execute();
      //Yii::$app->db->createCommand()->update('order',['order_status_id'=>5],'order_status_id=1' )->execute();
      $data = Order::find()->where(['order_status_id'=>1])->orderBy(['order_id'=>SORT_DESC])->asArray()->all();
      foreach ($data as $key => $value) {
          $ndata = OrderProduct::find()->where(['order_id'=>$value['order_id'] ])->asArray()->one();
          if ($ndate == $ndata['collection_date'] || $ndate == $ndata['delivery_date']) {
              Yii::$app->db->createCommand()->update('order',['order_status_id'=>5],['order_id'=>$ndata['order_id'] ] )->execute();
          }
      }



    }

}
