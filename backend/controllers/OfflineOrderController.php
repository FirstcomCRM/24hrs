<?php

namespace backend\controllers;

use Yii;
use common\models\OfflineOrder;
use common\models\OfflineOrderSearch;
use common\models\OfflineOrderProduct;
use common\models\OfflineRunningTable;
use common\models\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * OfflineOrderController implements the CRUD actions for OfflineOrder model.
 */
class OfflineOrderController extends Controller
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
     * Lists all OfflineOrder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OfflineOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      //    echo '<pre>';
      //    var_dump($dataProvider);
      //    echo '</pre>';die();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OfflineOrder model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $modelLine  = OfflineOrderProduct::find()->where(['off_order_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $modelLine,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            //'modelLine'=>$modelLine,
            'dataProvider'=>$dataProvider,
        ]);
    }

    /**
     * Creates a new OfflineOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OfflineOrder();
        $modelLine = [new OfflineOrderProduct];

        if ($model->load(Yii::$app->request->post())  ) {
            $modelLine = Model::createMultiple(OfflineOrderProduct::classname());
            Model::loadMultiple($modelLine, Yii::$app->request->post());

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelLine) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $run = OfflineRunningTable::findOne(1);
                    //  $quo = 'QUO-'. sprintf("%007d", $model->ID);
                    $model->invoice_no ='INV-'.sprintf("%005d",$run->value);
                    $run->value++;
                    $run->save(false);
                    if ($flag = $model->save(false)) {
                        foreach ($modelLine as $line)
                        {
                            $line->off_order_id = $model->id;
                            $line->del_date = $model->delivery_date;
                            $line->del_time = $model->delivery_time;
                            if (! ($flag = $line->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();


                        Yii::$app->session->setFlash('success', "Offline order created");
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        //    return $this->redirect(['view', 'id' => $model->id]);
        }else{
          return $this->render('create', [
              'model' => $model,
              'modelLine'=> (empty($modelLine)) ? [new OfflineOrderProduct] : $modelLine,
          ]);
        }


    }

    /**
     * Updates an existing OfflineOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelLine = OfflineOrderProduct::find()->where(['off_order_id' => $id])->all();


        if ($model->load(Yii::$app->request->post())   ) {
            $oldIDs = ArrayHelper::map($modelLine, 'id', 'id');
            $offline = Model::createMultiple(OfflineOrderProduct::classname(), $modelLine);
            Model::loadMultiple($offline, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($offline, 'id', 'id')));

            $valid = $model->validate();
            $valid = Model::validateMultiple($offline) && $valid;


            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                  try {

                        if ($flag = $model->save(false)) {
                            if (! empty($deletedIDs)) {
                              OfflineOrderProduct::deleteAll(['ID' => $deletedIDs]);
                            }
                        foreach ($offline as $line) {
                            $line->off_order_id = $model->id;
                            $line->del_date = $model->delivery_date;
                              $line->del_time = $model->delivery_time;
                            if (! ($flag = $line->save(false))) {
                                $transaction->rollBack();
                                break;
                              }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', "Offline order updated");
                            return $this->redirect(['view', 'id' => $model->id]);
                        }

                  } catch (Exception $e) {
                      $transaction->rollBack();
                  }
          }

          //  return $this->redirect(['view', 'id' => $model->id]);
        }else{
          return $this->render('update', [
              'model' => $model,
              'modelLine'=> (empty($modelLine)) ? [new OfflineOrderProduct] : $modelLine,
          ]);

        }


    }

    /**
     * Deletes an existing OfflineOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OfflineOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OfflineOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OfflineOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}