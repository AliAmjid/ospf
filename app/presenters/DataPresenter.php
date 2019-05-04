<?php


namespace App\Presenters;


use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;

class DataPresenter extends Presenter {

	private $mapper;

	public function __construct(Storage $mapper) {
		$this->mapper = $mapper;
	}

	protected function startup() {
		parent::startup();
		if (!$this->isAjax()) {
			throw new \Exception('Request is not ajax!');
		}
	}

	public function ActionOnload() {
		$this->sendResponse(new JsonResponse(
			array(
				'networks' => $this->mapper->getNetworks(),
				'nodes' => $this->mapper->getNodes()
			)));
	}

}