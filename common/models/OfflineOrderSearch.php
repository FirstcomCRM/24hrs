<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use common\models\OfflineOrder;

/**
 * OfflineOrderSearch represents the model behind the search form of `common\models\OfflineOrder`.
 */
class OfflineOrderSearch extends OfflineOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['invoice_no', 'invoice_date', 'delivery_date', 'customer_name', 'email', 'contact_number', 'recipient_name', 'recipient_contact_num', 'recipient_address', 'recipient_email', 'recipient_postal_code', 'recipient_country','status'], 'safe'],
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

      $query_off = (new \yii\db\Query())
          ->select('a.id,a.invoice_no,a.status,a.invoice_date,b.del_date,b.del_time,b.item_code')
          ->from('offline_order a')
          ->leftJoin('offline_order_product b','b.off_order_id=a.id')
          ->groupBy(['a.id'])
          ->where(['a.status'=>5]);

        $query_on = (new \yii\db\Query())
            ->select('c.order_id,c.invoice_no,c.order_status_id,c.date_invoice,d.delivery_date,d.delivery_text_time,d.product_id')
            ->from('order c')
            ->leftJoin('order_product d','d.order_id=c.order_id')
            ->groupBy(['c.order_id'])
            ->where(['c.order_status_id'=>5])
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
          //  'service_date',
          //  'quantity',
          //  'unit_price',
          //  'total_price',
          ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'invoice_date' => $this->invoice_date,
            'del_date' => $this->delivery_date,

        ]);

        $query->andFilterWhere(['like', 'invoice_no', $this->invoice_no]);


        return $dataProvider;
    }
}
