/**
 * @author http://www.cosmosfarm.com/
 */
jQuery(document).ready(function($){
	if(cosmosfarm_comments_plugin_id){
		cosmosfarm_comments.init({plugin_id:cosmosfarm_comments_plugin_id});
		$('.cosmosfarm-comments-plugin-count').each(function(){
			var count = $(this);
			var url = count.attr('data-url');
			if(url){
				cosmosfarm_comments.count(url, function(res){
					if(res.count){
						count.text(res.count);
					}
				});
			}
		});
		$('#cosmosfarm-latest-comments').each(function(){
			cosmosfarm_comments.latest({
				limit:5
			}, function(res){
				if(res){
					if(res.data.length > 0){
						$(res.data).each(function(index, row){
							var a = $('<a></a>').attr('href', row.url).text(row.content);
							var li = $('<li></li>').addClass('latest-comments').append(a);
							$('#cosmosfarm-latest-comments').append(li);
						});
					}
				}
			});
		});
	}
});