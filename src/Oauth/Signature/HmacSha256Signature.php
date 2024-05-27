<?php

namespace NetsuiteRestApi\Oauth\Signature;

class HmacSha256Signature extends Signature implements SignatureInterface
{
    use EncodesUrl;

    public function method(): string
    {
        return 'HMAC-SHA256';
    }

    public function sign(string $uri, array $parameters = [], string $method = 'POST'): string
    {
        $url = $this->createUrl($uri);

        $baseString = $this->baseString($url, $method, $parameters);

        return base64_encode($this->hash($baseString));
    }

    protected function hash($string): string
    {
        return hash_hmac('sha256', $string, $this->key(), true);
    }
}
