<?php

namespace Marlinc\PassbookBundle\GoogleWallet\WalletObjects\Models;

class Review extends \Google_Model
{
    public $comments;

    public function setComments($comments)
    {
        $this->comments = $comments;
    }
    public function getComments()
    {
        return $this->comments;
    }
}