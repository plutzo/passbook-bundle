<?php

namespace Marlinc\PassbookBundle\GooglePasses\Clients;

use Google_Client;
use Marlinc\PassbookBundle\GooglePasses\Factories\ResourcesFactory;
use Marlinc\PassbookBundle\GooglePasses\Helpers\Config;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Classes\LoyaltyClass;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Objects\LoyaltyObject;

class GoogleRestClient
{
    const SCOPES = 'https://www.googleapis.com/auth/wallet_object.issuer';

    private $client;

    private $service;

    private $resourcesFactory;

    public $config;

    public function __construct(Config $config)
    {

        $this->client = new Google_Client();
        $this->config = $config;
        // do OAuth2.0 via service account file.
        // See https://developers.google.com/api-client-library/php/auth/service-accounts#authorizingrequests
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $config->getServiceAccountFilePath());
        $this->client->useApplicationDefaultCredentials();
        // Set application name.
        $this->client->setApplicationName($config->getApplicationName());
        // Set Api scopes.
        $this->client->setScopes($config->getScopes());

        $this->resourcesFactory = new ResourcesFactory($this->getService());
    }

    public function getService()
    {
        if (empty($this->service)) {
            $this->service = new GoogleWalletObjectsService($this->client);
        }
        return $this->service;
    }

    public function insertLoyaltyClass(LoyaltyClass $loyaltyClass)
    {
        $response = null;

        $loyaltyResource = $this->resourcesFactory->makeLoyaltyClassResource();
        try {
            $response = $loyaltyResource->insert($loyaltyClass);
            $response["code"] = 200;
        } catch (\Google_Service_Exception $gException) {
            $response = $gException->getErrors();
            $response["code"] = $gException->getCode();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

        return $response;
    }

    public function getLoyaltyClass($classId)
    {
        $response = null;

        $loyaltyResource = $this->resourcesFactory->makeLoyaltyClassResource();

        try {
            $response = $loyaltyResource->get($classId);
            $response["code"] = 200;
        } catch (\Google_Service_Exception $gException) {
            $response = $gException->getErrors();
            $response["code"] = $gException->getCode();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

        return $response;
    }

    public function getLoyaltyObject($objectId)
    {
        $response = null;

        $loyaltyResource = $this->resourcesFactory->makeLoyaltyObjectResource();

        try {
            $response = $loyaltyResource->get($objectId);
            $response["code"] = 200;
        } catch (\Google_Service_Exception $gException) {
            $response = $gException->getErrors();
            $response["code"] = $gException->getCode();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

        return $response;
    }


    public function insertLoyaltyObject(LoyaltyObject $loyaltyObject)
    {
        $response = null;
        $loyaltyResource = $this->resourcesFactory->makeLoyaltyObjectResource();

        try {
            $response = $loyaltyResource->insert($loyaltyObject);
            $response["code"] = 200;
        } catch (\Google_Service_Exception $gException) {
            $response = $gException->getErrors();
            $response["code"] = $gException->getCode();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

        return $response;
    }

    public function handleInsertCallStatusCode($insertCallResponse, $idType, $id, $checkClassId)
    {
        if ($insertCallResponse["code"] == 200) {
            dump(sprintf("\n%s id (%s) insertion success!\n", $idType, $id));
        } else if ($insertCallResponse["code"] == 409) {  // Id resource exists for this issuer account
            dump(sprintf("\n%sId: (%s) already exists. %s", $idType, $id, $this->EXISTS_MESSAGE));

            // for object insert, do additional check
            if ($idType == "object") {

                $objectResponse = NULL;

                $objectResponse = $this->getLoyaltyObject($id);
                // check if object's classId matches target classId
                $classIdOfObjectId = $objectResponse->getClassReference()->getId();
                if ($classIdOfObjectId != $checkClassId && $checkClassId != NULL) {
                    \Exception(sprintf(">>>> Exception:\nthe classId of inserted object is (%s). " .
                        "It does not match the target classId (%s). The saved object will not " .
                        "have the class properties you expect.", $classIdOfObjectId, $checkClassId));
                }
            }
        } else {
            \Exception(sprintf(">>>> Exception:\n%s insert issue.\n%s", $idType, var_export($insertCallResponse, true)));
        }

        return;
    }

    private function handleGetCallStatusCode($getCallResponse, $idType, $id, $checkClassId)
    {

        if ($getCallResponse["code"] == 200) {  // Id resource exists for this issuer account
            dump(printf("\n%sId: (%s) already exists. %s", $idType, $id, $this->EXISTS_MESSAGE));

            // for object get, do additional check
            if ($idType == "object") {
                // check if object's classId matches target classId
                $classIdOfObjectId = $getCallResponse["classReference"]["id"];
                if ($classIdOfObjectId != $checkClassId && $checkClassId != NULL) {
                    throw new \Exception(sprintf(">>>> Exception:\nthe classId of inserted object is (%s). " .
                        "It does not match the target classId (%s). The saved object will not " .
                        "have the class properties you expect.", $classIdOfObjectId, $checkClassId));
                }
            }
        } else if ($getCallResponse["code"] == 404) {  // Id resource does not exist for this issuer account
            dump(printf("\n%sId: (%s) does not exist. %s", $idType, $id, '"Will be inserted when user saves by link/button for first time\n"'));
        } else {
            \Exception(sprintf(">>>> Exception:\nIssue with getting %s.\n%s", $idType, var_export($getCallResponse, true)));
        }

        return;
    }

}