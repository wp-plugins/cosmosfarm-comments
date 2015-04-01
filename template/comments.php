<?php if(!defined('ABSPATH')) exit;?>
<?php
global $post;
$core = new Cosmosfarm_Comments_Core();
?>
<div id="comments" class="comments-area">
	<!-- 코스모스팜 댓글 플러그인 시작 -->
	<div id="cosmosfarm-comments" data-plugin-id="<?php echo get_option('cosmosfarm_comments_plugin_id', '')?>" data-href="<?php echo get_permalink($post->ID)?>" data-width="100%" data-row="<?php echo get_option('cosmosfarm_comments_plugin_row', '10')?>" data-access-token="<?php echo $core->get_access_token()?>"><a href="http://www.cosmosfarm.com/plugin/comments">코스모스팜 댓글 플러그인</a></div>
	<!-- 코스모스팜 댓글 플러그인 종료 -->
</div>