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
        DoleticUIModule.getMembersTab();
        DoleticUIModule.getTeamsTab();
        DoleticUIModule.getDetailsTab();

        // hide user details tab
        $('#det').hide();
        //Draw graphs
        DoleticUIModule.drawGraphs();
        DoleticUIModule.fillValueIndicators();
        // fill user and team list. User first to fill user_list global array
        DoleticUIModule.fillUsersList(DoleticUIModule.fillTeamsList);
        //fill division field
        DoleticUIModule.fillDivisionSelector();
        // activate items in tabs
        $('.menu .item').tab();
        window.postLoad();
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
  							<a class=\"item\" id=\"memlist\" data-tab=\"memberlist\">Liste des membres</a> \
  							<a class=\"item\" data-tab=\"teamlist\">Liste des équipes</a> \
  							<!--<a class=\"item\" data-tab=\"form\">Formations</a>--> \
  							<a class=\"item\" id=\"det\" data-tab=\"userdetails\">Détails de l'utilisateur</a> \
						</div> \
						<div class=\"ui bottom attached tab segment active\" data-tab=\"stats\"> \
							<div id=\"statsTab\">\
								<div class=\"ui loader active\"></div>\
							</div>\
					    </div> \
						<div class=\"ui bottom attached tab segment\" data-tab=\"memberlist\"> \
							<div id=\"membersTab\">\
								<div class=\"ui loader active\"></div>\
							</div>\
						</div> \
						<div class=\"ui bottom attached tab segment\" data-tab=\"teamlist\"> \
							<div id=\"teamsTab\">\
								<div class=\"ui loader active\"></div>\
							</div>\
						</div> \
						<div class=\"ui bottom attached tab segment\" data-tab=\"userdetails\"> \
							<div id=\"detailsTab\">\
							</div>\
						</div> \
					</div> \
				  </div> \
				  <div class=\"row\"> \
				  </div> \
				  <div class=\"row\"> \
				  </div> \
				</div>";
    };
    /**
     *    Override uploadSuccessHandler
     */
    this.uploadSuccessHandler = function (id, data) {
        this.super.uploadSuccessHandler(id, data);
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
        $('#agr_form_modal').remove(); // Necessary to avoid duplicate (look for better solution)
        $('#statsTab').load("../modules/hr/ui/templates/statsTab.html", function () {
            $('#ag_container').prev('.ui.horizontal.divider').remove();
            $('#ag_container').remove();
        });
    };

    /**
     *    Load the HTML code of the Members Tab
     */
    this.getMembersTab = function () {
        $('#user_form_modal').remove(); // Necessary to avoid duplicate (look for better solution)
        $('#profile_form_modal').remove();
        $('#membersTab').load("../modules/hr/ui/templates/membersTab.html", function () {
            DoleticMasterInterface.makeDefaultCalendar('birthdate_calendar');
            $('#toggle_old').change(DoleticUIModule.fillUsersList);
            $('#adduser_modal_btn').remove();
        });
    };

    /**
     *    Load the HTML code of the Teams Tab
     */
    this.getTeamsTab = function () {
        $('#team_form_modal').remove(); //Necessary to avoid duplicate
        $('#teamsTab').load("../modules/hr/ui/templates/teamsTab.html");
    };
    /**
     *    Load the HTML code of the Details Tab
     */
    this.getDetailsTab = function () {
        $('#detailsTab').load("../modules/hr/ui/templates/detailsTab.html", function () {
            $('#addadmm_modal_btn').parent().remove();
            $('#addintm_modal_btn').parent().remove();
        });
    };

    this.hasInputError = false;

    this.fillDivisionSelector = function () {
        UserDataServicesInterface.getAllDivisions(function (data) {
            // if no service error
            if (data.code == 0) {
                // create content var to build html
                var content = '';
                // iterate over values to build options
                for (var i = 0; i < data.object.length; i++) {
                    content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                }
                // insert html content
                $('#division_search .menu').html(content);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillUsersList = function (callback) {
        // Optional callback
        callback = callback || 0;

        // Load old members
        var showOld = $('#toggle_old').prop('checked');
        UserDataServicesInterface.getAll(function (data) {
            // Delete and recreate table so Datatables is reinitialized
            $("#user_table_container").html("");
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                // Store data in global array
                window.user_list = [];
                // iterate over values to build options
                var content = "<table class=\"ui very basic celled table\" id=\"user_table\"> \
                <thead> \
                    <tr>\
                        <th></th>\
                        <th>Nom/Mail</th> \
                        <th>Poste</th> \
                        <th>Pôle</th> \
                        <th>Téléphone</th> \
                        <th>Année</th> \
                        <th>Actions</th> \
                    </tr>\
                </thead>\
                <tfoot> \
                    <tr>\
                        <th></th>\
                        <th>Nom</th> \
                        <th>Poste</th> \
                        <th>Pôle</th> \
                        <th>Téléphone</th> \
                        <th>Année</th> \
                        <th></th> \
                    </tr>\
                </tfoot>\
                <tbody id=\"user_body\">";

                var filters = [
                    DoleticMasterInterface.no_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.reset_filter
                ];
                var selector_content = "";
                for (var i = 0; i < data.object.length; i++) {
                    window.user_list[data.object[i].id] = data.object[i];

                    if (!(data.object[i].old && !showOld)) {
                        selector_content += '<div class="item" data-value="' + data.object[i].user_id + '">'
                            + data.object[i].firstname + ' ' + data.object[i].lastname + '</div>';

                        if (data.object[i].disabled) {

                        } else {
                            content += "<tr><td> \
			      						<button class=\"ui teal icon button\" data-tooltip=\"Détails de " + data.object[i].firstname + " " + data.object[i].lastname + "\" data-content=\"Cliquez ici pour afficher plus d'informations\" onClick=\"DoleticUIModule.fillUserDetails(" + data.object[i].user_id + "); return false;\"> \
				  							<i class=\"user icon\"></i> \
										</button> \
										</td><td> \
			        				<h4 class=\"ui header\"> \
			          				<div class=\"content\">" + data.object[i].firstname + " " + data.object[i].lastname +
                                "<div class=\"sub header\"><a href=\"mailto:" + data.object[i].email + "\" target=\"_blank\">" + data.object[i].email + "</a></div> \
			        				</div> \
			      					</h4></td> \
			      					<td>" + data.object[i].position[0].label + "</td> \
			      					<td>" + data.object[i].position[0].division + "</td> \
			      					<td>" + data.object[i].tel + "</td> \
			      					<td>" + data.object[i].school_year + data.object[i].insa_dept + "</td> \
			    				<td><i>Aucune</i></td> \
			    				</tr>";
                        }
                    }
                }
                content += "</tbody></table>";
                $('#user_table_container').append(content);
                DoleticMasterInterface.makeDataTables('user_table', filters);
                $('.user-drop .menu').html(selector_content);
                if (callback != 0) {
                    callback();
                }
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillTeamsList = function () {
        TeamServicesInterface.getAll(function (data) {
            // Delete and recreate table so Datatables is reinitialized
            $("#team_table_container").html("");
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                window.team_list = [];
                // create content var to build html
                var content = "<table class=\"ui very basic celled table\" id=\"team_table\"> \
								    <thead> \
								        <tr>\
								            <th>Nom</th> \
								            <th>Chef d'équipe</th> \
								            <th>Pôle</th> \
								            <th>Membres</th> \
								            <th>Actions</th> \
								        </tr>\
								    </thead>\
								    <tfoot> \
								        <tr>\
								            <th>Nom</th> \
								            <th>Chef d'équipe</th> \
								            <th>Pôle</th> \
								            <th>Membres</th> \
								            <th>Actions</th> \
								        </tr>\
								    </tfoot>\
								    <tbody id=\"team_body\"> ";
                var filters = [
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.reset_filter
                ];
                // iterate over values to build options
                for (var i = 0; i < data.object.length; i++) {
                    window.team_list[data.object[i].id] = data.object[i];
                    DoleticUIModule.makeTeamModal(data.object[i]);
                    content += "<tr><td>" + data.object[i].name + "</td> \
								<td>" + window.user_list[data.object[i].leader_id].firstname + " "
                        + window.user_list[data.object[i].leader_id].lastname + "</td> \
								<td>" + data.object[i].division + "</td> \
								<td> \
									<button class=\"ui teal icon button\" onClick=\"$('#tmodal_" + data.object[i].id + "').modal('show');\"> \
	  									<i class=\"write icon\"></i>Gérer \
								</td> \
								<td> \
									<div class=\"ui icon buttons\"> \
										<button class=\"ui blue icon button\" data-tooltip=\"Modifier\" onClick=\"DoleticUIModule.editTeam(" + data.object[i].id + "); return false;\"> \
		  									<i class=\"write icon\"></i> \
										</button> \
										<button class=\"ui red icon button\" data-tooltip=\"Supprimer\" onClick=\"DoleticUIModule.deleteTeam(" + data.object[i].id + "); return false;\"> \
		  									<i class=\"remove icon\"></i> \
										</button>\
									</div> \
								</td> \
								</tr>";
                    //}
                }
                content += "</tbody></table> ";
                // insert html content
                $('#team_table_container').append(content);
                DoleticMasterInterface.makeDataTables('team_table', filters);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.makeTeamModal = function (team) {
        $('#tmodal_' + team.id).remove();
        var modal = "<div class=\"ui modal\" id=\"tmodal_" + team.id + "\" > \
	  		<div class=\"header\">\
	    		Gérer les membres\
	  		</div> <br>\
	  		<div class=\"ui stackable grid container\"> \
	  			<div class=\"row\"> \
	  				<div class=\"ten wide column\"> \
	  					<table class=\"ui very basic single line striped table\"><tbody id=\"members_" + team.id + "\">";

        for (var i = 0; i < team.member_id.length; i++) {
            modal += "		<tr><td> \
						  <i class=\"large user middle aligned icon\"></i></td><td>\
						  <div class=\"content\">\
						    <div class=\"header\"><strong>" + window.user_list[team.member_id[i]].firstname + " "
                + window.user_list[team.member_id[i]].lastname;
            modal += "</strong></div><div class=\"description\">" + window.user_list[team.member_id[i]].position[0].label + "</div>\
						  </div>";

            if (team.member_id[i] != team.leader_id) {
                modal += "<td><button class=\"ui small red icon button\"onClick=\"DoleticUIModule.deleteTeamMember(" + team.id + ", " + team.member_id[i] + "); return false;\"> \
	  									<i class=\"remove icon\"></i>Retirer \
							</button></td>";
            } else {
                modal += "<td> (Chef d'équipe) </td>";
            }

            modal += "</td></tr>";
        }
        modal += "		</tbody></table> \
	  				</div> \
	  				<div class=\"six wide column\"> \
	  					<form class=\"ui form\">\
 						 <h4 class=\"ui dividing header\">Ajouter des membres</h4>\
 						 <div class=\"required field\"> \
							<label>Membre à ajouter</label> \
			      				<div id=\"add_tmember_select" + team.id + "\" class=\"ui fluid multiple search selection dropdown user-drop\">" +
            "<input type=\"hidden\"/>" +
            "<i class=\"dropdown icon\"></i>" +
            "<div class=\"default text\">Membre...</div>" +
            "<div class=\"menu\">";

        for (var i = 0; i < window.user_list.length; i++) {
            if (typeof window.user_list[i] !== 'undefined') {
                modal += "<div class=\"item\" id=\"memoption_" + team.id + "_" + window.user_list[i].id + "\" data-value=\"" + window.user_list[i].id + "\">" + window.user_list[i].firstname + " " + window.user_list[i].lastname + "</div>";
            }
        }

        modal += "</div></div> \
		  				 </div> \
		  				 <div id=\"add_tmember_btn" + team.id + "\" class=\"ui green button\" onClick=\"DoleticUIModule.insertTeamMember(" + team.id + ");\">Ajouter</div> \
 						</form>\
	  				</div> \
	  			</div> \
	  			<div class=\"row\"></div>\
	  		</div> \
		</div>";

        var $mod = $("#something").find("#tmodal_" + team.id);
        if (!$mod.length) {
            $("body").append(modal);
        } else {
            $mod.replaceWith(modal);
        }
        $("#add_tmember_select" + team.id).dropdown();
    };

    this.drawGraphs = function () {
        IndicatorServicesInterface.processAllGraphByModule('hr', function (data) {
            //console.log(data.object);
            DoleticMasterInterface.drawGraphs(data.object, 'graphs');
        });
    };

    this.fillValueIndicators = function () {
        IndicatorServicesInterface.processAllValueByModule('hr', function (data) {
            //console.log(data.object);
            DoleticMasterInterface.fillValueIndicators(data.object, 'indicators_body');
        });
    };

    this.fillUserDetails = function (userId) {
        // activate items in tabs
        $('.menu .item').tab();
        $('.dropdown').dropdown();

        UserDataServicesInterface.getByUserId(userId, function (data) {
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                $('#det_name').html(data.object.gender + " " + data.object.firstname + " " + data.object.lastname);
                var pos_html = "";
                pos_html += data.object.position[0].label;
                $('#det_pos').html(pos_html);
                $('#det_birth').html(data.object.birthdate);
                $('#det_country').html(data.object.country);
                $('#det_city').html(data.object.city);
                $('#det_add').html(data.object.address);
                $('#det_postal').html(data.object.postal_code);
                $('#det_tel').html(data.object.tel);
                $('#det_mail').html(data.object.email);
                $('#det_year').html(data.object.school_year + data.object.insa_dept);
                $('#det_ag').html(data.object.ag);
                $('#det').show();
                var htmlTitle = "Détails de " + data.object.firstname + " " + data.object.lastname;
                if (data.object.disabled) {
                    htmlTitle += " (désactivé)";
                }
                $('#det').html(htmlTitle);
                $('#det').click();
                $('#addadmm_modal_btn').attr("onClick", "DoleticUIModule.showNewAdmMembershipForm(" + data.object.user_id + "); return false;");
                $('#admm_btn').attr("onClick", "DoleticUIModule.insertNewAdmMembership(" + data.object.user_id + "); return false;");
                $('#abort_admm').attr("onClick", "DoleticUIModule.cancelNewAdmMembershipForm(" + data.object.user_id + "); return false;");
                $('#addintm_modal_btn').attr("onClick", "DoleticUIModule.showNewIntMembershipForm(" + data.object.user_id + "); return false;");
                $('#intm_btn').attr("onClick", "DoleticUIModule.insertNewIntMembership(" + data.object.user_id + "); return false;");
                $('#abort_intm').attr("onClick", "DoleticUIModule.cancelNewIntMembershipForm(" + data.object.user_id + "); return false;");

                // Fill memberships tables
                DoleticUIModule.fillAdmMemberships(data.object.user_id);
                DoleticUIModule.fillIntMemberships(data.object.user_id);
                DoleticUIModule.fillPositionHistory(data.object);

            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
        window.currentDetails = userId;
    };

    this.fillAdmMemberships = function (userId) {
        AdmMembershipServicesInterface.getUserAdmMemberships(userId, function (data) {
            $("#admm_table_container").html("");

            if (data.code == 0 && data.object != "[]") {

                var filters = [
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.reset_filter
                ];
                var html = "<table class=\"ui very basic celled table\" id=\"admm_table\"> \
							    <thead> \
							        <tr>\
							            <th>Date de début</th> \
							            <th>Date de fin</th> \
							            <th>Cotis.</th> \
							            <th>Fiche</th> \
							            <th>Certif.</th> \
							            <th>Actions</th> \
							        </tr>\
							    </thead>\
							    <tfoot> \
							        <tr>\
							            <th>Date de début</th> \
							            <th>Date de fin</th> \
							            <th>Cotis.</th> \
							            <th>Fiche</th> \
							            <th>Certif.</th> \
							            <th>Actions</th> \
							        </tr>\
							    </tfoot>\
							    <tbody id=\"admm_body\"> ";
                for (var i = 0; i < data.object.length; i++) {
                    if (!(data.object[i].fee && data.object[i].form && data.object[i].certif)) {
                        html += "<tr class=\"warning\">";
                    } else {
                        html += "<tr>";
                    }
                    html += "<td>" + data.object[i].start_date + "</td>";
                    html += "<td>" + data.object[i].end_date + "</td>";
                    html += "<td>" + data.object[i].fee + "</td>";
                    html += "<td>" + data.object[i].form + "</td>";
                    html += "<td>" + data.object[i].certif + "</td>";
                    html = html.replace(/false/g, "Non");
                    html = html.replace(/true/g, "Oui");
                    html += "<td><i>Aucune</i></td></tr>";
                }
                html += "</tbody></table>";
                $("#admm_table_container").html(html);
                DoleticMasterInterface.makeDataTables('admm_table', filters);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillIntMemberships = function (userId) {
        IntMembershipServicesInterface.getUserIntMemberships(userId, function (data) {
            $("#intm_table_container").html("");

            if (data.code == 0 && data.object != "[]") {

                var filters = [
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.select_filter,
                    DoleticMasterInterface.reset_filter
                ];
                var html = "<table class=\"ui very basic celled table\" id=\"intm_table\"> \
							    <thead> \
							        <tr>\
							            <th>Date de début</th> \
							            <th>Cotis.</th> \
							            <th>Fiche</th> \
							            <th>Certif.</th> \
							            <th>RIB</th> \
							            <th>Pièce id.</th> \
							            <th>Actions</th> \
							        </tr>\
							    </thead>\
							    <tfoot> \
							        <tr>\
							            <th>Date de début</th> \
							            <th>Cotis.</th> \
							            <th>Fiche</th> \
							            <th>Certif.</th> \
							            <th>RIB</th> \
							            <th>Pièce id.</th> \
							            <th>Actions</th> \
							        </tr>\
							    </tfoot>\
							    <tbody id=\"intm_body\"> ";
                for (var i = 0; i < data.object.length; i++) {
                    if (!(data.object[i].fee && data.object[i].form && data.object[i].certif && data.object[i].rib && data.object[i].identity)) {
                        html += "<tr class=\"warning\">";
                    } else {
                        html += "<tr>";
                    }
                    html += "<td>" + data.object[i].start_date + "</td>";
                    html += "<td>" + data.object[i].fee + "</td>";
                    html += "<td>" + data.object[i].form + "</td>";
                    html += "<td>" + data.object[i].certif + "</td>";
                    html += "<td>" + data.object[i].rib + "</td>";
                    html += "<td>" + data.object[i].identity + "</td>";
                    html = html.replace(/false/g, "Non");
                    html = html.replace(/true/g, "Oui");
                    html += "<td><i>Aucune</i></td></tr>";
                }
                $("#intm_table_container").html(html);
                DoleticMasterInterface.makeDataTables('intm_table', filters);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillPositionHistory = function (user) {
        var content = '';
        for (var i = 0; i < user.position.length; i++) {
            content += "<tr><td>" + user.position[i].label + "</td>";
            content += "<td>" + user.position[i].since + "</td></tr>";
        }
        $('#pos_history_body').html(content);
    };

    this.clearNewTeamForm = function () {
        $('#team_form .message').remove();
        $('#team_form')[0].reset();
        $('#team_form h4').html("Ajout d'une équipe");
        $('#team_form .dropdown').dropdown('restore defaults');
        $('#addteam_btn').html("Ajouter");
        $('#addteam_btn').attr("onClick", "DoleticUIModule.insertNewTeam(); return false;");
    };

    this.insertNewTeam = function () {
        if (DoleticUIModule.checkNewTeamForm()) {
            // retreive missing information
            TeamServicesInterface.insert(
                $('#tname').val(),
                $('#leader_search').dropdown('get value'),
                $('#division_search').dropdown('get value'),
                DoleticUIModule.addTeamHandler
            );
        }
    };

    this.insertTeamMember = function (id) {
        var options = $('#add_tmember_select' + id).dropdown('get value').split(',');
        TeamServicesInterface.insertMember(id, options, function (data) {
            // if no service error
            if (data.code == 0) {
                DoleticUIModule.updateTeamModal(id);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.editTeam = function (id) {
        $('#team_form h4').html("Edition d'une équipe");
        TeamServicesInterface.getById(id, function (data) {
            // if no service error
            if (data.code == 0 && data.object != "[]") {
                $('#tname').val(data.object.name);
                $('#division').dropdown("set selected", data.object.division);
                $('#leader').dropdown("set selected", data.object.leader_id);
                $('#addteam_btn').html("Confirmer");
                $('#addteam_btn').attr("onClick", "DoleticUIModule.updateTeam(" + id + "); return false;");
                $('#team_form_modal').modal('show');
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.updateTeam = function (id) {
        // ADD OTHER TESTS
        if (DoleticUIModule.checkNewTeamForm()) {
            // Update team data in DB
            TeamServicesInterface.update(id,
                $('#tname').val(),
                $('#leader_search').dropdown('get value'),
                $('#division_search').dropdown('get value'),
                DoleticUIModule.editTeamHandler
            );
        }
    };

    this.deleteTeamMember = function (id, memberId) {
        TeamServicesInterface.deleteMember(id, memberId, function (data) {
            // if no service error
            if (data.code == 0) {
                DoleticUIModule.updateTeamModal(id);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.updateTeamModal = function (id) {
        $("#add_tmember_select" + id).dropdown('restore defaults');
        TeamServicesInterface.getTeamMembers(id, function (data) {
            window.team_list[id].members = data.object;
            var html = "";
            for (var i = 0; i < data.object.length; i++) {
                html += "		<tr><td> \
							  <i class=\"large user middle aligned icon\"></i></td><td>\
							  <div class=\"content\">\
							    <div class=\"header\"><strong>" + window.user_list[data.object[i]].firstname + " "
                    + window.user_list[data.object[i]].lastname;
                html += "</strong></div><div class=\"description\">" + window.user_list[data.object[i]].position[0].label + "</div>\
							  </div>";

                if (data.object[i] != window.team_list[id].leader_id) {
                    html += "<td><button class=\"ui small red icon button\"onClick=\"DoleticUIModule.deleteTeamMember(" + id + ", " + data.object[i] + "); return false;\"> \
		  									<i class=\"remove icon\"></i>Retirer \
								</button></td>";
                } else {
                    html += "<td> (Chef d'équipe) </td>";
                }

                html += "</td></tr>";
                $("#members_" + id).html(html);
            }
        });
    };

    this.showNewTeamForm = function () {
        DoleticUIModule.clearNewTeamForm();
        $('#team_form_modal').modal('show');
    };

    this.cancelNewTeamForm = function () {
        DoleticUIModule.clearNewTeamForm();
        $('#team_form_modal').modal('hide');
    };

    this.checkNewTeamForm = function () {
        $('#team_form .field').removeClass("error");
        var valid = true;
        if ($('#tname').val() == "") {
            $('#tname_field').addClass("error");
            valid = false;
        }
        if ($('#leader_search').dropdown('get value') == "") {
            $('#leader_field').addClass("error");
            valid = false;
        }
        if ($('#division_search').dropdown('get value') == "") {
            $('#division_field').addClass("error");
            valid = false;
        }
        if (!valid) {
            $('#team_form').transition('shake');
            DoleticMasterInterface.showFormError("Erreur !", "Merci de corriger les champs affichés en rouge.", '#team_form');
        }
        return valid;
    };

    // --- HANDLERS
    this.addTeamHandler = function (data) {
        // if no service error
        if (data.code == 0) {
            // clear ticket form
            DoleticUIModule.cancelNewTeamForm();
            // alert user that creation is a success
            DoleticMasterInterface.showSuccess("Création réussie !", "L'équipe a été créée avec succès !");
            // fill ticket list
            DoleticUIModule.fillTeamsList();
        } else {
            // use default service service error handler
            DoleticServicesInterface.handleServiceError(data);
        }
    };

    this.editTeamHandler = function (data) {
        // if no service error
        if (data.code == 0) {
            // clear ticket form
            DoleticUIModule.cancelNewTeamForm();
            // alert user that creation is a success
            DoleticMasterInterface.showSuccess("Edition réussie !", "L'équipe a été modifiée avec succès !");
            // fill ticket list
            DoleticUIModule.fillTeamsList();
        } else {
            // use default service service error handler
            DoleticServicesInterface.handleServiceError(data);
        }
    };
};