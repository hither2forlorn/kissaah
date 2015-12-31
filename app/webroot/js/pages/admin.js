var ajaxCall= null;

var Admin = function () {

	return {
        init: function () {
        	$('.changeRoleBlock').hide();
        	$('#Loading').hide();
        },
        
		contextualMenu: function(link) {
			$('#tree-setup').jstree({
				'core' : {
						'themes' : {
								'responsive' : true
						},
						'check_callback' : true,
								'data' : {
										'url' : function(node) {
											return link + '/locTree.json';
										},
										'data' : function(node) {
											return {
												'parent' : node.id
											};
										}
									}
								},
								'types' : {
									'default' : {
										'icon' : 'fa fa-folder icon-state-warning icon-lg'
									},
									'file' : {
										'icon' : 'fa fa-file icon-state-warning icon-lg'
									}
								},
								'plugins' : [ 'changed', 'state' ]

							});
			
			$('#tree-setup').on('changed.jstree', function (e, data) {
				$.ajax({                    
			        url		: link + '/index/' + data.instance.get_node(data.selected).id,
			        type	: 'POST',
			        success	: function(data) {
			        	$('#tree-list').html(data);
			        }
			    });
			});
		},

        SearchUser: function() {
        	$('#SearchText').keyup(function() {
        		$('#Loading').show();
        		if(ajaxCall){
        			ajaxCall.abort();
        		}
        		ajaxCall = $.ajax({
        			beforeSend 	: function() {},
        			type 		: 'POST',
        			url 		: $('#SearchText').attr('data-link'),
        			data 		: { data: { search: $('input[id="SearchText"]').val()} },
        			success 	: function(data) {
        				$('.user-list').html(data)
        			},
        			error 		: function() {
        				$('#Loading' ).hide();
            			ajaxCall.abort();
        			},
        			complete 	: function() {
        				$('#Loading' ).hide();
        			}
        		});
        	});
        }
    };
}();