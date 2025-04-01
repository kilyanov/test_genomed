<?php

namespace app\controllers;

use app\models\CountClick;
use app\models\QrCode;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class DataController extends Controller
{
    /**
     * @return Response
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
        $model = CountClick::find()
            ->with(['qrCodeRelation'])
            ->where([
                CountClick::tableName() . '.[[ipUser]]' => inet_pton(Yii::$app->request->getUserIP()),
            ])
            ->andWhere([QrCode::tableName() . '.[[generalUrl]]' => $url])
            ->one();
    }
}
