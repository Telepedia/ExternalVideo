<?php

namespace Telepedia\Extensions\ExternalVideo\Providers;

use MediaWiki\Http\HttpRequestFactory;
use MediaWiki\MediaWikiServices;

abstract class ExternalVideoProvider {

	/**
	 * An instance of the HTTPRequestFactory that the provider
	 * can use to get stuff like the title and description for the video
	 * @var HttpRequestFactory
	 */
	protected HttpRequestFactory $httpRequestFactory;

	public function __construct() {
		$this->httpRequestFactory = MediaWikiServices::getInstance()->getHttpRequestFactory();
	}

	/**
	 * Get the ID of this video; need this for the embed and thumb generation
	 * @return string
	 */
	abstract function getId(): string;

	/**
	 * Return the URL of the thumb for this provider
	 * @return string
	 */
	abstract function getThumbnailUrl(): string;

	/**
	 * Get the embed snipped (probably an iframe) for this provider
	 * @return string
	 */
	abstract function getEmbed(): string;

	/**
	 * Get the title for this video. The caller MUST pass their title to this function
	 * parent::getTitle( $title ) which will deal with normalising the title to MediaWiki compat
	 * The caller should use the result for the upload
	 * @param string $title the title
	 * @return string
	 */
	protected function getTitle( string $title ): string {
		return str_replace(
			[
				'|',
				"[",
				"]",
				"<",
				">"
			],
			[
				"-",
				" ",
				" ",
				" ",
				" "
			],
			$title
		);
	}

	/**
	 * Get the description for the file page of this video. Caller is responsible for making it
	 * MediaWiki compat (ie, HTML must be transformed to wikitext)
	 * @return string
	 */
	abstract function getDescription(): string;
}