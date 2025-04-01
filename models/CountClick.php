<?php

namespace app\models;

use app\behaviors\IpBehavior;
use app\models\query\CountClickQuery;
use app\models\query\QrCodeQuery;
use ext\behaviors\IdAttributeBehavior;
use ext\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%count_click}}".
 *
 * @property string $id ID
 * @property string $idCode ID qr code
 * @property resource $ipUser IP пользователя
 * @property int|null $counter Счетчик переходов
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property QrCode $qrCodeRelation
 */
class CountClick extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%count_click}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['counter'], 'default', 'value' => 0],
            [['idCode', 'ipUser',], 'required'],
            [['ipUser'], 'string'],
            [['counter'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['idCode'], 'string', 'max' => 255],
            [
                ['idCode'],
                'exist',
                'skipOnError' => true,
                'targetClass' => QrCode::class,
                'targetAttribute' => ['idCode' => 'id']
            ],
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
            'IpBehavior' => [
                'class' => IpBehavior::class,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'idCode' => 'ID qr code',
            'ipUser' => 'IP пользователя',
            'counter' => 'Счетчик переходов',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
    }

    /**
     * Gets query for [[QrCode]].
     *
     * @return ActiveQuery|QrCodeQuery
     */
    public function getQrCodeRelation(): ActiveQuery|QrCodeQuery
    {
        return $this->hasOne(QrCode::class, ['id' => 'idCode']);
    }

    /**
     * {@inheritdoc}
     * @return CountClickQuery the active query used by this AR class.
     */
    public static function find(): CountClickQuery
    {
        return new CountClickQuery(get_called_class());
    }

}
