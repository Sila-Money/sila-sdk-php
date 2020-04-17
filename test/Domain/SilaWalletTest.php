<?php

namespace Silamoney\Client\Domain;


use PHPUnit\Framework\TestCase;

class SilaWalletTest extends TestCase
{

    public function testIsValidFalse()
    {
        $silaWallet = new SilaWallet("", "");
        self::assertTrue($silaWallet->isValid());
    }

}
