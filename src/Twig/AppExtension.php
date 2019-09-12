<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 05.08.2019 15:54
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

final class AppExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'priceFilter'])
        ];
    }

    public function priceFilter(int $number): string
    {
        return '$' . number_format($number, 2, '.', ',');
    }

    public function getGlobals()
    {
        return [
            'locale' => $this->locale,
        ];
    }
}