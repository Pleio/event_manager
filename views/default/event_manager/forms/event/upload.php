<?php 
	
if ($vars['entity']) {		
	$form_body = elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars['entity']->getGUID()));
	$form_body .= '<div><label>' . elgg_echo('title') . ' *</label>' . elgg_view('input/text', array('name' => 'title', 'value' => '')) . '</div>';
	$form_body .= '<div><label>' . elgg_echo('event_manager:edit:form:file') . ' *</label>' . elgg_view('input/file', array('name' => 'file')) . '</div>';
	$form_body .= elgg_view('input/submit', array('value' => elgg_echo('upload')));
	$form_body .= '<div class="elgg-subtext">(* = ' . elgg_echo('requiredfields') . ')</div>';
	
	$form = elgg_view('input/form', array(
		'id' => 'event_manager_event_upload', 
		'name' => 'event_manager_event_upload', 
		'action' => 'action/event_manager/event/upload', 
		'enctype' => 'multipart/form-data', 
		'body' => $form_body
	));
	
	echo elgg_view_module("main", "", $form);
}
