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

    public function rules()
    {
        return [
            [['order_id', 'invoice_no', 'store_id', 'customer_id', 'customer_group_id', 'payment_country_id', 'payment_zone_id', 'shipping_country_id', 'shipping_zone_id', 'order_status_id', 'affiliate_id', 'marketing_id', 'language_id', 'currency_id'], 'integer'],
            [['order_source', 'invoice_prefix', 'store_name', 'store_url', 'firstname', 'lastname', 'email', 'telephone', 'shipping_telephone', 'fax', 'custom_field', 'payment_firstname', 'payment_lastname', 'payment_company', 'payment_address_1', 'payment_address_2', 'payment_city', 'payment_postcode', 'payment_country', 'payment_zone', 'payment_address_format', 'payment_custom_field', 'payment_method', 'payment_code', 'shipping_firstname', 'shipping_lastname', 'shipping_company', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_postcode', 'shipping_country', 'shipping_zone', 'shipping_address_format', 'shipping_custom_field', 'shipping_method', 'shipping_code', 'comment', 'tracking', 'currency_code', 'ip', 'forwarded_ip', 'user_agent', 'accept_language', 'date_added', 'date_modified', 'date_invoice','delivery_date'], 'safe'],
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
    /* $query->joinWith(['orderProduct'])->select('order.order_id,order.invoice_no,order.invoice_prefix,order.order_status_id,order_product.delivery_date,
      order_product.delivery_text_time,order_product.name'); */

    //  $query->joinWith(['orderProduct'])->select('order.order_id,order.invoice_no,order.invoice_prefix,order.order_status_id,order_product.delivery_date');
      //samp;e
      //$query = Item::find()->joinWith(['subcategory'])->select(['item.*', 'sub_category.name'])->where(['item.active' => 1])->addOrderBy(['item.id' => SORT_DESC]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->orderBy(['order_id'=>SORT_DESC]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Order.order_id' => $this->order_id,
            'invoice_no' => $this->invoice_no,
            'store_id' => $this->store_id,
            'customer_id' => $this->customer_id,
            'customer_group_id' => $this->customer_group_id,
            'payment_country_id' => $this->payment_country_id,
            'payment_zone_id' => $this->payment_zone_id,
            'shipping_country_id' => $this->shipping_country_id,
            'shipping_zone_id' => $this->shipping_zone_id,
            'total' => $this->total,
            'order_status_id' => $this->order_status_id,
            'affiliate_id' => $this->affiliate_id,
            'commission' => $this->commission,
            'marketing_id' => $this->marketing_id,
            'language_id' => $this->language_id,
            'currency_id' => $this->currency_id,
            'currency_value' => $this->currency_value,
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
            'date_invoice' => $this->date_invoice,
        ]);

        $query->andFilterWhere(['like', 'order_source', $this->order_source])
            ->andFilterWhere(['like', 'invoice_prefix', $this->invoice_prefix])
            ->andFilterWhere(['like', 'store_name', $this->store_name])
            ->andFilterWhere(['like', 'store_url', $this->store_url])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'shipping_telephone', $this->shipping_telephone])
            ->andFilterWhere(['like', 'fax', $this->fax]);
        //   ->andFilterWhere(['like', 'order_product.delivery_date', $this->delivery_date]);

        return $dataProvider;
    }

    public function jonedSearch($params){
      $query = Order::find();
      //  ->select('store_name');
      //    ->leftJoin('order_product', '`order_product`.`order_id` = `order`.`order_id`');
      //  ->leftJoin('order_product','order_product.order_id'='order.order_id')
  //      ->all();


      //  echo '<pre>';
      //  print_r($query);die();
      //  echo '</pre>';

      $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
      ]);

      $this->load($params);

      //$query->andFilterWhere(['order_id'=>4015]);
      echo '<pre>';
      print_r($dataProvider->getModels() ) ;die();
      echo '</pre>';
      return $dataProvider;
    }
}
