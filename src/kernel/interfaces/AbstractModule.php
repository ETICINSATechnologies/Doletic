<?php

require_once "loaders/ModuleLoader.php";
require_once "objects/RightsMap.php";

/**
* 	@brief
*/
abstract class AbstractModule {
	
	// -- attributes
	private $mod_code = null;
	private $name = null;
	private $version = null;
	private $authors = null;
	private $dependencies = null;
	private $db_objects = null;
	private $db_services = null;
	private $uis = null;
	private $rights_map = null;
	private $ui_disabled = null;

	// -- functions
	public function GetCode() {
		return $this->mod_code;
	}
	/**
	 *
	 */
	public function GetName() {
		return $this->name;
	}
	/**
	 *
	 */
	public function GetVersion() {
		return $this->version;
	}
	/**
	 *
	 */
	public function GetAuthors() {
		return $this->authors;
	}
	/**
	 *
	 */
	public function GetDependencies() {
		return $this->dependencies;
	}
	/**
	 *
	 */
	public function GetDBObjects() {
		return $this->db_objects;
	}
	/**
	 *
	 */
	public function GetDBServices() {
		return $this->db_services;
	}
	/**
	 *
	 */
	public function GetJSServices() {
		return $this->mod_code."/services/services.js";
	}
	/**
	 *
	 */
	public function GetJS($uiCode) {
		$js = array();
		array_push($js, ModuleLoader::MODS_DIR.'/'.$this->mod_code."/ui/".$uiCode.".js");
		return $js;
	}
	/**
	 *
	 */
	public function GetCSS($uiCode) {
		$css = array();
		array_push($css, ModuleLoader::MODS_DIR.'/'.$this->mod_code."/ui/".$uiCode.".css");
		return $css;
	}
	/**
	 *
	 */
	public function GetAvailableUILinks($rgcode) {
		$ui_links = "[";
		if(!$this->ui_disabled) {
			$ui_links .= "\"".$this->name."\",[";
			$ui_added = false;
			// for each module ui 
			foreach ($this->uis as $ui_name => $ui_code) {
				// check if module ui can be accessed by current user
				if($this->CheckRights($rgcode, $ui_code)) {
					// add ui to list
					$ui_links .= "[\"".$ui_name."\",\"".$this->mod_code.":".$ui_code."\"],";	
					$ui_added = true; // raise added flag
				}
			}
			if($ui_added) {
				// if at least one ui added remove last comma
				$ui_links = substr($ui_links, 0, strlen($ui_links)-1);	
			}
			$ui_links .= "]";
		}
		return $ui_links."]";
	}
	/**
	 *
	 */
	public function CheckRights($rgcode, $action) {
		return ( $this->rights_map->Check($rgcode, $action) === RightsMap::OK );
	}

# PROTECTED & PRIVATE ###################################################

	protected function __construct($moduleCode, $name, $version, $authors, $groups, $rules, $uiDisabled = false, $dependencies = array()) {
		$this->mod_code = $moduleCode;
		$this->name = $name;
		$this->version = $version;
		$this->authors = $authors;
		$this->dependencies = $dependencies;
		$this->db_objects = array();
		$this->db_services = array();
		$this->uis = array();
		$this->rights_map = new RightsMap($groups, $rules);
		$this->ui_disabled = $uiDisabled;
	}

	protected function addDBObject($object) {
		$this->db_objects[$object->GetName()] = $object;
	}

	protected function addDBService($service) {
		$this->db_services[$service->GetName()] = $service;
	}

	protected function addUI($uiName, $uiCode) {
		$this->uis[$uiName] = $uiCode;
	}

}