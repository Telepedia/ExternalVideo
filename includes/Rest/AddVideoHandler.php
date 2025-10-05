<?php

namespace Telepedia\Extensions\ExternalVideo\Rest;

use MediaWiki\Rest\Response;
use MediaWiki\Rest\SimpleHandler;
use MediaWiki\Rest\TokenAwareHandlerTrait;
use MediaWiki\Rest\Validator\Validator;
use Telepedia\Extensions\ExternalVideo\ExternalVideoFactory;
use Telepedia\Extensions\ExternalVideo\ExternalVideoStore;
use Wikimedia\ParamValidator\ParamValidator;

class AddVideoHandler extends SimpleHandler {

	use TokenAwareHandlerTrait;

	public function __construct(
		private readonly ExternalVideoFactory $externalVideoFactory,
		private readonly ExternalVideoStore $externalVideoStore,
	) {}

	/**
	 * Upload our video and return the URL of the new file page to the caller
	 * so that they can redirect the user to the page
	 * @return Response
	 */
	public function run(): Response {

		if ( !$this->getAuthority()->isDefinitelyAllowed( 'upload' ) ) {
			return $this->getResponseFactory()->createHttpError(
				403,
				[ 'error' => wfMessage( 'externalvideo-upload-permissions' )->text() ]
			);
		}

		$data = $this->getValidatedBody();
		$user = $this->getSession()->getUser();

		if ( !filter_var( $data['url'], FILTER_VALIDATE_URL ) ) {
			return $this->getResponseFactory()->createHttpError(
				403,
				[ 'error' => wfMessage( 'externalvideo-invalid-url' )->text() ]
			);
		}

		$provider = $this->externalVideoFactory->newFromUrl( $data['url'] );

		if ( !$provider ) {
			return $this->getResponseFactory()->createHttpError(
				400,
				[ 'error' => wfMessage( 'externalvideo-provider-not-supported' )->text() ]
			);
		}

		$res = $this->externalVideoStore->createFileFromProvider( $provider, $user );

		if ( !$res->isOK() ) {
			return $this->getResponseFactory()->createHttpError(
				500,
				['error' => wfMessage( 'externalvideo-error' )->text() ]
			);
		}

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