<?php

require_once "managers/LogManager.php";
require_once "managers/CronManager.php";
require_once "managers/DBManager.php";
require_once "managers/ModuleManager.php";
require_once "managers/SettingsManager.php";
require_once "managers/AuthenticationManager.php";
require_once "managers/UIManager.php";
require_once "loaders/ModuleLoader.php";
require_once "loaders/DBObjectLoader.php";

/**
* 	@brief
*/
class DoleticKernel {

	// -- consts

	// -- attributes
	// --- managers
	private $log_mgr;
	private $cron_mgr;
	private $db_mgr;
	private $module_mgr;
	private $settings_mgr;
	private $authentication_mgr;
	private $ui_mgr;
	// --- loaders
	private $module_ldr;
	private $dbobject_ldr;
	// --- flags
	private $initialized;

	// -- functions

	public function __construct() {
		// -- create managers
		$this->log_mgr = new LogManager($this);
		$this->cron_mgr = new CronManager($this);
		$this->db_mgr = new DBManager($this);
	 	$this->module_mgr = new ModuleManager($this);
	 	$this->settings_mgr = new SettingsManager($this);
	 	$this->authentication_mgr = new AuthenticationManager($this);
	 	$this->ui_mgr = new UIManager($this);
	 	// -- create loggers
	 	$this->module_ldr = new ModuleLoader($this, $this->module_mgr);
	 	$this->dbobject_ldr = new DBObjectLoader($this, $this->db_mgr);
	 	// -- unset initialized flag
	 	$this->initialized = false;
	}

	public function Init() {
		if(!$this->initialized) {
			// -- init managers
			$this->settings_mgr->Init();
			$this->__info("Settings Manager initialized.");
			$this->log_mgr->Init();
			$this->__info("Log Manager initialized.");
			$this->db_mgr->Init();
			$this->__info("Database Manager initialized.");
			$this->cron_mgr->Init();
			$this->__info("Cron Manager initialized.");
		 	$this->module_mgr->Init();
		 	$this->__info("Module Manager initialized.");
		 	$this->authentication_mgr->Init();
		 	$this->__info("Authentication Manager initialized.");
		 	$this->ui_mgr->Init();
		 	$this->__info("User Interface Manager initialized.");
		 	// -- init loaders
		 	$this->module_ldr->Init();
		 	$this->__info("Module Loader initialized.");
		 	$this->dbobject_ldr->Init();
		 	$this->__info("Database Object Loader initialized.");
		 	// -- set initialized flag
		 	$this->initialized = true;	
		} else {
			$this->__warn("Calling kernel initializer twice or more !");
		}
	}

	// --- authentication management ---------------------------------------------------------

	public function HasValidUser() {
		return $this->authentication_mgr->HasValidUser();
	}

	public function AuthenticateUser($username, $hash) {
		return $this->authentication_mgr->AuthenticateUser($username, $hash);
	}

	// --- log management --------------------------------------------------------------------

	public function Log($logger,$logMessage) {
		$this->log_mgr->Log($logger,$logMessage);
	}

	// --- settings management ---------------------------------------------------------------

	public function ReloadSettings() {
		$this->settings_mgr->Reload();
	}

	public function SettingValue($key) {
		return $this->settings_mgr->GetSettingValue($key);
	}

	// --- ui management ---------------------------------------------------------------------

	/**
	 *	Returns the HTML page required
	 */
	public function GetInterface($ui) { 
		$this->__debug("Showing '" . $ui . "' interface.");
		// initialize page
		$page = null;
		// check if requested ui is a special ui
		if($this->ui_mgr->IsSpecialUI($ui)) {
			$page = $this->ui_mgr->MakeSpecialUI($ui); // affect page content with special content
		} else { // page is not special, search for a module
			$module = $this->module_ldr->GetModule(explode(':', $ui)[0]);
			$found = false;										// initialize found flag down
			if($module != null) {								// if module exists
				$js = $module->GetJS($ui);						// retrieve js array
				$css = $module->GetCSS($ui);					// retrieve css array
				if($css != null && $css != null) {				// if both css and js are valid arrays
					$page = $this->ui_mgr->MakeUI($js, $css); 	// affect page content		
					$found = true; 								// raise found flag
				}
			} 
			if(!$found) { // if found flag is down
				$page = $this->ui_mgr->Make404UI(); // affect page content using 404	
			}
		}
		return $page;
	}

	// --- cron management --------------------------------------------------------------------

	public function RunCron() {
		$this->__info("Cron running tasks.");
		// -- run cron tasks
		$this->cron_mgr->RunTasks();
	}

	// --- database management --------------------------------------------------------------------

	public function ClearDatabase() {
		$this->__info("Clear database.");
		// -- remove all tables
		$this->dbobject_ldr->FullDBClear($this->db_mgr);
	}
	public function ResetDatabase() {
		$this->__info("Reset database.");
		// -- build or rebuild all tables
		$this->dbobject_ldr->FullDBReset($this->db_mgr);
	}
	public function UpdateDatabase() {
		$this->__info("Update database.");
		// -- update all tables
		$this->dbobject_ldr->FullDBUpdate($this->db_mgr);
	}
	public function ConnectDB() {
		$this->__info("Connect DB.");
		$this->db_mgr->InitAllConnections();
	}
	public function DisconnectDB() {
		$this->__info("Disconect DB.");
		$this->db_mgr->CloseAllConnections();
	}
	public function GetDBObject($objKey) {
		return $this->dbobject_ldr->GetDBObject($objKey);
	}

# PROTECTED & PRIVATE #################################################################################

	// --- logging functions

	private function __debug($msg) {
		if($this->SettingValue(SettingsManager::KEY_KERN_DEBUG)) {
			echo "[KERN_DEBUG]>>>> ".$msg."\n";	
		}
	}
	private function __info($msg) {
		if($this->SettingValue(SettingsManager::KEY_KERN_LOG)) {
			echo "[KERN_INFO]>>>> ".$msg."\n";	
		}	
	}
	private function __warn($msg) {
		if($this->SettingValue(SettingsManager::KEY_KERN_LOG)) {
			echo "[KERN_WARN]>>>> ".$msg."\n";	
		}	
	}
	private function __erro($msg) {
		if($this->SettingValue(SettingsManager::KEY_KERN_LOG)) {
			echo "[KERN_ERRO]>>>> ".$msg."\n";	
		}	
	}
}
