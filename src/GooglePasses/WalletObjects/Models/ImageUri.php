<?php

namespace Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models;

use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Collections\LocalizedString;

class ImageUri extends \Google_Model
{
    public $description;
    public $uri;
    protected $localizedDescription;
    protected $localizedDescriptionType = LocalizedString::class;
    protected $localizedDescriptionDataType = '';

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setLocalizedDescription(LocalizedString $localizedDescription)
    {
        $this->localizedDescription = $localizedDescription;
    }

    public function getLocalizedDescription()
    {
        return $this->localizedDescription;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getUri()
    {
        return $this->uri;
    }
}