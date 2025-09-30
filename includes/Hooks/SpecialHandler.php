<?php

namespace Telepedia\Extensions\ExternalVideo\Hooks;

use MediaWiki\Hook\SkinTemplateNavigation__UniversalHook;

class SpecialHandler implements SkinTemplateNavigation__UniversalHook {

	/**
	 * @inheritDoc
	 */
	public function onSkinTemplateNavigation__Universal( $sktemplate, &$links ): void {
		// MediaWiki is dumb and "NewFiles" is actually "Newimages"
		if ( $sktemplate->getTitle()->isSpecial( 'Newimages' ) ) {
			$links['views']['externalvideo-add'] = [
				'text' => $sktemplate->getContext()->msg( 'external-video-add' )->text(),
				'href' => '#',
				'id' => 'ca-add-video'
			];
		}
	}
}