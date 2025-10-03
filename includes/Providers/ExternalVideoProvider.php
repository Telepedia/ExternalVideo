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
	 * @param int $width
	 * @param int $height
	 * @return string
	 */
	abstract function getEmbed( int $width, int $height ): string;

	/**
	 * Get the title for this video. The subclass is responsible for normalising the title to be
	 * MediaWiki compat
	 * @return string
	 */
	abstract function getTitle(): string;

	/**
	 * Get the description for the file page of this video. Caller is responsible for making it
	 * MediaWiki compat (ie, HTML must be transformed to wikitext)
	 * @return string
	 */
	abstract function getDescription(): string;

	/**
	 * Return the provider type (mime_minor) for this provider for the database. This determines
	 * which handler is responsible for the display
	 * @return string
	 */
	abstract function getMimeMinor(): string;

	/**
	 * The minimum width for the embed; below this point, return a thumbnail
	 * @return int
	 */
	abstract function getMinimumWidthForEmbed(): int;

	/**
	 * The minimum height for an embed - below this, return a thumbnail
	 * @return int
	 */
	abstract function getMinimumHeightForEmbed(): int;

}