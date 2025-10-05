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
		$options['file-link'] = false;
		$options['desc-link'] = false;
		return Html::rawElement(
			'span',
			[
				'class' => 'mw-external-video-thumbnail',
			],
			parent::toHtml( $options ) . $this->getPlay()
		);
	}

	/**
	 * Get the play button to be added to the wrapped thumnbnail to
	 * indicate that this is a video
	 * @return string
	 */
	private function getPlay(): string {
		$width =  $this->width * 0.3;
		$height = $this->height * 0.3;
		$play = sprintf('<svg width="%d" height="%d" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round">
					<path style="fill:none" d="M0 0h100v100H0z"/>
					<clipPath id="a">
						<path d="M0 0h100v100H0z"/>
					</clipPath>
					<g clip-path="url(#a)">
						<path d="M3.125 49.992a46.88 46.88 0 0 0 13.729 33.146 46.88 46.88 0 0 0 66.292 0 46.88 46.88 0 0 0 0-66.292A46.875 46.875 0 0 0 3.125 49.992Z" style="fill:#fff;fill-rule:nonzero;stroke:#fff;stroke-width:6.25px"/>
						<path d="M37.5 65.054a6.82 6.82 0 0 0 3.999 6.202 6.818 6.818 0 0 0 7.301-1.073L71.875 50 48.8 29.804a6.816 6.816 0 0 0-7.303-1.078 6.82 6.82 0 0 0-3.997 6.207v30.121Z" style="fill:#d9e111;fill-rule:nonzero;stroke:#d9e111;stroke-width:6.25px"/>
					</g>
				</svg>',
				$width,
				$height
			);

		$play = Html::rawElement(
			'span',
			[
				'class' => 'mw-external-video-thumbnail-play',
			],
			$play
		);

		return $play;
	}
}