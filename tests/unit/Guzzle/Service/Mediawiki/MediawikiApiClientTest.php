<?php

namespace Guzzle\Service\Mediawiki\UnitTests;

use Guzzle\Service\Mediawiki\MediawikiApiClient;

class MediawikiApiClientTest extends \PHPUnit_Framework_TestCase
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
		$wikiTextHtml = '%3D%20Wiki%20%3D%20%0A%20This%20is%20test%20text.%20%0A%0ASecond%20Paragraph%0A%0A%3D%3D%20Foo%20%3D%3D%0ALorem%20Ipsum';

		$testCases = array(
			'help' => array(
				'?action=help&format=json' => array(),
				'?action=help&format=json&modules=opensearch%7Cparse' => array('modules' => 'opensearch|parse'),
			),
			'parse' => array(
				'?action=parse&format=json&page=Wiki' => array('page' => 'Wiki'),
				'?action=parse&format=json&text='.$wikiTextHtml.'&contentmodel=wikitext' => array('text' => $wikiText, 'contentmodel' => 'wikitext'),
			),
			'logout' => array(
				'?action=logout&format=json' => array(),
			),
			'login' => array(
				'?action=login&format=json&lgname=foo&lgpassword=bar' => array( 'lgname' => 'foo', 'lgpassword' => 'bar' ),
				'?action=login&format=json&lgname=foo&lgpassword=bar&lgtoken=baz' => array( 'lgname' => 'foo', 'lgpassword' => 'bar', 'lgtoken' => 'baz' ),
			),
			'createaccount' => array(
				'?action=createaccount&format=json&name=foo&password=bar' => array( 'name' => 'foo', 'password' => 'bar' ),
			),
		);

		$provided = array();
		foreach( $testCases as $action => $details ) {
			foreach( $details as $url => $params ) {
				$provided[] = array( $action, $params, $url );
			}
		}
		return $provided;
	}

	/**
	 * @dataProvider provideCommandsAndUrls
	 * @param string $command
	 * @param array $params
	 * @param string $url
	 */
	public function testUrlConstruction( $command, $params, $url ) {
		$this->assertEquals( self::baseurl . $url, $this->getClient()->getCommand($command, $params)->prepare()->getUrl() );
	}

}