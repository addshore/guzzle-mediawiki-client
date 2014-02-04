<?php

namespace Guzzle\Service\Mediawiki\IntegrationTests;

use Guzzle\Service\Mediawiki\MediawikiApiClient;

class MediawikiApiClientTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var string
	 */
	private static $guzzleUser;
	private static $guzzlePassword = 'fooBarBaz123';

	const guzzleUserRandDigits = 6;

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		$digits = self::guzzleUserRandDigits;
		self::$guzzleUser = 'GuzzleUser' . str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
	}

	/**
	 * @return MediawikiApiClient
	 */
	private function getClient() {
		return MediawikiApiClient::factory( array( 'base_url' => "http://localhost/wiki/api.php" ) );
	}

	public function testCreateuser() {
		$client = $this->getClient();
		$result = $client->createaccount( array(
			'name' => self::$guzzleUser,
			'password' => self::$guzzlePassword,
		) );
		$result = $client->createaccount( array(
			'name' => self::$guzzleUser,
			'password' => self::$guzzlePassword,
			'token' => $result['createaccount']['token']
		) );
		$this->assertEquals( 'success', $result['createaccount']['result'] );
	}

	public function testParaminfo() {
		$client = $this->getClient();
		$result = $client->paraminfo( array( 'modules' => 'help' ) );
		$this->assertEquals( 'ApiHelp', $result['paraminfo']['modules'][0]['classname'] );
	}

}