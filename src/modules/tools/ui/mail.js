var DoleticUIModule = new function () {
    /**
     *    Parent abstract module
     */
    this.super = new AbstractDoleticUIModule('Mail_UIModule', 'Paul Dautry', '1.0dev');
    /**
     *    Override render function
     */
    this.render = function (htmlNode) {
        this.super.render(htmlNode, this);
        // enable special popup
        $('#copy_btn').popup({popup: '#copy_popup'});
        // fill category field
        DoleticUIModule.generateSignature();
        window.postLoad();
    }
    /**
     *    Override build function
     */
    this.build = function () {
        return "<div class=\"ui two column grid container\"> \
				  <div class=\"row\"> \
				  </div> \
				  <div class=\"row\"> \
				  	<div class=\"sixteen wide column\"> \
						<div id=\"title_seg\" class=\"html ui top attached segment\"> \
						   	<div class=\"ui top attached label\"><b>Votre signature de mail</b></div> \
						</div> \
						<div id=\"content_seg\" class=\"ui instructive attached segment\"> \
							<p><i id=\"copy_btn\" class=\"copy circular link icon\"></i> <b>Code HTML :</b></p> \
							<div id=\"copy_popup\" class=\"ui special small popup\"> \
								<div class=\"header\">Copier la signature :</div> \
								<div class=\"content\"> \
									<ol class=\"ui list\"> \
										<li>Cliquez dans la zone de texte</li> \
										<li>Pressez Ctrl+A</li> \
										<li>Pressez Ctrl+C</li> \
									<ol> \
								</div> \
						  	</div> \
							<form class=\"ui form\"> \
								<textarea id=\"code_zone\" readonly=\"\"> \
									<!-- HTML SIGNATURE CODE WILL GO THERE --> \
								</textarea> \
							</form> \
						</div> \
						<div id=\"footer_seg\" class=\"ui instructive bottom attached segment\"> \
							<p><b>Prévisualisation de votre signature :</b></p> \
							<div id=\"preview_zone\" class=\"\"> \
								<!-- HTML SIGNATURE WILL GO THERE --> \
							</div> \
						</div> \
					</div> \
				  </div> \
				  <div class=\"row\"> \
				  </div> \
				</div>";
    }
    /**
     *    Override uploadSuccessHandler
     */
    this.uploadSuccessHandler = function (id, data) {
        this.super.uploadSuccessHandler(id, data);
    }

    this.nightMode = function (on) {
        if (on) {
            $('#title_seg').attr('class', 'html ui top attached segment inverted');
            $('#content_seg').attr('class', 'ui instructive attached segment inverted');
            $('#footer_seg').attr('class', 'ui instructive bottom attached segment inverted');
        } else {
            $('#title_seg').attr('class', 'html ui top attached segment');
            $('#content_seg').attr('class', 'ui instructive attached segment');
            $('#footer_seg').attr('class', 'ui instructive bottom attached segment');
        }
    }

// ---- OTHER FUNCTION REQUIRED BY THE MODULE ITSELF

    this.generateSignature = function () {
        // create html signature content
        var html = '<table style="color: #000000; font-size: medium;">' +
            '<tbody>' +
            '<tr>' +
            '<td style="padding-right: 15px;">' +
            '<a href="'+ DoleticConfig.JE.website_url + '">' +
            '<img src="' + DoleticConfig.JE.logo_url + '" alt="" width="139" height="109" />' +
            '</a>' +
            '</td>' +
            '<td style="font-size: 13px; line-height: 14px; font-family: Helvetica,sans-serif;">' +
            '<p style="margin: 0px 0px;">' +
            '<span id="user_fullname" style="display: inline-block; margin-top: 12px; color: #006600; font-size: medium;">' +
            '</span><br />' +
            '<span style="display: inline-block; margin-top: 2px; color: #006600; font-size: medium;">' +
            '<strong id="user_position"></strong>' +
            '</span><br />' +
            '<span style="color: #3366ff;">' +
            '<span style="display: inline-block; margin-top: 2px;">' +
            '<a style="color: #3366ff;" id="user_phone"></a>' +
            '</span>' +
            '<span style="display: inline-block; margin-top: 2px;">&nbsp;|&nbsp;' +
            '<a id="user_mail" style="color: #3366ff;">' +
            '</a>' +
            '</span>' +
            '</span></p>' +
            '<p style="margin: 0px 0px;">' +
            '<span style="display: inline-block; margin-top: 2px; color: #888888;"></span>' +
            '<strong><span style="display: inline-block; margin-top: 2px; color: #888888;">ETIC INSA Technologies</span>&nbsp;</strong>' +
            '<br /><span style="display: inline-block; margin-top: 2px; color: #888888;">' +
            '<span> 20 avenue Albert Einstein - 69 100 Villeurbanne </span>' +
            '</span> <br />' +
            '<span style="display: inline-block; margin-top: 2px; color: #888888;">' +
            '<span> T&eacute;l&eacute;phone : <span style="color: #888888;">' +
            '<a style="color: #888888;" href="tel:+33 (0)4 78 94 02 27">' +
            ' +33 (0)4 78 94 02 27 ' +
            '</a></span></span></span></p></td></tr></tbody></table>';
        // put html signature into preview zone
        $('#preview_zone').html(html);
        // fill signature fields using user data
        DoleticServicesInterface.getCurrentUser(function (data) {
            if (data.code == 0) {
                var mail = data.object.firstname + '.'+ data.object.lastname + DoleticConfig.JE.mail_domain;
                $('#user_mail').html(mail).attr('href', 'mailto:' + mail);
                // retrieve user data
                UserDataServicesInterface.getById(data.object.id, function (data) {
                    if (data.code == 0) {
                        // set firstname, lastname, phone and year
                        $('#user_fullname').html(data.object.firstname + ' ' + data.object.lastname);
                        $('#user_phone').html(data.object.tel.replace(/^0/, '+33 (0)')).attr('href', 'tel:' + data.object.tel);
                        $('#user_departement').html(data.object.insa_dept);
                        $('#user_position').html(data.object.position[0].label);
                        // update signature source code when finished
                        DoleticUIModule.updateSignatureSourceCode(); // <!> necessary because asynchronously called
                    } else {
                        // use doletic services interface to display error
                        DoleticServicesInterface.handleServiceError(data);
                    }
                });
                // update signature source code when finished
                DoleticUIModule.updateSignatureSourceCode();
            } else {
                // update signature source code when finished
                DoleticUIModule.updateSignatureSourceCode(); // <!> necessary because asynchronously called
            }
        });
    };

    this.updateSignatureSourceCode = function () {
        $('#code_zone').html($('#preview_zone').html());
    };

};
