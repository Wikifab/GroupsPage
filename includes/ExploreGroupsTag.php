<?php
namespace GroupsPage;
/**
 * class for include explore area
 *
 * @file
 * @ingroup Extensions
 *
 * @author Pierre Boutet
 */

class ExploreGroupsTag {


	public static function simpleSearch() {
		$page = 1;

		$dbr = wfGetDB( DB_SLAVE );

		$limit = 12;

		$offset = ($page -1 ) * $limit;

		$res = $dbr->select(
				'page',
				array(
						'page_id'
				),
				array(
						'page_namespace' => NS_GROUP,
				),
				__METHOD__,
				array(
						'LIMIT' => $limit,
						'OFFSET' => $offset
				)
				);

		$pages = array();
		if ( $res->numRows() > 0 ) {
			foreach ( $res as $row ) {
				$pages[] =\WikiPage::newFromID($row->page_id );
			}
			$res->free();
		}
		return $pages;
	}

	public static function addSampleParser( $input, $filters = 'completeonly') {

		$filters = explode(',', $filters);

		$input->getOutput ()->addModuleStyles( array(
			'mediawiki.special', 'mediawiki.special.search', 'mediawiki.ui', 'mediawiki.ui.button',
			'mediawiki.ui.input',
		) );
		$input->getOutput ()->addModules( 'ext.wikifab.wfExplore.js');

		$WfExploreCore = new WfExploreCore();

		$params = [];

		if (false !== array_search('completeonly', $filters)) {
			$params['complete'] = 'complete';
		}

		//$WfExploreCore->executeSearch( $request = null , $params);
		$WfExploreCore->results = self::simpleSearch();

		$out = "";

		$out .= $WfExploreCore->getHtmlForm();

		$out .= $WfExploreCore->getSearchResultsHtml();

		return array( $out, 'noparse' => true, 'isHTML' => true );
	}

}