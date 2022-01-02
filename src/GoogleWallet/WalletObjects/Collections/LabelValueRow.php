<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections;

use Google\Collection;
use Google_Collection;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\LabelValue;

class LabelValueRow extends Collection
{
    protected $collection_key = 'columns';

    protected $columns;
    protected $columnsType = LabelValue::class;
    protected $columnsDataType = 'array';


    public function setColumns($columns)
    {
        $this->columns = $columns;
    }
    public function getColumns()
    {
        return $this->columns;
    }
}