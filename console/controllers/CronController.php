<?php

namespace console\controllers;

use Yii;
use yii\db\Command;
use yii\console\Controller;
use common\models\OfflineOrder;
use common\models\Order;
use common\models\OrderProduct;
use yii\db\Query;

class CronController extends Controller
{

    public function actionSetCompleted(){
      ini_set("memory_limit", "64M");
      $dates = new \DateTime();
      $ndate = $dates->format('Y-m-d');
    //  $ndate = $dates->modify('-1 day')->format('Y-m-d');
      Yii::$app->db->createCommand()->update('offline_order',['status'=>5],['status'=>1,'delivery_date'=>$ndate] )->execute();

      $query = new Query();
      $data = $query->select('a.order_id,a.order_status_id,b.delivery_date')
          ->from('order a')
          ->where(['a.order_status_id'=>1])
          ->andWhere(['b.delivery_date'=>$ndate])
          ->leftJoin('order_product b', 'b.order_id = a.order_id')
          ->all();
      foreach ($data as $key => $value) {
        Yii::$app->db->createCommand()->update('order',['order_status_id'=>5],['order_id'=>$value['order_id'] ] )->execute();
        echo 'coode executed'.$ndate;
      }
    //   echo 'success the run for reduc date '.$ndate.' then true date value is'.$cur->format('Y-m-d');
    }

}
