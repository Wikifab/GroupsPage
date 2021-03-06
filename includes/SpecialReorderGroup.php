<?php
namespace GroupsPage;
use SpecialPage;


class SpecialReorderGroup extends SpecialPage {
	function __construct() {
		parent::__construct( 'ReorderGroup' );
	}

	function execute( $par ) {

		$request = $this->getRequest();
		$output = $this->getOutput();
		$this->setHeaders();

		// Déclaration de mes variables
		$groupName = $request->getText( 'groupName' );
		$pageTitle = \Title::newFromText($groupName);

		// Si le nom de la page est vide ou inexistant alors on affiche le message d'erreur
		if ($pageTitle===null || ! $pageTitle->exists()){
			$output -> setStatusCode(404);
			$output -> setPageTitle('Erreur 404');
			$output -> addHTML( "Erreur 404, la page demandée n'existe pas, ou est nulle.");
		}else{
			$pages = GroupsPageCore::getInstance()->getMemberPages($pageTitle);

			$output->addHTML("<div id='reordergroup-alert' class='alert' style='display:none'></div>");

			$output->addHTML('<div id="tutorials-list" data-grouppage="'.\MWNamespace::getCanonicalName( $pageTitle->getNamespace() ).':'.$pageTitle->getDBKey().'">');

			foreach ($pages as $page) {
				if($page->getNamespace() == NS_MAIN){
					$output->addHTML('<div class="grabbable" id="item_'.$page->getArticleID().'">'.$page->getText().'<i class="fa fa-arrows-v"></i></div>');
				}
			}
			$output->addHTML('</div>');

			//save
			$output->addHTML('<button id="gp-special-save" class="site-button btn"><i class="fa fa-spinner fa-spin upl_loading" style="display:none"></i>'.
						wfMessage( 'gp-special-save' )->parse().
					'</button>');
			//cancel
			$output->addHTML('<button id="gp-special-cancel" class="site-button btn" onclick="(function(){
    window.history.back();
})();return false;">'.
						wfMessage( 'gp-special-cancel' )->parse().
					'</button>');

			$output->addJsConfigVars("groupspageLink", \Linker::link(\Title::newFromText('Group:'.$pageTitle->getDBkey()), $this->msg('gp-special-groupspage-link')));

			$output->addModules( 'ext.reordergroup.js' );
			$output->addModuleStyles('ext.reordergroup.css');
		}
	}

}




