<?php

namespace app\bus\qr;

class QrCodeCommand
{
    public function __construct(
        protected string $url,
    )
    {
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}