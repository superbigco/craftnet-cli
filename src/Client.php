<?php

namespace CraftnetCli;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    private $client;

    public function __construct()
    {
        $credentials  = new Credentials();
        $this->client = new GuzzleClient([
            'auth' => $credentials->getAuthPair(),
        ]);
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLicenses()
    {
        return $this->get('plugin-licenses');
    }

    public function getLicense($id = null)
    {
        return $this->get('plugin-licenses/' . $id);
    }

    public function createLicense($payload = [])
    {
        return $this->post('plugin-licenses', ['json' => $payload]);
    }

    /**
     * @param string $endpoint
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($endpoint)
    {
        return $this->client->request('GET', 'https://api.craftcms.com/v1/' . $endpoint);
    }

    /**
     * @param string $endpoint
     * @param array  $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($endpoint, array $options = [])
    {
        $json = [];

        if (isset($options['json'])) {
            $json = $options['json'];
        }

        return $this->client->request('POST', 'https://api.craftcms.com/v1/' . $endpoint, array_merge([
            'json' => $json,
        ], $options));
    }
}