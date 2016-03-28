<div>
    <label for="group"><?php echo elgg_echo("event_manager:add_attendees_to_group:select"); ?></label>
    <?php echo elgg_view('input/dropdown', array(
        'name' => 'group_guid',
        'options_values' => $vars['groups']
    )); ?>
</div>

<div>
    <?php if (elgg_is_admin_logged_in()): ?>
        <?php echo elgg_view('input/checkbox', array(
            'name' => 'add_to_site',
            'value' => 1,
            'checked' => 'checked'
        )); ?>
    <?php else: ?>
        <?php echo elgg_view('input/checkbox', array(
            'name' => 'add_to_site',
            'value' => 1,
            'disabled' => 'disabled'
        )); ?>
    <?php endif ?>

    <label for="add_to_site"><?php echo elgg_echo("event_manager:add_attendees_to_group:add_to_site"); ?></label>
    <?php if (!elgg_is_admin_logged_in()): ?>
        <p><i><?php echo elgg_echo("event_manager:add_attendees_to_group:add_to_site:disabled"); ?></i></p>
    <?php endif ?>
</div>

<?php echo elgg_view('input/hidden', array(
    'name' => 'guid',
    'value' => $vars['event']->guid
)); ?>

<?php echo elgg_view('input/submit', array(
    'value' => elgg_echo('event_manager:add_attendees_to_group:submit')
)); ?>