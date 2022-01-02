<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections;

use Google\Collection;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\CardRowTemplateInfo;

class CardTemplateOverride extends Collection
{
    protected $collection_key = 'cardRowTemplateInfos';
    protected $cardRowTemplateInfos;
    protected $cardRowTemplateInfosType = CardRowTemplateInfo::class;
    protected $cardRowTemplateInfosDataType = 'array';

    public function setCardRowTemplateInfos($cardRowTemplateInfos)
    {
        $this->cardRowTemplateInfos = $cardRowTemplateInfos;
    }
    public function getCardRowTemplateInfos()
    {
        return $this->cardRowTemplateInfos;
    }
}