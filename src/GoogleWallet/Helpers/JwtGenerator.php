<?php
declare(strict_types=1);


namespace Marlinc\PassbookBundle\GoogleWallet\Helpers;

use Firebase\JWT\JWT;

class JwtGenerator
{
    private const AUDIENCE = 'google';
    private const JWT_TYPE = 'savetoandroidpay';

    private string $issuer;
    private array $origins;
    private string $signingKey;

    public function __construct(string $issuer, string $signingKey, array $origins = [])
    {
        $this->issuer = $issuer;
        $this->origins = $origins;
        $this->signingKey = $signingKey;
    }

    public function generateJwt(JwtPayload $payload): string
    {
        $jwtToSign = [
            'iss' => $this->issuer,
            'aud' => self::AUDIENCE,
            'typ' => self::JWT_TYPE,
            'iat' => time(),
            'payload' => $payload->toArray(),
            'origins' => $this->origins
        ];

        return JWT::encode($jwtToSign, $this->signingKey, "RS256");
    }
}
