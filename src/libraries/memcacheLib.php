<?php

class MemcacheLib extends Library {
	protected $mem = null;
	const MEMCACHE_TIMEOUT = 1800;

	public function __construct(){
		$this->getInstance();

	}

	private function getInstance(){
		if(is_null($this->mem)){
			// $this->mem = new Memcached();	
			$this->mem = new Memcached();	
			$this->mem->addServer("127.0.0.1", 11211);
		}

	}

	public function addItem($key, $item){
		$this->mem->add($key, $item, self::MEMCACHE_TIMEOUT);

	}

	public function getItem($key){

		return $this->mem->get($key);

	}

}
