<?php

namespace spec\NetsuiteRestApi\Oauth;

use NetsuiteRestApi\Oauth\OauthService;
use PhpSpec\ObjectBehavior;

class OauthServiceSpec extends ObjectBehavior
{
    function let()
    {
        $companyUrl = "https://123456-sb1.suitetalk.api.netsuite.com";
        $accountId = "123456_SB1";
        $consumerKey = hash_hmac('sha256', 'a', '1');
        $consumerSecret = hash_hmac('sha256', 'b', '2');
        $tokenId = hash_hmac('sha256', 'c', '3');
        $tokenSecret = hash_hmac('sha256', 'd', '4');

        $this->beConstructedWith($companyUrl, $accountId, $consumerKey, $consumerSecret, $tokenId, $tokenSecret);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OauthService::class);
    }

    function it_should_generate_an_auth_header_for_a_GET_request(): void
    {
        $header = $this->getAuthorizationHeader('GET', 'http://test.com/path');

        $header->shouldStartWith('OAuth');
        $header->shouldContain('realm="123456_SB1"');
        $header->shouldContain(sprintf('oauth_consumer_key="%s"', hash_hmac('sha256', 'a', '1')));
        $header->shouldContain(sprintf('oauth_token="%s"', hash_hmac('sha256', 'c', '3')));
        $header->shouldContain('oauth_nonce=');
        $header->shouldContain('oauth_timestamp=');
        $header->shouldContain('oauth_version="1.0"');
        $header->shouldContain('oauth_signature=');
    }

    function it_should_generate_an_auth_header_for_a_GET_request_with_a_query(): void
    {
        $header = $this->getAuthorizationHeader('GET', 'http://test.com/path?a=1&b=2');

        $header->shouldStartWith('OAuth');
        $header->shouldContain('realm="123456_SB1"');
        $header->shouldContain(sprintf('oauth_consumer_key="%s"', hash_hmac('sha256', 'a', '1')));
        $header->shouldContain(sprintf('oauth_token="%s"', hash_hmac('sha256', 'c', '3')));
        $header->shouldContain('oauth_nonce=');
        $header->shouldContain('oauth_timestamp=');
        $header->shouldContain('oauth_version="1.0"');
        $header->shouldContain('oauth_signature=');
    }

    function it_should_generate_an_auth_header_for_a_POST_request(): void
    {
        $header = $this->getAuthorizationHeader('POT', 'http://test.com/path', ['customer' => '123']);

        $header->shouldStartWith('OAuth');
        $header->shouldContain('realm="123456_SB1"');
        $header->shouldContain(sprintf('oauth_consumer_key="%s"', hash_hmac('sha256', 'a', '1')));
        $header->shouldContain(sprintf('oauth_token="%s"', hash_hmac('sha256', 'c', '3')));
        $header->shouldContain('oauth_nonce=');
        $header->shouldContain('oauth_timestamp=');
        $header->shouldContain('oauth_version="1.0"');
        $header->shouldContain('oauth_signature=');
    }
}
