<?php

require_once "interfaces/AbstractManager.php";

/**
* 	This manager takes care of Doletic logs in database
*/
class LogManager extends AbstractManager {
	
	// -- attributes
	private $loggers;

	// -- functions

	public function __construct(&$kernel) {
		parent::__construct($kernel);
		/// \todo implement here
	}

	public function Init() {
		/// \todo implement here
	}
}
