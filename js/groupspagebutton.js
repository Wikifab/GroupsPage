(function() {
	
	function groupAdded(grouppage, page) {

		// jquery selector doesn't manage all special char such as quote (")
		// so we have to use a filter function :
		$(".addToGroupLink").filter(
				function(i) {
					return ($(this).attr("data-grouppage") == grouppage 
							&& $(this).attr("data-page") == page);
				})
				.addClass('groupAdded').removeClass('groupRemoved')
				.find('i').removeClass('fa-square-o').addClass('fa-check-square-o');

	}
	function groupRemoved(grouppage, page) {
		$(".addToGroupLink").filter(
				function(i) {
					return ($(this).attr("data-grouppage") == grouppage 
							&& $(this).attr("data-page") == page);
				})
				.removeClass('groupAdded').addClass('groupRemoved')
				.find('i').addClass('fa-square-o').removeClass('fa-check-square-o');
	}


	function addToGroup(grouppage, page) {
		
		// fonction to do second request to execute follow action
		function ajaxGroupsPageQuery(jsondata) {
			var token = jsondata.query.tokens.csrftoken;
			$.ajax({
				type: "POST",
				url: mw.util.wikiScript('api'),
				data: { 
					action:'goupspage', 
					format:'json', 
					groupaction: 'add', token: token, 
					memberpage: page, 
					groupspage: grouppage
				},
			    dataType: 'json',
			    success: function (jsondata) {
					if(jsondata.goupspage.success == 1) {
						groupAdded(grouppage, page);
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
	}
	
	function removeFromGroup(grouppage, page) {
		// fonction to do second request to execute follow action
		function ajaxGroupsPageQuery(jsondata) {
			var token = jsondata.query.tokens.csrftoken;
			$.ajax({
				type: "POST",
				url: mw.util.wikiScript('api'),
				data: { action:'goupspage', format:'json', groupaction: 'remove', token: token, memberpage: page, groupspage: grouppage},
			    dataType: 'json',
			    success: function (jsondata) {
					if(jsondata.goupspage.success == 1) {
						groupRemoved(grouppage, page);
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
	}

	$('.addToGroupLink').click(function() {
		var grouppage = $(this).attr('data-grouppage');
		var page = $(this).attr('data-page');

		if ($(this).hasClass('groupAdded')) {
			removeFromGroup(grouppage, page);
		} else {
			addToGroup(grouppage, page);
		}	
	});
})();
