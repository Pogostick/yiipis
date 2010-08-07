<?php
/*
 * CYPSAppImprover.php
 *
 * Copyright (c) 2010 Jerry Ablan <jablan@pogostick.com>.
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 *
 * This file is part of YiiPIS.
 *
 * We share the same open source ideals as does the jQuery team, and
 * we love them so much we like to quote their license statement:
 *
 * You may use our open source libraries under the terms of either the MIT
 * License or the Gnu General Public License (GPL) Version 2.
 *
 * The MIT License is recommended for most projects. It is simple and easy to
 * understand, and it places almost no restrictions on what you can do with
 * our code.
 *
 * If the GPL suits your project better, you are also free to use our code
 * under that license.
 *
 * You don’t have to do anything special to choose one license or the other,
 * and you don’t have to notify anyone which license you are using.
 */

//	Include Files
//	Constants
//	Global Settings

/**
 * A remote deployment and communications implement
 *
 * @package 	yiipis
 * @subpackage 	components
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @filesource
 */
class CYPSAppImprover extends CController
{
	//********************************************************************************
	//* Constants
	//********************************************************************************

	const	VERSION = '1.0.0';
	const	CONTROLLER_ID = '_yiipis';

	//********************************************************************************
	//* Member Variables
	//********************************************************************************

	/**
	 * Stores a list of imports
	 * @var array
	 */
	protected $_importList;
	public function getImportList() { return $this->_importList; }

	protected $_layoutPath;
	protected $_analysisMap;

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	 * Constructs an AppImprover
	 * @param string $id
	 * @param sttring $module
	 * @param array $config
	 */
	public function __construct( $id = null, $module = null, $config = null )
	{
		//	Stuff our own controller id into there...
		if ( null === $id ) $id = self::CONTROLLER_ID;
		parent::__construct( $id, $module );
	}

	/**
	 * Initialize the component
	 */
	public function init()
	{
		//	Hook into controller map...
		Yii::app()->controllerMap[ self::CONTROLLER_ID ] = array(
			'class' => __CLASS__,
		);

		//	Grab the errors for a clean experience...
		set_error_handler( function( $errNo, $errStr, $errFile, $errLine, $errContext ) {
			throw new CException( $errStr, $errNo );
		}, E_ERROR );

		$this->_layoutPath = Yii::app()->getLayoutPath();
	}

	//********************************************************************************
	//* Public Actions
	//********************************************************************************

	/**
	 * Returns the version of the implement
	 */
	public function actionVersion()
	{
		$this->_echoJSON( 
			array(
				'version' => self::VERSION,
			)
		);
	}

	/**
	 * Analyzes and reports back information about this application's configuration file.
	 * @returns string JSON array
	 */
	public function actionAnalyzeConfig()
	{
		$_dir = array();
		$_config = $this->actionGetAppConfig( true );

		$this->_analysisMap = array(
			'component' => array(),
			'controller' => array(),
			'model' => array(),
			'behavior' => array(),
			'event' => array(),
			'widget' => array(),
			'exception' => array(),
			'other' => array(),
		);

		ob_start();

		//	Look at imports...
		foreach ( $_config['import'] as $_path )
		{
			//	Search each path for classes
			$_dir[ $_path ] = $this->_getDirectoryTree( $_path );
		}

		ob_end_clean();

		//	Return
		$this->_echoJSON(
			array(
				'yiipis' => array(
					'imports' => $this->_importList,
					'fileTree' => $_dir,
					'appConfig' => $_config,
					'analysisMap' => $this->_analysisMap,
				),
			)
		);

		Yii::app()->end();
	}

	/**
	 * Retrieves and returns the application configuration file
	 * @param boolean $returnRawConfig If true, the config is returned as an array
	 * @returns string JSON array
	 */
	public function actionGetAppConfig( $returnRawConfig = false )
	{
		//	Icky, hate this but config location is not stored.
		global $config;

		$_config = array();
		if ( is_string( $config ) ) $_config = include( $config );

		if ( $returnRawConfig ) return $_config;

		$this->_echoJSON( $_config );
	}

