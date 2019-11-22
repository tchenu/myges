<?php

namespace MyGes;

use GuzzleHttp\Client as HTTPClient;

class Client
{
    /**
     * OAuth Authorize URL
     */
    const OAUTH_AUTHORIZE_URL = 'https://authentication.reseau-ges.fr/oauth/authorize?client_id={clientId}&response_type=token';
    
    /**
     * OAuth clientId
     *
     * @var string
     */
    protected $clientId;

    /**
     * MyGes Login
     *
     * @var string
     */
    protected $login;

    /**
     * MyGes password
     *
     * @var string
     */
    protected $password;

    /**
     * Access Token
     *
     * @var string
     */
    protected $accessToken;

    public function __construct(string $clientId, string $login, string $password)
    {
        $url = str_replace('{clientId}', $clientId, self::OAUTH_AUTHORIZE_URL);

        $client = new HTTPClient();

        $response = $client->request('GET', $url, [
            'auth' => [
                $login,
                $password
            ],
            'allow_redirects' => false,
            'http_errors' => false
        ]);

        $headers = $response->getHeaders();
        $status  = $response->getStatusCode();

        if ($status === 401) {
            throw new Exceptions\BadCredentialsException('Wrong credentials');
        }
        
        $fragments      = $this->extractFragments($headers);
        $accessToken    = $this->extractAccessToken($fragments);

        $this->accessToken = $accessToken;
    }

    /**
     * Return current access token
     *
     * @return void
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Extract fragments from headers
     *
     * @param array $headers
     * @return string|null
     */
    private function extractFragments(array $headers) : ?string
    {
        $location = $headers['Location'][0];
    
        $locationUrl = parse_url($location);

        if (!isset($locationUrl['fragment']) || empty($locationUrl['fragment'])) {
            throw new \Exception('Impossible to extract fragments');
        }
    
        return $locationUrl['fragment'];
    }

    /**
     * Extract access token from fragments
     *
     * @param string $fragments
     * @return string|null
     */
    private function extractAccessToken(string $fragments) : ?string
    {
        parse_str($fragments, $queryParams);

        if (!isset($queryParams['access_token']) || empty($queryParams['access_token'])) {
            throw new \Exception('Impossible to extract access token');
        }

        return $queryParams['access_token'] ?? false;
    }
}
