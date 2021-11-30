<?php

namespace Marlinc\PassbookBundle\GooglePasses\WalletObjects\Classes;

use Marlinc\PassbookBundle\GooglePasses\WalletObjects\Models\Message;

class MtestClass
{
    public int $var1;
    public Message $var2;

    /**
     * @return int
     */
    public function getVar1(): int
    {
        return $this->var1;
    }

    /**
     * @param int $var1
     */
    public function setVar1(int $var1): void
    {
        $this->var1 = $var1;
    }

    /**
     * @return Image
     */
    public function getVar2(): Message
    {
        return $this->var2;
    }

    /**
     * @param Image $var2
     */
    public function setVar2(Message $var2): void
    {
        $this->var2 = $var2;
    }


}