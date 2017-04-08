var ajaxCall = null;

var Admin = function() {

	return {
		init : function() {
			$('.changeRoleBlock').hide();
			$('#Loading').hide();
		},

		contextualMenu : function(link) {
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

			$('#tree-setup').on('changed.jstree',
					function(e, data) {
						$.ajax({
							url : link + '/index/'
									+ data.instance.get_node(data.selected).id,
							type : 'POST',
							success : function(data) {
								$('#tree-list').html(data);
							}
						});
					});
		},

		SearchUser : function() {
			$('#SearchText').keyup(function() {
				$('#Loading').show();
				if (ajaxCall) {
					ajaxCall.abort();
				}
				ajaxCall = $.ajax({
					beforeSend : function() {
					},
					type : 'POST',
					url : $('#SearchText').attr('data-link'),
					data : {
						data : {
							search : $('input[id="SearchText"]').val()
						}
					},
					success : function(data) {
						$('.user-list').html(data)
					},
					error : function() {
						$('#Loading').hide();
						ajaxCall.abort();
					},
					complete : function() {
						$('#Loading').hide();
					}
				});
			});
		},

		handleMultiSelect : function() {
			$('.multi-select')
					.multiSelect(
							{
								selectableHeader : "<input type='text' class='search-input' autocomplete='off' placeholder='try \"12\"'>",
								selectionHeader : "<input type='text' class='search-input' autocomplete='off' placeholder='try \"4\"'>",
								afterInit : function(ms) {
									var that = this, $selectableSearch = that.$selectableUl
											.prev(), $selectionSearch = that.$selectionUl
											.prev(), selectableSearchString = '#'
											+ that.$container.attr('id')
											+ ' .ms-elem-selectable:not(.ms-selected)', selectionSearchString = '#'
											+ that.$container.attr('id')
											+ ' .ms-elem-selection.ms-selected';

									that.qs1 = $selectableSearch.quicksearch(
											selectableSearchString).on(
											'keydown', function(e) {
												if (e.which === 40) {
													that.$selectableUl.focus();
													return false;
												}
											});

									that.qs2 = $selectionSearch.quicksearch(
											selectionSearchString).on(
											'keydown', function(e) {
												if (e.which == 40) {
													that.$selectionUl.focus();
													return false;
												}
											});
								},
								afterSelect : function() {
									this.qs1.cache();
									this.qs2.cache();
								},
								afterDeselect : function() {
									this.qs1.cache();
									this.qs2.cache();
								}
							});

			$('#my_multi_select2').multiSelect({
				selectableOptgroup : true
			});
		},

		SaveGroupUserRole : function() {
			$('select#role_id').on('change', function() {
    			var DOM_Element = $(this);
    			var data 		= $(this).serializeArray();
    			
    			console.log(DOM_Element);
    			console.log(data);

    			if(DOM_Element.attr('data-save') !== undefined) {
    				$.ajax({
    					type		: 'POST',
    					data		: data,
    					url			: $(this).attr('data-save'),
    					success		: function(data) {
    	        			var object = $.parseJSON(data);
    	        			if(object.success) {
    	        			}
    					}
    				});
    			}
			});
		},
	};
}();