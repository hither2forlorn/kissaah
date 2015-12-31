/**
 * @author Himalayantechies
 * 
 * please document this file with the method description, dependencies and behaviours... also include '@author' as it may help
 * close down the problems when encountered...
 */

$(function() {
/**
 * @author kishor kundan
 * if div#adminPanel doesnot exist exit frm this js.
 */
	if(!$('div#adminPanel').length) {
		return;
	}

/**
 * the rel's defined here will not be bound by this js
 * for eg the deleteAll and selectAll features are described in the index generator... 
 * but if they are not defined in the 
 * array object skipAnchors... the $(a).live('click', function() {....}); will bind them over-riding their behaviour.. 
 * or will interfare with there would-be-behaviour.
 * 
 */

var skipAnchors = [
                     	'selectAll',
                     	'deleteAll',
                     	'allowDefault',
                     	'BusinessAttribute'
                     ];

	ajaxDisplay('#adminPanel', __HOST_NAME__ + '/admin/businesses');
	
	
	$('a[rel*=help_actions]').live('click', function(clickEv) {
		clickEv.preventDefault();
		item = $(this);
			popupHelper = '<div id="actionContainer" class="help_popup">Loading contents</div>';
			
		hrefClicked = $(item).attr('href');
		$('div#actionContainer').load(hrefClicked);
	});
	
	/**
	 * @author kishor kundan
	 * 
	 * the following commented blocks of code were written to make something like that of google suggest for the streets. everytime a user would 
	 * type a keyword in streets text box triggering a method which would retrive list of streets from the streets controller...
	 * it was written somewhere in jan/feb not much is documented, however i did not delete this as to leave a reference for a case how to
	 * get a JSON o/p frm cake and then use it to create a selectbox... 
	 * 
	 * initially i had lots of work to be done when i attempted this for the frst time... :D :)
	 * 
	 * it is also important to use json_encode in php to pass proper json params.
	 */
	
	/*$('input#BusinessStreetsId').bind('keyup', function() {
		value = $('input#BusinessStreetsId').val();
		path = hostname + 'streets';
			$.getJSON(path, {data: value}, function(streets) {
			newSelect = '<select multiple = "multiple" size = "5" id = "streets>Streets</select>"';
			if(!($('select#streets').length )) {
				$(newSelect).insertAfter('input#BusinessStreetsId');
			}
			options = '';
			$.each(streets, function(id, name) {
					options += "<option value = '" + id +"'>"+ name + "</option>";
				});
				
				if($('select#streets').length ) {
					$('select#streets').html(options);
				}
				
				$('select#streets').bind('click', function() {
					valueFromSelect = $('select#streets :selected').text();
					$('input#BusinessStreetsId').val(valueFromSelect);
					$('select#streets').remove();		
				});
			});
	});*/
	
/**
 * @author kishor
 * the idea of this universal anchor binding is to open every thing in the same document...
 * mind you, if the div#adminPanel is not present in the document, this js will terminate execution
 * such behaviour should not be over-ridden, because it may create an infinite-loop never allowing any 
 * link to be opened in another document
 * 
 * whenever an anchor is clicked, it is first confirmed to see if they are to be skipped by checking in the array 
 * skipAnchors, if found it will not take further action and return immediately. if it is not found in skipAnchors
 * the default behaviour is prevented.
 * 
 * 
 * !!!!!!!!!default behaviour!!!!!!!!!!!
 * 
 * if the anchor qualifies for the methd.. the default behaviour is to open the link and display it in 
 * the div->adminPanel... 
 * the exceptional cases at the time of the conception of this method was only one being that for the delete,
 * which had to be handled separately...
 * 
 * if more exceptional cases start occuring, it will be in the best interest to devise new mechanism rather than
 * branching on every click...
 * 
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!important!!!!!!!!!!!!!!!!!!!!!!!!!!!1
 * 
 * before branching acertain yourself that the present methods do not fulfill your need...
 * 
 * ******************************************************************************************************************************************
 * modification on fri may 27 - 28																											*
 * 																																			*
 * now every time an anchor is clicked.. the current active menu link is read to determine the the current controller						*
 * 																																			*
 * ******************************************************************************************************************************************
 * 
 */
	/*$('a').live('click', function(clicked) {
		item = $(this);
		currentController = $('li.active-link a').text();
		relClick = $(item).attr('rel');
		hrefClicked = $(item).attr('href');
			if(skipAnchors.in_array(relClick)) {
				return;
			} 
			
			// modification for enable child ajax and to prevent opening of other links in same page 
				if(hrefClicked.indexOf(currentController.toLowerCase()) < 0) {
					return true;
				}
			// end of modification
			
			clicked.preventDefault();
				if (relClick == 'delete') {
					deleteEntry(hrefClicked);
					return;
				}
		ajaxDisplay('#adminPanel', hrefClicked);
	}); */
	
/**
 * @author kishor kundan
 * 
 * 
 * every time a submit button is clicked it is first checked to see if the form contains any file upload fields.
 * the form generator assigns the relation of rel = 'file' for ever submit button containing the file fields..
 * the form for file types and submit types can be defined in appConfigurations.php
 * 
 * if the rel is not 'file', then the form (parent of current submit btn) is read, the current form object is then
 * used to iterate throught each input and select boxes with non-empty value and containing the word  data as their
 * name. all the data read from such inputs are then used to construct a string of format
 * 	fieldname1/value1/fieldname2/value2/...../fieldnameN/valueN
 * the string is then appended to the link of the ajaxescontroller... the data is retireved from the url...
 * 
 * at the time of conception, author wanted to avoid the overhead of json or xml to post and retrieve the data
 * the ajaxes controller after performing the request form action echoes the name of the controller whose method 
 * was just serviced, for eg 'businesses', the callback of post method reads this value to load the index of that
 * controller to reflect the changes just made
 * 
 * a typical scenario... a event add form is populated with the values, clicked on submit... every non-empty values 
 * belonging to data of that model is read to post to the ajaxescontroller. after the service has been dealt, the events
 * controller will echo 'events' which will be utilised by the callback function to load the index of events...
 * 
 *  also at the time of conception of this method no instance wore encountered where this mechanism would fail apart
 *  from that of the deletes... so a check was added in the app_controller to see if current method being 
 *  serviced is delete ? if so, it will echo the current controller...
 *  
 */
	$('input[type=submit]').live('click', function(btn_click) { 
		if($(this).attr('rel') == 'file' || $(this).attr('rel') == 'search') {
			return;
		}
		submitButton_is = $(this);
		btn_click.preventDefault();
		DataAndValue = '';
			form_pointer = $(submitButton_is).parents('form');
			var arry = new Array();
				$(form_pointer)
				.find('div > input, div > select')
				.each(function() {
					item = $(this);
					nameIs = $(item).attr('name');
					valueIs = $(item).val();
					if((nameIs.indexOf('data') > -1) && (valueIs.length > 0)) {
						DataAndValue = DataAndValue + '/' + nameIs + '/' + valueIs;
					}
				});
			$.post(__HOST_NAME__ + '/admin/ajaxsubmits/retriveFormData/' + DataAndValue, {data: $(form_pointer).attr('action')}, function(controllerName) {
				if(controllerName == 'Failed') {
					alert('The data could not be saved');
				} else {
					locationToLoad = __HOST_NAME__ + '/admin/' + controllerName;
					ajaxDisplay('#adminPanel', locationToLoad);
				}
			});
	});
	
	/**
	 * @author kishor kundan
	 * the working mechanism of deleteEntry is more or less similar to that of submit with few exceptions
	 * as the methods are completely different for the once dealing with form and the delete
	 * 
	 * this method first confirms from the user if he really wants to delete the record, if yes proceeds with deletion
	 * else returns from this current method.
	 */
	
	function deleteEntry(hrefIs) {
		msg = 'You are about to perform deletion of the record selected. The following action will delete the selected record and all its childs, this can not be undone';
			if (!(confirm(msg))) {
				return;
			}
		
		$.post(hrefIs, 
				function(callBackController) {
					if(callBackController != 'Failed') {
						locationToLoad = __HOST_NAME__ + '/admin/' + callBackController;
						ajaxDisplay('#adminPanel', locationToLoad);
					}
					return;
				});
		return;
	}
});
