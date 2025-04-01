<?php

/**
 * @var yii\web\View $this
 * @var UrlForm $model
 */

use app\assets\QRAsset;
use app\models\UrlForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Главная страница';

QRAsset::register($this);
?>
<div class="site-index">

    <div class="body-content">
        <?php $form = ActiveForm::begin([
            'id' => 'js-qr-code-form',
            'options' => [
                'data-url' => '/'
            ],
        ]); ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'url')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-lg-1">
                <?= Html::submitButton('ОК', [
                    'class' => 'btn btn-primary',
                    'style' => 'margin-top: 32px;'
                ]) ?>
            </div>
            <div class="col-lg-5">
                <div id="js-qr-code-link"></div>
                <div id="js-qr-code-image"></div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
