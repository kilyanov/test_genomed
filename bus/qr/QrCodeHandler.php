<?php

namespace app\bus\qr;

use app\models\QrCode as QrCodeModel;
use Da\QrCode\Exception\BadMethodCallException;
use Da\QrCode\Exception\ValidationException;
use Da\QrCode\Format\MailToFormat;
use Da\QrCode\QrCode;
use Da\QrCode\Format\BookmarkFormat;
use Yii;
use yii\base\Exception;

class QrCodeHandler
{
    /**
     * @param QrCodeCommand $command
     * @return string[]
     * @throws Exception
     */
    public function __invoke(QrCodeCommand $command): array
    {
        $model = $this->getModel($command->getUrl());
        if (!$model instanceof QrCodeModel) {
            $model = new QrCodeModel([
                'url' => $command->getUrl(),
                'generalUrl' => Yii::$app->security->generateRandomString(9),
            ]);
            if (!$model->save()) {
                throw new Exception(
                    implode(',', $model->getErrorSummary(true))
                );
            }
        }

        $link = Yii::$app->request->getAbsoluteUrl() . 'url/' . $model->generalUrl;
        $format = new UrlFormat(['url' => $command->getUrl()]);
        $qrCode = new QrCode($format);
        try {
            return [
                $link,
                $qrCode
            ];
        } catch (BadMethodCallException|ValidationException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param string $url
     * @return QrCodeModel|null
     */
    protected function getModel(string $url): ?QrCodeModel
    {
        return QrCodeModel::findOne(['url' => $url]);
    }
}