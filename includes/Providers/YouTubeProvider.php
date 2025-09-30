<?php

namespace Telepedia\Extensions\ExternalVideo\Providers;

class YouTubeProvider extends ExternalVideoProvider {

	public function __construct( private readonly string $id ) {

	}

	function getId(): string {
		// TODO: Implement getId() method.
	}

	function getThumbnailUrl(): string {
		// TODO: Implement getThumbnailUrl() method.
	}

	function getEmbed(): string {
		// TODO: Implement getEmbed() method.
	}
}