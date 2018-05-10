var DoleticUIModule = new function () {
    /**
     *    Parent abstract module
     */
    this.super = new AbstractDoleticUIModule('Home_UIModule', 'Paul Dautry', '1.0dev');
    /**
     *    Override render function
     */
    this.render = function (htmlNode) {
        this.super.render(htmlNode, this);
        // Retrieve user data

        DoleticUIModule.getDashboard(function() {
            DoleticUIModule.fillGenderSelector();
            DoleticUIModule.fillCountrySelector();
            DoleticUIModule.fillINSADeptSelector();
            DoleticUIModule.fillSchoolYearSelector();
            DoleticMasterInterface.makeDefaultCalendar('birthdate_calendar');
        });
        DoleticUIModule.fillUserData();
        DoleticUIModule.fillUserProjects();
        DoleticUIModule.fillUserContacts();
        DoleticUIModule.refreshAvatar();
        window.postLoad();
    };
    /**
     *    Override build function
     */
    this.build = function () {
        return "<div class=\"ui two column grid container\" id=\"dashboard_container\"></div>" + DoleticUIFactory.makeUploadForm('avatar', true);
    };
    /**
     *    Override uploadSuccessHandler
     */
    this.uploadSuccessHandler = function (id, data) {
        // treat avatar upload success event
        if (id == 'avatar') {
            DoleticServicesInterface.updateAvatar(data, function (data) {
                if (data.code == 0) {
                    DoleticUIModule.refreshAvatar();
                } else {
                    DoleticServicesInterface.handleServiceError(data);
                }
            });
        } else {
            this.super.uploadSuccessHandler(id, data);
        }
    };

    this.nightMode = function (on) {
        if (on) {
            $('#login_form').attr('class', 'ui form segment inverted');
        } else {
            $('#login_form').attr('class', 'ui form segment');
        }
    };

// ---- OTHER FUNCTION REQUIRED BY THE MODULE ITSELF

    this.getDashboard = function(callback) {
        $('#profile_form_modal').remove();
        $('#dashboard_container').load("../modules/dashboard/ui/templates/dashboard.html", callback);
    };

    /**
     *
     */
    this.refreshAvatar = function () {
        DoleticServicesInterface.getAvatar(function (data) {
            if (data.code == 0) {
                $('#user_avatar').attr('src', data.object);
            } else {
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };
    /**
     *
     */
    this.fillUserData = function () {
        DoleticServicesInterface.getCurrentUser(function (data) {
            if (data.code == 0) {
                // set last connection timestamp
                $('#form_header').html('Edition du profil de ' + data.object.username);
                $('#uname').val(data.object.username);
                var date = new Date(data.object.last_connect_timestamp);
                $('#lastco_timestamp').html(
                    DoleticUIFactory.padleft(String(date.getDate()), 2, '0') + '/' +
                    DoleticUIFactory.padleft(String(date.getMonth()), 2, '0') + '/' +
                    DoleticUIFactory.padleft(String(date.getFullYear()), 4, '0') + " à " +
                    DoleticUIFactory.padleft(String(date.getHours()), 2, '0') + ':' +
                    DoleticUIFactory.padleft(String(date.getMinutes()), 2, '0') + ':' +
                    DoleticUIFactory.padleft(String(date.getSeconds()), 2, '0'));
                // retrieve user data
                UserDataServicesInterface.getByUserId(data.object.id, function (data) {
                    if (data.code == 0) {
                        // set user name
                        $('#user_fulname').html(data.object.firstname + ' ' + data.object.lastname);
                        $('#profile_firstname').val(data.object.firstname);
                        $('#profile_lastname').val(data.object.lastname);
                        $('#profile_birthdate').val(data.object.birthdate);
                        $('#profile_gender_search').dropdown('set selected', data.object.gender);
                        $('#profile_schoolyear_search').dropdown('set selected', data.object.school_year);
                        $('#profile_dept_search').dropdown('set selected', data.object.insa_dept);
                        $('#profile_country_search').dropdown('set selected', data.object.country);
                        $('#profile_mail').val(data.object.email);
                        $('#profile_tel').val(data.object.tel);
                        $('#profile_address').val(data.object.address);
                        $('#profile_postalcode').val(data.object.postal_code);
                        $('#profile_city').val(data.object.city);
                    } else {
                        // use doletic services interface to display error
                        DoleticServicesInterface.handleServiceError(data);
                    }
                });
                // retrieve user last position
                UserDataServicesInterface.getUserLastPos(data.object.id, function (data) {
                    if (data.code == 0) {
                        // set user name
                        $('#user_position').html(data.object.label);
                    } else {
                        // use doletic services interface to display error
                        DoleticServicesInterface.handleServiceError(data);
                    }
                });
            } else {
                // use doletic services interface to display error
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillUserProjects = function () {
        DoleticServicesInterface.getCurrentUser(function (data) {
            if (data.code == 0) {
                var userId = data.object.id;
                ProjectServicesInterface.getByChadaff(userId, function (data) {
                    if (data.code == 0) {
                        var filters = [
                            DoleticMasterInterface.input_filter,
                            DoleticMasterInterface.input_filter,
                            DoleticMasterInterface.select_filter,
                            DoleticMasterInterface.select_filter
                        ];
                        var content = '<table class="ui very basic celled table" id="project_table">' +
                            '<thead>' +
                            '<tr>' +
                            '<th>Numéro</th>' +
                            '<th>Nom</th>' +
                            '<th>Rôle</th>' +
                            '<th>Statut</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tfoot>' +
                            '<tr>' +
                            '<th>Numéro</th>' +
                            '<th>Nom</th>' +
                            '<th>Rôle</th>' +
                            '<th>Statut</th>' +
                            '</tr>' +
                            '</tfoot>' +
                            '<tbody id="project_body">';
                        var click = $('#submenu_ua').attr('onclick');
                        for (var i = 0; i < data.object.length; i++) {
                            var onClick = click.substr(0, click.length-2) + ", 'DoleticUIModule.fillProjectDetails(" + data.object[i].number + ", true);');";
                            content += '<tr>' +
                                "<td><button onClick=\"" + onClick + "\" class=\"ui teal button\" data-tooltip=\"Détails de l'étude " + data.object[i].number + "\">" + data.object[i].number + "</button></td>" +
                                '<td>' + data.object[i].name + '</td>' +
                                '<td>Chargé d\'affaires</td>' +
                                '<td>' + data.object[i].status + '</td>' +
                                '</tr>';
                        }
                        ProjectServicesInterface.getByAuditor(userId, function (data) {
                            if (data.code == 0) {
                                var click = $('#submenu_ua').attr('onclick');
                                for (var i = 0; i < data.object.length; i++) {
                                    var onClick = click.substr(0, click.length-2) + ", 'DoleticUIModule.fillProjectDetails(" + data.object[i].number + ");');";
                                    content += '<tr>' +
                                        "<td><button onClick=\"" + onClick + "\" class=\"ui teal button\" data-tooltip=\"Détails de l'étude " + data.object[i].number + "\">" + data.object[i].number + "</button></td>" +
                                        '<td>' + data.object[i].name + '</td>' +
                                        '<td>Correspondant qualité</td>' +
                                        '<td>' + data.object[i].status + '</td>' +
                                        '</tr>';
                                }
                                ProjectServicesInterface.getByInt(userId, function (data) {
                                    if (data.code == 0) {
                                        var click = $('#submenu_ua').attr('onclick');
                                        for (var i = 0; i < data.object.length; i++) {
                                            var onClick = click.substr(0, click.length-2) + ", 'DoleticUIModule.fillProjectDetails(" + data.object[i].number + ");');";
                                            content += '<tr>' +
                                                "<td><button onClick=\"" + onClick + "\" class=\"ui teal button\" data-tooltip=\"Détails de l'étude " + data.object[i].number + "\">" + data.object[i].number + "</button></td>" +
                                                '<td>' + data.object[i].name + '</td>' +
                                                '<td>Consultant</td>' +
                                                '<td>' + data.object[i].status + '</td>' +
                                                '</tr>';
                                        }
                                        content += '</tbody></table>';
                                        $('#project_table_container').html(content);
                                        DoleticMasterInterface.makeDataTables('project_table', filters);
                                    } else {
                                        // use doletic services interface to display error
                                        DoleticServicesInterface.handleServiceError(data);
                                    }
                                });
                            } else {
                                // use doletic services interface to display error
                                DoleticServicesInterface.handleServiceError(data);
                            }
                        });
                    } else {
                        // use doletic services interface to display error
                        DoleticServicesInterface.handleServiceError(data);
                    }
                });
            } else {
                // use doletic services interface to display error
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillUserContacts = function () {
        ContactServicesInterface.getCurrent(function (data) {
            if (data.code == 0) {
                var filters = [
                    DoleticMasterInterface.no_filter,
                    DoleticMasterInterface.input_filter,
                    DoleticMasterInterface.select_filter
                ];
                var content = '<table class="ui very basic celled table" id="contact_table">' +
                    '<thead>' +
                    '<tr>' +
                    '<th></th>' +
                    '<th>Nom</th>' +
                    '<th>Statut</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tfoot>' +
                    '<tr>' +
                    '<th></th>' +
                    '<th>Nom</th>' +
                    '<th>Statut</th>' +
                    '</tr>' +
                    '</tfoot>' +
                    '<tbody id="contact_body">';
                var click = $('#submenu_grc').attr('onclick');
                for (var i = 0; i < data.object.length; i++) {
                    var onClick = click.substr(0, click.length-2) + ", 'DoleticUIModule.openContactInfo(" + data.object[i].id + ");');";
                    content += '<tr>' +
                        "<td><button onClick=\"" + onClick + "\" class=\"ui teal icon button\" data-tooltip=\"Détails du contact\"><i class=\"user icon\"></i></button></td>" +
                        '<td>' + data.object[i].firstname + ' ' + data.object[i].name + '</td>' +
                        '<td>' + data.object[i].category + '</td>' +
                        '</tr>';
                }
                content += '</tbody></table>';
                $('#contact_table_container').html(content);
                DoleticMasterInterface.makeDataTables('contact_table', filters);
            } else {
                // use doletic services interface to display error
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.showEditProfileForm = function() {
        $('#profile_form .field').removeClass('error');
        $('#profile_form .message').remove();
        $('#profile_form_modal').modal('show');
    };

    this.cancelProfileForm = function() {
        $('#profile_form_modal').modal('hide');
    };

    this.showEditPassForm = function() {
        $('#pass_form_modal').modal('show');
    };

    this.cancelPassForm = function() {
        $('#pass_form .field').removeClass("error");
        $('#oldpass, #newpass, #confirm').val('');
        $('#pass_form_modal').modal('hide');
        $('#pass_form .message').remove();
    };

    this.updateProfile = function() {
        if(DoleticUIModule.checkProfileForm()) {
            UserDataServicesInterface.updateOwn(
                $('#profile_gender_search').dropdown('get value'),
                $('#profile_firstname').val(),
                $('#profile_lastname').val(),
                $('#profile_birthdate').val(),
                $('#profile_tel').val(),
                $('#profile_mail').val(),
                $('#profile_address').val(),
                $('#profile_city').val(),
                $('#profile_postalcode').val(),
                $('#profile_country_search').dropdown('get value'),
                $('#profile_schoolyear_search').dropdown('get value'),
                $('#profile_dept_search').dropdown('get value'),
                function(data) {
                    if (data.code == 0) {
                        DoleticUIModule.cancelProfileForm();
                        DoleticMasterInterface.showSuccess('Succès !', 'Votre profil a été modifié avec succès !');
                        DoleticUIModule.fillUserData();
                    } else {
                        // use default service service error handler
                        DoleticServicesInterface.handleServiceError(data);
                    }

                }
            );
        }
    };

    this.updatePassword = function() {
        if(DoleticUIModule.checkPassForm()) {
            DoleticServicesInterface.updatePassword(
                $('#uname').val(),
                $('#oldpass').val(),
                $('#newpass').val(),
                function(data) {
                    if (data.code == 0) {
                        DoleticUIModule.cancelPassForm();
                        DoleticMasterInterface.showSuccess('Succès !', 'Mot de passe mis à jour avec succès !');
                    } else {
                        // use default service service error handler
                        DoleticServicesInterface.handleServiceError(data);
                    }
                }
            );
        }
    };

    this.checkPassForm = function () {
        $('#pass_form .field').removeClass("error");
        var valid = true;
        if ($('#newpass').val() != $('#confirm').val()) {
            $('#newpass_field').addClass("error");
            $('#confirm_field').addClass("error");
            valid = false;
            DoleticMasterInterface.showFormError('Erreur !', 'Le mot de passe et la confirmation sont différents.', '#pass_form');
            $('#pass_form').transition('shake');
        }
        if ($('#newpass').val().length < 9) {
            $('#newpass_field').addClass("error");
            valid = false;
            DoleticMasterInterface.showFormError('Erreur !', 'Le mot de passe doit faire au moins 9 caractères.', '#pass_form');
            $('#pass_form').transition('shake');
        }
        return valid;
    };

    this.checkProfileForm = function () {
        $('#profile_form .message').remove();
        $('#profile_form .field').removeClass("error");
        var valid = true;
        var errorString = "";
        if (!DoleticMasterInterface.checkName($('#profile_firstname').val())) {
            $('#profile_firstname_field').addClass("error");
            valid = false;
        }
        if (!DoleticMasterInterface.checkName($('#profile_lastname').val())) {
            $('#profile_lastname_field').addClass("error");
            valid = false;
        }
        if (!DoleticMasterInterface.checkDate($('#profile_birthdate').val())) {
            $('#profile_birthdate_field').addClass("error");
            valid = false;
        }
        if (!DoleticMasterInterface.checkTel($('#profile_tel').val())) {
            $('#profile_tel_field').addClass("error");
            valid = false;
        }
        if (!DoleticMasterInterface.checkMail($('#profile_mail').val())) {
            $('#profile_mail_field').addClass("error");
            valid = false;
        }
        if ($('#profile_address').val() == "") {
            $('#profile_address_field').addClass("error");
            valid = false;
        }
        if (!DoleticMasterInterface.checkName($('#profile_city').val())) {
            $('#profile_city_field').addClass("error");
            valid = false;
        }
        if (!DoleticMasterInterface.checkPostalCode($('#profile_postalcode').val())) {
            $('#profile_postalcode_field').addClass("error");
            valid = false;
        }
        if ($('#profile_gender_search').dropdown('get value') == "") {
            $('#profile_gender_field').addClass("error");
            valid = false;
        }
        if ($('#profile_country_search').dropdown('get value') == "") {
            $('#profile_country_field').addClass("error");
            valid = false;
        }
        if ($('#profile_schoolyear_search').dropdown('get value') == "") {
            $('#profile_schoolyear_field').addClass("error");
            valid = false;
        }
        if ($('#profile_dept_search').dropdown('get value') == "") {
            $('#profile_dept_field').addClass("error");
            valid = false;
        }
        if (!valid) {
            $('#profile_form').transition('shake');
            DoleticMasterInterface.showFormError("Erreur !", "Merci de corriger les champs affichés en rouge.", '#profile_form');
        }
        return valid;
    };

    this.fillCountrySelector = function () {
        UserDataServicesInterface.getAllCountries(function (data) {
            // if no service error
            if (data.code == 0) {
                // create content var to build html
                var content = '';
                // iterate over values to build options
                for (var i = 0; i < data.object.length; i++) {
                    content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                }
                // insert html content
                $('#profile_country_search .menu').html(content).dropdown();
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

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
                $('#profile_gender_search .menu').html(content).dropdown();
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillINSADeptSelector = function () {
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
                $('#profile_dept_search .menu').html(content).dropdown();
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };

    this.fillSchoolYearSelector = function () {
        UserDataServicesInterface.getAllSchoolYears(function (data) {
            // if no service error
            if (data.code == 0) {
                // create content var to build html
                var content = '';
                // iterate over values to build options
                for (var i = 0; i < data.object.length; i++) {
                    content += '<div class="item" data-value="' + data.object[i] + '">' + data.object[i] + '</div>';
                }
                // insert html content
                $('#profile_schoolyear_search .menu').html(content);
            } else {
                // use default service service error handler
                DoleticServicesInterface.handleServiceError(data);
            }
        });
    };
};