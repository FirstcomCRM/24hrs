<?php
yii::setAlias('@image', '/image');
yii::setAlias('@cimages', dirname(dirname(__DIR__)) . '/image');
Yii::setAlias('@roots', realpath(dirname(__FILE__).'/../../../'));
return [
];
