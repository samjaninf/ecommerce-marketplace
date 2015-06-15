<?php namespace Koolbeans\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\Hash;

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
     * @param string $placeId
     *
     * @return bool
     */
    public function has($placeId)
    {
        $place = $this->getPlace($placeId);

        return $place['status'] === 'OK';
    }

    /**
     * @param string $placeId
     *
     * @return mixed
     */
    public function getPlace($placeId)
    {
        return $this->cache->remember('place.' . $placeId, 3600 * 24 * 31, function () use ($placeId) {
            return $this->httpGet('details/json', ['placeid' => $placeId]);
        });
    }

    /**
     * @param string $input
     *
     * @return mixed
     */
    public function nearby($input)
    {
        return $this->cache->remember('nearby.' . Hash::make($input), 3600 * 24 * 7, function () use ($input) {
            return $this->httpGet('autocomplete/json', ['input' => $input, 'types' => 'geocode']);
        });
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

        $url = "$this->url/$path?" . http_build_query($params);

        return $this->client->get($url)->json();
    }
}
