<?php
class SiteController extends BaseController
{
	public function actionIndex() 
	{
		$this->setPageLayout( 'home' );
		return $this->render( 'index' );
	}
}