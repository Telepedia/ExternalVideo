<?php

use MediaWiki\Logger\LoggerFactory;
use MediaWiki\MediaWikiServices;
use Telepedia\Extensions\ExternalVideo\ExternalVideoFactory;
use Telepedia\Extensions\ExternalVideo\ExternalVideoStore;

return [

	'ExternalVideo.ExternalVideoFactory' => static function (
		MediaWikiServices $services
	): ExternalVideoFactory {
		return new ExternalVideoFactory(
			LoggerFactory::getInstance( 'ExternalVideo' ),
		);
	},

	'ExternalVideo.ExternalVideoStore' => static function (
		MediaWikiServices $services
	): ExternalVideoStore {
		return new ExternalVideoStore(
			$services->getRepoGroup()
		);
	},
];