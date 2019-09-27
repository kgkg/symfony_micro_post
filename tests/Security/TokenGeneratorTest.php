<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 27.09.2019 21:09
 */

namespace App\Tests\Security;

use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

final class TokenGeneratorTest extends TestCase
{
    public function test_should_return_valid_token(): void
    {
        // given
        $tokenLength = 30;
        $tokenGenerator = new TokenGenerator();

        // when
        $token = $tokenGenerator->getRandomSecureToken($tokenLength);

        // then
        $this->assertSame($tokenLength, strlen($token));
        $this->assertSame(1, preg_match("([A-Za-z0-9]{{$tokenLength}})", $token));
    }

}
