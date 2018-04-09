<?php

namespace GroupsPage;

/**
 * add fonctions to reorder a group
 *
 * @author Julien
 */
class ApiReorderGroup extends \ApiBase {
	public function __construct($query, $moduleName) {
		parent::__construct ( $query, $moduleName );
	}
	public function getAllowedParams() {
		return array (
				'groupspage' => array (
						\ApiBase::PARAM_TYPE => 'string',
						\ApiBase::PARAM_REQUIRED => true
				),
				'indexes' => array (
						\ApiBase::PARAM_TYPE => 'string',
						\ApiBase::PARAM_REQUIRED => true
				)
		);
	}
	public function getParamDescription() {
		return [ ];
	}
	public function getDescription() {
		return false;
	}
	public function execute() {
		$params = $this->extractRequestParams ();
		$grouppageParam = $params ['groupspage'];
		$indexesParam = $params['indexes'];

		//$grouppageParam = 'Group:Toto';

		$grouppage = \Title::newFromDBkey ( $grouppageParam );

		$r = [ ];
		$fail = false;

		if ($fail) {
			$this->getResult ()->addValue ( null, $this->getModuleName (), $r );
			return;
		}

		$core = new GroupsPageCore ();

	  	$indexes = array();
	  	parse_str($indexesParam, $indexes);
		$result = $core->reorderGroup ( $grouppage, $indexes['item']);
		if ($result){
			//empty cache
			$wikipage = new \Wikipage($grouppage);
			$wikipage->doPurge();
		}

		$r = [ ];
		if ($result) {
			$r ['success'] = 1;
			$r ['result'] = 'OK';
			$r ['detail'] = $result;
		} else {
			$r ['result'] = 'fail';
			$r ['detail'] = $result;
		}

		$this->getResult ()->addValue ( null, $this->getModuleName (), $r );
	}
	public function needsToken() {
		return 'csrf';
	}
}