<?php

namespace app\controllers;

use app\bus\qr\QrCodeCommand;
use app\models\UrlForm;
use League\Tactician\CommandBus;
use Yii;
use yii\bootstrap5\Alert;
use yii\bootstrap5\Html;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * @param $id
     * @param $module
     * @param CommandBus $bus
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        protected CommandBus $bus,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * @return string|Response
     * @throws \Throwable
     */
    public function actionIndex(): Response|string
    {
        $model = new UrlForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $command = new QrCodeCommand($model->url);
                [$url, $qrCode] = $this->bus->handle($command);
                return $this->asJson([
                    'error' => false,
                    'url' => Html::a($url, $url),
                    'qrCode' => $qrCode->writeDataUri(),
                ]);
            }
            else {
                return $this->asJson([
                    'error' => true,
                    'massage' => Alert::widget([
                        'options' => [ 'class' => 'alert-warning'],
                        'body' => implode(',', $model->getErrorSummary(true))
                    ])
                ]);
            }
        }

        return $this->render(
            'index',
            [
                'model' => $model
            ]
        );
    }
}
