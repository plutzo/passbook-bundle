<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Classes;

use Google\Collection;

abstract class AbstractClass extends Collection
{
    protected $collection_key = 'textModulesData';
    public $id;

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}