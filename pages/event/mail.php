<?php
gatekeeper();

$guid = get_input("guid");
$title = elgg_echo("event_manager:mail");

$event = get_entity($guid);
if (!$event || !$event->canEdit()) {
    register_error(elgg_echo("InvalidParameterException:GUIDNotFound", array($guid)));
    forward(REFERER);
}

elgg_set_page_owner_guid($event->container_guid);

elgg_push_breadcrumb($event->title, $event->getURL());
elgg_push_breadcrumb($title);

$form = elgg_view("event_manager/forms/event/mail", array(
    "entity" => $event
));

$body = elgg_view_layout('content', array(
    'filter' => '',
    'content' => $form,
    'title' => $title,
));

echo elgg_view_page($title, $body);