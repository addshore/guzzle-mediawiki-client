<?php

namespace Guzzle\Service\Mediawiki;

use Guzzle\Common\Exception\InvalidArgumentException;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Common\Collection;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;

/**
 * Methods within this class as generated from json
 *
 * General Methods
 * @method getAction( array $params )
 * @method postAction( array $params )
 *
 * Api methods
 * @method login( array $params )
 * @method logout( array $params )
 * @method createaccount( array $params )
 * @method query( array $params )
 * @method expandtemplates( array $params )
 * @method parse( array $params )
 * @method opensearch( array $params )
 * @method feedcontributions( array $params )
 * @method feedwatchlist( array $params )
 * @method help( array $params )
 * @method paraminfo( array $params )
 * @method rsd( array $params )
 * @method compare( array $params )
 * @method tokens( array $params )
 * @method purge( array $params )
 * @method setnotificationtimestamp( array $params )
 * @method rollback( array $params )
 * @method delete( array $params )
 * @method undelete( array $params )
 * @method protect( array $params )
 * @method block( array $params )
 * @method unblock( array $params )
 * @method move( array $params )
 * @method edit( array $params )
 * @method upload( array $params )
 * @method filerevert( array $params )
 * @method emailuser( array $params )
 * @method watch( array $params )
 * @method patrol( array $params )
 * @method import( array $params )
 * @method userrights( array $params )
 * @method options( array $params )
 * @method imagerotate( array $params )
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
        $client->setUserAgent('addwiki-guzzle-mediawiki-client');
        $client->setDescription(ServiceDescription::factory( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'mediawiki.json'));

        return $client;
    }
}
