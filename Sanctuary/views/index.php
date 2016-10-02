<?php

// Make sure no one attempts to run this view directly.
if (!defined('FORUM'))
	exit;

if ($luna_user['first_run'] == '0') {

	if ( $luna_user['id'] == -1 ) {
?>
<style>
@media (min-width:768px) {
	.navbar-inverse {
		background-color: rgba(0,0,0,.1);
	}
}
</style>
	<?php } ?>
<div class="heading">
    <div class="jumbotron first-run">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-xs-6">
                	<h3 class="text-center"><span class="hidden-xs"><?php echo sprintf(__('Hi there, %s', 'luna'), luna_htmlspecialchars($luna_user['username'])) ?></span><span class="visible-xs-block"><?php echo luna_htmlspecialchars($luna_user['username']) ?></span></h3>
                    <div class="user-avatar thumbnail"><?php echo $user_avatar ?></div>
                </div>
				<?php if (!$luna_user['is_guest']) { ?>
					<div class="col-sm-4 hidden-xs">
						<h3><?php echo sprintf(__('Welcome to %s', 'luna'), $luna_config['o_board_title']) ?></h3>
						<p><?php echo $luna_config['o_first_run_message']; ?></p>
					</div>
					<div class="col-sm-4 col-xs-6">
						<div class="list-group list-group-transparent">
							<a href="settings.php" class="list-group-item"><?php _e('Extend your details', 'luna') ?></a>
							<a href="help.php" class="list-group-item"><?php _e('Get help', 'luna') ?></a>
							<a href="search.php" class="list-group-item"><?php _e('Search the board', 'luna') ?></a>
							<a href="index.php?action=do_not_show&id=<?php echo $luna_user['id'] ?>" class="list-group-item active"><?php _e('Don\'t show again', 'luna') ?></a>
						</div>
					</div>
				<?php } else { ?>
					<?php $redirect_url = check_url(); ?>
					<div class="col-sm-4 hidden-xs">
						<h3><?php echo sprintf(__('Welcome to %s', 'luna'), $luna_config['o_board_title']) ?></h3>
						<div class="list-group list-group-transparent">
							<a href="register.php" class="list-group-item"><?php _e('Register', 'luna') ?></a>
							<a href="#" data-toggle="modal" data-target="#reqpass" class="list-group-item"><?php _e('Forgotten password', 'luna') ?></a>
						</div>
					</div>
					<div class="col-sm-4 col-xs-6">
						<form class="form form-first-run" id="login" method="post" action="login.php?action=in" onsubmit="return process_form(this)">
							<fieldset>
								<h3><?php _e('Login', 'luna') ?></h3>
								<input type="hidden" name="form_sent" value="1" />
								<input type="hidden" name="redirect_url" value="<?php echo luna_htmlspecialchars($redirect_url) ?>" />
								<div class="first-run-login">
									<input class="form-control top-form" type="text" name="req_username" maxlength="25" tabindex="1" placeholder="<?php _e('Username', 'luna') ?>" />
									<input class="form-control bottom-form" type="password" name="req_password" tabindex="2" placeholder="<?php _e('Password', 'luna') ?>" />
								</div>
								<label><input type="checkbox" name="save_pass" value="1" tabindex="3" checked /> <?php _e('Remember me', 'luna') ?></label>
								<span class="pull-right">
									<input class="btn btn-primary btn-login" type="submit" name="login" value="<?php _e('Login', 'luna') ?>" tabindex="4" />
								</span>
							</fieldset>
						</form>
					</div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="index profile-header container-fluid">
	<div class="jumbotron profile">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h2 class="username"><?php _e( 'Welcome back', 'luna' ) ?></h2>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="main index profile container">
	<div class="row">
		<div class="col-sm-3 col-xs-12 sidebar">
			<?php if (!$luna_user['is_guest'] && $luna_user['first_run'] == '1') { ?>
			<div class="container-avatar hidden-xs">
				<img src="<?php echo get_avatar( $luna_user['id'] ) ?>" alt="Avatar" class="img-avatar img-center">
			</div>
			<?php } if ($luna_config['o_header_search'] && $luna_user['g_search'] == '1'): ?>
			<form id="search" class="input-group search-form" method="get" action="search.php?section=simple">
				<input type="hidden" name="action" value="search" />
				<input class="form-control" type="text" name="keywords" placeholder="<?php _e('Search in comments', 'luna') ?>" maxlength="100" />
				<span class="input-group-btn">
					<button class="btn btn-default btn-search" type="submit" name="search" accesskey="s"><i class="fa fa-fw fa-search"></i></button>
				</span>
			</form>
			<hr />
			<?php endif; ?>
            <div class="title-block title-block-primary">
                <h5><?php _e('Recent activity', 'luna') ?></h5>
            </div>
            <div class="list-group list-group-thread">
                <?php draw_index_threads_list(7, 'thread2.php', true); ?>
            </div>
			<?php if ($luna_user['g_search'] == '1') { ?>
			<hr />
			<div class="list-group list-group-luna">
				<?php echo implode('', $page_threadsearches) ?>
			</div>
			<?php } ?>
			<hr />
			<div class="list-group list-group-luna">
				<?php draw_mark_read('list-group-item', 'index'); ?>
			</div>
		</div>
		<div class="col-sm-9 col-xs-12">
<?php
	// Announcement
	if ($luna_config['o_announcement'] == '1') {
?>
			<div class="alert alert-<?php echo $luna_config['o_announcement_type']; ?> announcement">
				<?php if (!empty($luna_config['o_announcement_title'])) { ?><h4><?php echo $luna_config['o_announcement_title']; ?></h4><?php } ?>
				<?php echo $luna_config['o_announcement_message']; ?>
			</div>
<?php
	}
?>
			<!--- FEATURED THREADS -->
			<div class="list-group list-group-thread">
				<div class="title-block title-block-primary">
					<h3>Featured threads</h3>
				</div>
				<?php
					require LUNA_ROOT.'include/parser.php';
				
					$featured_threads = $db->query('SELECT * FROM '.$db->prefix.'threads WHERE featured=1 ORDER BY id DESC');
				
					while($cur_thread = $db->fetch_assoc($featured_threads)){
						$thread_text = $db->fetch_assoc($db->query('SELECT * FROM '.$db->prefix.'comments WHERE id='.$cur_thread["first_comment_id"]))["message"];
						$thread_text = parse_message($thread_text);
						
						++$thread_count;
						$status_text = array();
						$item_status = ($thread_count % 2 == 0) ? 'roweven' : 'rowodd';
						$icon_type = 'icon';
						$subject = luna_htmlspecialchars($cur_thread['subject']);
						$last_comment_date = '<a href="thread.php?pid='.$cur_thread['last_comment_id'].'#p'.$cur_thread['last_comment_id'].'">'.format_time($cur_thread['last_comment']).'</a>';

						if (is_null($cur_thread['moved_to'])) {
							$thread_id = $cur_thread['id'];

							$last_commenter = '<span class="byuser">'.__('by', 'luna').' '.luna_htmlspecialchars($cur_thread['last_commenter']).'</span>';
						} else {
							$last_commenter = '';
							$thread_id = $cur_thread['moved_to'];
						}

						if ($luna_config['o_censoring'] == '1')
							$cur_thread['subject'] = censor_words($cur_thread['subject']);

						if ($cur_thread['pinned'] == '1') {
							$item_status .= ' pinned-item';
							$status_text[] = '<i class="fa fa-fw fa-thumb-tack status-pinned"></i>';
						}

						if (isset($cur_thread['answer']) && $cur_forum['solved'] == 1) {
							$item_status .= ' solved-item';
							$status_text[] = '<i class="fa fa-fw fa-check status-solved"></i>';
						}

						if ($cur_thread['important']) {
							$item_status .= ' important-item';
							$status_text[] = '<i class="fa fa-fw fa-map-marker status-important"></i>';
						}

						if ($cur_thread['moved_to'] != 0) {
							$status_text[] = '<i class="fa fa-fw fa-arrows-alt status-moved"></i>';
							$item_status .= ' moved-item';
						}

						if ($cur_thread['closed'] == '1') {
							$status_text[] = '<i class="fa fa-fw fa-lock status-closed"></i>';
							$item_status .= ' closed-item';
						}

						if (!$luna_user['is_guest'] && $cur_thread['last_comment'] > $luna_user['last_visit'] && (!isset($tracked_threads['threads'][$cur_thread['id']]) || $tracked_threads['threads'][$cur_thread['id']] < $cur_thread['last_comment']) && (!isset($tracked_threads['forums'][$id]) || $tracked_threads['forums'][$id] < $cur_thread['last_comment']) && is_null($cur_thread['moved_to'])) {
							$item_status .= ' new-item';
							$icon_type = 'icon icon-new';
							$status_text[] = '<a href="thread.php?id='.$cur_thread['id'].'&amp;action=new" title="'.__('Go to the first new comment in the thread.', 'luna').'"><i class="fa fa-fw fa-bell status-new"></i></a>';
						}

						$url = 'thread.php?id='.$thread_id;
						$by = '<span class="byuser">'.__('by', 'luna').' '.luna_htmlspecialchars($cur_thread['commenter']).'</span> 
						<hr style="margin-top:2px;margin-bottom:5px;">
						<div class="thread-text">
						'.$thread_text.'
						</div>';

						if (!$luna_user['is_guest'] && $luna_config['o_has_commented'] == '1') {
							if ($cur_thread['has_commented'] == $luna_user['id']) {
								$item_status .= ' commented-item';
							}
						}

						$subject_status = implode(' ', $status_text);

						$num_pages_thread = ceil(($cur_thread['num_replies'] + 1) / $luna_user['disp_comments']);

						if ($num_pages_thread > 1)
							$subject_multipage = '<span class="inline-pagination"> &middot; '.simple_paginate($num_pages_thread, -1, 'thread.php?id='.$cur_thread['id']).'</span>';
						else
							$subject_multipage = null;

						$comments_label = _n('comment', 'comments', $cur_thread['num_replies'], 'luna');
						$views_label = _n('view', 'views', $cur_thread['num_views'], 'luna');

						require get_view_path('featuredthread.php');
					}
				?>
			</div>
			
            <div class="list-group list-group-thread">
                <?php draw_forum_list('forum.php', 1, 'category.php', ''); ?>
            </div>
		</div>
	</div>
</div>