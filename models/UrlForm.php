<?php

namespace app\models;

use yii\base\Model;

class UrlForm extends Model
{
    /**
     * @var string|null
     */
    public ?string $url = null;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            ['url', 'required'],
            ['url', 'url'],
            ['url', 'validateUrl'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'url' => 'Введите Url'
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @return void
     */
    public function validateUrl($attribute, $params): void
    {
        $headers = get_headers($this->url);
        if ((int)substr($headers[0], 9, 3) !== 200) {
            $this->addError(
                'url',
                sprintf('Указанный %s не валиден.', $this->url)
            );
        }
    }
}
