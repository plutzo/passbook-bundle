<?php

namespace Marlinc\PassbookBundle\GoogleWallet\Helpers;

use Marlinc\PassbookBundle\GoogleWallet\Exceptions\InvalidArgumentException;

class IdGenerator
{
    public const TYPE_OFFER = 1;
    public const TYPE_EVENTTICKET = 2;
    public const TYPE_FLIGHT = 3;
    public const TYPE_GIFTCARD = 4;
    public const TYPE_LOYALTY = 5;
    public const TYPE_TRANSIT = 6;

    private const ENTITY_CLASS = 'CLASS';
    private const ENTITY_OBJECT = 'OBJECT';

    private static array $typesMap = [
        self::TYPE_OFFER => 'OFFER',
        self::TYPE_EVENTTICKET => 'EVENTTICKET',
        self::TYPE_FLIGHT => 'FLIGHT',
        self::TYPE_GIFTCARD => 'GIFTCARD',
        self::TYPE_LOYALTY => 'LOYALTY',
        self::TYPE_TRANSIT => 'TRANSIT',
    ];

    public static function makeClassId(string $issuerId, int $type): string
    {
        if (!array_key_exists($type, self::$typesMap)) {
            throw new InvalidArgumentException('Invalid pass type');
        }
        return sprintf("%s.%s", $issuerId, self::makeUniqueId(self::ENTITY_CLASS, $type));
    }

    public static function makeObjectId(string $issuerId, int $type): string
    {
        if (!array_key_exists($type, self::$typesMap)) {
            throw new InvalidArgumentException('Invalid pass type');
        }
        return sprintf("%s.%s", $issuerId, self::makeUniqueId(self::ENTITY_OBJECT, $type));
    }

    private static function makeUniqueId(string $entity, string $type): string
    {
        return self::getTypeAsString($type) . "_" . $entity . "_" . uniqid('', true);
    }

    public static function getTypeAsString(int $typeId): ?string
    {
        return self::$typesMap[$typeId] ?? null;
    }
}