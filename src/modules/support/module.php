<?php

require_once "interfaces/AbstractModule.php";
require_once "../modules/support/services/objects/TicketDBObject.php";

class SupportModule extends AbstractModule {

	// -- attributes

	// -- functions

	public function __construct() {
		// -- build abstract module
		parent::__construct(
			"support",
			"Support", 
			"1.0dev", 
			array("Paul Dautry","Nicolas Sorin"), 
			array()
			);
		// -- add module specific dbo objects
		parent::addDBObject(new TicketDBObject());
	}

}

// ----------- ADD MODULE TO GLOBAL MODULES VAR -------------

ModuleLoader::RegisterModule(new SupportModule());