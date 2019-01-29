<?php
if( !function_exists('ya_comment') ){
	function ya_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
			<div class="author">
				<a class="pull-left" href="<?php echo get_comment_author_link(get_comment_ID())?>"><?php echo get_avatar($comment, $size = '64'); ?></a>
			</div>
			<div class="media-heading">
					<div class="author-name">
						<a href="#"><?php echo comment_author_link(get_comment_ID())?></a>
					</div>
					<div class="time">
						<?php edit_comment_link(__('(Edit)', 'shoppystore'), '', ''); ?>
						<i class="fa fa-clock-o"></i><time datetime="<?php echo comment_date('c'); ?>"><?php printf(__('%1$s', 'shoppystore'), get_comment_date(),  get_comment_time()); ?></time>
					</div>
			</div>
			<div class="media-body">
				<div class="media">
					<?php if ($comment->comment_approved == '0') : ?>
						<div class="awaiting row-fluid">
						  <i><?php esc_html_e('Your comment is awaiting moderation.', 'shoppystore'); ?></i>
						</div>
					<?php endif; ?>
					<div class="media-content row-fluid">
					<?php comment_text(); ?>
					<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
					</div>
				</div>      		      	
		  </div>
	 </div>
	<?php
	}
}
// end function
?>

<?php if (post_password_required()) : ?>
	<div id="comments">
		<div class="alert alert-block fade in">
			<a class="close" data-dismiss="alert">&times;</a>
			<p><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'shoppystore'); ?></p>
		</div>
	</div><!-- /#comments -->
<?php endif; ?>

<?php if (have_comments()) : ?>
	<div id="comments">
	    <div class="comment-title">
		    <h3><?php esc_html_e('Comments', 'shoppystore'); ?><small>(<?php echo get_post()->comment_count;?>)</small></h3>
        </div>
		<div class="commentlist">
		<?php wp_list_comments(array('callback' => 'ya_comment')); ?>
	</div>

	<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
	<nav id="comments-nav" class="pager">
		<ul class="pager">
		<?php if (get_previous_comments_link()) : ?>
			<li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'shoppystore')); ?></li>
		<?php else: ?>
			<li class="previous disabled"><a><?php esc_html_e('&larr; Older comments', 'shoppystore'); ?></a></li>
		<?php endif; ?>
		<?php if (get_next_comments_link()) : ?>
			<li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'shoppystore')); ?></li>
		<?php else: ?>
			<li class="next disabled"><a><?php esc_html_e('Newer comments &rarr;', 'shoppystore'); ?></a></li>
		<?php endif; ?>
		</ul>
	</nav>
	<?php endif; // check for comment navigation ?>
</div><!-- /#comments -->
<?php endif; ?>

<?php if (comments_open()) : ?>
<div id="respond">
<h5><?php esc_html_e('Submit a Review', 'shoppystore'); ?></h5>
	<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
	
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" name="commentform" onsubmit="return submitform()" class="form-horizontal row-fluid">		
		<?php if (is_user_logged_in()) : ?>
			<p><?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'shoppystore'), get_option('siteurl'), $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'shoppystore'); ?>"><?php esc_html_e('Log out &raquo;', 'shoppystore'); ?></a></p>
		<?php else : ?>
            <div class="cmm-box-left">
		<div class="control-group-1">
			<!--<label class="control-label" for="author"><?php esc_html_e('Name*','shoppystore'); ?></label>-->
			<div class="controls">
				<p class="label-comment">
				<?php esc_html_e('Display Name','shoppystore'); ?>
				</p>
				<input type="text" class="input-block-level" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?>>
				
			</div>
		</div>
		<div class="control-group-1-1">
			
			<div class="controls">
				<p class="label-comment">
				<?php esc_html_e('Email','shoppystore'); ?>
				</p>
				<input 
				type="email" class="input-block-level" name="email" id="email"
				value="<?php echo esc_attr($comment_author_email); ?>" size="22"
				tabindex="2" <?php if ($req) echo "aria-required='true'"; ?>>
				
				</div>
			</div>
        <div class="control-group-2">				
				<div class="controls">
				<p class="label-comment">
				<?php esc_html_e('Title','shoppystore'); ?>
				</p>
					<input 
					type="url" class="input-block-level" name="url" id="url"
					value="<?php echo esc_attr($comment_author_url); ?>" size="22"
				tabindex="3">
				
			</div>
		</div>
            </div>
		<?php endif; ?>
        <div class="cmm-box-right">
		<div class="control-group-3">			
			<div class="controls">
			<p class="label-comment">
				<?php esc_html_e('Message','shoppystore'); ?>
				</p>
				<textarea name="comment"  id="comment" class="input-block-level"
					rows="7" tabindex="4"
					<?php if ($req) echo "aria-required='true'"; ?>></textarea>
			</div>
			<button type="submit" class="btn btn-default">
				<?php esc_html_e('Submit', 'shoppystore'); ?>
			</button>
		</div>
        </div>
		
			
	

		<?php comment_id_fields(); ?>
		<?php do_action('comment_form', $post->ID ); ?>
	</form>

</div><!-- /#respond -->
<?php endif; ?>
<script type="text/javascript">
	function submitform(){
		if(document.commentform.comment.value=='' || document.commentform.author.value=='' || document.commentform.email.value==''){
			alert('Please fill the required field.');
			return false;
		} else return true;
	}
</script>