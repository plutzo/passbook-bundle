<?php
declare(strict_types=1);

namespace Marlinc\PassbookBundle\GoogleWallet;

use Google\Client as GoogleClient;
use Marlinc\PassbookBundle\GoogleWallet\Factories\ResourcesFactory;
use Marlinc\PassbookBundle\GoogleWallet\Helpers\Config;
use Marlinc\PassbookBundle\GoogleWallet\Helpers\JwtGenerator;
use Marlinc\PassbookBundle\GoogleWallet\Helpers\JwtPayload;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Classes\LoyaltyClass;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Objects\LoyaltyObject;


class Client
{
    private ResourcesFactory $resourcesFactory;

    private ?JwtGenerator $jwtGenerator = null;

    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;

        // do OAuth2.0 via service account file.
        // See https://developers.google.com/api-client-library/php/auth/service-accounts#authorizingrequests
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $config->getConfigFilePath());

        $client = new GoogleClient();
        $client->useApplicationDefaultCredentials();
        $client->setApplicationName($config->getApplicationName());
        $client->setScopes($config->getScopes());

        $this->resourcesFactory = new ResourcesFactory(new ObjectsService($client));
    }

    public function getJwtGenerator(): JwtGenerator
    {
        return $this->jwtGenerator ?? new JwtGenerator(
            $this->config->getServiceAccountEmail(),
            $this->config->getPrivateKey(),
            $this->config->getOrigins()
        );
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function insertLoyaltyClass(LoyaltyClass $loyaltyClass): LoyaltyClass
    {
        return $this->resourcesFactory->makeLoyaltyClassResource()->insert($loyaltyClass);
    }

    public function getLoyaltyClass($classId): LoyaltyClass
    {
        return $this->resourcesFactory->makeLoyaltyClassResource()->get($classId);
    }

    public function insertLoyaltyObject(LoyaltyObject $loyaltyObject): LoyaltyObject
    {
        return $this->resourcesFactory->makeLoyaltyObjectResource()->insert($loyaltyObject);
    }

    public function getLoyaltyObject(string $objectId): LoyaltyObject
    {
        return $this->resourcesFactory->makeLoyaltyObjectResource()->get($objectId);
    }

    public function generateJwt(JwtPayload $payload): string
    {
        return $this->getJwtGenerator()->generateJwt($payload);
    }

    public function generateDownloadLink(string $objectId): string
    {
        $payload = JwtPayload::create()
            ->addLoyaltyObject(["id" => $objectId]);
        $signedJwt = $this->generateJwt($payload);

        return $this->config::DOWNLOAD_URL.$signedJwt;
    }

}
