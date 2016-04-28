<?php

$fields = array(
    "subject" => ELGG_ENTITIES_ANY_VALUE,
    "message" => ELGG_ENTITIES_ANY_VALUE
);

if (elgg_is_sticky_form('event_mail')) {
    $fields = array_merge($fields, elgg_get_sticky_values('event_mail'));
}

$body = "<p>";
$body .= "<label>" . elgg_echo("event_manager:mail:subject") . "</label>";
$body .= elgg_view("input/text", array(
    "name" => "subject",
    "value" => $fields["subject"]
));
$body .= "</p>";

$body .= "<p>";
$body .= "<label>" . elgg_echo("event_manager:mail:message") . "</label>";
$body .= elgg_view("input/longtext", array(
    "name" => "message",
    "value" => $fields["message"]
));
$body .= "</p>";

$body .= elgg_view("input/hidden", array(
    "name" => "guid",
    "value" => $vars['entity']->guid
));

$body .= "<p>";
$body .= elgg_view("input/submit", array(
    "name" => "send_type",
    "value" => elgg_echo("event_manager:mail:send_test")
));

$body .= elgg_view("input/submit", array(
    "name" => "send_type",
    "value" => elgg_echo("event_manager:mail:send"),
    "onClick" => "this.disabled=true;this.form.submit();"
));
$body .= "</p>";

$body .= "<p class=\"elgg-subtext\">";
$body .= elgg_echo("event_manager:mail:please_wait");
$body .= "</p>";

echo elgg_view('input/form', array(
    'action' => '/action/event_manager/attendees/mail',
    'body' => $body
));