<?php

namespace app\models\query;

use app\models\QrCode;
use yii\db\ActiveQuery;

class QrCodeQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return QrCode[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return QrCode|array|null
     */
    public function one($db = null): QrCode|array|null
    {
        return parent::one($db);
    }
}
