<?php

namespace Telepedia\Extensions\ExternalVideo\Hooks;

use MediaWiki\Hook\BeforePageDisplayHook;
use MediaWiki\Hook\SkinTemplateNavigation__UniversalHook;

class SpecialHandler implements
	SkinTemplateNavigation__UniversalHook,
	BeforePageDisplayHook
{

	/**
	 * @inheritDoc
	 */
	public function onSkinTemplateNavigation__Universal( $sktemplate, &$links ): void {
		// MediaWiki is dumb and "NewFiles" is actually "Newimages"
		if ( $sktemplate->getTitle()->isSpecial( 'Newimages' ) ) {
			$links['views']['externalvideo-add'] = [
				'text' => $sktemplate->getContext()->msg( 'externalvideo-add' )->text(),
				'href' => '#',
				'id' => 'ca-add-video'
			];
		}
	}

	/**
	 * @inheritDoc
	 */
	public function onBeforePageDisplay( $out, $skin ): void {
		if ( $out->getTitle()->isSpecial( 'Newimages' ) ) {
			$out->addModules( 'ext.externalvideo.scripts' );
		}

		$out->addModuleStyles( 'ext.externalvideo.styles' );
	}
}
