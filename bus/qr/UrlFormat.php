<?php

namespace app\bus\qr;

use Da\QrCode\Exception\InvalidConfigException;
use Da\QrCode\Format\AbstractFormat;
use Da\QrCode\Traits\UrlTrait;

class UrlFormat extends AbstractFormat
{
    use UrlTrait;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        if ($this->url === null) {
            throw new InvalidConfigException("'url' cannot be empty.");
        }
    }

    /**
     * @inheritdoc
     */
    public function getText(): string
    {
        return "URL:{$this->url};";
    }
}