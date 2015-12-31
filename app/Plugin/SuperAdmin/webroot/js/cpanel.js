$(document).ready(function(){
//Control panel Related Functions...
	/*
	 * store complete action path
	 * userRole-Controller-Method-radioName
	 */
	var userRole = user = appPlugin = controller = '';
	var userText, controllerText;
	var actionPath, controllerId;  
	
	$('select#ControlPanelRoles').live("change", function() {
		DOM_element = $(this);
		parentId = DOM_element.val();
		userRole = $('select#ControlPanelRoles :selected').val();
		user = '';
		$('select#ControlPanelUsers').attr("disabled", true);
		$('select#ControlPanelPlugins').attr("disabled", true);
		$('select#ControlPanelControllers').attr("disabled", true);
		//DOM_element.attr("disabled",false);
		$("#content-cpanel-methods").empty().html('<img class="loading" src="'+__HOST_NAME__+'/super_admin/img/loading.gif" />');

		$('#content-cpanel-users').load(__HOST_NAME__ + "/super_admin/ControlPanels/getUserLists",{
			role: parentId
		}, function(result){
			/*$('#content-cpanel-methods').load(__HOST_NAME__ + "/super_admin/ControlPanels/getControllerPermissions",{
				name: userRole
			}, function(result){
				$('select#ControlPanelUsers').attr("disabled", false);
				return;
			});*/
			$('#content-cpanel-methods').load(__HOST_NAME__ + "/super_admin/ControlPanels/getPermissions",{
				role: userRole,
				user: user,
				plugin: appPlugin,
				controller: controller
			}, function(result){
				$('select#ControlPanelUsers').attr("disabled", false);
				$('select#ControlPanelPlugins').attr("disabled", false);
				$('select#ControlPanelControllers').attr("disabled", false);
				return;
			});
			return;
		});
	});
	
	$('select#ControlPanelPlugins').live("change", function() {
		DOM_element = $(this);
		parentId = DOM_element.val();
		appPlugin = $('select#ControlPanelPlugins :selected').val();
		controller = '';
		$('select#ControlPanelControllers').attr("disabled", true);
		$('select#ControlPanelRoles').attr("disabled", true);
		$('select#ControlPanelUsers').attr("disabled", true);
		//DOM_element.attr("disabled",false);
		$("#content-cpanel-methods").empty().html('<img class="loading" src="'+__HOST_NAME__+'/super_admin/img/loading.gif" />');

		$('#content-cpanel-controllers').load(__HOST_NAME__ + "/super_admin/ControlPanels/getControllerLists",{
			plugin: parentId
		}, function(result){
			/*$('#content-cpanel-methods').load(__HOST_NAME__ + "/super_admin/ControlPanels/getControllerPermissions",{
				name : userRole
			}, function(result){
				$('select#ControlPanelControllers').attr("disabled", false);
				return;
			});*/
			$('#content-cpanel-methods').load(__HOST_NAME__ + "/super_admin/ControlPanels/getPermissions",{
				role: userRole,
				user: user,
				plugin: appPlugin,
				controller: controller
			}, function(result){
				$('select#ControlPanelControllers').attr("disabled", false);
				$('select#ControlPanelRoles').attr("disabled", false);
				$('select#ControlPanelUsers').attr("disabled", false);
				return;
			});
			return;
		});
	});
	
	$('select#ControlPanelUsers').live("change", function() {
		DOM_element = $(this);
		user = $('select#ControlPanelUsers :selected').val();
		userText = $('select#ControlPanelUsers :selected').text();
		
		$('select#ControlPanelRoles').attr("disabled", true);
		$('select#ControlPanelPlugins').attr("disabled", true);
		$('select#ControlPanelControllers').attr("disabled", true);
		$("#content-cpanel-methods").empty().html('<img class="loading" src="'+__HOST_NAME__+'/super_admin/img/loading.gif" />');

		$('#content-cpanel-methods').load(__HOST_NAME__ + "/super_admin/ControlPanels/getPermissions",{
			role: userRole,
			user: user,
			plugin: appPlugin,
			controller: controller
		}, function(result){
			$('select#ControlPanelRoles').attr("disabled", false);
			$('select#ControlPanelPlugins').attr("disabled", false);
			$('select#ControlPanelControllers').attr("disabled", false);
			return;
		});
	});
	
	$('select#ControlPanelControllers').live("change", function() {
		DOM_element = $(this);
		controller = $('select#ControlPanelControllers :selected').val();
		controllerText = $('select#ControlPanelControllers :selected').text(); 
		
		$('select#ControlPanelPlugins').attr("disabled", true);
		$('select#ControlPanelRoles').attr("disabled", true);
		$('select#ControlPanelUsers').attr("disabled", true);
		$("#content-cpanel-methods").empty().html('<img class="loading" src="'+__HOST_NAME__+'/super_admin/img/loading.gif" />');

		$('#content-cpanel-methods').load(__HOST_NAME__ + "/super_admin/ControlPanels/getPermissions",{
			role: userRole,
			user: user,
			plugin: appPlugin,
			controller: controller
		}, function(result){
			$('select#ControlPanelPlugins').attr("disabled", false);
			$('select#ControlPanelRoles').attr("disabled", false);
			$('select#ControlPanelUsers').attr("disabled", false);
			return;
		});
	});
	
	$(':radio,img[class=acoImage]').live("click", function() {
		var acoAction = false;
		var flag_confirm = false;
		DOM_element = $(this);
		if(DOM_element.is('img')) {
			acoAction = DOM_element.attr('aco-action');
		} else if(DOM_element.is('input:radio')) {
			acoAction = DOM_element.val();
		}
		if(acoAction) {
			flag_confirm = true;
		}
		if(acoAction == 'delete') flag_confirm = confirm("Do u really want to delete the aco??");
		if(flag_confirm) {
			$.post(__HOST_NAME__ + "/super_admin/ControlPanels/security", {
				role: userRole,
				user: user,
				plugin: appPlugin,
				controller: controller,
				acoModel: DOM_element.attr('aco-model'),
				acoAlias: DOM_element.attr('aco-alias'),
				acoAction: acoAction
			}, function(result){
				jsonData = $.parseJSON(result);
				if(jsonData.status) {
					DOM_parent = DOM_element.parents('tr');
					if(DOM_parent.find('img.perImage').length) {
						DOM_parent.find('img.perImage').attr({
							'src' : __HOST_NAME__+'/super_admin/img/cpanel/'+jsonData.permImage,
							'alt' : jsonData.permAlt
						});
						DOM_parent.find('img.acoImage').attr({
							'src' : __HOST_NAME__+'/super_admin/img/cpanel/'+jsonData.acoImage,
							'alt' : jsonData.acoAlt
						});
						if(jsonData.permValue.length) {
							DOM_parent.find('input.allow-deny-radio[value='+jsonData.permValue+']').attr('checked', true);
						} else {
							DOM_parent.find('input.allow-deny-radio').attr('checked', false);
						}
					} else {
						DOM_parent.remove();
					}
				}
			});
		}
		return false;
	});
	
});