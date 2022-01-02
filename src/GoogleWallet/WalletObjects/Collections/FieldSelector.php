<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections;

use Google\Collection;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\FieldReference;

class FieldSelector extends Collection
{
    protected $fields;
    protected $fieldsType = FieldReference::class;
    protected $fieldsDataType = 'array';

    protected $collection_key = 'fields';

    public function setFields($fields)
    {
        $this->fields = $fields;
    }
    public function getFields()
    {
        return $this->fields;
    }
}