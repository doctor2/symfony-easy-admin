<?php

namespace App\Twig\Filter;

class AbsoluteUrlRuntime
{
    private $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function __invoke(string $url): string
    {
        return sprintf(
            '%s%s',
            $this->baseUrl,
            $url
        );
    }
}
