<?php

use MediaWiki\Logger\LoggerFactory;
use MediaWiki\MediaWikiServices;

return [

	'ExternalVideo.ExternalVideoFactory' => static function (
		MediaWikiServices $services
	): ExternalVideoFactory {
		return new ExternalVideoFactory(
			LoggerFactory::getInstance( 'ExternalVideo' ),
		);
	},
];