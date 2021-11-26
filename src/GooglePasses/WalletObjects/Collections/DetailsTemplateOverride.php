<?php

namespace Marlinc\PassbookBundle\GooglePasses\WalletObjects\Collections;

use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\DetailsItemInfo;

class DetailsTemplateOverride extends \Google_Collection
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