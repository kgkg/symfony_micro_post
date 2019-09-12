<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 30.07.2019 15:48
 */

namespace App\Service;

use Psr\Log\LoggerInterface;

final class Greeting
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function greet(string $name): string
    {
        $this->logger->info("Greeted {$name}");

        return "Hello {$name}";
    }
}