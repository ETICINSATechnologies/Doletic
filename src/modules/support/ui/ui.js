var DoleticUIModule = new function() {
	/**
	 *	Parent abstract module
	 */
	this.super = new AbstractDoleticUIModule('Support_UIModule', 'Paul Dautry', '1.0dev');
	/**
	 *	Override render function
	 */
	this.render = function(htmlNode) {
		this.super.render(htmlNode, this);
		// fill category field
		TicketServicesInterface.getAllCategories(DoleticUIModule.fillCategorySelector);
		// fill ticket list
		TicketServicesInterface.getUserTickets(DoleticUIModule.fillTicketsList);
	}
	/**
	 *	Override build function
	 */
	this.build = function() {
		return "<div class=\"ui two column grid container\"> \
				  <div class=\"row\"> \
				  </div> \
				  <div class=\"row\"> \
				  <div class=\"ten wide column\"> \
					<div class=\"ui horizontal divider\">Mes tickets</div> \
						  <div id=\"open_popup\" class=\"ui special popup\"> \
							<div class=\"content\">Votre problème n'a pas encore été pris en charge.</div> \
						  </div> \
						  <div id=\"work_popup\" class=\"ui special popup\"> \
							<div class=\"content\">Votre problème est en cours de résolution.</div> \
						  </div> \
						  <div id=\"done_popup\" class=\"ui special popup\"> \
							<div class=\"content\">Votre problème est résolu.</div> \
						  </div> \
						  <div id=\"undefined_popup\" class=\"ui special popup\"> \
							<div class=\"content\">L'etat de ce ticket est étrange. Merci de prévenir les développeurs.</div> \
						  </div> \
						  <div id=\"ticket_list\" class=\"ui very relaxed celled selection list\"> \
							<!-- USER TICKETS WILL GO HERE --> \
						  </div> \
					</div> \
					<div class=\"six wide column\"> \
					  <form id=\"support_form\" class=\"ui form segment\"> \
					    <h4 class=\"ui dividing header\">Création d'un nouveau ticket</h4> \
				  	    <div class=\"fields\"> \
						    <div id=\"subject_field\" class=\"twelve wide required field\"> \
						      <label>Sujet</label> \
						      <input id=\"subject\" placeholder=\"Sujet\" type=\"text\"/> \
						    </div> \
						    <div class=\"field\"> \
						      <label>Catégorie</label> \
      						  <select id=\"category\" class=\"ui search dropdown\"> \
      							<!-- CATEGORIES WILL GO HERE --> \
    						  </select> \
  							</div> \
						  </div> \
						  <div id=\"data_field\" class=\"required field\"> \
    						<label>Description</label> \
    						<textarea id=\"data\"></textarea> \
  						  </div> \
  						  <div class=\"ui support_center small buttons\"> \
							<div class=\"ui button\" onClick=\"DoleticUIModule.clearNewTicketForm();\">Annuler</div> \
							<div class=\"or\" data-text=\"ou\"></div> \
							<div class=\"ui green button\" onClick=\"DoleticUIModule.sendNewTicket();\">Envoyer</div> \
						  </div> \
				      </form> \
					</div> \
				  </div> \
				  <div class=\"row\"> \
				  </div> \
				</div>";
	}
	/**
	 *	Override uploadSuccessHandler
	 */
	this.uploadSuccessHandler = function(id, data) {
		this.super.uploadSuccessHandler(id, data);
	}

// ---- OTHER FUNCTION REQUIRED BY THE MODULE ITSELF

	this.hasInputError = false;

	this.fillCategorySelector = function(data) {
		// if no service error
		if(data.code == 0) {
			// create content var to build html
			var content = "";
			// iterate over values to build options
			for (var i = 0; i < data.data.length; i++) {
				content += "<option value=\""+(i+1)+"\">"+data.data[i]+"</option>\n";
			};
			// insert html content
			$('#category').html(content);
		} else {
			// use default service service error handler
			DoleticServicesInterface.handleServiceError(data);
		}
	}

	this.fillTicketsList = function(data) {
		// if no service error
		if(data.code == 0 && data.data != "[]") {
			// create content var to build html
			var content = "";
			// iterate over values to build options
			for (var i = 0; i < data.data.length; i++) {
				var status, popup_selector;
				var id = "popup_trigger_"+i;
				switch (data.data[i].status_id) {
				  case 1:
				  	status = "red radio";
				  	popup_selector = "#open_popup";
				    break;
				  case 2:
				  	status = "orange spinner";
				  	popup_selector = "#work_popup";
				    break;
				  case 3:
				  	status = "green selected radio";
				  	popup_selector = "#done_popup";
				    break;
				  default:
				  	status = "blue help";
				  	popup_selector = "#undefined_popup";
				    break;
				}
				content += "<div class=\"item\"> \
							  <i id=\""+id+"\" class=\""+status+" big icon link\"></i> \
							  <div class=\"middle aligned content\"> \
							    <a class=\"header\">"+data.data[i].subject+"</a> \
							    <div class=\"description\">"+data.data[i].data+"</div>  \
							  </div> \
							  <script>$('#"+id+"').popup({popup:'"+popup_selector+"'});</script> \
							</div>";
			};
			// insert html content
			$('#ticket_list').html(content);
		} else {
			// use default service service error handler
			DoleticServicesInterface.handleServiceError(data);
		};
	}

	this.clearNewTicketForm = function() {
		$('#subject').val('');
		$('#data').val('');
		/// \todo trouver quelque chose de mieux ici pour le reset du selecteur
		TicketServicesInterface.getAllCategories(DoleticUIModule.fillCategorySelector);
		// clear error
		if(this.hasInputError) {
			// disable has error
			this.hasInputError = false;
			// change input style
			$('#support_form').attr('class', 'ui form segment');
			$('#subject_field').attr('class', 'required field');
			$('#data_field').attr('class', 'required field');
			// remove error elements
			$('#subject_error').remove();
			$('#data_error').remove();
		}
	}

	this.showInputError = function() {
		if(!this.hasInputError) {
			// raise loginError flag
			this.hasInputError = true;
			// show input error elements
			$('#support_form').attr('class', 'ui form segment error');
			$('#subject_field').attr('class', 'field error');
			$('#subject_field').append("<div id=\"subject_error\" class=\"ui basic red pointing prompt label transition visible\">Le sujet ne doit pas être vide</div>");
			$('#data_field').attr('class', 'field error');
			$('#data_field').append("<div id=\"data_error\" class=\"ui basic red pointing prompt label transition visible\">La description ne dois pas être vide</div>");
		}
	}

	this.sendHandler = function(data) {
		// if no service error
		if(data.code == 0) {
			// clear ticket form
			DoleticUIModule.clearNewTicketForm();
			// alert user that creation is a success
			DoleticMasterInterface.showSuccess("Création réussie !", "Le ticket a été créé avec succès !");
			// fill ticket list
			TicketServicesInterface.getUserTickets(DoleticUIModule.fillTicketsList);
		} else {
			// use default service service error handler
			DoleticServicesInterface.handleServiceError(data);
		}
	}

	this.sendNewTicket = function() {
		if($('#subject').val().length > 0 && 
		   $('#data').val().length > 0) {
		   	// retreive missing information
		TicketServicesInterface.insert(
			"-1",
			$('#subject').val(),
			$('#category').val(),
			$('#data').val(),
			DoleticUIModule.sendHandler
			);
		} else {
			DoleticUIModule.showInputError();
		}
	}

}