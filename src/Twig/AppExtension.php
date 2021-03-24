<?php

namespace App\Twig;

use App\Twig\Filter\AbsoluteUrlRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('absolute_url', [AbsoluteUrlRuntime::class, '__invoke'], ['is_safe' => ['html']]),
        ];
    }
}
