<?php

namespace Marlinc\PassbookBundle\GooglePasses\WalletObjects\Collections;

use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\FieldReference;

class FieldSelector extends \Google_Collection
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