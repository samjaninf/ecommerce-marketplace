<?php namespace Koolbeans\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;

class GooglePlacesAPI
{

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    private $config;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    private $cache;

    /**
     * @param \GuzzleHttp\Client                      $client
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Contracts\Cache\Repository  $cache
     */
    public function __construct(Client $client, Config $config, Cache $cache)
    {
        $this->client = $client;
        $this->key    = $config->get('services.places.secret');
        $this->url    = 'https://maps.googleapis.com/maps/api/place';
        $this->config = $config;
        $this->cache  = $cache;
    }

    /**
     * @param $placeId
     *
     * @return bool
     */
    public function has($placeId)
    {
        $response = $this->cache->remember('place.' . $placeId, Carbon::now()->addMonth(), function () use ($placeId) {
            return $this->httpGet('details/json', ['placeid' => $placeId]);
        });

        return $response['status'] === 'OK';
    }

    /**
     * @param string $path
     * @param array  $params
     *
     * @return mixed
     */
    private function httpGet($path, array $params = [])
    {
        $params['key'] = $this->key;

        return $this->client->get("$this->url/$path?" . http_build_query($params))->json();
    }
}
