<?php

use yii\helpers\Html;
use common\models\JGoccassion;
use yii\helpers\ArrayHelper;



$data = JGoccassion::find()->all();
$occ =ArrayHelper::map($data,'occassion_text','occassion_text');
?>

<?= Html::label('Select Occassion', null, ['class' => 'labels userss']) ?>
<!--Options--->
<?php echo Html::dropDownList('tests',null,$occ,['class'=>'form-control occassions','id'=>'occassions','onchange'=>'mocc()', 'prompt'=>'Select']) ?>
<br>
<?= Html::label('Options', null, ['class' => 'labels userss']) ?>
<?php echo Html::dropDownList('tests',null,[],['class'=>'form-control','id'=>'moptions']) ?>
