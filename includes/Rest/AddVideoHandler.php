<?php

namespace Telepedia\Extensions\ExternalVideo\Rest;

use MediaWiki\Rest\Response;
use MediaWiki\Rest\SimpleHandler;
use MediaWiki\Rest\TokenAwareHandlerTrait;
use MediaWiki\Rest\Validator\Validator;
use Wikimedia\ParamValidator\ParamValidator;

class AddVideoHandler extends SimpleHandler {

	use TokenAwareHandlerTrait;

	public function __construct() {
		if ( !$this->getAuthority()->isDefinitelyAllowed( 'upload' ) ) {
			return $this->getResponseFactory()->createHttpError(
				403,
				[ 'error' => wfMessage( 'externalvideo-upload-permissions' )->text() ]
			);
		}

		$data = $this->getValidatedBody();
		$user = $this->getSession()->getUser();
	}

	/**
	 * Upload our video and return the URL of the new file page to the caller
	 * so that they can redirect the user to the page
	 * @return Response
	 */
	public function run(): Response {
		return $this->getResponseFactory()->createNoContent();
	}

	/**
	 * @inheritDoc
	 */
	public function needsWriteAccess(): bool {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function validate( Validator $restValidator ) {
		parent::validate( $restValidator );
		$this->validateToken( false );
	}

	/**
	 * @inheritDoc
	 */
	public function getBodyParamSettings(): array {
		return [
			'url' => [
				self::PARAM_SOURCE => 'body',
				ParamValidator::PARAM_TYPE => 'string',
			]
		] + $this->getTokenParamDefinition();
	}
}