<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Collections;

use Google\Collection;
use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\Uri;

class DiscoverableProgramMerchantSignupInfo extends Collection
{
    protected $collection_key = 'signupSharedDatas';
    protected $signupSharedDatas;
    protected $signupWebsite;
    protected $signupWebsiteType = Uri::class;
    protected $signupWebsiteDataType = '';

    public function setSignupSharedDatas($signupSharedDatas)
    {
        $this->signupSharedDatas = $signupSharedDatas;
    }
    public function getSignupSharedDatas()
    {
        return $this->signupSharedDatas;
    }
    public function setSignupWebsite(Uri $signupWebsite)
    {
        $this->signupWebsite = $signupWebsite;
    }
    public function getSignupWebsite()
    {
        return $this->signupWebsite;
    }
}