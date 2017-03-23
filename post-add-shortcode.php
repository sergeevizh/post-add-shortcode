<?php
/**
 * Plugin Name: Post Add Shortcode
 */

/**
 * Output form on page "submit-post"
 */
add_shortcode( 'post-add', function( $content ) {

	//only show to logged in users who can edit posts
	if ( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
		ob_start();?>
		<form id="pas-form">
			<div class="row">
				<label for="pas-post-title">Заголовок</label>
				<input type="text" name="post-title" id="pas-post-title" required aria-required="true">
			</div>
			<div class="row">
				<label for="pas-post-content">Описание</label>
				<textarea rows="10" cols="20" name="post-content" id="pas-post-content"></textarea>
			</div>
			<div class="row">
				<input type="submit" value="Сохранить">
			</div>
		</form>
		<div id="pas-form-result"></div>
		<?php
		$content .= ob_get_clean();
	}else{
		$content .=  sprintf( '<a href="%1s">%2s</a>', esc_url( wp_login_url() ), "Войти в систему" );
	}

	return $content;

});


/**
 * Setup JavaScript
 */
add_action( 'wp_enqueue_scripts', function() {

	//load script
	wp_enqueue_script( 'pas', plugins_url( 'post-submitter.js', __FILE__ ), array( 'jquery' ) );

	//customize data for script
	wp_localize_script( 'pas', 'WP_PAS', array(
			'url' => esc_url_raw( rest_url('/wp/v2/posts') ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'status_default' => 'publish',
			'success' => "Данные сохранены",
			'failure' => "Ошибка сохранения данных",
			'current_user_id' => get_current_user_id()
		)
	);

});
