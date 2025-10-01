<?php

namespace Telepedia\Extensions\ExternalVideo\Handlers;

use MediaHandler;

class YouTubeHandler extends MediaHandler {

	/**
	 * @inheritDoc
	 */
	public function getParamMap(): array {
		return [
			'width' => 'width',
			'height' => 'height'
		];
	}

	/**
	 * Copied from TimedMediaHandler!!
	 * @inheritDoc
	 */
	public function validateParam( $name, $value ): ?int {
		if ( in_array( $name, ['width','height'] ) ) {
			return $value > 0;
		}
		return true;
	}

	/**
	 * Not sure this will actually work tbf
	 * @param $params
	 *
	 * @return string
	 */
	public function makeParamString( $params ): string {
		return http_build_query( $params );
	}

	/**
	 * @inheritDoc
	 */
	public function parseParamString( $str ): bool|array {
		parse_str( $str, $out );
		return $out;
	}

	/**
	 * @inheritDoc
	 */
	public function normaliseParams( $image, &$params ): void {
		// some default widths and heights taken from Fandom's implementation
		if ( empty( $params['width'] ) ) {
			$params['width'] = 480;
		}
		if ( empty( $params['height'] ) ) {
			$params['height'] = 360;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ): string|\MediaTransformOutput {
		// if we are in a gallery, or [[File:XYZ|thumb]] then just return the thumbnail
		return $dstUrl;
	}

	/**
	 * @inheritDoc
	 */
	public function getMetadata( $image, $path ): array|string {
		$metadata = [];

		if ( $image->getMetadataItem('videoId') ) {
			$metadata[] = [ 'name' => 'videoId', 'value' => $image->getMetadataItem('videoId') ];
		}

		return $metadata;
	}
}