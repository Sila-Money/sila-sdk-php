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
    private $privateKey;

    /**
     * @var string
     */
    private $authHandle;

    /**
     * @var ApiClient
     */
    private $apiClient;

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
     * @param string $authHandle
     */
    public function __construct(string $basePath, string $privateKey, string $authHandle)
    {
        $this->basePath = $basePath;
        $this->privateKey = $privateKey;
        $this->authHandle = $authHandle;
        $this->timeout = 10000;
        $this->apiClient = new ApiClient($this->basePath);
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
    public function getAuthHandle(): string
    {
        return $this->authHandle;
    }

    /**
     * @param string $authHandle
     */
    public function setAuthHandler(string $authHandle): void
    {
        $this->authHandle = $authHandle;
    }

    /**
     * @return \Silamoney\Client\Api\ApiClient
     */
    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
    }

    /**
     * @param \Silamoney\Client\Api\ApiClient $apiClient
     */
    public function setApiClient(ApiClient $apiClient): void
    {
        $this->apiClient = $apiClient;
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
