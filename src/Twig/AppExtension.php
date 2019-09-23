<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 05.08.2019 15:54
 */

namespace App\Twig;

use App\Entity\LikeNotification;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigTest;

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
            new TwigFilter('price', [$this, 'priceFilter']),

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

    public function getTests()
    {
        return [
            new TwigTest('like', function ($obj) {
                return $obj instanceof LikeNotification;
            }),

        ];
    }
}