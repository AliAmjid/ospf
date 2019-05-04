<?php

namespace App\Presenters;

use App\Entity\neighbor;
use App\Entity\neighborEdge;
use App\Entity\network;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter {
	private $storage;

	public function __construct(Storage $storage) {
		$this->storage = $storage;
	}

	protected function beforeRender() {
		parent::beforeRender();
		$this->template->version = file_get_contents(__DIR__ . '/../../www/version');
	}

	public function actionDefault() {
	}

	public function actionGenerate($id) {
		//Vymazání mezipaměti v databázi
		$this->storage->deleteCache();

		$currentNetwork = $id;
		$this->storage->setShortestDistance($currentNetwork, 0);
		$this->storage->setPrevNetwork($currentNetwork, $currentNetwork);
		$lastDistanceFromSart = 0;
		$visited[] = 0;
		//Cyklus do té doby dokud nebudou známy všechny cesty
		/**
		 * @Popis:
		 *https://youtu.be/pVfj6mxhdMw?t=639
		 */
		while (true) {
			/** @var neighborEdge $neighborEdge */
			foreach ($this->storage->getNeighborsExcept($currentNetwork, $visited) as $neighborEdge) {
				$distanceFormStart = $lastDistanceFromSart + $neighborEdge->metric;
				/** @var network $net_b */
				$net_b = $this->storage->getNetwork($this->getRealNegihbor($neighborEdge, $currentNetwork));
				$ch_short = $net_b->ch_short ? $net_b->ch_short : 100000;
				if ($distanceFormStart < $ch_short) {
					$this->storage->setShortestDistance($net_b->id, $distanceFormStart);
					$this->storage->setPrevNetwork($net_b->id, $currentNetwork);
				}
			}
			$selNxt = [];
			if (count($visited) == count($this->storage->getNetworks())) {
				break;
			}
			$visited[] = $currentNetwork;
			$nextNetwork = $this->storage->getNextNetworkByRules($visited);
			$lastDistanceFromSart = $nextNetwork->ch_short;
			$currentNetwork = $nextNetwork->id;
		}
		if ($this->isAjax()) {
			$this->sendJson(array('done'));
		}
		$this->redirect('Homepage:render', $id);
	}

	/** Vyrednerování tabulky */
	public function actionRender($id) {
		$renderArray = array();
		$this->template->netwrok = $this->storage->getNetwork($id);
		/** @var network $network */
		foreach ($this->storage->getNetworks() as $network) {
			$row = new \stdClass();
			$row->name = $network->name;
			if ($network->ch_prev) {
				$row->metric = $network->ch_short;
				$row->last_network = $this->storage->getNetwork($network->ch_prev)->name;
				$pathString = "";
				$prev = $network;
				while ($prev->id != $id) {
					$pathString = $pathString . $prev->name . " &#8594; ";
					$prev = $this->storage->getNetwork($prev->ch_prev);
				}
				$pathString .= $this->storage->getNetwork($id)->name;
				$row->path = $pathString;
			} else {
				$row->metric = "??";
				$row->last_network = "??";
				$row->path = "??";

			}
			$renderArray[] = $row;
		}
		$this->template->data = $renderArray;
	}

	/** @var neighborEdge $neighborEdge */
	private function getRealNegihbor($neighborEdge, $current) {
		return $neighborEdge->network_a == $current ? $neighborEdge->network_b : $neighborEdge->network_a;
	}
}
