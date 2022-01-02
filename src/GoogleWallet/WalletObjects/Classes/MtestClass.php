<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Classes;

use Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models\Message;

class MtestClass
{
    public int $var1;
    public Message $var2;

    public function getVar1(): int
    {
        return $this->var1;
    }

    public function setVar1(int $var1): void
    {
        $this->var1 = $var1;
    }

    public function getVar2(): Message
    {
        return $this->var2;
    }

    public function setVar2(Message $var2): void
    {
        $this->var2 = $var2;
    }


}