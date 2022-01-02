<?php

namespace Marlinc\PassbookBundle\GoogleWallet;

use Google\Client;
use Google\Service;

class ObjectsService extends Service
{
    public const SERVICE_NAME = 'walletobjects';
    public const API_VERSION = 'v1';

    public function __construct(Client $client)
    {
        parent::__construct($client);
        $this->rootUrl = 'https://walletobjects.googleapis.com/';
        $this->servicePath = '';
        $this->batchPath = 'batch';
        $this->version = self::API_VERSION;
    }
}