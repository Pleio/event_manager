<?php $event = $vars['event']; ?>
<ul>
	<li>
        <?php if ($event->separate_first_lastname): ?>
            <?php echo elgg_view('event_manager/registration/separate_first_lastname', array(
                'event' => $event
            )); ?>
        <?php else: ?>
            <label><?php echo elgg_echo('user:fullname:label'); ?> *</label><br />
            <input type="text" name="question_name" value="<?php echo $_SESSION['registerevent_values']['question_name']; ?>" class="input-text" />
         <?php endif ?>
	</li>

	<li>
		<label><?php echo elgg_echo('email'); ?> *</label><br />
		<input type="text" name="question_email" value="<?php echo $_SESSION['registerevent_values']['question_email']; ?>" class="input-text" />
	</li>
</ul>