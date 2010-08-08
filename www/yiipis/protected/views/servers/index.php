<?php
/*
 * This file is part of YiiPIS
 *
 * @copyright Copyright &copy; 2010 Pogostick, LLC
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 */

/**
 * servers.index view
 *
 * @package 	yiipis
 * @subpackage 	views
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */

//	Our form CSS
PS::_rcf( '/css/ui.jqgrid.css', 'all' );
PS::_rsf( 'http://gettopup.com/releases/latest/top_up-min.js?libs=all&fast_mode=1', CClientScript::POS_HEAD );
PS::_rcf( '/css/sexyalertbox.css', 'all' );
PS::_rsf( '/scripts/jquery.sexyalertbox-1.2.js' );
PS::_rs( 'temp.vars', 'var _lastSelection;', CClientScript::POS_BEGIN );

//	Turn off form required labels...
PS::$afterRequiredLabel = null;

//	Set up our columns for display
$_columnNames = array(
	'ID',
	'URL',
	'Dev URL',
);

$_columnModel = array(
	array( 'name' => 'id', 'key' => true, 'sorttype' => 'integer', 'jsonmap' => 'id', 'align' =>'center', 'width' => 75 ),
	array( 'name' => 'url_text', 'jsonmap' => 'url_text' ),
	array( 'name' => 'dev_url_text', 'jsonmap' => 'dev_url_text' ),
);
?>

<?php

//	Create our grid...
CPSjqGridWidget::create( 'report-grid',
	array(
		'data' => $data,
		'toppager' => false,
		'datatype' => 'local',
		'autowidth' => true,
		'altRows' => true,
		'sortorder' => 'desc',
//		'forceFit' => true,
		'shrinkToFit' => true,
		'height' => '100%',
		'rowNum' => 10,
		'loadtext' => 'One moment please...',
		'rowList' => array( 10, 25, 50, 100 ),
		'sortable' => true,
		'colNames' => $_columnNames,
		'colModel' => $_columnModel,
		'caption' => 'Server Manager',
		'pager' => '#report-grid-pager',
		'viewrecords' => true,
		'editurl' => '/servers/update',
		'loadonce' => true,
		'jsonReader' => array(
			'repeatitems' => false,
			'id' => '0',
			'root' => 'rows'
		),
		'apiOptions' => array(
			'navGrid' => array(
				'edit' => false,
				'add' => false,
				'del' => false,
				'search' => true,
			),
		),
		'theme' => PS::_gp( 'siteTheme' ),
	)
);
?>
