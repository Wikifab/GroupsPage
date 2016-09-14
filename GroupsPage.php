<?php

$wgResourceModules['ext.groupspage.js'] = array(
		'scripts' => 'groupspagebutton.js',
		'styles' => array(),
		'messages' => array(
		),
		'dependencies' => array(
		),
		'position' => 'bottom',
		'localBasePath' => __DIR__ . 'js',
		'remoteExtPath' => 'GroupsPage/js',
);

// define namespaces :
define("NS_GROUP", 220);
define("NS_GROUP_TALK", 221);
define("NS_GROUP_BELONGING", 222);

// Add namespaces.
$wgExtraNamespaces[NS_GROUP] = "Group";
$wgExtraNamespaces[NS_GROUP_TALK] = "Group_talk";

// group belonging is a namespace for pages destinated to link on page to many other
// (not necessarely a group page)
// not used yet
$wgExtraNamespaces[NS_GROUP_BELONGING] = "Group_belonging";


$wgAutoloadClasses['GroupsPage\\Hook'] = __DIR__ . '/includes/Hook.php';
$wgAutoloadClasses['GroupsPage\\ApiGroupsPage'] = __DIR__ . '/includes/ApiGroupsPage.php';


$wgHooks['SkinTemplateNavigation'][] = 'GroupsPage\\Hook::displayTab';
$wgHooks['BeforePageDisplay'][] = 'GroupsPage\\Hook::onBeforePageDisplay';
$wgHooks['ParserFirstCallInit'][] = 'GroupsPage\\Hook::onParserFirstCallInit';


$wgAPIModules['goupspage'] = 'GroupsPage\\ApiGroupsPage';

$wgExtensionMessagesFiles['GroupsPage'] = __DIR__ . '/GroupsPage.i18n.php';
