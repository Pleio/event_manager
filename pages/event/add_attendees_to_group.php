<?php
gatekeeper();

$guid = get_input("owner_guid");

if ($guid) {
    $event = get_entity($guid);
}

if (!$event || !elgg_instanceof($event, "object", "event") || !$event->canEdit()) {
    register_error('InvalidParameterException:NoEntityFound');
    forward(REFERER);
}

elgg_set_page_owner_guid($event->container_guid);
elgg_push_breadcrumb($event->title, $event->getURL());
elgg_push_breadcrumb(elgg_echo('event_manager:add_attendees_to_group'));

$user = elgg_get_logged_in_user_entity();
$groups = array();
foreach ($user->getGroups(array(), 0, 0) as $group) {
    if ($group->canEdit()) {
        $groups[$group->guid] = $group->name;
    }
}

if (count($groups) == 0) {
    register_error(elgg_echo('event_manager:add_attendees_to_group:no_groups'));
    forward(REFERER);
}

$title_text = elgg_echo('event_manager:add_attendees_to_group');
$body = elgg_view_layout('content', array(
    'title' => $title_text,
    'filter' => '',
    'content' => elgg_view_form('event_manager/attendees/add_to_group', array(), array(
        'event' => $event,
        'groups' => $groups
    ))
));

echo elgg_view_page($title_text, $body);

?>