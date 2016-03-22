<?php
$event = $vars['event'];
$current_user = elgg_get_logged_in_user_entity();

if ($current_user) {
    $name = explode(' ', $current_user->name);
    if (!$_SESSION['registerevent_values']['question_firstname']) {
        $_SESSION['registerevent_values']['question_firstname'] = implode(' ', array_slice($name, 0, 1));
    }
    if (!$_SESSION['registerevent_values']['question_lastname']) {
        $_SESSION['registerevent_values']['question_lastname'] = implode(' ', array_slice($name, 1));
    }
}
?>
<label><?php echo elgg_echo('user:firstname:label'); ?> *</label><br />
<input type="text" name="question_firstname" value="<?php echo $_SESSION['registerevent_values']['question_firstname']; ?>" class="input-text" />
<label><?php echo elgg_echo('user:lastname:label'); ?> *</label><br />
<input type="text" name="question_lastname" value="<?php echo $_SESSION['registerevent_values']['question_lastname']; ?>" class="input-text" />