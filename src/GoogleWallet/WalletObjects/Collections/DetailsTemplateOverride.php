<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections;

use Google\Collection;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\DetailsItemInfo;

class DetailsTemplateOverride extends Collection
{
    protected $collection_key = 'detailsItemInfos';

    protected $detailsItemInfos;
    protected $detailsItemInfosType = DetailsItemInfo::class;
    protected $detailsItemInfosDataType = 'array';

    public function setDetailsItemInfos($detailsItemInfos)
    {
        $this->detailsItemInfos = $detailsItemInfos;
    }
    public function getDetailsItemInfos()
    {
        return $this->detailsItemInfos;
    }
}