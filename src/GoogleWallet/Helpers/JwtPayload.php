<?php
declare(strict_types=1);

namespace Marlinc\PassbookBundle\GoogleWallet\Helpers;


class JwtPayload
{
    private array $payload = [];

    public static function create(): self
    {
        return new self();
    }

    public function addOfferClass($resourcePayload): self
    {
        if (!array_key_exists("offerClasses", $this->payload)) {
            $this->payload["offerClasses"] = [];
        }
        $this->payload["offerClasses"][] = $resourcePayload;

        return $this;
    }

    public function addOfferObject($resourcePayload): self
    {
        if (!array_key_exists("offerObjects", $this->payload)) {
            $this->payload["offerObjects"] = [];
        }
        $this->payload["offerObjects"][] = $resourcePayload;

        return $this;
    }

    public function addLoyaltyClass($resourcePayload): self
    {
        if (!array_key_exists("loyaltyClasses", $this->payload)) {
            $this->payload["loyaltyClasses"] = [];
        }
        $this->payload["loyaltyClasses"][] = $resourcePayload;

        return $this;
    }

    public function addLoyaltyObject($resourcePayload): self
    {
        if (!array_key_exists("loyaltyObjects", $this->payload)) {
            $this->payload["loyaltyObjects"] = [];
        }
        $this->payload["loyaltyObjects"][] = $resourcePayload;

        return $this;
    }

    public function addGiftCardClass($resourcePayload): self
    {
        if (!array_key_exists("giftCardClasses", $this->payload)) {
            $this->payload["giftCardClasses"] = [];
        }
        $this->payload["giftCardClasses"][] = $resourcePayload;

        return $this;
    }

    public function addGiftCardObject($resourcePayload): self
    {
        if (!array_key_exists("giftCardObjects", $this->payload)) {
            $this->payload["giftCardObjects"] = [];
        }
        $this->payload["giftCardObjects"][] = $resourcePayload;

        return $this;
    }

    public function addEventTicketClass($resourcePayload): self
    {
        if (!array_key_exists("eventTicketClasses", $this->payload)) {
            $this->payload["eventTicketClasses"] = [];
        }
        $this->payload["eventTicketClasses"][] = $resourcePayload;

        return $this;
    }

    public function addEventTicketObject($resourcePayload): self
    {
        if (!array_key_exists("eventTicketObjects", $this->payload)) {
            $this->payload["eventTicketObjects"] = [];
        }
        $this->payload["eventTicketObjects"][] = $resourcePayload;

        return $this;
    }

    public function addFlightClass($resourcePayload): self
    {
        if (!array_key_exists("flightClasses", $this->payload)) {
            $this->payload["flightClasses"] = [];
        }
        $this->payload["flightClasses"][] = $resourcePayload;

        return $this;
    }

    public function addFlightObject($resourcePayload): self
    {
        if (!array_key_exists("flightObjects", $this->payload)) {
            $this->payload["flightObjects"] = [];
        }
        $this->payload["flightObjects"][] = $resourcePayload;

        return $this;
    }

    public function addTransitClass($resourcePayload): self
    {
        if (!array_key_exists("transitClasses", $this->payload)) {
            $this->payload["transitClasses"] = [];
        }
        $this->payload["transitClasses"][] = $resourcePayload;

        return $this;
    }

    public function addTransitObject($resourcePayload): self
    {
        if (!array_key_exists("transitObjects", $this->payload)) {
            $this->payload["transitObjects"] = [];
        }
        $this->payload["transitObjects"][] = $resourcePayload;

        return $this;
    }

    public function toArray(): array
    {
        return $this->payload;
    }
}