<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;
use yii\db\Query;
/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public $delivery_date;
    public $alt_invoice_no;
    public $invoice_date;
    public $id;

    public $start;
    public $end;
    public $product_code;


    public function rules()
    {
        return [
            [['order_id', 'store_id', 'customer_id', 'customer_group_id', 'payment_country_id', 'payment_zone_id', 'shipping_country_id', 'shipping_zone_id', 'order_status_id', 'affiliate_id', 'marketing_id', 'language_id', 'currency_id'], 'integer'],
            [['order_source', 'invoice_prefix', 'store_name', 'store_url', 'firstname', 'lastname', 'email', 'telephone', 'shipping_telephone', 'fax', 'custom_field',  'date_invoice','delivery_date','start','end','product_code', 'invoice_no'], 'safe'],
            [['total', 'commission', 'currency_value'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();
        //$query->joinWith('orderProduct','INNER_JOIN')->all();
      //  $query->joinWith(['orderProduct'])->select(['order.order_id,order.invoice_no,order.invoice_prefix.order.order_status_id']);

      //this one to use
      $query->joinWith(['orderProduct'])->select('order.order_id,order.invoice_no,order.invoice_prefix,order.order_status_id,order_product.delivery_date,
      order_product.product_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
              'pageSize'=>10,
            ],
        ]);

        $query->orderBy(['order_id'=>SORT_DESC]);
        $query->groupBy(['order.order_id']);

        //$query->add a cache function here
        $this->load($params);

        if (!empty($this->delivery_date)) {
          list($this->start,$this->end)= explode(' - ',$this->delivery_date);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
        //    'Order.order_id' => $this->order_id,
            'order.order_id' => $this->order_id,
            'invoice_no' => $this->invoice_no,
            'order_status_id'=>$this->order_status_id,

        ]);

        $query->andFilterWhere(['like', 'order_source', $this->order_source])
            ->andFilterWhere(['like', 'invoice_prefix', $this->invoice_prefix])
            ->andFilterWhere(['like', 'store_name', $this->store_name])
            ->andFilterWhere(['like', 'store_url', $this->store_url])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'order_product.delivery_date', $this->delivery_date])
            ->andFilterWhere(['between', 'order_product.delivery_date', $this->start, $this->end])
            ->andFilterWhere(['like', 'order_product.product_id', $this->product_code]);
        return $dataProvider;
    }

    public function today_search($params){

            /*$query_off = (new \yii\db\Query())
                ->select('a.id,a.invoice_no,a.status,a.invoice_date,b.del_date,b.del_time,b.item_code')
                ->from('offline_order a')
                ->leftJoin('offline_order_product b','b.off_order_id=a.id')
                ->groupBy(['a.id'])
                ->where(['a.status'=>1]);*/
            $query_off = (new \yii\db\Query())
                ->select('a.id,a.invoice_no,a.status,a.invoice_date,b.del_date,fu.delivery_time as del_time,b.item_code')
                ->from('offline_order a')
                ->leftJoin('offline_order_product b','b.off_order_id=a.id')
                ->leftJoin('delivery_time fu','fu.id=a.delivery_time')
                ->groupBy(['a.id'])
                ->where(['a.status'=>1]);

            $query_on = (new \yii\db\Query())
                ->select('c.order_id,c.invoice_no,c.order_status_id,c.date_invoice,d.delivery_date,d.delivery_text_time,d.product_id')
                ->from('order c')
                ->leftJoin('order_product d','d.order_id=c.order_id')
                ->groupBy(['c.order_id'])
                ->where(['c.order_status_id'=>1])
                ->andWhere(['!=','d.delivery_date','0000-00-00']);

            $query = (new \yii\db\Query())
                ->from(['dummy_name' => $query_off->union($query_on)]);
                //  ->orderBy(['del_date' => SORT_DESC]);

              //  echo '<pre>';
              //  print_r($query);


              $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                //    'sort'=> ['defaultOrder' => ['dadst'=>SORT_DESC]]

              ]);

              $dataProvider->setSort([
                'defaultOrder' => ['del_date'=>SORT_DESC],
                'attributes'=>[
                  'id',
                  'invoice_no',
                  'invoice_date',
                  'del_date',
                  'status',
                ],
              ]);

              $this->load($params);

              if (!$this->validate()) {
                  // uncomment the following line if you do not want to return any records when validation fails
                  // $query->where('0=1');
                  return $dataProvider;
              }




               //print_r($this->start);die();
              // grid filtering conditions
              $query->andFilterWhere([
                  'id' => $this->order_id,
                  'invoice_date' => $this->invoice_date,
              //    'del_date' => $this->delivery_date,
              ]);

              if (!empty($this->delivery_date)) {
                list($this->start,$this->end)= explode(' - ',$this->delivery_date);
                $this->start =  date('Y-m-d', strtotime($this->start) );
                $this->end =  date('Y-m-d', strtotime($this->end) );
                $query->andFilterWhere(['between', 'del_date', $this->start, $this->end]);

              //  die($this->end);
              }else{
                $this->start = date('Y-m-d');
                $date = new \DateTime($this->start);
                $this->end = $date->modify('+1 day')->format('Y-m-d');
                $query->andFilterWhere(['<=','del_date',$this->end]);
              }

              $query->andFilterWhere(['like', 'invoice_no', $this->invoice_no]);
              //      ->andFilterWhere(['between', 'del_date', $this->start, $this->end]);

              return $dataProvider;
          }

    public function future_search($params){
    /*  $query_off = (new \yii\db\Query())
          ->select('a.id,a.invoice_no,a.status,a.invoice_date,b.del_date,b.del_time,b.item_code')
          ->from('offline_order a')
          ->leftJoin('offline_order_product b','b.off_order_id=a.id')
          ->groupBy(['a.id'])
          ->where(['a.status'=>1]);*/
      $query_off = (new \yii\db\Query())
          ->select('a.id,a.invoice_no,a.status,a.invoice_date,b.del_date,fu.delivery_time as del_time,b.item_code')
          ->from('offline_order a')
          ->leftJoin('offline_order_product b','b.off_order_id=a.id')
          ->leftJoin('delivery_time fu','fu.id=a.delivery_time')
          ->groupBy(['a.id'])
          ->where(['a.status'=>1]);

      $query_on = (new \yii\db\Query())
          ->select('c.order_id,c.invoice_no,c.order_status_id,c.date_invoice,d.delivery_date,d.delivery_text_time,d.product_id')
          ->from('order c')
          ->leftJoin('order_product d','d.order_id=c.order_id')
          ->groupBy(['c.order_id'])
          ->where(['c.order_status_id'=>1])
          ->andWhere(['!=','d.delivery_date','0000-00-00']);

      $query = (new \yii\db\Query())
          ->from(['dummy_name' => $query_off->union($query_on)]);
          //  ->orderBy(['del_date' => SORT_DESC]);

        //  echo '<pre>';
        //  print_r($query);


        $dataProvider = new ActiveDataProvider([
              'query' => $query,
          //    'sort'=> ['defaultOrder' => ['dadst'=>SORT_DESC]]

        ]);

        $dataProvider->setSort([
          'defaultOrder' => ['del_date'=>SORT_DESC],
          'attributes'=>[
            'id',
            'invoice_no',
            'invoice_date',
            'del_date',
            'status',
          ],
        ]);

        $this->load($params);


         //print_r($this->start);die();
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->order_id,
            'invoice_date' => $this->invoice_date,
        //    'del_date' => $this->delivery_date,
        ]);

        if (!empty($this->delivery_date)) {
          list($this->start,$this->end)= explode(' - ',$this->delivery_date);
          $this->start =  date('Y-m-d', strtotime($this->start) );
          $this->end =  date('Y-m-d', strtotime($this->end) );
          $query->andFilterWhere(['between', 'del_date', $this->start, $this->end]);

        //  die($this->end);
        }else{
          $this->start = date('Y-m-d');
          $date = new \DateTime($this->start);
          $this->start = $date->modify('+2 day')->format('Y-m-d');
          $this->end = $date->modify('+2 years')->format('Y-m-d');
          $query->andFilterWhere(['between', 'del_date', $this->start, $this->end]);
        }

        $query->andFilterWhere(['like', 'invoice_no', $this->invoice_no]);
        //      ->andFilterWhere(['between', 'del_date', $this->start, $this->end]);

        return $dataProvider;
    }

    public function completed_search($params){
    /*  $query_off = (new \yii\db\Query())
          ->select('a.id,a.invoice_no,a.status,a.invoice_date,b.del_date,b.del_time,b.item_code')
          ->from('offline_order a')
          ->leftJoin('offline_order_product b','b.off_order_id=a.id')
          ->groupBy(['a.id'])
          ->where(['a.status'=>5])
          ->orWhere(['a.status'=>7]);*/
      $query_off = (new \yii\db\Query())
          ->select('a.id,a.invoice_no,a.status,a.invoice_date,b.del_date,fu.delivery_time as del_time,b.item_code')
          ->from('offline_order a')
          ->leftJoin('offline_order_product b','b.off_order_id=a.id')
          ->leftJoin('delivery_time fu','fu.id=a.delivery_time')
          ->groupBy(['a.id'])
          ->where(['a.status'=>1]);

      $query_on = (new \yii\db\Query())
          ->select('c.order_id,c.invoice_no,c.order_status_id,c.date_invoice,d.delivery_date,d.delivery_text_time,d.product_id')
          ->from('order c')
          ->leftJoin('order_product d','d.order_id=c.order_id')
          ->groupBy(['c.order_id'])
          ->limit(500)
          ->orderBy(['d.delivery_date'=>SORT_DESC])
          ->where(['c.order_status_id'=>5])
          ->orWhere(['c.order_status_id'=>7]);

    //      ->andWhere(['!=','d.delivery_date','0000-00-00']);

      $query = (new \yii\db\Query())
          ->from(['dummy_name' => $query_off->union($query_on)]);
          //  ->orderBy(['del_date' => SORT_DESC]);

        //  echo '<pre>';
        //  print_r($query);


        $dataProvider = new ActiveDataProvider([
              'query' => $query,
          //    'sort'=> ['defaultOrder' => ['dadst'=>SORT_DESC]]

        ]);

        $dataProvider->setSort([
          'defaultOrder' => ['del_date'=>SORT_DESC],
          'attributes'=>[
            'id',
            'invoice_no',
            'invoice_date',
            'del_date',
          ],
        ]);

        $this->load($params);


         //print_r($this->start);die();
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->order_id,
            'invoice_date' => $this->invoice_date,
        //    'del_date' => $this->delivery_date,
        ]);

        if (!empty($this->delivery_date)) {
          list($this->start,$this->end)= explode(' - ',$this->delivery_date);
          $this->start =  date('Y-m-d', strtotime($this->start) );
          $this->end =  date('Y-m-d', strtotime($this->end ) );
          $query->andFilterWhere(['between', 'del_date', $this->start, $this->end]);
        //  die($this->end);
        }else{
          /*$this->start = date('Y-m-d');
          $date = new \DateTime($this->start);
          $this->start = $date->modify('+2 day')->format('Y-m-d');
          $this->end = $date->modify('+2 years')->format('Y-m-d');
          $query->andFilterWhere(['between', 'del_date', $this->start, $this->end]);*/
        }

        $query->andFilterWhere(['like', 'invoice_no', $this->invoice_no]);
        //      ->andFilterWhere(['between', 'del_date', $this->start, $this->end]);

        return $dataProvider;
    }
}
