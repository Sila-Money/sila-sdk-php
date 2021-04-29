<?php

/**
 * Register Wallet Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;
use Silamoney\Client\Security\EcdsaUtil;

/**
 * Register Wallet Message
 * Object sent in the get wallet method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Walter Zelada <wzelada@digitalgeko.com>
 */
class RegisterWalletMessage implements ValidInterface
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var Silamoney\Client\Domain\SilaWallet
     * @Type("Silamoney\Client\Domain\SilaWallet")
     */
    private $wallet;

    /**
     * @var string
     * @Type("string")
     */
    private $wallet_verification_signature;

    /**
     ** Constructor for RegisterWalletMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param Silamoney\Client\Domain\SilaWallet $wallet
     * @param string $wallet_verification_signature
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        SilaWallet $wallet,
        string $wallet_verification_signature
    ) {
        $this->wallet = $wallet;
        $this->wallet_verification_signature = $wallet_verification_signature;
        $this->header = new Header($appHandle, $userHandle);
    }

    public static function fromPrivateKey(
        string $userHandle,
        string $appHandle,
        SilaWallet $wallet,
        string $walletPrivateKey
    ): RegisterWalletMessage {
        $walletVerificationSignature = '';
        if ($wallet->getBlockchainAddress() && $walletPrivateKey) {
            $walletVerificationSignature = EcdsaUtil::sign($wallet->getBlockchainAddress(), $walletPrivateKey);
        }
        return new RegisterWalletMessage($userHandle, $appHandle, $wallet, $walletVerificationSignature);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && v::notOptional()->validate($this->wallet)
            && v::notOptional()->validate($this->wallet_verification_signature);
    }
}