	//********************************************************************************
	//* Private Methods
	//********************************************************************************

	/**
	 * Given an alias or path, returns an array of the directory structure underneath
	 * @param string $alias The alias or path to the folder
	 * @returns array
	 */
	protected function _getDirectoryTree( $alias )
	{
		$_result = array();
		$this->_parseImport( $alias );
		$_path = Yii::getPathOfAlias( $alias );

		$_dir = @dir( $_path );

        while ( $_dir && false !== ( $_folder = $_dir->read() ) )
		{
			if ( $_folder != '.' && $_folder != '..' )
			{
				$_fullFilePath = $_path . DIRECTORY_SEPARATOR . $_folder;

				if ( is_dir( $_fullFilePath ) )
				{
					$_result[ $_folder ] = $this->_getDirectoryTree( $_path . DIRECTORY_SEPARATOR );
				}
				else
				{
					if ( $_result[ $_folder ] = is_file( $_fullFilePath ) )
					{
						$_parsedFile = $this->_parseFile( $_path, $_folder );
						$_result['classMap'][ $_fullFilePath ] = $_parsedFile;
					}
				}
			}
		}

		ksort( $_result );
		return $_result;
	}

	/**
	 * Minified version of Yii::import()
	 * @param string $alias The alias or path to the folder
	 * @returns array
	 */
	protected function _parseImport( $alias )
	{
		if ( isset( $this->_importList[ $alias ] ) )
			return $this->_importList[ $alias ];

		$_pathParts = explode( '.', $alias );
		$_className = ( count( $_pathParts ) > 1 ) ? $_pathParts[ count( $_pathParts ) - 1 ] : $alias;
		
		if ( $_className != '*' && ( class_exists( $alias, false ) || interface_exists( $alias, false ) ) )
		{
			return $this->_importList[ $alias ] = $_className;
		}
		
		if ( false !== ( $_path = Yii::getPathOfAlias( $alias ) ) )
		{
			if ( $_className !== '*' )
				return $_className;

			return $this->_importList[ $alias ] = $_path;
		}
	}

	/**
	 * Parses a class file for interesting tidbits
	 * @param string $fileName
	 * @returns array
	 */
	protected function _parseFile( $path, $fileName )
	{
		$_results = array();

		try
		{
			$_className = str_ireplace( array( '.class.php', '.php' ), '', $fileName );

			if ( $_class = new ReflectionClass( $_className ) )
			{
				$_results['name'] = $_class->getName();
				$_results['path'] = $path;
				$_results['fileName'] = $fileName;

				if ( $_class->isSubclassOf( 'CController' ) )
					$_results['type'] = 'controller';
				else if ( $_class->isSubclassOf( 'CComponent' ) )
					$_results['type'] = 'component';
				else if ( $_class->isSubclassOf( 'CModel' ) )
					$_results['type'] = 'model';
				else if ( $_class->isSubclassOf( 'CBehavior' ) )
					$_results['type'] = 'behavior';
				else if ( $_class->isSubclassOf( 'CEvent' ) )
					$_results['type'] = 'event';
				else if ( $_class->isSubclassOf( 'CWidget' ) )
					$_results['type'] = 'widget';
				else if ( $_class->isSubclassOf( 'CException' ) )
					$_results['type'] = 'exception';
				else
					$_results['type'] = 'other';

				

				$this->_analysisMap[$_results['type']][] = array( 'ref' => $_class );
			}
		}
		catch ( Exception $_ex )
		{
			//	Not a PHP file or has an error...
		}

		return $_results;
	}

	/**
	 * Converts the parameter to JSON and echos
	 * @param mixed The value to echo
	 */
	protected function _echoJSON( $value )
	{
		header( 'Content-Type: application/json' );
		echo CJSON::encode( $value );
	}

}