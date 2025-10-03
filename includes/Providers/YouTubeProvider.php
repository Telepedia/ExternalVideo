<?php

namespace Telepedia\Extensions\ExternalVideo\Providers;

class YouTubeProvider extends ExternalVideoProvider {

	private string $thumbnailUrl;

	private string $title;

	public function __construct( private readonly string $id ) {
		parent::__construct();

		// YouTube is a bit of a funny one, we can get all the information we need from one
		// API call
		$this->setData();
	}

	/**
	 * Helper function to set all the data onto the Provider
	 * @return void
	 */
	public function setData(): void {
		$url = "https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=$this->id&format=json";
		$data = $this->httpRequestFactory->get( $url );
		$data = json_decode( $data, true );

		$this->thumbnailUrl = $data['thumbnail_url'];
		$this->title = $data['title'];
	}

	/**
	 * Get the ID corresponding to this video
	 * @return string
	 */
	function getId(): string {
		return $this->id;
	}

	/**
	 * Get the URL for the thumbnail that we can upload locally
	 * and display on the file page
	 * @return string
	 */
	function getThumbnailUrl(): string {
		return $this->thumbnailUrl;
	}

	/**
	 * Get an embed from YouTube for display on the file page
	 * @return string
	 */
	public function getEmbed( int $width, int $height ): string {
		return "<iframe width='$width' height='$height' "
			. "src='https://www.youtube.com/embed/{$this->id}' "
			. "frameborder='0' allowfullscreen></iframe>";
	}

	/**
	 * Get the sanitised title for this video, removing |[]<>
	 * @return string
	 */
	public function getTitle(): string {
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
			$this->title
		);
	}

	/**
	 * No-op at present
	 * @return string
	 */
	public function getDescription(): string {
		return "";
	}

	/**
	 * Mime type for this provider is video/youtube
	 * @return string
	 */
	public function getMimeMinor(): string {
		return "youtube";
	}

	/**
	 * @inheritDoc
	 */
	public function getMinimumWidthForEmbed(): int {
		return 480;
	}

	/**
	 * @inheritDoc
	 */
	public function getMinimumHeightForEmbed(): int {
		return 360;
	}


}