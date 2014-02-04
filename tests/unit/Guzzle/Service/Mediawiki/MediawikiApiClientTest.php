<?php

namespace Guzzle\Service\Mediawiki\UnitTests;

use Guzzle\Service\Mediawiki\MediawikiApiClient;

/**
 * @group unit
 */
class MediawikiApiClientUnitTest extends \PHPUnit_Framework_TestCase
{

	const baseurl = 'API';

	/**
	 * @return MediawikiApiClient
	 */
	private function getClient() {
		return MediawikiApiClient::factory( array( 'base_url' => self::baseurl ) );
	}

	public function provideCommandsAndUrls() {
		$wikiText = "= Wiki = \n This is test text. \n\nSecond Paragraph\n\n== Foo ==\nLorem Ipsum";

		return array(
			array( 'help', array() ),
			array( 'help', array('modules' => 'opensearch|parse') ),
			array( 'paraminfo', array() ),
			array( 'paraminfo', array('modules' => 'opensearch|parse') ),
			array( 'parse', array('page' => 'Wiki') ),
			array( 'parse', array('text' => $wikiText, 'contentmodel' => 'wikitext') ),
			array( 'logout', array() ),
			array( 'login', array( 'lgname' => 'foo', 'lgpassword' => 'bar' ) ),
			array( 'login', array( 'lgname' => 'foo', 'lgpassword' => 'bar', 'lgtoken' => 'baz' ) ),
			array( 'createaccount', array( 'name' => 'foo', 'password' => 'bar' ) ),
		);
	}

	/**
	 * @dataProvider provideCommandsAndUrls
	 * @param string $action
	 * @param array $params
	 */
	public function testUrlConstruction( $action, $params ) {
		$expectedParams = array_merge( $params, array( 'action' => $action, 'format' => 'json' ) );

		$command = $this->getClient()->getCommand( $action, $params );
		$request = $command->prepare();
		$url = $request->getUrl( true );
		$urlString = $request->getUrl();

		//Assert the params are as we expected
		$this->assertEquals(
			$expectedParams,
			$url->getQuery()->getAll()
		);

		//Assert the url is okay
		$expectedStart = self::baseurl . '?action=' . $action . '&format=json';
		$this->assertStringStartsWith( $expectedStart , $urlString );
		foreach( $params as $key => $value ) {
			$expectedMiddle = '&' . rawurlencode( $key ) . '=' . rawurlencode( $value );
			$this->assertContains( $expectedMiddle, $urlString );
		}
	}

}