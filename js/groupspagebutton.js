(function() {
	

	function groupAdded( grouppage, page) {
		$(".addToGroupsPage[data-grouppage='"+grouppage+"'][data-page='"+page+"']").hide();
		$(".removeFromGroupsPage[data-grouppage='"+grouppage+"'][data-page='"+page+"']").show();
	};
	function groupRemoved(grouppage, page) {
		$(".addToGroupsPage[data-grouppage='"+grouppage+"'][data-page='"+page+"']").show();
		$(".removeFromGroupsPage[data-grouppage='"+grouppage+"'][data-page='"+page+"']").hide();
	};



	$('.addToGroupsPage').click(function() {
		
		var grouppage = $(this).attr('data-grouppage');
		var page = $(this).attr('data-page');
		var button = this;
		
		// fonction to do second request to execute follow action
		function ajaxGroupsPageQuery(jsondata) {
			var token = jsondata.query.tokens.csrftoken;
			$.ajax({
				type: "POST",
				url: mw.util.wikiScript('api'),
				data: { action:'goupspage', format:'json', groupaction: 'add', token: token, page: page, groupspage: grouppage},
			    dataType: 'json',
			    success: function (jsondata) {
					if(jsondata.goupspage.success == 1) {
						groupAdded(userToFollow);
					}
			}});
		};
		
		// first request to get token
		$.ajax({
			type: "GET",
			url: mw.util.wikiScript('api'),
			data: { action:'query', format:'json',  meta: 'tokens', type:'csrf'},
		    dataType: 'json',
		    success: ajaxGroupsPageQuery
		});
	});


	$('.removeFromGroupsPage').click(function() {

		var grouppage = $(this).attr('data-grouppage');
		var page = $(this).attr('data-page');
		var button = this;
		
		// fonction to do second request to execute follow action
		function ajaxGroupsPageQuery(jsondata) {
			var token = jsondata.query.tokens.csrftoken;
			$.ajax({
				type: "POST",
				url: mw.util.wikiScript('api'),
				data: { action:'goupspage', format:'json', groupaction: 'remove', token: token, page: page, groupspage: grouppage},
			    dataType: 'json',
			    success: function (jsondata) {
					if(jsondata.goupspage.success == 1) {
						groupRemoved(userToFollow);
					}
			}});
		};
		
		// first request to get token
		$.ajax({
			type: "GET",
			url: mw.util.wikiScript('api'),
			data: { action:'query', format:'json',  meta: 'tokens', type:'csrf'},
		    dataType: 'json',
		    success: ajaxGroupsPageQuery
		});
	});
})();
