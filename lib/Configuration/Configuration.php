<?php

namespace Silamoney\Client\Configuration;

use Silamoney\Client\Api\ApiClient;

class Configuration
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @var string
     */
    private $balanceBasePath;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string
     */
    private $appHandle;

    /**
     * @var \Silamoney\Client\Api\ApiClient
     */
    private $apiClient;

    /**
     * @var \Silamoney\Client\Api\ApiClient
     */
    private $balanceClient;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @var int
     */
    private $timeout;

    /**
     * @param string $basePath
     * @param string $privateKey
     * @param string $appHandle
     */
    public function __construct(string $basePath, string $balanceBasePath, string $privateKey, string $appHandle)
    {
        $this->basePath = $basePath;
        $this->balanceBasePath = $balanceBasePath;
        $this->privateKey = $privateKey;
        $this->appHandle = $appHandle;
        $this->timeout = 10000;
        $this->apiClient = new ApiClient($this->basePath);
        $this->balanceClient = new ApiClient($this->balanceBasePath);
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
        unset($this->apiClient);
        $this->apiClient = new ApiClient($this->basePath);
    }

    /**
     * @return string
     */
    public function getBalanceBasePath(): string
    {
        return $this->balanceBasePath;
    }

    /**
     * @param string $balanceBasePath
     */
    public function setBalanceBasePath(string $balanceBasePath): void
    {
        $this->balanceBasePath = $balanceBasePath;
        unset($this->balanceClient);
        $this->balanceClient = new ApiClient($this->balanceBasePath);
    }

    /**
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * @param string $privateKey
     */
    public function setPrivateKey(string $privateKey): void
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @return string
     */
    public function getAppHandle(): string
    {
        return $this->appHandle;
    }

    /**
     * @param string $appHandle
     */
    public function setAppHandle(string $appHandle): void
    {
        $this->appHandle = $appHandle;
    }

    /**
     * @return \Silamoney\Client\Api\ApiClient
     */
    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
    }

    /**
     * @return \Silamoney\Client\Api\ApiClient
     */
    public function getBalanceClient(): ApiClient
    {
        return $this->balanceClient;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent(string $userAgent): void
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }
}
