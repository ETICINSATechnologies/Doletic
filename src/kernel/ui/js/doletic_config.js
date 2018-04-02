// ----------------------------------- Doletic Config -----------------------------------

var DoleticConfig = new function () {

    // Junior-Entreprise related params
    this.JE = {
        name: 'ETIC INSA Technologies',
        website_url: 'http://www.etic-insa.com',
        logo_url: 'https://ibin.co/3w70yoxDrwvs.png',
        school: 'INSA Lyon',
        mail_domain: '@etic-insa.com'
    };

};

// ----------------------------------- Doletic UI Settings -----------------------------------

var DoleticUISettings = new function () {

    // ui settings structure
    this.settings = {
        night_mode: false
    };

    this.configurationForm = " \
	<form> \
       <div class=\"inline field\"> \
        <div id=\"set_night_mode\" class=\"ui toggle checkbox\" onClick=\"DoleticUISettings.toggleNightMode();\"> \
          <input type=\"checkbox\"> \
          <label>Mode nuit</label> \
        </div> \
      </div> \
    </form> \
	";

    // functions used to modify settings

    this.defaultSettings = function () {
        // reset settings structure
        this.settings = {
            night_mode: false
        };
        // reset form elements
        $('#set_night_mode').attr('class', 'ui toggle checkbox');
    };

    this.applySettings = function () {
        DoleticUIModule.nightMode(this.settings.night_mode);
    };

    this.toggleNightMode = function () {
        // change night mode
        this.settings.night_mode = (!this.settings.night_mode);
        // update form element
        if (this.settings.night_mode) {
            $('#set_night_mode').attr('class', 'ui toggle checkbox checked');
        } else {
            $('#set_night_mode').attr('class', 'ui toggle checkbox');
        }
        // notify master interface
        DoleticMasterInterface.nightMode(this.settings.night_mode);
        // notify module
        DoleticUIModule.nightMode(this.settings.night_mode);
    }

};
