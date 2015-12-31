/**
 * @author kishor
 * use this file to house the library methods called frequently. as it should be the first custom written js to load apart
 * from template specific js files..
 */

/**
 * __HOST_NAME__ is used by other methods to get the path to call methods
 * it should automatically add /khumbaya for localhost and not add anything on khumbaya.com
 */

//var __HOST_NAME__ = 'http://' + window.location.hostname + HOST_NAME_LOCATION;
var __HOST_NAME__ = 'http://' + window.location.host;
//For the prefix in control panel and anywhere else in controller
var conPrefix = '';

/**
 * function to check if the value is in array...
 * 
 * @return true if found in array
 * 		   false if not found in array
 * 
 * @usage 
 * 	var arrayExample = new Array();
 * 
 * 		arrayExample = [2, 3, 4 ,5]
 * 
 * inArrayOrNot = (arrayExample.in_array(2)) ? 'true' : 'false';
 * alert(inArrayOrNot);
 */
	Array.prototype.in_array = function(checkVal) {
		length = this.length;
		for(i=0; i < length; i++ ) {
			if(this[i] == checkVal) {
				return true;
			}
		}
		return false;
	};
/**
 * ajaxDisplay utilizes jQuery's .load to load a web content to the div provided in divToLoad. the url to load is 
 * provided in hrefToLoad
 * 
 * @param divToLoad id of the div where hrefToLoad is to be loaded
 * @param hrefToLoad link of the page which has to be loaded
 * @return null
 */
	
	function ajaxDisplay(divToLoad, hrefToLoad){
		$(divToLoad).fadeOut('fast').load(hrefToLoad).fadeIn('fast');
	}
