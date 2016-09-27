<div class="list-group-item clearfix <?php echo $item_status ?><?php if ($cur_thread['soft'] == true) echo ' soft'; ?>">
	<div class="col-md-6 col-sm-6 col-xs-10">
		<?php echo $subject_status ?> <a href="<?php echo $url ?>" class="forum-title"><?php echo $subject ?></a><br />
        <span class="thread-desc"><?php echo $by ?> <?php echo $subject_multipage ?><span class="hidden-lg hidden-md hidden-sm"><?php echo (($cur_thread['moved_to'] == 0)? ' &middot; '.__('Latest comment on', 'luna').' '.$last_comment_date : '') ?></span></span>
	</div>
	<div class="col-md-1 col-sm-2 col-xs-2">
		<?php echo '<h5>'.(($cur_thread['moved_to'] == 0)? $cur_thread['num_replies'] : '-').'</h5> <h6><small>'.$comments_label.'</small></h6>';  ?>
	</div>
	<div class="col-md-1 hidden-sm hidden-xs">
		<?php echo '<h5>'.(($cur_thread['moved_to'] == 0)? $cur_thread['num_views'] : '-').'</h5> <h6><small>'.$views_label.'</small></h6>'; ?>
	</div>
	<div class="col-md-4 col-sm-4 hidden-xs overflow">
        <span class="thread-date">
            <?php echo (($cur_thread['moved_to'] == 0)? $last_comment_date : '-') ?>
        </span>
	</div>
</div>
