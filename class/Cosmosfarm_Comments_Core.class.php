<?php
/**
 * 코스모스팜 소셜댓글
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2015 Cosmosfarm. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html
 */
final class Cosmosfarm_Comments_Core {
	
	public function add_admin_menu(){
		$position = 1234.56789;
		add_menu_page('코스모스팜 소셜댓글', '소셜댓글', 'administrator', 'cosmosfarm_comments_setting', array($this, 'setting'), COSMOSFARM_COMMENTS_URL . '/images/icon.png', $position);
		add_submenu_page('cosmosfarm_comments_setting', '소셜댓글', '소셜댓글', 'administrator', 'cosmosfarm_comments_setting');
	}
	
	public function setting(){
		$action = isset($_POST['action'])?$_POST['action']:'';
		if($action == 'cosmosfarm_comments_save'){
			$this->save();
		}
		else if($action == 'cosmosfarm_comments_request_token_reset'){
			$this->reset_request_token();
		}
		$request_token = $this->get_request_token();
		include COSMOSFARM_COMMENTS_DIR_PATH . '/admin/setting.php';
	}
	
	private function save(){
		if(isset($_POST['cosmosfarm-comments-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-comments-save-nonce'], 'cosmosfarm-comments-save')){
			$option_name = 'cosmosfarm_comments_plugin_id';
			$new_value = $_POST[$option_name];
			if(get_option($option_name) !== false) update_option($option_name, $new_value);
			else add_option($option_name, $new_value, '', 'yes');
			
			$option_name = 'use_cosmosfarm_comments_plugin';
			$new_value = $_POST[$option_name];
			if(get_option($option_name) !== false) update_option($option_name, $new_value);
			else add_option($option_name, $new_value, '', 'yes');
			
			$option_name = 'cosmosfarm_comments_plugin_row';
			$new_value = $_POST[$option_name];
			if(get_option($option_name) !== false) update_option($option_name, $new_value);
			else add_option($option_name, $new_value, '', 'yes');
			
			$option_name = 'use_cosmosfarm_comments_plugin_extern_api';
			$new_value = $_POST[$option_name];
			if(get_option($option_name) !== false) update_option($option_name, $new_value);
			else add_option($option_name, $new_value, '', 'yes');
		}
	}
	
	public function get_request_token(){
		$request_token = get_option('cosmosfarm_comments_request_token');
		if(!$request_token !== false){
			$request_token = md5(uniqid(rand(10000000, 99999999)));
			add_option('cosmosfarm_comments_request_token', $request_token, '', 'no');
		}
		return $request_token;
	}
	
	public function reset_request_token(){
		if(isset($_POST['cosmosfarm-comments-request-token-reset-nonce']) && wp_verify_nonce($_POST['cosmosfarm-comments-request-token-reset-nonce'], 'cosmosfarm-comments-request-token-reset')){
			$request_token = md5(uniqid(rand(10000000, 99999999)));
			update_option('cosmosfarm_comments_request_token', $request_token);
		}
	}
	
	public function get_access_token(){
		global $wpdb;
		$user_id = get_current_user_id();
		if($user_id && get_option('use_cosmosfarm_comments_plugin_extern_api', '')){
			$expiry = date('YmdHis', current_time('timestamp'));
			$wpdb->query("DELETE FROM `{$wpdb->prefix}cosmosfarm_comments_token` WHERE `expiry`<='$expiry'");
			
			$access_token = hash('sha256', md5(uniqid(rand(10000000, 99999999))));
			$expiry = date('YmdHis', current_time('timestamp')+(60*60));
			$wpdb->query("INSERT INTO `{$wpdb->prefix}cosmosfarm_comments_token` (`user_id`, `access_token`, `expiry`) VALUE ('$user_id', '$access_token', '$expiry')");
		}
		else{
			$access_token = '';
		}
		return $access_token;
	}
	
	private function get_profile($access_token){
		global $wpdb;
		$access_token = addslashes($access_token);
		if(!$access_token) return '';
		$expiry = date('YmdHis', current_time('timestamp'));
		$user_id = $wpdb->get_var("SELECT `user_id` FROM `{$wpdb->prefix}cosmosfarm_comments_token` WHERE `access_token`='$access_token' AND `expiry`>'$expiry'");
		if($user_id){
			return get_userdata($user_id);
		}
		else{
			return '';
		}
	}
	
	public function print_profile(){
		global $wpdb;
		if(get_option('cosmosfarm_comments_plugin_id') && get_option('use_cosmosfarm_comments_plugin_extern_api')){
			$access_token = isset($_GET['access_token'])?$_GET['access_token']:'';
			$profile = $this->get_profile($access_token);
			if($profile){
				$avatar = get_avatar($profile->ID, 48);
				preg_match("/src=[\"' ]?([^\"' >]+)[\"' ]?[^>]*>/i", $avatar, $matches);
				$picture = $matches[1];
				$url = parse_url(site_url());
				echo json_encode(array('channel'=>$url['host'], 'channel_id'=>$profile->ID, 'picture'=>$picture, 'email'=>$profile->user_email, 'username'=>$profile->display_name));
			}
		}
		exit;
	}
	
	public function template(){
		return COSMOSFARM_COMMENTS_DIR_PATH . '/template/comments.php';
	}
	
	public function number(){
		global $post;
		$permalink = get_permalink($post->ID);
		return '<span class="cosmosfarm-comments-plugin-count" data-url="'.$permalink.'">0</span>';
	}
	
	public function print_plugin_id(){
		echo "<script>var cosmosfarm_comments_plugin_id='".get_option('cosmosfarm_comments_plugin_id', '')."';</script>\n";
	}
}
?>