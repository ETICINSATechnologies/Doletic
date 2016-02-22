<?php

require_once "../wrappers/utils/ovh-php/src/Api.php";

class DoleticOVHAPIConnector {
	// -- consts

	// -- attributes 
	private $api;

	// -- functions

	public function __construct($kernel, $httpClient = null) {
		// retrieve api settings
		$application_key = $kernel->SettingValue(SettingsManager::DBKEY_OVH_API_APP_KEY);
        $application_secret = $kernel->SettingValue(SettingsManager::DBKEY_OVH_API_APP_SEC);
        $endpoint = $kernel->SettingValue(SettingsManager::DBKEY_OVH_API_APP_ENDPOINT);
        $consumer_key = $kernel->SettingValue(SettingsManager::DBKEY_OVH_API_CONSUMER_KEY);
        // check settings
        if( isset($application_key) && strlen($application_key) > 0 &&
        	isset($application_secret) && strlen($application_secret) > 0 && 
        	isset($endpoint) && strlen($endpoint) > 0 &&
        	isset($consumer_key) && strlen($consumer_key) > 0) 
        {
        	// create api object
			$this->api = new Api(    
				$application_key,
	            $application_secret,
	            $endpoint,
	            $consumer_key,
			    $httpClient
			);
        } else {
        	$this->api = null;
        }
	}

	public function GetAPI() {
		return $this->api;
	}

# PROTECTED & PRIVATE ###########################################

// nothing here for now...
	
}