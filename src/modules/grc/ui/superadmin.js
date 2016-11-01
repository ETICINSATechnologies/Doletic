var DoleticUIModule = new function () {
    /**
     *    Parent abstract module
     */
    this.super = new AbstractDoleticUIModule('GRC_UIModule', 'Olivier Vicente', '1.0dev');

    this.CONTACT_TYPES = {
        PROSPECT : 'Prospect',
        ACHIEVED_PROSPECT : 'Prospect appelé',
        CONTACT : 'Client',
        OLD_CONTACT : 'Ancien Client'
    };

    /**
     *    Override render function
     */
    this.render = function (htmlNode) {
        this.super.render(htmlNode, this);
        // activate items in tabs
        $('.menu .item').tab();
        // Load HTML templates
        DoleticUIModule.getContactsTab();
        DoleticUIModule.getCompaniesTab();
        DoleticUIModule.getProspectsTab();
        DoleticUIModule.getAchievedProspectsTab();
        DoleticUIModule.getOldContactsTab();
        DoleticUIModule.getStatsTab();
        DoleticUIModule.getContactDetailsTab();
        DoleticUIModule.getContactFormModal();

        // Hide contact details
        $('#det_cont_tabChoose').hide();

        // Fill tables
        DoleticUIModule.fillFirmList(true);

        // Fill all the selectors
        DoleticUIModule.fillContactTypeSelector();
        DoleticUIModule.fillFirmTypeSelector();
        DoleticUIModule.fillCountrySelector();
        DoleticUIModule.fillGenderSelector();

        window.postLoad();
    };
    /**
     *    Override build function
     */
    this.build = function () {
        return "<div class=\"ui two column grid container\"> \
 				  	<div class=\"row\"> \
 				  		<div class=\"sixteen wide column\"> \
 				  			<div class=\"ui top attached tabular menu\"> \
   								<a class=\"item active\" data-tab=\"companies\">Gestion des Sociétés</a> \
   								<a class=\"item\" data-tab=\"prospects\">Prospections à réaliser</a> \
   								<a class=\"item\" data-tab=\"achievedProspects\">Résultats des prospections</a> \
   								<a class=\"item\" data-tab=\"contacts\">Contacts courants</a> \
   								<a class=\"item\" data-tab=\"oldContacts\">Anciens contacts</a> \
   								<a class=\"item\" data-tab=\"contactDetails\" id=\"det_cont_tabChoose\">Détails du contact</a> \
 							</div> \
 							<div class=\"ui bottom attached tab segment active\" data-tab=\"companies\"> \
								<div id=\"companiesTab\"> \
								</div> \
                        	</div> \
                            <div class=\"ui bottom attached tab segment\" data-tab=\"prospects\"> \
								<div id=\"prospectsTab\"> \
								</div> \
 					    	</div> \
                            <div class=\"ui bottom attached tab segment\" data-tab=\"achievedProspects\"> \
								<div id=\"achievedProspectsTab\"> \
								</div> \
 					    	</div> \
                            <div class=\"ui bottom attached tab segment\" data-tab=\"contacts\"> \
								<div id=\"contactsTab\"> \
								</div> \
 					    	</div> \
                            <div class=\"ui bottom attached tab segment\" data-tab=\"oldContacts\"> \
								<div id=\"oldContactsTab\"> \
								</div> \
 					    	</div> \
                            <div class=\"ui bottom attached tab segment\" data-tab=\"contactDetails\"> \
								<div id=\"contactDetailsTab\"> \
								</div> \
 					    	</div> \
						</div> \
 					</div> \
	 				<div class=\"row\"> \
	 				</div> \
				</div>\
                <div class=\"ui modal\" id=\"contact_form_modal\"></div>";
    };
    /**
     *    Override uploadSuccessHandler
     */
    this.uploadSuccessHandler = function (id, data) {
        this.super.uploadSuccessHandler(id, data);
    };

    this.nightMode = function (on) {
        if (on) {

        } else {

        }
    };

// ---- OTHER FUNCTION REQUIRED BY THE MODULE ITSELF

    /**
     *    Load the HTML code of the Contacts Tab
     */
    this.getContactsTab = function () {
        //$('#contact_form_modal').remove();
        $('#contactsTab').load("../modules/grc/ui/templates/contactsTab.html", function () {
            DoleticUIModule.fillContactList();
        });
    };

    /**
     *    Load the HTML code of the Companies Tab
     */
    this.getCompaniesTab = function () {
        $('#company_form_modal').remove();
        $('#companiesTab').load("../modules/grc/ui/templates/companiesTab.html", function () {
            $('#toggle_old_firms').change(function () {
                DoleticUIModule.fillFirmList(false);
            });
        });
    };

    /**
     *    Load the HTML code of the Propects Tab
     */
    this.getProspectsTab = function () {
        //$('#prospects_form_modal').remove();
        $('#prospectsTab').load("../modules/grc/ui/templates/prospectsTab.html", function () {
            DoleticUIModule.fillProspectList();
        });
    };

    /**
     *    Load the HTML code of the Propects Tab
     */
    this.getAchievedProspectsTab = function () {
        //$('#prospects_form_modal').remove();
        $('#achievedProspectsTab').load("../modules/grc/ui/templates/achievedProspectsTab.html", function () {
            DoleticUIModule.fillAchievedProspectList();
        });
    };

    /**
     *    Load the HTML code of the Contacts Tab
     */
    this.getOldContactsTab = function () {
        //$('#contact_form_modal').remove();
        $('#oldContactsTab').load("../modules/grc/ui/templates/oldContactsTab.html", function () {
            DoleticUIModule.fillOldContactList();
        });
    };

    /**
     *    Load the HTML code of the Stats Tab
     */
    this.getStatsTab = function () {
        $('#statsTab').load("../modules/grc/ui/templates/statsTab.html");
    };

    /**
     *    Load the HTML code of the Stats Tab
     */
    this.getContactDetailsTab = function () {
        $('#contactDetailsTab').load("../modules/grc/ui/templates/contactDetailsTab.html");
    };

    /**
     *    Load the HTML code of the Stats Tab
     */
    this.getContactFormModal = function () {
        $('#contact_form_modal').load("../modules/grc/ui/templates/contactFormModal.html", function() {
            DoleticUIModule.fillGenderSelector();
        });
    };

    /**
     *    Clear all the field from the Contact Form
     */
    this.clearNewContactForm = function () {
        $('#contact_form .message').remove();
        $('#contact_form')[0].reset();
        $('#contact_gender_field .dropdown').dropdown('restore defaults');
        $('#contact_type_field .dropdown').dropdown('restore defaults');
        $('#contact_firm_field .dropdown').dropdown('restore defaults');
        $('#contact_error_field .dropdown').dropdown('restore defaults');
        $('#contact_prospected_field .dropdown').dropdown('restore defaults');

        $('#contact_form h4').html("Ajout d'un contact");
        $('#addcontact_btn').html("Ajouter").attr("onClick", "DoleticUIModule.insertNewContact(); return false;");
    };

    /**
     *    Add a new Contact
     */
    this.insertNewContact = function () {
        // ADD OTHER TESTS
        if (DoleticUIModule.checkNewContactForm()) {
            // Insert new project in db
            ContactServicesInterface.insert(
                $('#contact_gender_search').dropdown('get value'),
                $('#contact_firstname').val(),
                $('#contact_lastname').val(),
                $('#contact_firm_search').dropdown('get value'),
                $('#contact_mail').val(),
                $('#contact_tel').val(),
                $('#contact_cell').val(),
                $('#contact_type_search').dropdown('get value'),
                $('#contact_role').val(),
                $('#contact_notes').val(),
                function (data) {
                    DoleticUIModule.addContactHandler(data);
                });
        }
    };

    /**
     *    Open Contact Details Tab
     */
    this.openContactInfo = function (contactId) {
        ContactServicesInterface.getById(contactId, function (data) {
            // if no service error
            if (data.code == 0 && data.object != "[]") {

                var tabTitle = "Détails de ";
                tabTitle += data.object.firstname;
                tabTitle += " ";
                tabTitle += data.object.lastname;
                $('#det_cont_tabChoose').html(tabTitle);

                $('#det_cont_name').html(data.object.gender + " " + data.object.firstname + " " + data.object.lastname);
                $('#det_cont_email').html(data.object.email);
                $('#det_cont_phone').html(data.object.phone);
                $('#det_cont_cellphone').html(data.object.cellphone);
                $('#det_cont_role').html(data.object.role);

                if(typeof window.firm_list[data.object.firm_id] !== 'undefined') {
                    $('#det_cont_firm').html(window.firm_list[data.object.firm_id].name);
                } else {
                    $('#det_cont_firm').html("<i>Aucune</i>");
                }

                if(data.object.prospected == 1) {
                    $('#det_cont_prospected').html("Oui");
                } else if(data.object.prospected == 0) {
                    $('#det_cont_prospected').html("Non");
                } else {
                    $('#det_cont_prospected').html("undefined");
                }

                if(data.object.errorFlag == -1) {
                    $('#det_cont_error').html("Correctes");
                } else {
                    $('#det_cont_error').html("Erronées");
                }

                if(data.object.nextCallDate !== null && data.object.nextCallDate != "") {
                    $('#det_cont_next_call_date').html(data.object.nextCallDate);
                } else {
                    $('#det_cont_next_call_date').html("<i>Aucune</i>");
                }

                if(data.object.origin !== null && data.object.origin != "") {
                    $('#det_cont_origin').html(data.object.origin);
                } else {
                    $('#det_cont_origin').html("<i>Inconnue</i>");
                }

                if(data.object.notes !== null && data.object.notes != "") {
                    $('#det_cont_notes').html(data.object.notes);
                } else {
                    $('#det_cont_notes').html("<i>Aucune</i>");
                }

                $('#det_cont_tabChoose').show();
                $('#det_cont_tabChoose').click();

            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    /**
     *    Add a new Firm
     */
    this.insertNewFirm = function () {
        // ADD OTHER TESTS
        if (DoleticUIModule.checkNewFirmForm()) {
            // Insert new project in db
            FirmServicesInterface.insert(
                $('#firm_siret').val(),
                $('#firm_name').val(),
                $('#firm_address').val(),
                $('#firm_postalcode').val(),
                $('#firm_city').val(),
                $('#firm_country_search').dropdown('get value'),
                $('#firm_type_search').dropdown('get value'),
                function (data) {
                    DoleticUIModule.addFirmHandler(data);
                });
        }
    };

    this.editContact = function (id) {
        $('#contact_form h4').html("Edition d'un contact");
        ContactServicesInterface.getById(id, function (data) {
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                $('#contact_firstname').val(data.object.firstname);
                $('#contact_lastname').val(data.object.lastname);
                $('#contact_tel').val(data.object.phone);
                $('#contact_cell').val(data.object.cellphone);
                $('#contact_mail').val(data.object.email);
                $('#contact_role').val(data.object.role);
                $('#contact_notes').val(data.object.notes);
                $('#contact_origin').val(data.object.origin);
                $('#sdatei_nextCalldate').val(data.object.nextCallDate);
                $('#contact_gender_search').dropdown("set selected", data.object.gender);
                $('#contact_type_search').dropdown("set selected", data.object.category);
                $('#contact_firm_search').dropdown("set selected", data.object.firm_id);
                $('#contact_prospected_search').dropdown("set selected", data.object.prospected);
                $('#contact_error_search').dropdown("set selected", data.object.errorFlag);
                $('#addcontact_btn').html("Confirmer").attr("onClick", "DoleticUIModule.updateContact(" + id + "); return false;");
                $('#contact_form_modal').modal('show');
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.editFirm = function (id) {
        $('#company_form h4').html("Edition d'une société");
        FirmServicesInterface.getById(id, function (data) {
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                $('#firm_name').val(data.object.name);
                $('#firm_siret').val(data.object.siret);
                $('#firm_address').val(data.object.address);
                $('#firm_postalcode').val(data.object.postal_code);
                $('#firm_city').val(data.object.city);
                $('#firm_type_search').dropdown("set selected", data.object.type);
                $('#contact_type_search').dropdown("set selected", data.object.category);
                $('#firm_country_search').dropdown("set selected", data.object.country);
                $('#addfirm_btn').html("Confirmer").attr("onClick", "DoleticUIModule.updateFirm(" + id + "); return false;");
                $('#company_form_modal').modal('show');
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.updateContact = function (id) {
        // ADD OTHER TESTS
        if (DoleticUIModule.checkNewContactForm()) {
            // Insert new project in db
            ContactServicesInterface.update(
                id,
                $('#contact_gender_search').dropdown('get value'),
                $('#contact_firstname').val(),
                $('#contact_lastname').val(),
                $('#contact_firm_search').dropdown('get value'),
                $('#contact_mail').val(),
                $('#contact_tel').val(),
                $('#contact_cell').val(),
                $('#contact_type_search').dropdown('get value'),
                $('#contact_role').val(),
                $('#contact_notes').val(),
                function (data) {
                    DoleticUIModule.editContactHandler(data);
                });
        }
    };

    this.updateFirm = function (id) {
        // ADD OTHER TESTS
        if (DoleticUIModule.checkNewFirmForm()) {
            // Insert new project in db
            FirmServicesInterface.update(
                id,
                $('#firm_siret').val(),
                $('#firm_name').val(),
                $('#firm_address').val(),
                $('#firm_postalcode').val(),
                $('#firm_city').val(),
                $('#firm_country_search').dropdown('get value'),
                $('#firm_type_search').dropdown('get value'),
                function (data) {
                    DoleticUIModule.editFirmHandler(data);
                });
        }
    };

    /**
     *    Clear all the field from the Firm Form
     */
    this.clearNewFirmForm = function () {
        $('#company_form .message').remove();
        $('#company_form')[0].reset();
        $('#company_form .dropdown').dropdown('restore defaults');
        $('#company_form h4').html("Ajout d'une société");
        $('#addfirm_btn').html("Ajouter").attr("onClick", "DoleticUIModule.insertNewFirm(); return false;");
    };

    /**
     *    Fill the contact type selector
     */
    this.fillContactTypeSelector = function () {
        ContactServicesInterface.getAllContactTypes(function (data) {
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                var content = '';
                for (var i = 0; i < data.object.length; i++) {
                    content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                }
                $('#contact_type_search .menu').html(content);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    /**
     *    Fill the firm type selector
     */
    this.fillFirmTypeSelector = function () {
        FirmServicesInterface.getAllFirmTypes(function (data) {
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                var content = '';
                for (var i = 0; i < data.object.length; i++) {
                    content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                }
                $('#firm_type_search .menu').html(content).dropdown();
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    /**
     *    Add the countries selector
     */
    this.fillCountrySelector = function () {
        UserDataServicesInterface.getAllCountries(function (data) {
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                var content = '';
                for (var i = 0; i < data.object.length; i++) {
                    content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                }
                $('#firm_country_search .menu').html(content);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    /**
     *    Add the gender selector
     */
    this.fillGenderSelector = function () {
        UserDataServicesInterface.getAllGenders(function (data) {
            // if no service error
            if (data.code == 0) {
                // create content var to build html
                var content = '';
                // iterate over values to build options
                for (var i = 0; i < data.object.length; i++) {
                    content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                }
                // insert html content

                $('#contact_gender_search .menu').html(content);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    /**
     *    Add the gender selector
     */
    this.fillFirmList = function (fillContact) {
        var showOld = $('#toggle_old_firms').prop('checked');
        FirmServicesInterface.getAll(function (data) {
            window.firm_list = [];
            $('#company_table_container').html('');
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                var content = "<table class=\"ui very basic celled table\" id=\"company_table\"> \
                <thead> \
                    <tr>\
                        <th>Nom</th> \
                        <th>SIRET</th> \
                        <th>Type</th> \
                        <th>Adresse</th> \
                        <th>Code postal</th> \
                        <th>Ville</th> \
                        <th>Pays</th> \
                        <th>Actions</th> \
                    </tr>\
                </thead>\
                <tfoot> \
                    <tr>\
                        <th>Nom</th> \
                        <th>SIRET</th> \
                        <th>Type</th> \
                        <th>Adresse</th> \
                        <th>Code postal</th> \
                        <th>Ville</th> \
                        <th>Pays</th> \
                        <th></th> \
                    </tr>\
                </tfoot>\
                <tbody id=\"company_body\">";

                var filters = [
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.reset_filter
                ];
                var selector_content = '';
                var counter = 0;
                for (var i = 0; i < data.object.length; i++) {
                    window.firm_list[data.object[i].id] = data.object[i];
                    if (showOld || counter < 100) {
                        content += "<tr><td>" + data.object[i].name + "</td> \
			      					<td>" + data.object[i].siret + "</td> \
			      					<td>" + data.object[i].type + "</td> \
			      					<td>" + data.object[i].address + "</td> \
			      					<td>" + data.object[i].postal_code + "</td>\
			    					<td>" + data.object[i].city + "</td>\
                                    <td>" + data.object[i].country + "</td> \
			    				<td> \
			    					<div class=\"ui icon buttons\"> \
				    					<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editFirm(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"write icon\"></i> \
										</button>" +
                            "<button class=\"ui red icon button\" data-tooltip=\"Supprimer\" onClick=\"DoleticUIModule.deleteFirm(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"remove icon\"></i> \
										</button> \
									</div> \
			    				</td> \
			    				</tr>";
                    }
                    selector_content += '<div class="item" data-value="' + data.object[i].id + '">' + data.object[i].name + '</div>';
                    counter++;
                }
                content += "</tbody></table>";
                $('#company_table_container').append(content);
                $('#contact_firm_search .menu').html(selector_content);
                DoleticMasterInterface.makeDataTables('company_table', filters);
                if (fillContact) {
                    DoleticUIModule.fillContactList();
                }
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillProspectList = function() {
        ContactServicesInterface.getByCategory(this.CONTACT_TYPES.PROSPECT, function (data) {
            $('#prospect_table_container').html('');
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                var content = "<table class=\"ui very basic celled table\" id=\"prospect_table\"> \
                <thead> \
                    <tr>\
                        <th>Nom/Email</th> \
                        <th>Téléphone</th> \
                        <th>Mobile</th> \
                        <th>Société</th> \
                        <th>Role</th> \
                        <th>Actions</th> \
                    </tr>\
                </thead>\
                <tfoot> \
                    <tr>\
                        <th>Nom/Email</th> \
                        <th>Téléphone</th> \
                        <th>Mobile</th> \
                        <th>Société</th> \
                        <th>Role</th> \
                        <th></th> \
                    </tr>\
                </tfoot>\
                <tbody id=\"prospect_body\">";

                var filters = [
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.reset_filter
                ];
                var counter = 0;
                for (var i = 0; i < data.object.length && counter<100; i++) {

                    content += "<tr><td> \
			        				<h4 class=\"ui header\"> \
			          				<div class=\"content\">" + data.object[i].firstname + " " + data.object[i].lastname +
                        "<div class=\"sub header\"><a href=\"mailto:" + data.object[i].email + "\" target=\"_blank\">" + data.object[i].email + "</a></div> \
			        				</div> \
			      					</h4></td> \
			      					<td>" + data.object[i].phone + "</td> \
			      					<td>" + data.object[i].cellphone + "</td> \
			      					<td>" + (typeof window.firm_list[data.object[i].firm_id] !== 'undefined' ? window.firm_list[data.object[i].firm_id].name : '<i>Aucune</i>') + "</td> \
			    				    <td>" + data.object[i].role + "</td> \
			    				    <td> \
			    					<div class=\"ui icon buttons\"> \
			    					    <button class=\"ui teal icon button\" data-tooltip=\"Informations\" onClick=\"DoleticUIModule.openContactInfo(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"info icon\"></i> \
										</button>\
				    					<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editContact(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"write icon\"></i> \
										</button>" +
                                        "<button class=\"ui orange icon button\" data-tooltip=\"Marquer comme prospecté\" onClick=\"\"> \
                                              <i class=\"call icon\"></i> \
                                        </button> \
                                        <button class=\"ui red icon button\" data-tooltip=\"Supprimer\" onClick=\"DoleticUIModule.deleteContact(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"remove icon\"></i> \
										</button> \
									</div> \
			    				</td> \
			    				</tr>";
                    counter++;
                }
                content += "</tbody></table>";
                $('#prospect_table_container').append(content);
                DoleticMasterInterface.makeDataTables('prospect_table', filters);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillAchievedProspectList = function() {
        ContactServicesInterface.getByCategory(this.CONTACT_TYPES.ACHIEVED_PROSPECT, function (data) {
            $('#achievedProspect_table_container').html('');
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                var content = "<table class=\"ui very basic celled table\" id=\"achievedProspect_table\"> \
                <thead> \
                    <tr>\
                        <th>Nom/Email</th> \
                        <th>Société</th> \
                        <th>Role</th> \
                        <th>Prochaine prospection</th> \
                        <th>Coordonnées</th> \
                        <th>Actions</th> \
                    </tr>\
                </thead>\
                <tfoot> \
                    <tr>\
                        <th>Nom/Email</th> \
                        <th>Société</th> \
                        <th>Role</th> \
                        <th>Prochaine prospection</th> \
                        <th>Coordonnées</th> \
                        <th></th> \
                    </tr>\
                </tfoot>\
                <tbody id=\"achievedProspect_body\">";

                var filters = [
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.reset_filter
                ];
                var counter = 0;
                for (var i = 0; i < data.object.length && counter<100; i++) {

                    var nextCallDate = "<i>Aucune</i>";
                    if(data.object[i].nextCallDate !== null) {
                        nextCallDate = data.object[i].nextCallDate;
                    }

                    var error = "Correctes";
                    if(data.object[i].errorFlag != -1) {
                        error = "Erronées";
                    }

                    content += "<tr><td> \
			        				<h4 class=\"ui header\"> \
			          				<div class=\"content\">" + data.object[i].firstname + " " + data.object[i].lastname +
                        "<div class=\"sub header\"><a href=\"mailto:" + data.object[i].email + "\" target=\"_blank\">" + data.object[i].email + "</a></div> \
			        				</div> \
			      					</h4></td> \
			      					<td>" + (typeof window.firm_list[data.object[i].firm_id] !== 'undefined' ? window.firm_list[data.object[i].firm_id].name : '<i>Aucune</i>') + "</td> \
			    				    <td>" + data.object[i].role + "</td> \
			      					<td>" + nextCallDate + "</td> \
			    				    <td>" + error + "</td> \
			    				    <td> \
			    					<div class=\"ui icon buttons\"> \
			    					    <button class=\"ui teal icon button\" data-tooltip=\"Informations\" onClick=\"DoleticUIModule.openContactInfo(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"info icon\"></i> \
										</button>\
				    					<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editContact(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"write icon\"></i> \
										</button>" +
                                        "<button class=\"ui yellow icon button\" data-tooltip=\"Demander une prospection\" onClick=\"\"> \
                                              <i class=\"reply icon\"></i> \
                                        </button> \
                                        <button class=\"ui orange icon button\" data-tooltip=\"Marquer comme client\" onClick=\"\"> \
                                              <i class=\"suitcase icon\"></i> \
                                        </button> \
                                        <button class=\"ui red icon button\" data-tooltip=\"Supprimer\" onClick=\"DoleticUIModule.deleteContact(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"remove icon\"></i> \
										</button> \
									</div> \
			    				</td> \
			    				</tr>";
                    counter++;
                }
                content += "</tbody></table>";
                $('#achievedProspect_table_container').append(content);
                DoleticMasterInterface.makeDataTables('achievedProspect_table', filters);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillContactList = function () {
        ContactServicesInterface.getByCategory(this.CONTACT_TYPES.CONTACT, function (data) {
            $('#contact_table_container').html('');
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                var content = "<table class=\"ui very basic celled table\" id=\"contact_table\"> \
                <thead> \
                    <tr>\
                        <th>Nom/Email</th> \
                        <th>Téléphone</th> \
                        <th>Mobile</th> \
                        <th>Société</th> \
                        <th>Role</th> \
                        <th>Prospecté</th> \
                        <th>Actions</th> \
                    </tr>\
                </thead>\
                <tfoot> \
                    <tr>\
                        <th>Nom/Email</th> \
                        <th>Téléphone</th> \
                        <th>Mobile</th> \
                        <th>Société</th> \
                        <th>Role</th> \
                        <th>Prospecté</th> \
                        <th></th> \
                    </tr>\
                </tfoot>\
                <tbody id=\"company_body\">";

                var filters = [
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.reset_filter
                ];
                var counter = 0;
                for (var i = 0; i < data.object.length && counter<100; i++) {

                    var isProspected = "Non";
                    if(data.object[i].prospected == 1) {
                        isProspected = "Oui";
                    }

                    content += "<tr><td> \
			        				<h4 class=\"ui header\"> \
			          				<div class=\"content\">" + data.object[i].firstname + " " + data.object[i].lastname +
                        "<div class=\"sub header\"><a href=\"mailto:" + data.object[i].email + "\" target=\"_blank\">" + data.object[i].email + "</a></div> \
			        				</div> \
			      					</h4></td> \
			      					<td>" + data.object[i].phone + "</td> \
			      					<td>" + data.object[i].cellphone + "</td> \
			      					<td>" + (typeof window.firm_list[data.object[i].firm_id] !== 'undefined' ? window.firm_list[data.object[i].firm_id].name : '<i>Aucune</i>') + "</td> \
			    				    <td>" + data.object[i].role + "</td> \
			    				    <td>" + isProspected + "</td> \
			    				    <td> \
			    					<div class=\"ui icon buttons\"> \
			    					    <button class=\"ui teal icon button\" data-tooltip=\"Informations\" onClick=\"DoleticUIModule.openContactInfo(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"info icon\"></i> \
										</button>\
				    					<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editContact(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"write icon\"></i> \
										</button>" +
                                        "<button class=\"ui orange icon button\" data-tooltip=\"Marquer comme ancien\" onClick=\"\"> \
				  							<i class=\"blind icon\"></i> \
										</button> \
										<button class=\"ui red icon button\" data-tooltip=\"Supprimer\" onClick=\"DoleticUIModule.deleteContact(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"remove icon\"></i> \
										</button> \
									</div> \
			    				</td> \
			    				</tr>";
                    counter++;
                }
                content += "</tbody></table>";
                $('#contact_table_container').append(content);
                DoleticMasterInterface.makeDataTables('contact_table', filters);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillOldContactList = function () {
        ContactServicesInterface.getByCategory(this.CONTACT_TYPES.OLD_CONTACT, function (data) {
            $('#oldContact_table_container').html('');
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                var content = "<table class=\"ui very basic celled table\" id=\"oldContact_table\"> \
                <thead> \
                    <tr>\
                        <th>Nom/Email</th> \
                        <th>Téléphone</th> \
                        <th>Mobile</th> \
                        <th>Société</th> \
                        <th>Role</th> \
                        <th>Prospecté</th> \
                        <th>Actions</th> \
                    </tr>\
                </thead>\
                <tfoot> \
                    <tr>\
                        <th>Nom/Email</th> \
                        <th>Téléphone</th> \
                        <th>Mobile</th> \
                        <th>Société</th> \
                        <th>Role</th> \
                        <th>Prospecté</th> \
                        <th></th> \
                    </tr>\
                </tfoot>\
                <tbody id=\"oldContact_body\">";

                var filters = [
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.reset_filter
                ];
                var counter = 0;
                for (var i = 0; i < data.object.length && counter<100; i++) {

                    var isProspected = "Non";
                    if(data.object[i].prospected == 1) {
                        isProspected = "Oui";
                    }

                    content += "<tr><td> \
			        				<h4 class=\"ui header\"> \
			          				<div class=\"content\">" + data.object[i].firstname + " " + data.object[i].lastname +
                        "<div class=\"sub header\"><a href=\"mailto:" + data.object[i].email + "\" target=\"_blank\">" + data.object[i].email + "</a></div> \
			        				</div> \
			      					</h4></td> \
			      					<td>" + data.object[i].phone + "</td> \
			      					<td>" + data.object[i].cellphone + "</td> \
			      					<td>" + (typeof window.firm_list[data.object[i].firm_id] !== 'undefined' ? window.firm_list[data.object[i].firm_id].name : '<i>Aucune</i>') + "</td> \
			    				    <td>" + data.object[i].role + "</td> \
			    				    <td>" + isProspected + "</td> \
			    				    <td> \
			    					<div class=\"ui icon buttons\"> \
			    					    <button class=\"ui teal icon button\" data-tooltip=\"Informations\" onClick=\"DoleticUIModule.openContactInfo(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"info icon\"></i> \
										</button>\
				    					<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editContact(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"write icon\"></i> \
										</button>" +
                                        "<button class=\"ui yellow icon button\" data-tooltip=\"Demander une prospection\" onClick=\"\"> \
                                              <i class=\"reply icon\"></i> \
                                        </button> \
                                        <button class=\"ui red icon button\" data-tooltip=\"Supprimer\" onClick=\"DoleticUIModule.deleteContact(" + data.object[i].id + "); return false;\"> \
				  							<i class=\"remove icon\"></i> \
										</button> \
									</div> \
			    				</td> \
			    				</tr>";
                    counter++;
                }
                content += "</tbody></table>";
                $('#oldContact_table_container').append(content);
                DoleticMasterInterface.makeDataTables('oldContact_table', filters);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.showNewFirmForm = function () {
        DoleticUIModule.clearNewFirmForm();
        $('#company_form_modal').modal('show');
    };

    this.cancelNewFirmForm = function () {
        DoleticUIModule.clearNewFirmForm();
        $('#company_form_modal').modal('hide');
    };

    this.showNewContactForm = function () {
        DoleticUIModule.clearNewContactForm();
        $('#contact_form_modal').modal('show');
    };

    this.cancelNewContactForm = function () {
        DoleticUIModule.clearNewContactForm();
        $('#contact_form_modal').modal('hide');
    };

    this.deleteContact = function (id) {
        // Confirmation
        DoleticMasterInterface.showConfirmModal("Confirmer la suppression", "\<i class=\"remove icon\"\>\<\/i\>",
            "Etes-vous sûr de vouloir supprimer le contact ? Cette opération est irréversible.",
            function () {
                DoleticUIModule.deleteContactHandler(id);
            },
            DoleticMasterInterface.hideConfirmModal);
    };

    this.deleteFirm = function (id) {
        // Confirmation
        DoleticMasterInterface.showConfirmModal("Confirmer la suppression", "\<i class=\"remove icon\"\>\<\/i\>",
            "Etes-vous sûr de vouloir supprimer la société ? Cette opération est irréversible.",
            function () {
                DoleticUIModule.deleteFirmHandler(id);
            },
            DoleticMasterInterface.hideConfirmModal);
    };

    this.addContactHandler = function (data) {
        // if no service error
        if (data.code == 0) {
            // clear contact form
            DoleticUIModule.cancelNewContactForm();
            DoleticMasterInterface.showSuccess("Ajout réussi !", "Le contact a été ajouté avec succès !");
            DoleticUIModule.fillContactList();
        } else {
            // use default service service error handler
            DoleticServicesInterface.handleServiceError(data);
        }
    };

    this.editContactHandler = function (data) {
        // if no service error
        if (data.code == 0) {
            // clear contact form
            DoleticUIModule.cancelNewContactForm();
            DoleticMasterInterface.showSuccess("Édition réussie !", "Le contact a été modifié avec succès !");
            DoleticUIModule.fillContactList();
        } else {
            // use default service service error handler
            DoleticServicesInterface.handleServiceError(data);
        }
    };

    this.deleteContactHandler = function (id) {
        ContactServicesInterface.delete(id, function (data) {
            // if no service error
            if (data.code == 0) {
                DoleticMasterInterface.hideConfirmModal();
                DoleticMasterInterface.showSuccess("Suppression réussie !", "Le contact a été supprimé avec succès !");
                DoleticUIModule.fillContactList();
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.addFirmHandler = function (data) {
        // if no service error
        if (data.code == 0) {
            // clear firm form
            DoleticUIModule.cancelNewFirmForm();
            DoleticMasterInterface.showSuccess("Ajout réussi !", "La société a été ajoutée avec succès !");
            DoleticUIModule.fillFirmList(false);
        } else {
            // use default service service error handler
            DoleticServicesInterface.handleServiceError(data);
        }
    };

    this.editFirmHandler = function (data) {
        // if no service error
        if (data.code == 0) {
            // clear firm form
            DoleticUIModule.cancelNewFirmForm();
            DoleticMasterInterface.showSuccess("Édition réussi !", "La société a été modifiée avec succès !");
            DoleticUIModule.fillFirmList(false);
        } else {
            // use default service service error handler
            DoleticServicesInterface.handleServiceError(data);
        }
    };

    this.deleteFirmHandler = function (id) {
        FirmServicesInterface.delete(id, function (data) {
            // if no service error
            if (data.code == 0) {
                DoleticMasterInterface.hideConfirmModal();
                DoleticMasterInterface.showSuccess("Suppression réussie !", "La société a été supprimée avec succès !");
                DoleticUIModule.fillFirmList(false);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.checkNewContactForm = function () {
        $('#contact_form .message').remove();
        $('#contact_form .field').removeClass('error');
        var valid = true;
        if (!DoleticMasterInterface.checkName($('#contact_firstname').val())) {
            valid = false;
            $('#contact_firstname_field').addClass('error');
        }
        if (!DoleticMasterInterface.checkName($('#contact_lastname').val())) {
            valid = false;
            $('#contact_lastname_field').addClass('error');
        }
        if ($('#contact_gender_search').dropdown('get value') == "") {
            $('#contact_gender_field').addClass("error");
            valid = false;
        }
        if ($('#contact_type_search').dropdown('get value') == "") {
            $('#contact_type_field').addClass("error");
            valid = false;
        }
        if ($('#contact_firm_search').dropdown('get value') == "") {
            $('#contact_firm_field').addClass("error");
            valid = false;
        }
        if ($('#contact_tel').val() != '' && !DoleticMasterInterface.checkTel($('#contact_tel').val())) {
            valid = false;
            $('#contact_tel_field').addClass('error');
        }
        if ($('#contact_cell').val() != '' && !DoleticMasterInterface.checkTel($('#contact_cell').val())) {
            valid = false;
            $('#contact_cell_field').addClass('error');
        }
        if ($('#contact_mail').val() != '' && !DoleticMasterInterface.checkMail($('#contact_mail').val())) {
            valid = false;
            $('#contact_email_field').addClass('error');
        }
        if (!valid) {
            $('#contact_form').transition('shake');
            DoleticMasterInterface.showFormError("Erreur !", "Merci de corriger les champs affichés en rouge.", '#contact_form');
        }
        return valid;
    };

    this.checkNewFirmForm = function () {
        console.log($('#company_form'));
        $('#company_form .message').remove();
        $('#company_form .field').removeClass('error');
        var valid = true;
        if (!DoleticMasterInterface.checkName($('#firm_name').val())) {
            valid = false;
            $('#firm_name_field').addClass('error');
        }
        if ($('#firm_address').val() == "") {
            valid = false;
            $('#firm_address_field').addClass('error');
        }
        if ($('#firm_city').val() == "") {
            valid = false;
            $('#firm_city_field').addClass('error');
        }
        if ($('#firm_country_search').dropdown('get value') == "") {
            $('#firm_country_field').addClass("error");
            valid = false;
        }
        if ($('#firm_type_search').dropdown('get value') == "") {
            $('#firm_type_field').addClass("error");
            valid = false;
        }
        if (!DoleticMasterInterface.checkPostalCode($('#firm_postalcode').val())) {
            valid = false;
            $('#firm_postalcode_field').addClass('error');
        }
        if (!valid) {
            $('#company_form').transition('shake');
            DoleticMasterInterface.showFormError("Erreur !", "Merci de corriger les champs affichés en rouge.", '#company_form');
        }
        return valid;
    };

};
