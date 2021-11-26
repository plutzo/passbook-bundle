<?php

namespace Marlinc\PassbookBundle\GooglePasses\Factories;

use Marlinc\PassbookBundle\GooglePasses\Clients\GoogleWalletObjectsService;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Resources\LoyaltyClassResource;
use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Resources\LoyaltyObjectResource;

class ResourcesFactory
{
    const LOYALTY_OBJECT = 'loyaltyobject';
    const LOYALTY_CLASS = 'loyaltyclass';
    protected $service;

    public function __construct(GoogleWalletObjectsService $service)
    {
        $this->service = $service;
    }

    public function makeLoyaltyObjectResource()
    {
        return new LoyaltyObjectResource(
            $this->service,
            GoogleWalletObjectsService::SERVICE_NAME,
            self::LOYALTY_OBJECT,
            [
                'methods' => [
                    'addmessage' => [
                        'path' => 'walletobjects/v1/loyaltyObject/{resourceId}/addMessage',
                        'httpMethod' => 'POST',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                    'get' => [
                        'path' => 'walletobjects/v1/loyaltyObject/{resourceId}',
                        'httpMethod' => 'GET',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                    'insert' => [
                        'path' => 'walletobjects/v1/loyaltyObject',
                        'httpMethod' => 'POST',
                        'parameters' => [],
                    ],
                    'list' => [
                        'path' => 'walletobjects/v1/loyaltyObject',
                        'httpMethod' => 'GET',
                        'parameters' => [
                            'classId' => [
                                'location' => 'query',
                                'type' => 'string',
                            ],
                            'token' => [
                                'location' => 'query',
                                'type' => 'string',
                            ],
                            'maxResults' => [
                                'location' => 'query',
                                'type' => 'integer',
                            ],
                        ],
                    ],
                    'modifylinkedofferobjects' => [
                        'path' => 'walletobjects/v1/loyaltyObject/{resourceId}/modifyLinkedOfferObjects',
                        'httpMethod' => 'POST',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                    'patch' => [
                        'path' => 'walletobjects/v1/loyaltyObject/{resourceId}',
                        'httpMethod' => 'PATCH',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                    'update' => [
                        'path' => 'walletobjects/v1/loyaltyObject/{resourceId}',
                        'httpMethod' => 'PUT',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                ]
            ]
        );
    }

    public function makeLoyaltyClassResource()
    {
        return new LoyaltyClassResource(
            $this->service,
            GoogleWalletObjectsService::SERVICE_NAME,
            self::LOYALTY_CLASS,
            [
                'methods' => [
                    'addmessage' => [
                        'path' => 'walletobjects/v1/loyaltyClass/{resourceId}/addMessage',
                        'httpMethod' => 'POST',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                    'get' => [
                        'path' => 'walletobjects/v1/loyaltyClass/{resourceId}',
                        'httpMethod' => 'GET',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                    'insert' => [
                        'path' => 'walletobjects/v1/loyaltyClass',
                        'httpMethod' => 'POST',
                        'parameters' => [],
                    ],
                    'list' => [
                        'path' => 'walletobjects/v1/loyaltyClass',
                        'httpMethod' => 'GET',
                        'parameters' => [
                            'issuerId' => [
                                'location' => 'query',
                                'type' => 'string',
                            ],
                            'token' => [
                                'location' => 'query',
                                'type' => 'string',
                            ],
                            'maxResults' => [
                                'location' => 'query',
                                'type' => 'integer',
                            ],
                        ],
                    ],
                    'patch' => [
                        'path' => 'walletobjects/v1/loyaltyClass/{resourceId}',
                        'httpMethod' => 'PATCH',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                    'update' => [
                        'path' => 'walletobjects/v1/loyaltyClass/{resourceId}',
                        'httpMethod' => 'PUT',
                        'parameters' => [
                            'resourceId' => [
                                'location' => 'path',
                                'type' => 'string',
                                'required' => true,
                            ],
                        ],
                    ],
                ]
            ]
        );
    }
}