<?php

/**
 * Entity
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use Respect\Validation\Validator as v;
use Sop\CryptoTypes\Asymmetric\EC\ECPublicKey;
use Sop\CryptoTypes\Asymmetric\EC\ECPrivateKey;
use Sop\CryptoEncoding\PEM;
use kornrunner\{Keccak,Secp256k1};

/**
 * Entity
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   Isaac Avery <avery@silamoney.com>
 */
class SilaWallet implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $address;

    /**
     * @var string
     * @Type("string")
     */
    private $private_key;

    /**
     * Constructor for SilaWallet object.
     * @param $private_key  String Optional Private Key to initialize wallet with
     * @param $address      String Optional Address to initialize wallet with (must match $private_key)
     * @throws \Exception
     */
    public function __construct($private_key, $address)
    {
        if (!$private_key || !$address) {
            $config = [
                'private_key_type' => OPENSSL_KEYTYPE_EC,
                'curve_name' => 'secp256k1'
            ];
            $res = openssl_pkey_new($config);
            if (!$res) {
                echo 'ERROR: Failed to generate private key. -> ' . openssl_error_string();
                exit;
            }
            openssl_pkey_export($res, $priv_key);
            $key_detail = openssl_pkey_get_details($res);
            $priv_pem = PEM::fromString($priv_key);
            $ec_priv_key = ECPrivateKey::fromPEM($priv_pem);
            $ec_priv_seq = $ec_priv_key->toASN1();
            $priv_key_hex = bin2hex($ec_priv_seq->at(1)->asOctetString()->string());
            $pub_key_hex = bin2hex($ec_priv_seq->at(3)->asTagged()->asExplicit()->asBitString()->string());
            $pub_key_hex_2 = substr($pub_key_hex, 2);
            $hash = Keccak::hash(hex2bin($pub_key_hex_2), 256);
            $wallet_address = '0x' . substr($hash, -40);
            $wallet_private_key = '0x' . $priv_key_hex;
            $this->address = $wallet_address;
            $this->private_key = $wallet_private_key;
        } else {
            $this->address = $address;
            $this->private_key = $private_key;
        }
    }

    /**
     * Verify that parameters are valid.
     * @todo: Add regex validation check.
     * @return bool
     */
    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return $notEmptyString->validate($this->address)
            && $notEmptyString->validate($this->private_key);
    }

    /**
     * Get the Ethereum Address associated with this wallet
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Get the Ethereum Private Key for this wallet
     * @todo: Replace this with an internal signing mechanism.
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->private_key;
    }
}
