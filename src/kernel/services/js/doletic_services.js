
// ----------------------- DOLETIC INTERFACE SERVICES CLASS ----------------------------------

/**
 *  DoleticServicesInterface
 */
var DoleticServicesInterface = new function() {

  /**
   *  Global url to main script
   */
  this.doleticMainURL = 'http://localhost/src/kernel/Main.php';
  /**
   *  Loads a standard Doletic page using ui parameter 
   */
  this.getUI = function(ui) {
    window.location.replace(this.doleticMainURL + '?q=ui&page=' + ui);
  }
  /**
   *  Loads a specific Doletic Login page
   */
  this.getUILogin = function() {
    this.getUI('login');
  }
  /**
   *  Loads a specific Doletic Logout page
   */
  this.getUILogout = function() {
    DoleticMasterInterface.showConfirmModal(
      '',
      '',
      '<h2 class="ui inverted header"> \
        <i class="help inverted icon"></i> \
        <div class="content"> \
          Déconnexion ? \
          <div class="sub header">Souhaitez-vous vraiment vous deconnecter ?</div> \
        </div> \
      </h2>',
      function(){
        // require logout
        DoleticServicesInterface.getUI("logout");
      },
      function() {
        // hide modal and don't do anything
        DoleticMasterInterface.hideConfirmModal();
      });
  }
  /**
   *  Loads a specific Doletic 404 page
   */
  this.getUI404 = function() {
    this.getUI('404');
  }
  /**
   *  Loads a specific Doletic Home page
   */
  this.getUIHome = function() {
    this.getUI('home');
  }
  /**
   *  Loads a specific Doletic Auth page
   */
  this.authenticate = function(username, password, successHandler) {
    this.ajaxPOST(
      this.doleticMainURL, 
      {
        q: 'auth',
        user: username,
        hash: phpjsLight.sha1(password)
      },
      'json',
      DoleticServicesInterface.handleAJAXError,
      successHandler
      );
  }
  /**
   *  Require an upload from server
   */
  this.upload = function(formData, successHandler) {
    $.ajax({
         url: this.doleticMainURL,
         type: 'POST',
         data: formData,
         processData: false,
         contentType: false,
         dataType: 'json',
         error: DoleticServicesInterface.handleAJAXError,
         success: successHandler
      });
  }
  /**
   *  Make an AJAX call to Doletic services to retrieve some data
   */
  this.callService = function(object, action, params, successHandler) {
    this.ajaxPOST(
      this.doleticMainURL,
      {
        q:'service',
        obj:object,
        act:action,
        params:params
      },
      'json',
      DoleticServicesInterface.handleAJAXError,
      successHandler
      );
  }
  /**
   *  Make an ajax call. Do not call it from the outside of this class
   */
  this.ajaxPOST = function(url, data, dataType, errorHandler, successHandler) {
      // DEBUG -------------------------------
      console.debug("ajaxPOST called with url = "+url);
      // -------------------------------------
      $.ajax({
         url: url,
         type: 'POST',
         data: data,
         dataType: dataType,
         error: errorHandler,
         success: successHandler
      });
  }
  /**
   *  AJAX error default handler
   */
   this.handleAJAXError = function(jqXHR, textStatus, errorThrown) {
    // Show an error message on doletic interface
        DoleticMasterInterface.showError("L'appel AJAX a échoué !", "<p>L'appel AJAX d'authentification à échoué ! Détails : " + errorThrown + " ("+textStatus+")</p>");
        // Debug the response content
        console.debug(jqXHR.responseText);
   }

}

