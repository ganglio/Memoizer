<?php

namespace ganglio;

class Memoizer {

	const NOT_CALLABLE = 1;

	private $f = null;
	private $results = null;

	public function __construct($f) {
		if (!is_callable($f)) {
			throw new \InvalidArgumentException("Argument needs to be callable", self::NOT_CALLABLE);
		}

		$this->f = new \ReflectionFunction($f);
	}

	public function __invoke() {
		$args = func_get_args();
		$args_hash = spl_object_hash((object)$args);

		if (!isset($this->results[$args_hash])) {
			$this->results[$args_hash] = $this->f->invokeArgs($args);
		}

		return $this->results[$args_hash];
	}
}