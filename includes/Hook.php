<?php

namespace GroupsPage;

class Hook  {
	/**
	 * @param EchoEvent $event
	 * @param string $param
	 * @param Message $message
	 * @param User $user
	 */
	protected function processParam( $event, $param, $message, $user ) {


		parent::processParam( $event, $param, $message, $user );

		return;
	}

	public static function onParserFirstCallInit( $parser ) {
		$parser->setFunctionHook( 'addToGroupButton', 'GroupsPage\\Hook::parserAddToGroupButton' );
		return true;
	}


	public static function parserAddToGroupButton( $input, $grouppage = 'top', $page = 4 ) {

		$button = '<a class="addToGroupsPage" data-grouppage="'.$grouppage.'" data-page="'.$page.'" >';
		$button .= '<button>';
		$button .= 'add to group';
		$button .= '</button>';
		$button .= '</a>';


		return array( $button, 'noparse' => true, 'isHTML' => true );
	}


	public static function onBeforePageDisplay( $out ) {
		$out->addModules( 'ext.groupspage.js' );
	}


	/**
	 * Adds an "action" (i.e., a tab) to edit the current article with
	 * a form
	 */
	static function displayTab( $obj, &$links ) {


		$button = '<button class="addToGroupsPage" data-grouppage="Group:toto" data-page="Horloge_de_Fibonacci" > add to group</button>';

		$content_actions = &$links['views'];

		if ( method_exists ( $obj, 'getTitle' ) ) {
			$title = $obj->getTitle();
		} else {
			$title = $obj->mTitle;
		}
		$groupNameSpace = [ NS_GROUP, NS_GROUP_TALK];

		if ( !isset( $title ) ||
			( !in_array( $title->getNamespace(), $groupNameSpace ) ) ) {
					return true;
		}

		$form_create_tab = array(
			'class' => '',
			'text' => $button,
			'href' => $title->getLocalURL( 'action=formcreate' )
		);

		$content_actions['addtogroup'] = $form_create_tab;

		return true; // always return true, in order not to stop MW's hook processing!
	}
}
