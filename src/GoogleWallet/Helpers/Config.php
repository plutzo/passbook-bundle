<?php
declare(strict_types=1);


namespace Marlinc\PassbookBundle\GoogleWallet\Helpers;

use Marlinc\PassbookBundle\GoogleWallet\Exceptions\InvalidArgumentException;

class Config
{
    public const DOWNLOAD_URL = 'https://pay.google.com/gp/v/save/';

    private string $issuerId;

    private string $applicationName;

    private array $origins;

    private array $serviceAccount;

    private array $scopes;

    private string $configFilePath;

    public function __construct(
        string $issuerId,
        string $configFilePath,
        string $applicationName,
        array $origins,
        array $scopes
    )
    {
        $this->issuerId = $issuerId;
        $this->applicationName = $applicationName;
        $this->origins = $origins;
        $this->scopes = $scopes;
        $this->configFilePath = $configFilePath;
        $this->serviceAccount = $this->loadServiceAccountData($configFilePath);
    }


    private function loadServiceAccountData(string $configFilePath): array
    {
        $jsonFile = file_get_contents(realpath($configFilePath));

        if (empty($jsonFile)) {
            throw new InvalidArgumentException("Service account file not found or isn't readable");
        }

        $serviceAccountCredentials = json_decode($jsonFile, true, 512, JSON_THROW_ON_ERROR);

        if (empty($serviceAccountCredentials)) {
            throw new InvalidArgumentException("Service account file contains invalid JSON");
        }

        if (!isset($serviceAccountCredentials['private_key'])) {
            throw new InvalidArgumentException("Service account file doesn't contain private key");
        }

        return $serviceAccountCredentials;
    }

    public function getConfigFilePath(): string
    {
        return $this->configFilePath;
    }

    public function getPrivateKey(): string
    {
        return $this->serviceAccount['private_key'];
    }

    public function getApplicationName(): string
    {
        return $this->applicationName;
    }

    public function getServiceAccountEmail(): string
    {
        return $this->serviceAccount['client_email'];
    }

    public function getIssuerId(): string
    {
        return $this->issuerId;
    }

    public function getOrigins(): array
    {
        return $this->origins;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }
}