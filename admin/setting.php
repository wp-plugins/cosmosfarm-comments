<?php if(!defined('ABSPATH')) exit;?>
<div class="wrap">
	<div style="float: left; margin: 7px 8px 0 0; width: 36px; height: 34px; background: url(<?php echo plugins_url('cosmosfarm-comments/images/icon-big.png')?>) left top no-repeat;"></div>
	<h2>
		코스모스팜 소셜댓글
		<a href="http://www.cosmosfarm.com/plugin/comments" class="add-new-h2" onclick="window.open(this.href); return false;">홈페이지</a>
		<a href="http://www.cosmosfarm.com/threads" class="add-new-h2" onclick="window.open(this.href); return false;">커뮤니티</a>
		<a href="http://www.cosmosfarm.com/support" class="add-new-h2" onclick="window.open(this.href); return false;">고객지원</a>
	</h2>
	<p>내 사이트의 회원과 소셜회원 모두 참여가 가능한 커뮤니티를 구축할 수 있습니다. 네이버, 카카오톡, 페이스북, 트위터, 구글 등 다양한 소셜로그인을 지원하며 내 사이트 회원까지 토론에 참여할 수 있어 더 많은 사용자를 확보할 수 있습니다.</p>
	
	<hr>
	
	<form method="post" action="">
		<?php wp_nonce_field('cosmosfarm-comments-save', 'cosmosfarm-comments-save-nonce')?>
		<input type="hidden" name="action" value="cosmosfarm_comments_save">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"></th>
					<td>
						먼저 <a href="http://www.cosmosfarm.com/plugin/comments" onclick="window.open(this.href);return false;">소셜댓글 플러그인</a> 관리사이트에서 이 워드프레스 사이트를 <a href="http://www.cosmosfarm.com/plugin/comments/create" onclick="window.open(this.href);return false;">등록</a>해주세요.
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cosmosfarm_comments_plugin_id">소셜댓글 플러그인 ID</label></th>
					<td>
						<input type="text" name="cosmosfarm_comments_plugin_id" id="cosmosfarm_comments_plugin_id" value="<?php echo get_option('cosmosfarm_comments_plugin_id', '')?>">
						<p class="description"><a href="http://www.cosmosfarm.com/plugin/comments/sites" onclick="window.open(this.href);return false;">등록된 사이트</a> » 설치하기 페이지에 나와있는 ID값을 입력해주세요.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="use_cosmosfarm_comments_plugin">소셜댓글 플러그인 사용</label></th>
					<td>
						<select name="use_cosmosfarm_comments_plugin" id="use_cosmosfarm_comments_plugin">
							<option value="">비활성화</option>
							<option value="1"<?php if(get_option('use_cosmosfarm_comments_plugin')):?> selected<?php endif?>>활성화</option>
						</select>
						<p class="description">워드프레스 댓글을 비활성화 하고 소셜댓글 플러그인을 사용합니다.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cosmosfarm_comments_plugin_row">댓글 표시</label></th>
					<td>
						<select name="cosmosfarm_comments_plugin_row" id="cosmosfarm_comments_plugin_row" class="">
							<option value="10">10개</option>
							<option value="20"<?php if(get_option('cosmosfarm_comments_plugin_row')=='20'):?> selected<?php endif?>>20개</option>
							<option value="30"<?php if(get_option('cosmosfarm_comments_plugin_row')=='30'):?> selected<?php endif?>>30개</option>
							<option value="50"<?php if(get_option('cosmosfarm_comments_plugin_row')=='50'):?> selected<?php endif?>>50개</option>
							<option value="100"<?php if(get_option('cosmosfarm_comments_plugin_row')=='100'):?> selected<?php endif?>>100개</option>
						</select>
						<p class="description">한 페이지에 보여지는 댓글 숫자를 정합니다.</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="use_cosmosfarm_comments_plugin_extern_api">회원 연동 API 사용</label></th>
					<td>
						<select name="use_cosmosfarm_comments_plugin_extern_api" id="use_cosmosfarm_comments_plugin_extern_api">
							<option value="" selected="">비활성화</option>
							<option value="1"<?php if(get_option('use_cosmosfarm_comments_plugin_extern_api')):?> selected<?php endif?>>활성화</option>
						</select>
						<p class="description">이 워드프레스 사이트 회원의 이름으로 댓글을 남길 수 있습니다. (프리미엄 서비스 가입이 필요합니다. <a href="http://www.cosmosfarm.com/plugin/comments" onclick="window.open(this.href);return false;">사이트로 이동</a>)</p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button-primary" value="변경 사항 저장">
		</p>
	</form>
	
	<hr>
	
	<h3>회원 연동 API 정보</h3>
	<form method="post" action="">
		<?php wp_nonce_field('cosmosfarm-comments-request-token-reset', 'cosmosfarm-comments-request-token-reset-nonce')?>
		<input type="hidden" name="action" value="cosmosfarm_comments_request_token_reset">
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">회원정보 요청 주소</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo site_url("?cosmosfarm_comments_request_token={$request_token}")?>" readonly>
						<input type="submit" class="button" value="요청 주소 재설정">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">로그인 버튼 아이콘 이미지 주소</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo COSMOSFARM_COMMENTS_URL . '/images/wordpress-logo.png'?>" readonly>
						<img src="<?php echo COSMOSFARM_COMMENTS_URL . '/images/wordpress-logo.png'?>" alt="" style="vertical-align: middle;">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">로그인 페이지 주소</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo wp_login_url()?>" readonly>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">프로필 페이지 주소</th>
					<td>
						<input type="text" class="regular-text" value="<?php echo admin_url('profile.php')?>" readonly>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<div class="clear"></div>