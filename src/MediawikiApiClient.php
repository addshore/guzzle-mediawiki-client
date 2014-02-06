<?php

namespace Guzzle\Service\Mediawiki;

use Guzzle\Common\Exception\InvalidArgumentException;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Common\Collection;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;

/**
 * @method array help( array $params )
 * @method array parse( array $params )
 * @method array login( array $params )
 * @method array logout( array $params )
 * @method array tokens( array $params )
 * @method array upload( array $params )
 * @method array createaccount( array $params )
 * @method array edit( array $params )
 */
class MediawikiApiClient extends Client
{
	/**
	 * Factory method to create a new MediawikiApiClient
	 *
	 * @param array|Collection $config Configuration data. Array keys:
	 *    base_url - Base URL of web service
	 *
	 * @throws InvalidArgumentException
	 * @return MediawikiApiClient
	 */
    public static function factory($config = array())
    {
        $required = array('base_url');
        $config = Collection::fromConfig($config, array(), $required);

        $client = new self($config->get('base_url'));

        $cookiePlugin = new CookiePlugin(new ArrayCookieJar());
        $client->addSubscriber($cookiePlugin);

        $client->setConfig($config);
        $client->setUserAgent('addwiki-mediawiki-api-client');
        $client->setDescription(ServiceDescription::factory(__DIR__ . DIRECTORY_SEPARATOR . 'client.json'));

        return $client;
    }
}
