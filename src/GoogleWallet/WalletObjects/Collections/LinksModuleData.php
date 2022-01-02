<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections;

use Google\Collection;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\Uri;

class LinksModuleData extends Collection
{
    protected $collection_key = 'uris';
    protected $uris;
    protected $urisType = Uri::class;
    protected $urisDataType = 'array';

    public function setUris($uris)
    {
        $this->uris = $uris;
    }
    public function getUris()
    {
        return $this->uris;
    }
}