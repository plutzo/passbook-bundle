<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models;

use Google_Model;

class AppTarget extends Google_Model
{
    protected $targetUri;
    protected $targetUriType = Uri::class;
    protected $targetUriDataType = '';

    public function setTargetUri(Uri $targetUri)
    {
        $this->targetUri = $targetUri;
    }
    public function getTargetUri()
    {
        return $this->targetUri;
    }
}