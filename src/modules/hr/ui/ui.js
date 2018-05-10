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
        $('#teamsTab').load("../modules/hr/ui/templates/teamsTab.html", function () {
            $('#addteam_modal_btn').remove();
        });
    };
    /**
     *    Load the HTML code of the Details Tab
     */
    this.getDetailsTab = function () {
        $('#detailsTab').load("../modules/hr/ui/templates/detailsTab.html", function () {
            $('#addadmm_modal_btn').parent().remove();
            $('#addintm_modal_btn').parent().remove();
            $('#admm_table_container').prev('.ui.horizontal.divider').remove();
            $('#admm_table_container').remove();
            $('#intm_table_container').prev('.ui.horizontal.divider').remove();
            $('#intm_table_container').remove();
        });
    };

    this.hasInputError = false;

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
									<button class=\"ui icon button\" onClick=\"$('#tmodal_" + data.object[i].id + "').modal('show');\"> \
	  									<i class=\"write icon\"></i>Voir \
								</td> \
								<td><i>Aucune</i></td> \
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
	    		Voir les membres\
	  		</div> <br>\
	  		<div class=\"ui stackable grid container\"> \
	  			<div class=\"row\"> \
	  				<div class=\"sixteen wide column\"> \
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

            } else {
                modal += "<td> (Chef d'équipe) </td>";
            }

            modal += "</td></tr>";
        }

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

    this.fillTableIndicators = function () {
        IndicatorServicesInterface.processAllTableByModule('hr', function (data) {
            //console.log(data.object);
            DoleticMasterInterface.fillTableIndicators(data.object, 'tables');
            $('#indictab_0 .indicval_label').click(function () {
                $('#user_table_Pôle').dropdown('set selected', $(this).html()).change();
                $('#memlist').click();
            });
            $('#indictab_1 .indicval_label').click(function () {
                $('#user_table_Année').val($(this).html()).change();
                $('#memlist').click();
            });
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

                // Fill memberships tables
                DoleticUIModule.fillPositionHistory(data.object);

            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
        window.currentDetails = userId;
    };

    this.fillPositionHistory = function (user) {
        var content = '';
        for (var i = 0; i < user.position.length; i++) {
            content += "<tr><td>" + user.position[i].label + "</td>";
            content += "<td>" + user.position[i].since + "</td></tr>";
        }
        $('#pos_history_body').html(content);
    };
};