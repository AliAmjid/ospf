<?php


namespace App\Presenters;


use Dibi\Connection;
use Nette\DI\Container;

class Storage {

	private $connection;

	public function __construct(Container $container) {
		$params = $container->getParameters()['dibi'];
		$this->connection = new Connection([
			'driver' => $params['driver'],
			'host' => $params['host'],
			'username' => $params['username'],
			'password' => $params['password'],
			'database' => $params['database'],
		]);
	}


	public function getNetworks() {
		return $this->connection->query('SELECT * FROM networks')->fetchAll();
	}

	public function getNodes() {
		return $this->connection->query('SELECT * FROM network_has_neighbor')->fetchAll();
	}

	public function getAllExcept($id) {
		return $this->connection->query('SELECT * FROM networks WHERE id != %i', $id);
	}

	public function getNeighborsExcept($id, $except) {
		return $this->connection->query("SELECT * FROM network_has_neighbor WHERE network_a = %i OR network_b = %i AND network_a NOT IN %in AND network_b NOT IN %in",$id,$id,$except,$except)->fetchAll();
	}

	public function getNeighborsExceptTest($id, $except) {
		 $this->connection->test("SELECT * FROM network_has_neighbor WHERE network_a = %i OR network_b = %i AND network_a NOT IN %in AND network_b NOT IN %in",$id,$id,$except,$except);
	}

	public function getNeighborsByName($id) {
		return $this->connection->test('
SELECT a.a_name,b.b_name,metric FROM network_has_neighbor 
LEFT JOIN (SELECT name as a_name,id FROM networks) a ON a.id = network_a
LEFT JOIN (SELECT name as b_name,id FROM networks) b ON b.id = network_b
WHERE network_a = %i OR network_b = %i ',$id,$id)->fetchAll();
	}

	public function getNetworkName($id) {
	return $this->connection->query('SELECT name FROM networks WHERE id = %i',$id)->fetchSingle();
	}

	public function getNetworkId($name) {
		return $this->connection->query('SELECT id FROM networks WHERE name = %s',$name)->fetchSingle();
	}

	public function findInNeighbours($network,$searchingNetwork) {
		return $this->connection->query('SELECT * FROM (SELECT * FROM network_has_neighbor WHERE network_a = %i OR network_b = %i) t WHERE t.network_a = %i OR t.network.b = %i',$network,$network,$searchingNetwork,$searchingNetwork)->fetchAll();
	}

	public function neighboursSource() {
		return $this->connection->dataSource('SELECT * FROM network_has_neighbor')->toFluent();
	}

	public function deleteCache() {
		$this->connection->query('UPDATE networks SET ch_short = NULL, ch_prev = NULL, ch_done = NULL');
	}

	public function setShortestDistance($id, $distance) {
		$this->connection->query('UPDATE networks SET ch_short = %i WHERE id = %i',$distance,$id);
	}
	public function setDone($id,$done = 1) {
		$this->connection->query('UPDATE networks SET ch_done = %i WHERE id = %i',(int)$done,$id);
	}

	public function setPrevNetwork($id, $prevNetowrk) {
		$this->connection->query('UPDATE networks SET ch_prev = %i WHERE id = %i',$prevNetowrk,$id);
	}
	public function getNetwork($id) {
		return $this->connection->query('SELECT * FROM networks WHERE id = %i',$id)->fetch();
	}

	public function countUnesigned() {
		return $this->connection->query('SELECT * FROM networks WHERE ch_short IS NULL')->count();
	}

	public function getDistanceBetween($first, $second) {
		return $this->connection->query("SELECT metric FROM network_has_neighbor WHERE network_a = %i AND network_b = %i OR network_b = %i AND network_a = %i",$first,$second,$first,$second)->fetchSingle();
	}

	public function getNextNetworkByRules(array $visited) {
		return $this->connection->query('SELECT * FROM networks WHERE ch_short is NOT NULL AND id NOT IN %in ORDER BY ch_short LIMIT 1',$visited)->fetch();
	}
}