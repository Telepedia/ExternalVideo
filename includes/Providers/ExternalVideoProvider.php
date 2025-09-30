<?php

namespace Telepedia\Extensions\ExternalVideo\Providers;

abstract class ExternalVideoProvider {

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
	 * Get the embed snipped (probably a iframe) for this provider
	 * @return string
	 */
	abstract function getEmbed(): string;
}