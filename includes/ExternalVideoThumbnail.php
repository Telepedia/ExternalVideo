<?php

namespace Telepedia\Extensions\ExternalVideo;

use MediaWiki\Html\Html;
use ThumbnailImage;

class ExternalVideoThumbnail extends ThumbnailImage {

	/**
	 * Wrap the thumbnail so we can add our play button
	 * @param $options
	 * @return string
	 */
	public function toHtml( $options = [] ): string {
		return Html::rawElement(
			'span',
			[
				'class' => 'mw-external-video-thumbnail',
			],
			parent::toHtml( $options )
		);
	}
}