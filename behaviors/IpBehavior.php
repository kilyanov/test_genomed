<?php

namespace app\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class IpBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public string $attribute = 'ipUser';

    /**
     * @return string[]
     */
    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'setAttribute',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'setAttribute',
            BaseActiveRecord::EVENT_AFTER_FIND => 'getAttribute',
        ];
    }

    /**
     * @param $event
     * @return void
     */
    public function setAttribute($event): void
    {
        $owner = $this->owner;
        $owner->{$this->attribute} = inet_pton($owner->{$this->attribute});
    }

    /**
     * @param $event
     * @return void
     */
    public function getAttribute($event): void
    {
        $owner = $this->owner;
        $owner->{$this->attribute} = inet_ntop($owner->{$this->attribute});
    }

}