var DoleticUIModule = new function () {
        /**
         *    Parent abstract module
         */
        this.super = new AbstractDoleticUIModule('HR_UIModule', 'Nicolas Sorin', '1.0dev');
        /**
         *    Override render function
         */
        this.render = function (htmlNode) {

            this.super.render(htmlNode, this);

            window.currentDetails = -1;

            // Load HTML templates
            DoleticUIModule.getStatsTab();
            DoleticUIModule.getProjectsTab();
            DoleticUIModule.getSollicTab();
            DoleticUIModule.getDisabledTab();
            DoleticUIModule.getArchivedTab();
            DoleticUIModule.getDetailsTab();

            // hide project details tab
            $('#det').hide();
            // display indicators
            // DoleticUIModule.drawGraphs();
            // DoleticUIModule.fillValueIndicators();
            // DoleticUIModule.fillTableIndicators();
            DoleticUIModule.fillFirmAndUserLists(DoleticUIModule.fillProjectsList);
            // fill project field field
            DoleticUIModule.fillFieldSelector();
            // fill origin field
            DoleticUIModule.fillOriginSelector();
            //fill amendment type field
            DoleticUIModule.fillAmendmentTypeSelector();
            // activate items in tabs
            $('.menu .item').tab();
        };
        /**
         *    Override build function
         */
        this.build = function () {
            return "<div class=\"ui two column grid container\"> \
				  <div class=\"row\"> \
				  </div> \
				  <div class=\"row\"> \
				  	<div class=\"sixteen wide column\" id=\"page_content\"> \
				  		<div class=\"ui top attached tabular menu\" id=\"tabmenu\" > \
  							<a class=\"item active\" data-tab=\"stats\">Statistiques</a> \
  							<a class=\"item\" id=\"sollist\" data-tab=\"solliclist\">Sollicitations</a> \
  							<a class=\"item\" id=\"prolist\" data-tab=\"projectlist\">Etudes en cours</a> \
  							<a class=\"item\" id=\"dislist\" data-tab=\"disabledlist\">Etudes en Stand-By</a> \
  							<a class=\"item\" id=\"arclist\" data-tab=\"archivedlist\">Etudes archivées</a> \
  							<a class=\"item\" id=\"det\" data-tab=\"projectdetails\">Détails de l'étude</a> \
						</div> \
						<div class=\"ui bottom attached tab segment active\" data-tab=\"stats\"> \
							<div id=\"statsTab\">\
								<div class=\"ui loader active\"></div>\
							</div>\
					    </div> \
						<div class=\"ui bottom attached tab segment\" data-tab=\"solliclist\"> \
							<div id=\"sollicTab\">\
								<div class=\"ui loader active\"></div>\
							</div>\
						</div> \
						<div class=\"ui bottom attached tab segment\" data-tab=\"projectlist\"> \
							<div id=\"projectsTab\">\
								<div class=\"ui loader active\"></div>\
							</div>\
						</div> \
						<div class=\"ui bottom attached tab segment\" data-tab=\"disabledlist\"> \
							<div id=\"disabledTab\">\
								<div class=\"ui loader active\"></div>\
							</div>\
						</div> \
						<div class=\"ui bottom attached tab segment\" data-tab=\"archivedlist\"> \
							<div id=\"archivedTab\">\
								<div class=\"ui loader active\"></div>\
							</div>\
						</div> \
						<div class=\"ui bottom attached tab segment\" data-tab=\"projectdetails\"> \
							<div id=\"detailsTab\">\
							</div>\
						</div> \
					</div> \
				  </div> \
				</div>";
        };
        /**
         *    Override uploadSuccessHandler
         */
        this.uploadSuccessHandler = function (id, data) {
            DocumentServicesInterface.insert(window.currentDetails, window.currentTemplate, data, function () {
                DoleticUIModule.fillDocumentList(window.currentDetails);
            });
        };

        this.nightMode = function (on) {
            /*if(on) {
             $('.ui.horizontal.divider').attr('class', 'ui horizontal divider inverted');
             $('#ticket_list').attr('class', 'ui very relaxed celled selection list inverted');
             $('#support_form').attr('class', 'ui form segment inverted');
             $('#abort_btn').attr('class', 'ui button inverted');
             $('#adduser_btn').attr('class', 'ui green button inverted');
             } else {
             $('.ui.horizontal.divider.inverted').attr('class', 'ui horizontal divider');
             $('#ticket_list').attr('class', 'ui very relaxed celled selection list');
             $('#support_form').attr('class', 'ui form segment');
             $('#abort_btn').attr('class', 'ui button');
             $('#adduser_btn').attr('class', 'ui green button');
             }*/
        };

// ---- OTHER FUNCTION REQUIRED BY THE MODULE ITSELF

        /**
         *    Load the HTML code of the Stats Tab
         */
        this.getStatsTab = function () {
            $('#statsTab').load("../modules/ua/ui/templates/statsTab.html");
        };

        /**
         *    Load the HTML code of the Members Tab
         */
        this.getProjectsTab = function () {
            $('#projectsTab').load("../modules/ua/ui/templates/projectsTab.html");
        };

        /**
         *    Load the HTML code of the Members Tab
         */
        this.getSollicTab = function () {
            $('#project_form_modal').remove(); // Necessary to avoid duplicate (look for better solution)
            $('#disable_form_modal').remove(); // Necessary to avoid duplicate (look for better solution)
            $('#sollicTab').load("../modules/ua/ui/templates/sollicTab.html", function () {
                DoleticMasterInterface.makeDefaultCalendar('disable_calendar');
            });
        };

        /**
         *    Load the HTML code of the Members Tab
         */
        this.getDisabledTab = function () {
            $('#disabledTab').load("../modules/ua/ui/templates/disabledTab.html");
        };

        /**
         *    Load the HTML code of the Teams Tab
         */
        this.getArchivedTab = function () {
            $('#archivedTab').load("../modules/ua/ui/templates/archivedTab.html");
        };
        /**
         *    Load the HTML code of the Details Tab
         */
        this.getDetailsTab = function () {
            $('#detailsTab').load("../modules/ua/ui/templates/detailsTab.html", function () {
                DoleticMasterInterface.makeDefaultCalendar('amend_scalendar');
                DoleticMasterInterface.makeDefaultCalendar('task_scalendar');
                DoleticMasterInterface.makeDefaultCalendar('task_ecalendar');
                DoleticMasterInterface.makeDefaultCalendar('delivered_calendar');
                DoleticMasterInterface.makeDefaultCalendar('paid_calendar');
                DoleticMasterInterface.makeDefaultCalendar('sign_calendar');
                DoleticMasterInterface.makeDefaultCalendar('end_calendar');
                window.postLoad();
            });
        };

        this.hasInputError = false;

        this.fillFirmAndUserLists = function (callback) {
            // Optional callback
            callback = callback || 0;
            // Get all users
            window.user_list = [];
            KernelDBServicesInterface.getAllUserDataWithStatus(function (data) {
                // if no service error
                if (data.code == 0) {
                    var adm_content = "";
                    var auditor_content = "";
                    var int_content = "";
                    for (var i = 0; i < data.object.length; i++) {
                        window.user_list[data.object[i].user_id] = data.object[i];
                        if (data.object[i].admm_status != "Non") {
                            adm_content += '<div class="item" data-value="' + data.object[i].id + '">'
                                + data.object[i].firstname + ' ' + data.object[i].lastname + '</div>';
                        }
                        if (data.object[i].position[0].division == "Qualité") {
                            auditor_content += '<div class="item" data-value="' + data.object[i].id + '">'
                                + data.object[i].firstname + ' ' + data.object[i].lastname + '</div>';
                        }
                        if (data.object[i].intm_status != "Non") {
                            int_content += '<div class="item" data-value="' + data.object[i].id + '">'
                                + data.object[i].firstname + ' ' + data.object[i].lastname + '</div>';
                        }
                    }
                    $('#auditor_search .menu').html(auditor_content);
                    $('#chadaff_search .menu').html(adm_content);
                    $('#int_search .menu').html(int_content);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
            // Get all firms
            window.firm_list = [];
            FirmServicesInterface.getAll(function (data) {
                // if no service error
                if (data.code == 0) {
                    var content = '';
                    for (var i = 0; i < data.object.length; i++) {
                        window.firm_list[data.object[i].id] = data.object[i];
                        content += '<div class="item" data-value="' + data.object[i].id + '">' + data.object[i].name + '</div>';
                    }
                    $('#project_firm_search .menu').html(content);
                    // Execute callback
                    if (callback != 0) {
                        callback();
                    }
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });

            // Get all contacts
            window.contact_list = [];
            ContactServicesInterface.getAll(function (data) {
                // if no service error
                if (data.code == 0) {
                    for (var i = 0; i < data.object.length; i++) {
                        window.contact_list[data.object[i].id] = data.object[i];
                    }
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillFieldSelector = function () {
            UserDataServicesInterface.getAllINSADepts(function (data) {
                // if no service error
                if (data.code == 0) {
                    // create content var to build html
                    var content = '';
                    // iterate over values to build options
                    for (var i = 0; i < data.object.length; i++) {
                        content += '<div class="item" data-value="' + data.object[i].label + '">' + data.object[i].label + '</div>';
                    }
                    // insert html content
                    $('#project_field_search .menu').html(content).dropdown();
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillAmendmentTypeSelector = function () {
            ProjectServicesInterface.getAllAmendmentTypes(function (data) {
                // if no service error
                if (data.code == 0) {
                    // create content var to build html
                    var content = '';
                    // iterate over values to build options
                    for (var i = 0; i < data.object.length; i++) {
                        content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                    }
                    // insert html content
                    $('#amtype_search .menu').html(content).dropdown();
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillOriginSelector = function () {
            ProjectServicesInterface.getAllOrigins(function (data) {
                // if no service error
                if (data.code == 0) {
                    // create content var to build html
                    //var content = "<option value=\"\">Poste...</option>";
                    var content = "";
                    // iterate over values to build options
                    for (var i = 0; i < data.object.length; i++) {
                        content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                    }
                    // insert html content
                    $('#project_origin_search .menu').html(content);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillProjectsList = function () {
            // Link to view user details
            var click = $('#submenu_hr').attr('onclick');
            click = click.substr(0, click.length - 2) + ", 'DoleticUIModule.fillUserDetails(";

            ProjectServicesInterface.getAllFull(function (data) {
                // Delete and recreate table so Datatables is reinitialized
                $("#sollic_table_container").html("");
                $("#project_table_container").html("");
                $("#disabled_table_container").html("");
                $("#archived_table_container").html("");
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    var headFoot = "<thead> \
            <tr>\
            <th>Numéro</th> \
            <th>Nom</th> \
            <th>Domaine</th> \
            <th>Société</th> \
            <th>Date</th> \
            <th>Chargé(s) d'affaires</th> \
            <th>Consultant(s)</th> \
            <th>Corresp. qualité</th> \
            <th>Statut</th> \
            <th>Actions</th\
                        > \
                    </tr>\
                </thead>\
                <tfoot> \
                    <tr>\
                        <th>Numéro</th> \
                        <th>Nom</th> \
                        <th>Domaine</th> \
                        <th>Société</th> \
                        <th>Date</th> \
                        <th>Chargé(s) d'affaires</th> \
                        <th>Consultant(s)</th> \
                        <th>Corresp. qualité</th> \
                        <th>Statut</th> \
            <th></th> \
            </tr>\
            </tfoot>\ ";
                    // iterate over values to build options
                    var sollic_content = "<table class=\"ui very basic celled table\" id=\"sollic_table\">" + headFoot + "<tbody id=\"sollic_body\">";
                    var project_content = "<table class=\"ui very basic celled table\" id=\"project_table\">" + headFoot + "<tbody id=\"project_body\">";
                    var disabled_content = "<table class=\"ui very basic celled table\" id=\"disabled_table\">" + headFoot + "<tbody id=\"disabled_body\">";
                    var archived_content = "<table class=\"ui very basic celled table\" id=\"archived_table\">" + headFoot + "<tbody id=\"archived_body\">";

                    var filters = [
                        DoleticMasterInterface.input_filter,
                        DoleticMasterInterface.input_filter,
                        DoleticMasterInterface.select_filter,
                        DoleticMasterInterface.input_filter,
                        DoleticMasterInterface.input_filter,
                        DoleticMasterInterface.input_filter,
                        DoleticMasterInterface.input_filter,
                        DoleticMasterInterface.input_filter,
                        DoleticMasterInterface.select_filter,
                        DoleticMasterInterface.reset_filter
                    ];

                    for (var i = 0; i < data.object.length; i++) {
                        var chadaffHtml = "";
                        var j = 0;
                        for (j = 0; j < data.object[i].chadaff_id.length; j++) {
                            var chadaff = window.user_list[data.object[i].chadaff_id[j].chadaff_id];
                            var onClick = click + +data.object[i].chadaff_id[j].chadaff_id + ");');";
                            chadaffHtml += '<a href="#" onclick="' + onClick + '">' + chadaff.firstname + ' ' + chadaff.lastname + "</a><br>";
                        }
                        chadaffHtml = j == 0 ? "<i>Non assigné</i>" : chadaffHtml;
                        var intHtml = "";
                        var k = 0;
                        for (k = 0; k < data.object[i].int_id.length; k++) {
                            var int = window.user_list[data.object[i].int_id[k].int_id];
                            var onClick = click + +data.object[i].int_id[k].int_id + ");');";
                            intHtml += '<a href="#" onclick="' + onClick + '">' + int.firstname + ' ' + int.lastname + "</a><br>";
                        }
                        intHtml = k == 0 ? "<i>Non assigné</i>" : intHtml;
                        var auditorClick = click + +data.object[i].auditor_id + ");');";
                        var row = "<tr" + (data.object[i].critical ? 'class="error"' : '') + ">" +
                            "<td><button id=\"details_" + data.object[i].number + "\" onClick=\"DoleticUIModule.fillProjectDetails(" + data.object[i].number + "); return false;\" class=\"ui teal button\" data-tooltip=\"Détails de l'étude " + data.object[i].number + "\">" + data.object[i].number + "</button></td>" +
                            "<td>" + data.object[i].name + "</td>" +
                            "<td>" + data.object[i].field + "</td>" +
                            "<td>" + (typeof window.firm_list[data.object[i].firm_id] != 'undefined' ? window.firm_list[data.object[i].firm_id].name : '<i>Aucune</i>') + "</td>" +
                            "<td>" + data.object[i].creation_date + "</td>" +
                            "<td>" + chadaffHtml + "</td>" + // Change this
                            "<td>" + intHtml + "</td>" + // Change this
                            "<td>" + (data.object[i].auditor_id != null ? '<a href="#" onclick="' + auditorClick + '">' + window.user_list[data.object[i].auditor_id].firstname + ' ' + window.user_list[data.object[i].auditor_id].lastname + '</a>' : "<i>Non assigné</i>") + "</td>" +
                            "<td>" + data.object[i].status + "</td>";

                        if (data.object[i].disabled) {
                            disabled_content += row + "<td><div class=\"ui icon buttons\">" +
                                "<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"write icon\"></i>" +
                                "</button>" +
                                "<button class=\"ui olive icon button\" data-tooltip=\"Réactiver\" onClick=\"DoleticUIModule.restoreProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"refresh icon\"></i>" +
                                "</button>" +
                                "<button class=\"ui red icon button\" data-tooltip=\"Supprimer\" onClick=\"DoleticUIModule.deleteProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"remove icon\"></i>" +
                                "</button>" +
                                "</div></td>" +
                                "</tr>";
                        } else if (data.object[i].archived) {
                            archived_content += row + "<td><div class=\"ui icon buttons\">" +
                                "<button class=\"ui yellow icon button\" data-tooltip=\"Restaurer\" onClick=\"DoleticUIModule.unarchiveProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"archive icon\"></i>" +
                                "</button>" +
                                "</div></td>" +
                                "</tr>";
                        } else if (data.object[i].sign_date == null) {
                            sollic_content += row + "<td><div class=\"ui icon buttons\">" +
                                "<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"write icon\"></i>" +
                                "</button>" +
                                "<button class=\"ui yellow icon button\" data-tooltip=\"Archiver\" onClick=\"DoleticUIModule.abortProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"archive icon\"></i>" +
                                "</button>" +
                                "<button class=\"ui orange icon button\" data-tooltip=\"Mettre en Stand-By\" onClick=\"DoleticUIModule.disableProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"remove icon\"></i>" +
                                "</button>" +
                                "</div></td>" +
                                "</tr>";
                        } else {
                            project_content += row + "<td><div class=\"ui icon buttons\">" +
                                "<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"write icon\"></i>" +
                                "</button>" +
                                "<button class=\"ui yellow icon button\" data-tooltip=\"Archiver\" onClick=\"DoleticUIModule.abortProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"archive icon\"></i>" +
                                "</button>" +
                                "<button class=\"ui orange icon button\" data-tooltip=\"Mettre en Stand-By\" onClick=\"DoleticUIModule.disableProject(" + data.object[i].number + "); return false;\">" +
                                "<i class=\"remove icon\"></i>" +
                                "</button>" +
                                "</div></td>" +
                                "</tr>";
                        }
                    }
                    sollic_content += "</tbody></table>";
                    project_content += "</tbody></table>";
                    disabled_content += "</tbody></table>";
                    archived_content += "</tbody></table>";
                    $('#sollic_table_container').append(sollic_content);
                    $('#project_table_container').append(project_content);
                    $('#disabled_table_container').append(disabled_content);
                    $('#archived_table_container').append(archived_content);
                    DoleticMasterInterface.makeDataTables('sollic_table', filters);
                    DoleticMasterInterface.makeDataTables('project_table', filters);
                    DoleticMasterInterface.makeDataTables('disabled_table', filters);
                    DoleticMasterInterface.makeDataTables('archived_table', filters);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.drawGraphs = function () {
            IndicatorServicesInterface.processAllGraphByModule('ua', function (data) {
                DoleticMasterInterface.drawGraphs(data.object, 'graphs');
            });
        };

        this.fillValueIndicators = function () {
            IndicatorServicesInterface.processAllValueByModule('ua', function (data) {
                DoleticMasterInterface.fillValueIndicators(data.object, 'indicators_body');
            });
        };

        this.fillTableIndicators = function () {
            IndicatorServicesInterface.processAllTableByModule('ua', function (data) {
                DoleticMasterInterface.fillTableIndicators(data.object, 'tables');
            });
        };


        this.fillProjectDetails = function (number) {
            // activate items in tabs
            $('.menu .item').tab();
            $('.dropdown').dropdown();

            ProjectServicesInterface.getByNumber(number, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    // Fill basic details
                    $('#det_name').html(data.object.name);
                    $('#det_description').html(data.object.description);
                    $('#det_field').html(data.object.field);
                    $('#det_origin').html(data.object.origin);
                    $('#det_status').html(data.object.status);
                    $('#det_creation').html(data.object.creation_date);
                    $('#det_mgmt').html(data.object.mgmt_fee + '€');
                    $('#det_app').html(data.object.app_fee + '€');
                    $('#det_rebilled').html(data.object.rebilled_fee + '€');
                    $('#det_advance').html(data.object.advance + '€');
                    var signhtml = "";
                    if (data.object.end_date != null) {
                        signhtml = "<i>" + data.object.sign_date + "</i>";
                    } else if (data.object.sign_date == null) {
                        signhtml = "<button class=\"ui green button\" " +
                            "onClick=\"DoleticUIModule.showSignForm(); return false;\">" +
                            "Etude signée" +
                            "</button>";
                    } else {
                        signhtml = "<button class=\"ui red button\" " +
                            "onClick=\"DoleticUIModule.unsignProject(" + data.object.number + "); return false;\"" +
                            "data-tooltip=\"Annuler la signature\">" +
                            data.object.sign_date +
                            "</button>";
                    }
                    $('#det_sign').html(signhtml);
                    var endhtml = "";
                    if (data.object.sign_date == null) {
                        endhtml = "<i>Etude non signée</i>";
                    } else if (data.object.end_date == null) {
                        endhtml = "<button class=\"ui green button\" " +
                            "onClick=\"DoleticUIModule.showEndForm(); return false;\">" +
                            "Etude terminée" +
                            "</button>";
                    } else {
                        endhtml = "<button class=\"ui red button\" " +
                            "onClick=\"DoleticUIModule.unendProject(" + data.object.number + "); return false;\"" +
                            "data-tooltip=\"Annuler la clôture\">" +
                            data.object.end_date +
                            "</button>";
                    }
                    $('#det_end').html(endhtml);
                    var htmlTitle = "Détails de l'étude " + data.object.number;
                    if (data.object.disabled) {
                        htmlTitle += " (désactivé)";
                    }
                    if (data.object.auditor_id != null) {
                        var click = $('#submenu_hr').attr('onclick');
                        click = click.substr(0, click.length - 2) + ", 'DoleticUIModule.fillUserDetails(";
                        var onClick = click + +data.object.auditor_id + ");');";
                        var auditor = window.user_list[data.object.auditor_id];
                        $('#auditor_name').html('<a href="#" onclick="' + onClick + '">' + auditor.firstname + ' ' + auditor.lastname + '</a>');
                        $('#auditor_tel').html(auditor.tel);
                        $('#auditor_mail').html(auditor.email);
                        $('#auditor_data').show();
                        $('#auditor_form').hide();
                    } else {
                        $('#auditor_data').hide();
                        $('#auditor_form').show();
                    }
                    $('#auditor_btn').attr('onClick', 'DoleticUIModule.assignAuditor(' + number + '); return false;');
                    $('#editsollic_modal_btn').attr('onClick', 'DoleticUIModule.editProject(' + number + '); return false;');
                    $('#disableproject_btn').attr('onClick', 'DoleticUIModule.disableProject(' + number + '); return false;');
                    $('#addamend_modal_btn').attr('onClick', 'DoleticUIModule.showNewAmendmentForm(' + number + '); return false');
                    $('#addtask_modal_btn').attr('onClick', 'DoleticUIModule.showNewTaskForm(' + number + '); return false');
                    $('#contact_btn').attr('onClick', 'DoleticUIModule.addContact(' + number + '); return false;');
                    $('#int_btn').attr('onClick', 'DoleticUIModule.addInt(' + number + '); return false;');
                    $('#chadaff_btn').attr('onClick', 'DoleticUIModule.addChadaff(' + number + '); return false;');
                    $('#amend_btn').attr('onClick', 'DoleticUIModule.insertNewAmendment(' + number + '); return false;');
                    $('#task_btn').attr('onClick', 'DoleticUIModule.insertNewTask(' + number + '); return false;');
                    $('#sign_btn').attr('onClick', 'DoleticUIModule.signProject(' + number + '); return false;');
                    $('#end_btn').attr('onClick', 'DoleticUIModule.endProject(' + number + '); return false;');

                    // Fill contacts related to project number
                    var contactOptions = "";
                    for (var i = 0; i < window.contact_list.length; i++) {
                        if (typeof window.contact_list[i] != 'undefined' && window.contact_list[i].firm_id == data.object.firm_id) {
                            contactOptions += '<div class="item" data-value="' + window.contact_list[i].id
                                + '">' + window.contact_list[i].firstname + ' '
                                + window.contact_list[i].lastname + '</div>';
                        }
                    }
                    $('#contact_search .menu').html(contactOptions);

                    // Fill lists
                    DoleticUIModule.fillContactList(number);
                    DoleticUIModule.fillIntList(number);
                    DoleticUIModule.fillChadaffList(number);
                    DoleticUIModule.fillAmendmentList(number);
                    DoleticUIModule.fillTaskList(number);
                    DoleticUIModule.fillDocumentList(number);

                    $('#det').html(htmlTitle).show().click();
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
            window.currentDetails = number;
        };

        this.fillContactList = function (number) {
            ProjectServicesInterface.getAllContactsByProject(number, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    var content = "";
                    var search_content = "";
                    var defaultValue = 0;
                    for (var i = 0; i < data.object.length; i++) {
                        var contact = window.contact_list[data.object[i].contact_id];
                        defaultValue = (i == 0 ? contact.id : defaultValue);
                        search_content += '<div class="item" data-value="' + contact.id + '">'
                            + contact.firstname + ' ' + contact.lastname + '</div>';
                        content += '<tr><td>' + contact.firstname + ' ' + contact.lastname + '</td>' +
                            '<td>' + contact.phone + '</td>' +
                            '<td><a href=\"mailto:"' + contact.email + '" target="_blank">' + contact.email + '</a></td>' +
                            '<td><button data-tooltip="Supprimer" class="ui red icon button" onclick="DoleticUIModule.removeContact('
                            + number + ', ' + contact.id + '); return false;"><i class="remove icon"></i>' +
                            '</button> </td></tr>';
                    }
                    $('#project_contacts_body').html(content);
                    $.when($('#contact_search_doc .menu').html(search_content)).then(function() {
                        if (defaultValue != 0) {
                            $('#contact_search_doc').dropdown('set selected', defaultValue);
                        } else {
                            $('#contact_search_doc').dropdown('restore defaults');
                        }
                    });
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillIntList = function (number) {
            var click = $('#submenu_hr').attr('onclick');
            click = click.substr(0, click.length - 2) + ", 'DoleticUIModule.fillUserDetails(";

            ProjectServicesInterface.getAllIntsByProject(number, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    var content = "";
                    var search_content = "";
                    var defaultValue = 0;
                    for (var i = 0; i < data.object.length; i++) {
                        var onClick = click + +data.object[i].int_id + ");');";
                        var int = window.user_list[data.object[i].int_id];
                        defaultValue = (i == 0 ? int.id : defaultValue);
                        search_content += '<div class="item" data-value="' + int.id + '">'
                            + int.firstname + ' ' + int.lastname + '</div>';
                        content += '<tr><td><a href="#" onclick="' + onClick + '">' + int.firstname + ' ' + int.lastname + '</a></td>' +
                            '<td>' + int.tel + '</td>' +
                            '<td><a href=\"mailto:"' + int.email + '" target="_blank">' + int.email + '</a></td>' +
                            '<td>' + data.object[i].jeh_assigned + '</td>' +
                            '<td>' + data.object[i].pay + '€</td>' +
                            '<td><button data-tooltip="Supprimer" class="ui red icon button" onclick="DoleticUIModule.removeInt('
                            + number + ', ' + int.id + '); return false;"><i class="remove icon"></i>' +
                            '</button> </td></tr>';
                    }
                    $('#project_ints_body').html(content);
                    $.when($('#int_search_doc .menu').html(search_content)).then(function () {
                        if (defaultValue != 0) {
                            $('#int_search_doc').dropdown('set selected', defaultValue);
                        } else {
                            $('#int_search_doc').dropdown('restore defaults');
                        }
                    });
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillChadaffList = function (number) {
            var click = $('#submenu_hr').attr('onclick');
            click = click.substr(0, click.length - 2) + ", 'DoleticUIModule.fillUserDetails(";

            ProjectServicesInterface.getAllChadaffsByProject(number, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    var content = "";
                    var search_content = "";
                    var defaultValue = 0;
                    for (var i = 0; i < data.object.length; i++) {
                        var onClick = click + +data.object[i].chadaff_id + ");');";
                        var chadaff = window.user_list[data.object[i].chadaff_id];
                        defaultValue = (i == 0 ? chadaff.id : defaultValue);
                        search_content += '<div class="item" data-value="' + chadaff.id + '">'
                            + chadaff.firstname + ' ' + chadaff.lastname + '</div>';
                        content += '<tr><td><a href="#" onclick="' + onClick + '">' + chadaff.firstname + ' ' + chadaff.lastname + '</a></td>' +
                            '<td>' + chadaff.tel + '</td>' +
                            '<td><a href=\"mailto:"' + chadaff.email + '" target="_blank">' + chadaff.email + '</a></td>' +
                            '<td><button data-tooltip="Supprimer" class="ui red icon button" onclick="DoleticUIModule.removeChadaff('
                            + number + ', ' + chadaff.id + '); return false;"><i class="remove icon"></i>' +
                            '</button> </td></tr>';
                    }
                    $('#project_chadaffs_body').html(content);
                    $.when($('#chadaff_search_doc .menu').html(search_content)).then(function () {
                        if (defaultValue != 0) {
                            $('#chadaff_search_doc').dropdown('set selected', defaultValue);
                        } else {
                            $('#chadaff_search_doc').dropdown('restore defaults');
                        }
                    });
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillDocumentList = function (number) {
            DocumentServicesInterface.getProjectDocuments(number, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    var content = "";
                    for (var i = 0; i < data.object.length; i++) {
                        var document = data.object[i];
                        var validHtml = '<i>Aucun</i>';
                        var uploadBtn = "";
                        var downloadBtn = "";
                        if (document.document != null) {
                            if (document.document.valid) {
                                validHtml = '<button class="ui red icon button" data-tooltip="Annuler" ' +
                                    'onCLick="DoleticUIModule.invalidateDocument(' + document.document.id + ', ' + number + '); return false;">' +
                                    '<i class="remove icon"></i>' +
                                    '</button>';
                            } else {
                                validHtml = '<button class="ui green icon button" data-tooltip="Valider" ' +
                                    'onClick="DoleticUIModule.validateDocument(' + document.document.id + ', ' + number + '); return false;">' +
                                    '<i class="checkmark icon"></i>' +
                                    '</button>';
                            }
                            uploadBtn = '<button data-tooltip="Remplacer" class="ui yellow icon button" ' +
                                'onClick="DoleticUIModule.uploadDocument(' + document.id + '); return false;">' +
                                '<i class="upload icon"></i>' +
                                '</button>';
                            downloadBtn = '<button data-tooltip="Télécharger" class="ui blue icon button" onClick="DoleticServicesInterface.download('
                                + document.document.upload + ');">' +
                                '<i class="download icon"></i>' +
                                '</button>';
                        } else {
                            uploadBtn = '<button data-tooltip="Uploader" class="ui green icon button" ' +
                                'onClick="DoleticUIModule.uploadDocument(' + document.id + '); return false;">' +
                                '<i class="upload icon"></i>' +
                                '</button>';
                        }
                        content += '<tr>' +
                            '<td>' + document.label + '</td>' +
                            '<td><button class="ui olive icon button" ' +
                            'onclick="DoleticUIModule.editDocument(' + document.id + ', ' + number + ');">' +
                            '<i class="book icon"></i></button></td>' +
                            '<td>' +
                            '<div class="ui buttons">' +
                            uploadBtn + downloadBtn +
                            '</div>' +
                            DoleticUIFactory.makeUploadForm('doc' + document.id, true) +
                            '</td>' +
                            '<td>' + validHtml + '</td>' +
                            '</tr>';
                    }
                    $('#project_docs_body').html(content);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillTaskList = function (number) {
            TaskServicesInterface.getByProject(number, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    var content = "";
                    for (var i = 0; i < data.object.length; i++) {
                        var task = data.object[i];
                        content += '<tr>' +
                            '<td><div class="ui icon buttons">' +
                            (i == 0 ? '' : ('<button class="ui icon button" data-tooltip="Monter" ' +
                            'onClick="DoleticUIModule.switchTask(' + data.object[task.number - 1].id +
                            ', ' + data.object[task.number - 2].id + ', ' + number + ');">' +
                            '<i class="caret up icon"></i>' +
                            '</button>')) +
                            ( i == data.object.length - 1 ? '' : ('<button class="ui icon button" data-tooltip="Descendre" ' +
                            'onClick="DoleticUIModule.switchTask(' + data.object[task.number - 1].id +
                            ', ' + data.object[task.number].id + ', ' + number + ');">' +
                            '<i class="caret down icon"></i>' +
                            '</button>')) +
                            '</div></td>' +
                            '<td><button class="ui basic button" data-tooltip="' + task.description + '">' + task.name + '</button></td>' +
                            '<td>' + task.jeh_amount + '</td>' +
                            '<td>' + task.jeh_cost + '€</td>' +
                            '<td>' + task.start_date + '</td>' +
                            '<td>' + task.end_date + '</td>' +
                            '<td>' + (task.ended ? 'Oui' : 'Non') + '</td>' +
                            '<td>' +
                            '<button class="ui teal icon button" onClick="DoleticUIModule.showDeliveryModal(' + task.id + '); return false;">' +
                            '<i class="write icon"></i>' +
                            'Gérer' +
                            '</button>' +
                            '</td>' +
                            '<td>' +
                            '<div class="ui icon buttons">' +
                            '<button class="ui olive icon button" data-tooltip="' + (task.ended ? 'Annuler' : 'Terminer') + '" onClick="DoleticUIModule.' + (task.ended ? 'un' : '') + 'endTask(' + task.id + ', ' + number + '); return false;">' +
                            '<i class="' + (task.ended ? 'reply' : 'checkmark') + ' icon"></i>' +
                            '</button>' +
                            '<button class="ui blue icon button" data-tooltip="Modifier" onClick="DoleticUIModule.editTask(' + task.id + ', ' + number + '); return false;">' +
                            '<i class="write icon"></i>' +
                            '</button>' +
                            '<button class="ui red icon button" data-tooltip="Supprimer" onClick="DoleticUIModule.deleteTask(' + task.id + ', ' + number + '); return false;">' +
                            '<i class="remove icon"></i>' +
                            '</button>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#project_tasks_body').html(content);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillDeliveryList = function (taskId) {
            TaskServicesInterface.getDeliveryByTask(taskId, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    var content = "";
                    for (var i = 0; i < data.object.length; i++) {
                        var delivery = data.object[i];
                        content += '<tr>' +
                            '<td><button class="ui basic button" data-tooltip="' + delivery.content + '">' + delivery.number + '</button></td>' +
                            '<td>' + (delivery.billed ? 'Oui' : 'Non') + '</td>' +
                            '<td>' + (delivery.delivered ?
                            '<button class="ui orange button" data-tooltip="Annuler livraison" ' +
                            'onClick="DoleticUIModule.undeliverDelivery(' + delivery.id + ', ' + delivery.task_id + ');">' +
                            delivery.delivery_date +
                            '</button>' :
                            '<button class="ui olive button" data-tooltip="Marquer comme livré" ' +
                            'onClick="DoleticUIModule.deliverDelivery(' + delivery.id + ', ' + delivery.task_id + ');">' +
                            'Non' +
                            '</button>') +
                            '</td>' +
                            '<td>' + (delivery.paid ?
                            '<button class="ui orange button" data-tooltip="Annuler paiement" ' +
                            'onClick="DoleticUIModule.unpayDelivery(' + delivery.id + ', ' + delivery.task_id + ');">' +
                            delivery.payment_date +
                            '</button>' :
                            '<button class="ui olive button" data-tooltip="Marquer comme payé" ' +
                            'onClick="DoleticUIModule.payDelivery(' + delivery.id + ', ' + delivery.task_id + ');">' +
                            'Non' +
                            '</button>') +
                            '</td>' +
                            '<td>' +
                            '<div class="ui blue icon buttons">' +
                            '<button class="ui icon button" data-tooltip="Modifier" ' +
                            'onClick="DoleticUIModule.editDelivery(' + delivery.id + ', ' + taskId + '); return false;">' +
                            '<i class="write icon"></i>' +
                            '</button>' +
                            '<button class="ui red icon button" data-tooltip="Supprimer" ' +
                            'onClick="DoleticUIModule.deleteDelivery(' + delivery.id + ', ' + taskId + '); return false;">' +
                            '<i class="remove icon"></i>' +
                            '</button>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#task_delivery_body').html(content);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.fillAmendmentList = function (number) {
            ProjectServicesInterface.getAllAmendmentsByProject(number, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    var content = "";
                    for (var i = 0; i < data.object.length; i++) {
                        var amendment = data.object[i];
                        content += '<tr>' +
                            '<td>' + amendment.creation_date + '</td>' +
                            '<td>' + amendment.type + '</td>' +
                            '<td>' +
                            '<button class="ui teal button" onClick="DoleticUIModule.showContentModal(\'' + amendment.content + '\'); return false;">Afficher</button>' +
                            '</td>' +
                            '<td>' + (amendment.attributable ? 'Oui' : 'Non') + '</td>' +
                            '<td>' +
                            '<div class="ui icon buttons">' +
                            '<button class="ui blue icon button" data-tooltip="Modifier" ' +
                            'onClick="DoleticUIModule.editAmendment(' + amendment.id + ', ' + number + '); return false;">' +
                            '<i class="write icon"></i>' +
                            '</button>' +
                            '<button class="ui red icon button" data-tooltip="Supprimer" ' +
                            'onClick="DoleticUIModule.deleteAmendment(' + amendment.id + ', ' + number + '); return false;">' +
                            '<i class="remove icon"></i>' +
                            '</button>' +
                            '</div>' +
                            '</td>' +
                            '</tr>'
                    }
                    $('#project_amendments_body').html(content);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.uploadDocument = function (templateId) {
            window.currentTemplate = templateId;
            $('#file_input_doc' + templateId).click();
        };

        this.editDocument = function (id, number) {
            DoleticServicesInterface.editDocument(
                id,
                number,
                $('#contact_search_doc').dropdown('get value'),
                $('#chadaff_search_doc').dropdown('get value'),
                $('#int_search_doc').dropdown('get value'),
                function (data) {
                    if (data.code == 0) {
                        $('body').append('<a id="tmp_link" href="' + data.object + '" download style="display: none;"></a> ');
                        $('#tmp_link')[0].click();
                        $('#tmp_link').remove();
                    } else {
                        DoleticMasterInterface.showError('Erreur', data.error);
                    }
                }
            );
        };

        this.validateDocument = function (id, number) {
            DocumentServicesInterface.valid(id, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    DoleticUIModule.fillDocumentList(number);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.invalidateDocument = function (id, number) {
            DocumentServicesInterface.invalid(id, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    DoleticUIModule.fillDocumentList(number);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.showContentModal = function (content) {
            $('#content_modal_text').html(content);
            $('#content_modal').modal('show');
        };

        this.showDeliveryModal = function (taskId) {
            DoleticUIModule.clearNewDeliveryForm(taskId);
            DoleticUIModule.fillDeliveryList(taskId);
            $('#delivery_modal').modal('show');
        };

        this.hideContentModal = function () {
            $('#content_modal').modal('hide');
        };

        this.hideDeliveryModal = function (taskId) {
            $('#taskid').val(-1);
            $('#delivery_modal').modal('hide');
        };

        this.clearNewProjectForm = function () {
            $('#project_form .message').remove();
            $('#project_form')[0].reset();
            $('#project_form h4').html("Ajout d'une sollicitation");
            $('#project_form .dropdown').dropdown('restore defaults');
            $('#project_mgmt_field').parent().hide();
            $('#project_rebilled_field').parent().hide();
            $('#project_mgmt, #project_app, #project_rebilled, #project_advance').val('0');
            $('#project_current_field').show();
            $('#addproject_btn').html("Ajouter").attr("onClick", "DoleticUIModule.insertNewProject(); return false;");
        };

        this.clearAddChadaff = function () {
            $('#chadaff_search').dropdown('restore defaults');
        };

        this.clearAddInt = function () {
            $('#int_search').dropdown('restore defaults');
            $('#jehassigned').val('');
            $('#jehpay').val('');
        };

        this.clearAddContact = function () {
            $('#contact_search').dropdown('restore defaults');
        };

        this.clearDisableProjectForm = function (number) {
            $('#disable_form')[0].reset();
            $('#disable_number').val(number);
        };

        this.clearNewAmendmentForm = function (number) {
            $('#amend_form .message').remove();
            $('#amend_form h4').html("Ajout d'un avenant");
            $('#amend_form')[0].reset();
            $('#amtype_search').dropdown('restore defaults');
            $('#amend_btn').html("Ajouter").attr("onClick", "DoleticUIModule.insertNewAmendment(" + number + "); return false;");
        };

        this.clearNewTaskForm = function (number) {
            $('#task_form .message').remove();
            $('#task_form')[0].reset();
            $('#task_form h4').html("Ajout d'une phase");
            $('#task_form .dropdown').dropdown('restore defaults');
            $('#task_btn').html("Ajouter").attr("onClick", "DoleticUIModule.insertNewTask(" + number + "); return false;");
        };

        this.clearNewDeliveryForm = function (taskId) {
            $('#delivery_form .message').remove();
            $('#delivery_form')[0].reset();
            $('#taskid').val(taskId);
            $('#delivery_form h4').html("Ajout d'un livrable");
            $('#delivery_form .dropdown').dropdown('restore defaults');
            $('#delivery_btn').html("Ajouter").attr("onClick", "DoleticUIModule.insertNewDelivery(" + taskId + "); return false;");
        };

        this.insertNewProject = function () {
            // ADD OTHER TESTS
            if (DoleticUIModule.checkNewProjectForm()) {
                // Insert new project in db
                ProjectServicesInterface.insert(
                    $('#project_name').val(),
                    $('#project_description').val(),
                    $('#project_origin_search').dropdown('get value'),
                    $('#project_field_search').dropdown('get value'),
                    $('#project_firm_search').dropdown('get value'),
                    $('#project_mgmt').val(),
                    $('#project_app').val(),
                    $('#project_rebilled').val(),
                    $('#project_advance').val(),
                    $('#project_secret').prop('checked') ? 1 : 0,
                    $('#project_critical').prop('checked') ? 1 : 0,
                    $('#project_current').prop('checked') ? 1 : 0,
                    DoleticUIModule.addProjectHandler);
            } else {

            }
        };

        this.insertNewTask = function (number) {
            if (DoleticUIModule.checkNewTaskForm()) {
                // retreive missing information
                TaskServicesInterface.insert(
                    number,
                    $('#tname').val(),
                    $('#tdescription').val(),
                    $('#jehamount').val(),
                    $('#jehcost').val(),
                    $('#sdatea').val(),
                    $('#edate').val(),
                    function (data) {
                        DoleticUIModule.addTaskHandler(data, number);
                    }
                );
            }
        };

        this.insertNewDelivery = function (taskId) {
            if (DoleticUIModule.checkNewDeliveryForm()) {
                // retreive missing information
                TaskServicesInterface.insertDelivery(
                    taskId,
                    $('#delnumber').val(),
                    $('#delcontent').val(),
                    $('#billed').prop('checked') ? 1 : 0,
                    function (data) {
                        DoleticUIModule.addDeliveryHandler(data, taskId);
                    }
                );
            }
        };

        this.insertNewAmendment = function (number) {
            if (DoleticUIModule.checkNewAmendmentForm()) {
                // retreive missing information
                ProjectServicesInterface.insertAmendment(
                    number,
                    $('#amtype_search').dropdown('get value'),
                    $('#content_field').val(),
                    $('#attributable').prop('checked') ? 1 : 0,
                    $('#amdate').val(),
                    function (data) {
                        DoleticUIModule.addAmendmentHandler(data, number);
                    }
                );
            }
        };

        this.assignAuditor = function (number) {
            ProjectServicesInterface.assignProjectAuditor(
                number,
                $('#auditor_search').dropdown('get value'),
                function (data) {
                    DoleticUIModule.editProjectHandler(data, number);
                }
            );
        };

        this.editAuditor = function () {
            $('#auditor_data').hide();
            $('#auditor_form').show();
        };

        this.addChadaff = function (number) {
            ProjectServicesInterface.assignProjectChadaff(
                number,
                $('#chadaff_search').dropdown('get value'),
                function () {
                    DoleticUIModule.clearAddChadaff();
                    DoleticUIModule.fillChadaffList(number);
                }
            );
        };

        this.addContact = function (number) {
            ProjectServicesInterface.assignProjectContact(
                number,
                $('#contact_search').dropdown('get value'),
                function () {
                    DoleticUIModule.clearAddContact();
                    DoleticUIModule.fillContactList(number);
                }
            );
        };

        this.addInt = function (number) {
            ProjectServicesInterface.assignProjectInt(
                number,
                $('#int_search').dropdown('get value'),
                $('#jehassigned').val(),
                $('#jehpay').val(),
                function () {
                    DoleticUIModule.clearAddInt();
                    DoleticUIModule.fillIntList(number);
                }
            );
        };

        this.removeChadaff = function (number, id) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer la suppression", "\<i class=\"remove user icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir supprimer le chargé d'affaires ? Il ne sera plus lié à l'étude.",
                function () {
                    ProjectServicesInterface.removeProjectChadaff(
                        number,
                        id,
                        function () {
                            DoleticMasterInterface.hideConfirmModal();
                            DoleticUIModule.fillChadaffList(number);
                        }
                    );
                },
                DoleticMasterInterface.hideConfirmModal
            );
        };

        this.removeContact = function (number, id) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer la suppression", "\<i class=\"remove user icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir supprimer le contact ? Il ne sera plus lié à l'étude.",
                function () {
                    ProjectServicesInterface.removeProjectContact(
                        number,
                        id,
                        function () {
                            DoleticMasterInterface.hideConfirmModal();
                            DoleticUIModule.fillContactList(number);
                        }
                    );
                },
                DoleticMasterInterface.hideConfirmModal
            );
        };

        this.removeInt = function (number, id) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer la suppression", "\<i class=\"remove user icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir supprimer le consultant ? Il ne sera plus lié à l'étude.",
                function () {
                    ProjectServicesInterface.removeProjectInt(
                        number,
                        id,
                        function () {
                            DoleticMasterInterface.hideConfirmModal();
                            DoleticUIModule.fillIntList(number);
                        }
                    );
                },
                DoleticMasterInterface.hideConfirmModal
            );
        };

        this.endTask = function (id, number) {
            TaskServicesInterface.endTask(id, function (data) {
                DoleticUIModule.editTaskHandler(data, number);
            });
        };

        this.unendTask = function (id, number) {
            TaskServicesInterface.unendTask(id, function (data) {
                DoleticUIModule.editTaskHandler(data, number);
            });
        };

        this.switchTask = function (id1, id2, number) {
            TaskServicesInterface.switchTaskNumbers(id1, id2, function (data) {
                DoleticUIModule.editTaskHandler(data, number);
            });
        };

        this.editProject = function (number) {
            $('#project_form h4').html("Edition d'une étude");
            ProjectServicesInterface.getByNumber(number, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    $('#project_name').val(data.object.name);
                    $('#project_description').val(data.object.description);
                    $('#project_origin_search').dropdown("set selected", data.object.origin);
                    $('#project_field_search').dropdown("set selected", data.object.field);
                    $('#project_firm_search').dropdown("set selected", data.object.firm_id);
                    $('#project_mgmt_field').parent().show();
                    $('#project_rebilled_field').parent().show();
                    $('#project_mgmt').val(data.object.mgmt_fee);
                    $('#project_app').val(data.object.app_fee);
                    $('#project_rebilled').val(data.object.rebilled_fee);
                    $('#project_advance').val(data.object.advance);
                    $('#project_secret').val(data.object.secret);
                    $('#project_critical').val(data.object.critical);
                    $('#project_current_field').hide();
                    $('#addproject_btn').html("Confirmer");
                    $('#addproject_btn').attr("onClick", "DoleticUIModule.updateProject(" + number + "); return false;");
                    $('#project_form_modal').modal('show');
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.showSignForm = function () {
            $('#sign_form')[0].reset();
            $('#sign_form_modal').modal('show');
        };

        this.signProject = function (number) {
            ProjectServicesInterface.signProject(
                number,
                $('#signdate').val(),
                function (data) {
                    $('#sign_form_modal').modal('hide');
                    DoleticUIModule.editProjectHandler(data, number);
                }
            );
        };

        this.unsignProject = function (number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer l'annulation ?", "\<i class=\"remove user icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir annuler la signature ? Le chargé d'affaires pourra de nouveau modifier les données",
                function () {
                    DoleticUIModule.unsignProjectHandler(number);
                },
                DoleticMasterInterface.hideConfirmModal);
        };

        this.showEndForm = function () {
            $('#end_form')[0].reset();
            $('#end_form_modal').modal('show');
        };

        this.endProject = function (number) {
            ProjectServicesInterface.endProject(
                number,
                $('#enddate').val(),
                function (data) {
                    $('#end_form_modal').modal('hide');
                    DoleticUIModule.editProjectHandler(data, number);
                }
            );
        };

        this.unendProject = function (number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer l'annulation ?", "\<i class=\"remove user icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir annuler la clôture ?",
                function () {
                    DoleticUIModule.unendProjectHandler(number);
                },
                DoleticMasterInterface.hideConfirmModal);
        };

        this.editTask = function (id, number) {
            $('#task_form h4').html("Edition d'une phase");
            TaskServicesInterface.getById(id, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    $('#tname').val(data.object.name);
                    $('#tasknumber').val(data.object.number);
                    $('#tdescription').val(data.object.description);
                    $('#jehamount').val(data.object.jeh_amount);
                    $('#jehcost').val(data.object.jeh_cost);
                    $('#sdatea').val(data.object.start_date);
                    $('#edate').val(data.object.end_date);
                    $('#task_btn').html("Confirmer").attr("onClick", "DoleticUIModule.updateTask(" + id + ", " + number + "); return false;");
                    $('#task_form_modal').modal('show');
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.editDelivery = function (id, taskId) {
            $('#delivery_form').show().find('h4').html("Edition d'un livrable");
            TaskServicesInterface.getDeliveryById(id, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    $('#taskid').val(data.object.task_id);
                    $('#delnumber').val(data.object.number);
                    $('#delcontent').val(data.object.content);
                    $('#billed').prop('checked', data.object.billed);
                    $('#delivery_btn').html("Confirmer").attr("onClick", "DoleticUIModule.updateDelivery(" + id + ", " + taskId + "); return false;");
                    $('#delivery_modal').modal('show');
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.editAmendment = function (id, number) {
            $('#amend_form h4').html("Edition d'un Avenant");
            ProjectServicesInterface.getAmendmentById(id, function (data) {
                // if no service error
                if (data.code == 0 && data.object != "[]") {
                    $('#amdate').val(data.object.creation_date);
                    $('#amtype_search').dropdown("set selected", data.object.type);
                    $('#attributable').val(data.object.attributable);
                    $('#content_field').val(data.object.content);
                    $('#amend_btn').html("Confirmer").attr("onClick", "DoleticUIModule.updateAmendment(" + id + ", " + number + "); return false;");
                    $('#amend_form_modal').modal('show');
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.updateProject = function (number) {
            // ADD OTHER TESTS
            if (DoleticUIModule.checkNewProjectForm()) {
                // Insert user data in db SELECT ?
                ProjectServicesInterface.update(
                    number,
                    $('#project_name').val(),
                    $('#project_description').val(),
                    $('#project_origin_search').dropdown('get value'),
                    $('#project_field_search').dropdown('get value'),
                    $('#project_firm_search').dropdown('get value'),
                    $('#project_mgmt').val(),
                    $('#project_app').val(),
                    $('#project_rebilled').val(),
                    $('#project_advance').val(),
                    $('#project_secret').prop('checked') ? 1 : 0,
                    $('#project_critical').prop('checked') ? 1 : 0,
                    function (data) {
                        DoleticUIModule.editProjectHandler(data, number);
                    }
                );
            }
        };

        this.updateTask = function (id, number) {
            // ADD OTHER TESTS
            if (DoleticUIModule.checkNewTaskForm()) {
                // Update team data in DB
                TaskServicesInterface.update(
                    id,
                    $('#tname').val(),
                    $('#tdescription').val(),
                    $('#jehamount').val(),
                    $('#jehcost').val(),
                    $('#sdatea').val(),
                    $('#edate').val(),
                    function (data) {
                        DoleticUIModule.editTaskHandler(data, number);
                    }
                );
            }
        };

        this.updateDelivery = function (id, taskId) {
            if (DoleticUIModule.checkNewDeliveryForm()) {
                // retreive missing information
                TaskServicesInterface.updateDelivery(
                    id,
                    $('#delnumber').val(),
                    $('#delcontent').val(),
                    $('#billed').prop('checked') ? 1 : 0,
                    function (data) {
                        DoleticUIModule.editDeliveryHandler(data, taskId);
                    }
                );
            }
        };

        this.payDelivery = function (id, taskId) {
            $('#delivery_form').hide();
            $('#paid_btn').attr('onClick', 'DoleticUIModule.confirmPayDelivery(' + id + ', ' + taskId + '); return false;');
            $('#paid_form').show();
            $('#paydate').focus();
        };

        this.confirmPayDelivery = function (id, taskId) {
            TaskServicesInterface.payDelivery(
                id,
                $('#paydate').val(),
                function (data) {
                    DoleticUIModule.cancelPaidForm();
                    DoleticUIModule.editDeliveryHandler(data, taskId);
                }
            );
        };

        this.unpayDelivery = function (id, taskId) {
            TaskServicesInterface.unpayDelivery(
                id,
                function (data) {
                    DoleticUIModule.editDeliveryHandler(data, taskId);
                }
            );
        };

        this.deliverDelivery = function (id, taskId) {
            $('#delivery_form').hide();
            $('#delivered_btn').attr('onClick', 'DoleticUIModule.confirmDeliverDelivery(' + id + ', ' + taskId + '); return false;');
            $('#delivered_form').show();
            $('#deldate').focus();
        };

        this.confirmDeliverDelivery = function (id, taskId) {
            TaskServicesInterface.deliverDelivery(
                id,
                $('#deldate').val(),
                function (data) {
                    DoleticUIModule.cancelDeliveredForm();
                    DoleticUIModule.editDeliveryHandler(data, taskId);
                }
            );
        };

        this.undeliverDelivery = function (id, taskId) {
            TaskServicesInterface.undeliverDelivery(
                id,
                function (data) {
                    DoleticUIModule.editDeliveryHandler(data, taskId);
                }
            );
        };

        this.updateAmendment = function (id, number) {
            if (DoleticUIModule.checkNewAmendmentForm()) {
                // retreive missing information
                ProjectServicesInterface.updateAmendment(
                    id,
                    $('#amtype_search').dropdown('get value'),
                    $('#content_field').val(),
                    $('#attributable').prop('checked') ? 1 : 0,
                    $('#amdate').val(),
                    function (data) {
                        DoleticUIModule.editAmendmentHandler(data, number);
                    }
                );
            }
        };

        this.deleteProject = function (number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer la suppression", "\<i class=\"remove user icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir supprimer l'étude ? Cette opération est irréversible.",
                function () {
                    DoleticUIModule.deleteProjectHandler(number);
                },
                DoleticMasterInterface.hideConfirmModal);
        };

        this.deleteTask = function (id, number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer la suppression", "\<i class=\"remove icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir supprimer la phase ? Cette opération est irréversible.",
                function () {
                    DoleticUIModule.deleteTaskHandler(id, number);
                },
                DoleticMasterInterface.hideConfirmModal);
        };

        this.deleteDelivery = function (id, taskId) {
            TaskServicesInterface.deleteDelivery(id, function (data) {
                DoleticUIModule.deleteDeliveryHandler(data, taskId);
            });
        };

        this.deleteAmendment = function (id, number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer la suppression", "\<i class=\"remove icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir supprimer l'avenant ? Cette opération est irréversible.",
                function () {
                    DoleticUIModule.deleteAmendmentHandler(id, number);
                },
                DoleticMasterInterface.hideConfirmModal);
        };

        this.disableProject = function (number) {
            // Confirmation
            DoleticUIModule.clearDisableProjectForm(number);
            $('#disable_form_modal').modal('show');
        };

        this.confirmDisableProject = function () {
            ProjectServicesInterface.disable(
                $('#disable_number').val(),
                $('#restoredate').val(),
                DoleticUIModule.disableProjectHandler
            );
        };

        this.restoreProject = function (number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer la réactivation", "\<i class=\"remove icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir réactiver cete étude plus tôt que prévu ? Elle sera de nouveau éditable.",
                function () {
                    DoleticUIModule.restoreProjectHandler(number);
                },
                DoleticMasterInterface.hideConfirmModal);
        };

        this.abortProject = function (number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer l'avortement ?", "\<i class=\"archive icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir avorter cette sollicitation ? Elle ne sera considérée comme abandonnée.",
                function () {
                    DoleticUIModule.abortProjectHandler(number);
                },
                DoleticMasterInterface.hideConfirmModal);
        };

        this.archiveProject = function (number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer l'archivage", "\<i class=\"student icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir archiver cette étude ? Elle ne sera considérée comme terminée ou rompue.",
                function () {
                    DoleticUIModule.archiveProjectHandler(number);
                },
                DoleticMasterInterface.hideConfirmModal);
        };

        this.unarchiveProject = function (number) {
            // Confirmation
            DoleticMasterInterface.showConfirmModal("Confirmer le désarchivage", "\<i class=\"add user icon\"\>\<\/i\>",
                "Etes-vous sûr de vouloir désarchiver cette étude ? Elle ne sera plus considérée comme terminée ou rompue.",
                function () {
                    DoleticUIModule.unarchiveProjectHandler(number)
                },
                DoleticMasterInterface.hideConfirmModal);
        };

// Show forms

        this.showNewProjectForm = function () {
            DoleticUIModule.clearNewProjectForm();
            $('#project_form_modal').modal('show');
        };

        this.cancelNewProjectForm = function () {
            DoleticUIModule.clearNewProjectForm();
            $('#project_form_modal').modal('hide');
        };

        this.cancelDisableProjectForm = function () {
            DoleticUIModule.clearDisableProjectForm();
            $('#disable_form_modal').modal('hide');
        };

        this.showNewTaskForm = function (number) {
            DoleticUIModule.clearNewTaskForm(number);
            $('#task_form_modal').modal('show');
        };

        this.cancelNewTaskForm = function (number) {
            DoleticUIModule.clearNewTaskForm(number);
            $('#task_form_modal').modal('hide');
        };

        this.showNewAmendmentForm = function (number) {
            DoleticUIModule.clearNewAmendmentForm(number);
            $('#amend_form_modal').modal('show');
        };

        this.cancelNewAmendmentForm = function (number) {
            DoleticUIModule.clearNewAmendmentForm(number);
            $('#amend_form_modal').modal('hide');
        };

        this.cancelPaidForm = function () {
            $('#delivery_form').show();
            $('#paid_form').hide()[0].reset();
        };

        this.cancelDeliveredForm = function () {
            $('#delivery_form').show();
            $('#delivered_form').hide()[0].reset();
        };

        this.checkNewProjectForm = function () {
            $('#project_form .message').remove();
            $('#project_form .field').removeClass("error");
            var valid = true;
            var errorString = "";
            if ($('#project_name').val().trim() == '') {
                $('#project_name_field').addClass("error");
                valid = false;
            }
            if ($('#project_origin_search').dropdown('get value') == "") {
                $('#project_origin_field').addClass("error");
                valid = false;
            }
            if ($('#project_field_search').dropdown('get value') == "") {
                $('#project_field_field').addClass("error");
                valid = false;
            }
            if ($('#project_firm_search').dropdown('get value') == "") {
                $('#project_firm_field').addClass("error");
                valid = false;
            }
            if (!DoleticMasterInterface.checkInt($('#project_mgmt').val())) {
                $('#project_mgmt_field').addClass("error");
                valid = false;
            }
            if (!DoleticMasterInterface.checkInt($('#project_app').val())) {
                $('#project_app_field').addClass("error");
                valid = false;
            }
            if (!DoleticMasterInterface.checkInt($('#project_rebilled').val())) {
                $('#project_rebilled_field').addClass("error");
                valid = false;
            }
            if (!DoleticMasterInterface.checkInt($('#project_advance').val())) {
                $('#project_advance_field').addClass("error");
                valid = false;
            }
            if (!valid) {
                $('#project_form').transition('shake');
                DoleticMasterInterface.showFormError("Erreur !", "Merci de corriger les champs affichés en rouge.", '#project_form');
            }
            return valid;
        };

        this.checkNewTaskForm = function () {
            $('#task_form .message').remove();
            $('#task_form .field').removeClass("error");
            var valid = true;
            if ($('#tname').val() == "") {
                $('#tname_field').addClass("error");
                valid = false;
            }
            if (!DoleticMasterInterface.checkDate($('#sdatea').val())) {
                $('#sdatea_field').addClass("error");
                valid = false;
            }
            if (!DoleticMasterInterface.checkDate($('#edate').val()) || $('#edate').val() < $('#sdatea').val()) {
                $('#edate_field').addClass("error");
                valid = false;
            }
            if (!DoleticMasterInterface.checkInt($('#jehamount').val())) {
                $('#jehamount_field').addClass("error");
                valid = false;
            }
            // Use setting for max JEH cost ...
            if (!DoleticMasterInterface.checkInt($('#jehcost').val()) || Number($('#jehcost').val()) > 340 || Number($('#jehcost').val()) < 80) {
                $('#jehcost_field').addClass("error");
                valid = false;
            }
            if (!valid) {
                $('#task_form').transition('shake');
                DoleticMasterInterface.showFormError("Erreur !", "Merci de corriger les champs affichés en rouge.", '#task_form');
            }
            return valid;
        };

        this.checkNewDeliveryForm = function () {
            $('#delivery_form .message').remove();
            $('#delivery_form .field').removeClass("error");
            var valid = true;
            if (!DoleticMasterInterface.checkInt($('#delnumber').val())) {
                $('#delnumber_field').addClass("error");
                valid = false;
            }
            if (!valid) {
                $('#delivery_form').transition('shake');
                DoleticMasterInterface.showFormError("Erreur !", "Merci de corriger les champs affichés en rouge.", '#delivery_form');
            }
            return valid;
        };

        this.checkNewAmendmentForm = function () {
            $('#amend_form .message').remove();
            $('#amend_form .field').removeClass("error");
            var valid = true;
            if (!DoleticMasterInterface.checkDate($('#amdate').val())) {
                $('#amdate_field').addClass("error");
                valid = false;
            }
            if ($('#type_search').dropdown('get value') == "") {
                $('#type_field').addClass("error");
                valid = false;
            }
            if (!valid) {
                $('#amendment_form').transition('shake');
                DoleticMasterInterface.showFormError("Erreur !", "Merci de corriger les champs affichés en rouge.", '#amend_form');
            }
            return valid;
        };


// --- HANDLERS
        this.addProjectHandler = function (data) {
            // if no service error
            if (data.code == 0) {
                // clear project form
                DoleticUIModule.cancelNewProjectForm();
                // alert user that creation is a success
                DoleticMasterInterface.showSuccess("Création réussie !", "L'étude a été créée avec succès !");
                // fill project list
                DoleticUIModule.fillProjectsList();
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.editProjectHandler = function (data, number) {
            // if no service error
            if (data.code == 0) {
                // clear project form
                DoleticUIModule.cancelNewProjectForm();
                // alert user that creation is a success
                DoleticMasterInterface.showSuccess("Edition réussie !", "L'étude a été modifiée avec succès !");
                // fill project list
                DoleticUIModule.fillProjectsList();
                if (window.currentDetails == number) {
                    DoleticUIModule.fillProjectDetails(number);
                }
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.disableProjectHandler = function (data) {
            // if no service error
            if (data.code == 0) {
                // clear disable project form
                DoleticUIModule.cancelDisableProjectForm();
                // alert user that disable is a success
                DoleticMasterInterface.showSuccess("Désactivation réussie !", "L'étude a été désactivée avec succès !");
                // fill project list
                DoleticUIModule.fillProjectsList();
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.restoreProjectHandler = function (number) {
            ProjectServicesInterface.enable(number, function (data) {
                // if no service error
                if (data.code == 0) {
                    DoleticMasterInterface.hideConfirmModal();
                    // alert user that restore is a success
                    DoleticMasterInterface.showSuccess("Restauration réussie !", "L'étude a été restaurée avec succès !");
                    DoleticUIModule.fillProjectsList();
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.abortProjectHandler = function (number) {
            ProjectServicesInterface.abortProject(number, function (data) {
                // if no service error
                if (data.code == 0) {
                    DoleticMasterInterface.hideConfirmModal();
                    DoleticMasterInterface.showSuccess("Opération réussie !", "L'étude a été avortée.");
                    DoleticUIModule.fillProjectsList();
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.archiveProjectHandler = function (number) {
            ProjectServicesInterface.archiveProject(number, function (data) {
                // if no service error
                if (data.code == 0) {
                    DoleticMasterInterface.hideConfirmModal();
                    DoleticMasterInterface.showSuccess("Opération réussie !", "L'étude a été archivée.");
                    DoleticUIModule.fillProjectsList();
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.unarchiveProjectHandler = function (number) {
            ProjectServicesInterface.unarchiveProject(number, function (data) {
                // if no service error
                if (data.code == 0) {
                    DoleticMasterInterface.hideConfirmModal();
                    DoleticMasterInterface.showSuccess("Opération réussie !", "L'étude a été retirée des archives.");
                    DoleticUIModule.fillProjectsList();
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.deleteProjectHandler = function (number) {
            ProjectServicesInterface.delete(number, function (data) {
                // if no service error
                if (data.code == 0) {
                    DoleticMasterInterface.hideConfirmModal();
                    DoleticMasterInterface.showSuccess("Suppression réussie !", "L'étude a été supprimée avec succès !");
                    DoleticUIModule.fillProjectsList();
                    if (window.currentDetails = number) {
                        $("#det").hide();
                    }
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.unsignProjectHandler = function (number) {
            ProjectServicesInterface.unsignProject(number, function (data) {
                DoleticMasterInterface.hideConfirmModal();
                DoleticUIModule.editProjectHandler(data, number);
            });
        };

        this.unendProjectHandler = function (number) {
            ProjectServicesInterface.unendProject(number, function (data) {
                DoleticMasterInterface.hideConfirmModal();
                DoleticUIModule.editProjectHandler(data, number);
            });
        };

        this.addTaskHandler = function (data, number) {
            // if no service error
            if (data.code == 0) {
                // clear ticket form
                DoleticUIModule.cancelNewTaskForm(number);
                // alert user that creation is a success
                DoleticMasterInterface.showSuccess("Création réussie !", "La phase a été créée avec succès !");
                // fill ticket list
                DoleticUIModule.fillTaskList(number);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.editTaskHandler = function (data, number) {
            // if no service error
            if (data.code == 0) {
                // clear ticket form
                DoleticUIModule.cancelNewTaskForm(number);
                // alert user that creation is a success
                DoleticMasterInterface.showSuccess("Edition réussie !", "La phase a été modifiée avec succès !");
                // fill ticket list
                DoleticUIModule.fillTaskList(number);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.deleteTaskHandler = function (id, number) {
            TaskServicesInterface.delete(id, function (data) {
                // if no service error
                if (data.code == 0) {
                    DoleticMasterInterface.hideConfirmModal();
                    DoleticMasterInterface.showSuccess("Suppression réussie !", "La phase a été supprimée avec succès !");
                    DoleticUIModule.fillTaskList(number);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

        this.addDeliveryHandler = function (data, taskId) {
            // if no service error
            if (data.code == 0) {
                // clear ticket form
                DoleticUIModule.clearNewDeliveryForm(taskId);
                // fill delivery list
                DoleticUIModule.fillDeliveryList(taskId);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.editDeliveryHandler = function (data, taskId) {
            // if no service error
            if (data.code == 0) {
                // clear ticket form
                DoleticUIModule.clearNewDeliveryForm(taskId);
                // fill delivery list
                DoleticUIModule.fillDeliveryList(taskId);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.deleteDeliveryHandler = function (data, taskId) {
            // if no service error
            if (data.code == 0) {
                // fill delivery list
                DoleticUIModule.fillDeliveryList(taskId);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.addAmendmentHandler = function (data, number) {
            // if no service error
            if (data.code == 0) {
                // clear ticket form
                DoleticUIModule.cancelNewAmendmentForm(number);
                // alert user that creation is a success
                DoleticMasterInterface.showSuccess("Création réussie !", "L'avenant a été créé avec succès !");
                // fill ticket list
                DoleticUIModule.fillAmendmentList(number);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.editAmendmentHandler = function (data, number) {
            // if no service error
            if (data.code == 0) {
                // clear ticket form
                DoleticUIModule.cancelNewAmendmentForm(number);
                // alert user that creation is a success
                DoleticMasterInterface.showSuccess("Modification réussie !", "L'avenant a été modifié avec succès !");
                // fill ticket list
                DoleticUIModule.fillAmendmentList(number);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        };

        this.deleteAmendmentHandler = function (id, number) {
            ProjectServicesInterface.deleteAmendment(id, function (data) {
                // if no service error
                if (data.code == 0) {
                    DoleticMasterInterface.hideConfirmModal();
                    DoleticMasterInterface.showSuccess("Suppression réussie !", "L'avenant a été supprimé avec succès !");
                    DoleticUIModule.fillAmendmentList(number);
                } else {
                    // use default service service error handler
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        };

    }
    ;