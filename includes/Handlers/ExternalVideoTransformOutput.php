<?php

namespace Telepedia\Extensions\ExternalVideo\Handlers;

use MediaTransformOutput;
use Telepedia\Extensions\ExternalVideo\Providers\ExternalVideoProvider;

class ExternalVideoTransformOutput extends MediaTransformOutput {

	private ExternalVideoProvider $provider;

	private string $thumbUrl;

	public function __construct( array $conf ) {
		$this->thumbUrl = $conf['thumbUrl'];
		$this->provider = $conf['provider'];
		$this->width = $conf['width'];
		$this->height = $conf['height'];
	}

	/**
	 * @inheritDoc
	 */
	public function toHtml( $options = [] ): string {
		return $this->provider->getEmbed( $this->width, $this->height );
	}
}
