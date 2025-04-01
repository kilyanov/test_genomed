<?php

namespace app\models;

use app\models\query\QrCodeQuery;
use ext\behaviors\IdAttributeBehavior;
use ext\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%qr_code}}".
 *
 * @property string $id ID
 * @property string $url Url
 * @property string $generalUrl Короткий url
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property CountClick[] $countClicksRelations
 */
class QrCode extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%qr_code}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['url', 'generalUrl',], 'required'],
            [['url'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['generalUrl'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
            'IdAttributeBehavior' => [
                'class' => IdAttributeBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'generalUrl' => 'Короткий url',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
    }

    /**
     * Gets query for [[CountClicks]].
     *
     * @return ActiveQuery
     */
    public function getCountClicksRelation(): ActiveQuery
    {
        return $this->hasMany(CountClick::class, ['idCode' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return QrCodeQuery the active query used by this AR class.
     */
    public static function find(): QrCodeQuery
    {
        return new QrCodeQuery(get_called_class());
    }

}
