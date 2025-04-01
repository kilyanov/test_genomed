<?php

namespace app\models\query;

use app\models\CountClick;
use yii\db\ActiveQuery;

class CountClickQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return CountClick[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CountClick|array|null
     */
    public function one($db = null): CountClick|array|null
    {
        return parent::one($db);
    }
}
