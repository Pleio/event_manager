<?php

	$event = elgg_extract("event", $vars);
	$object = elgg_extract("object", $vars);

	$rel = $event->getRelationshipByUser($object->getGUID());
	echo elgg_view("output/longtext", array("value" => elgg_echo("event_manager:event:relationship:message:" . $rel)));

	echo "<div class='mtm'>";
	echo elgg_view("output/url", array("text" => elgg_echo("event_manager:registration:continue"), "href" => $event->getURL(), "class" => "elgg-button elgg-button-action"));
	echo "</div>";