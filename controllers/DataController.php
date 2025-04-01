<?php

namespace app\controllers;

use app\models\CountClick;
use app\models\QrCode;
use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\Response;

class DataController extends Controller
{
    /**
     * @return Response
     * @throws Exception
     */
    public function actionIndex(string $url)
    {
        /**
         * $ip = '192.168.0.1';
         * $binIp = inet_pton( $ip );
         * echo bin2hex( $binIp );
         * // > c0a80001
         *
         * # Пример использования inet_ntop() для преобразования двоичного представления IP-адреса в строку
         * $binIp = hex2bin( 'c0a80001' );
         * $ip = inet_ntop( $binIp );
         * echo $ip;
         * // > 192.168.0.1
         */
        $modelCode = QrCode::findOne(['generalUrl' => $url]);
        if ($modelCode === null) {
            throw new Exception(sprintf('Указанный %s не найден.', $url));
        }
        $model = CountClick::find()
            ->where([
                CountClick::tableName() . '.[[ipUser]]' => inet_pton(Yii::$app->request->getUserIP()),
                CountClick::tableName() . '.[[idCode]]' => $modelCode->id
            ])
            ->one();
        if (!$model instanceof CountClick) {
            $model = new CountClick([
                'idCode' => $modelCode->id,
                'ipUser' => inet_pton(Yii::$app->request->getUserIP()),
                'counter' => 0
            ]);
        }
        $model->counter += 1;
        if ($model->save()) {
            return $this->redirect($modelCode->url);
        } else {
            throw new Exception(implode(', ', $model->getErrorSummary(true)));
        }
    }
}
