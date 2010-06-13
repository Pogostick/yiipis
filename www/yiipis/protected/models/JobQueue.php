<?php
/*
 * JobQueue.php
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
 * @package 	yiipis
 * @subpackage	models
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
class JobQueue extends BaseModel
{
	//********************************************************************************
	//* Constants
	//********************************************************************************

	/**
	* Job Status Codes
	*/
	const ST_UNHANDLED_REQUEST = -1;
	const ST_QUEUED = 0;
	const ST_COMPLETE = 1;
	const ST_COMPLETE_WITH_ERROR = 2;

	/**
	* Job Classes
	*/
	const	EXPORT_CSV = 'CExportCsv';

	/**
	* Job Type Codes
	*/
	const	SYS_WELCOME_EMAIL = 0;
	const 	SYS_PASSWORD_RESET = 1;
	const 	SYS_NOTIFICATION_EMAIL = 2;
	const 	SYS_RESEND_VERIFY_EMAIL = 3;
	const 	SYS_REMOVE_IMAGE = 4;
	const 	SYS_CLICK = 5;
	const	SYS_OX_PUBLISHER_SITE = 6;
	const	SYS_USER_UPDATE = 7;

	/**
	* The display name for job statuses
	* @var array
	* @access protected
	*/
	protected $m_arStatusCode = array(
		-1 => 'Unhandled Request',
		0 => 'Queued',
		1 => 'Completed',
		2 => 'Completed, with error',
	);

	/**
	* Returns the job status code array
	* @returns array
	*/
	public function getStatusCodes() { return $this->m_arStatusCode; }

	/**
	* Returns the display name for a specific job status
	* @returns string
	*/
	public function getStatusText() { return PS::o( $this->m_arStatusCode, $this->proc_ind ); }

	/**
	* The display name for job types
	*
	* @var array
	*/
	protected $m_arJobType = array(
		self::SYS_WELCOME_EMAIL => 'Welcome Email',
		self::SYS_PASSWORD_RESET => 'Password Reset Request',
		self::SYS_NOTIFICATION_EMAIL => 'Notification',
		self::SYS_RESEND_VERIFY_EMAIL => 'Resent Verification Email',
		self::SYS_REMOVE_IMAGE => 'Remove Image',
		self::SYS_CLICK => 'Click',
		self::SYS_OX_PUBLISHER_SITE => 'Synchronize Publisher Site',
		self::SYS_USER_UPDATE => 'User Data Changed',
	);

	/**
	* Returns the job type array
	* @returns array
	*/
	public function getJobTypes() { return $this->m_arJobType; }

	/**
	* Gets the display name for this job
	* @return string
	*/
	public function getJobType() { return PS::o( $this->m_arJobType, $this->job_type_code ); }

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	* Returns the static model of the specified AR class.
	* @return CActiveRecord the static model class
	*/
	public static function model( $sClassName = __CLASS__ )
	{
		return parent::model( $sClassName );
	}

	/**
	* @return string the associated database table name
	*/
	public function tableName()
	{
		return self::getTablePrefix() . 'job_queue_t';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
		return array(
			array( 'job_name_text', 'length', 'max' => 30 ),
			array( 'job_name_text, job_type_code', 'required' ),
			array( 'job_type_code, proc_ind', 'numerical', 'integerOnly' => true ),
			array( 'id', 'required', 'on' => 'update' ),
		);
	}

	/**
	* @return array relational rules.
	*/
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'job_name_text' => 'Job Name',
			'job_type_code' => 'Job Type',
			'job_cmd_text' => 'Job Command',
			'proc_ind' => 'Processed Indicator',
			'statusText' => 'Status',
			'last_status_text' => 'Message',
			'server_name_text' => 'Server ID',
			'create_date' => 'Create Date',
			'lmod_date' => 'Modified Date',
		);
	}

	//********************************************************************************
	//* Named Scopes
	//********************************************************************************

	/**
	* Returns jobs with a matching target date
	* @returns JobQueue
	*/
	public function forDate( $sDate = null, $sFormat = 'Y-m-d' )
	{
		if ( $sDate )
		{
			$this->getDbCriteria()->mergeWith(
				array(
					'condition' => 'target_date = :target_date',
					'params' => array( ':target_date' => date( $sFormat, strtotime( PS::nvl( $sDate, date( $sFormat ) ) ) ) ),
				)
			);
		}

		return $this;
	}

	/**
	* Returns jobs with a matching creation date
	* @returns JobQueue
	*/
	public function fromDate( $sDate = null, $sFormat = 'Y-m-d' )
	{
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => 'date(create_date) = :start_date',
				'params' => array( ':start_date' => date( $sFormat, strtotime( PS::nvl( $sDate, date( $sFormat ) ) ) ) ),
			)
		);

		return $this;
	}

	/**
	* Returns jobs that have been created since date
	* @returns JobQueue
	*/
	public function since( $sDate = null, $sFormat = 'Y-m-d' )
	{
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => 'create_date >= str_to_date(:start_date)',
				'params' => array( ':start_date' => date( $sFormat, strtotime( PS::nvl( $sDate, date( $sFormat ) ) ) ) ),
			)
		);

		return $this;
	}

	/**
	* Returns jobs that have completed, optionally returns only successful jobs
	* @returns JobQueue
	*/
	public function completed( $bSuccessfulOnly = false )
	{
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => $bSuccessfulOnly ? 'proc_ind = 1' : 'proc_ind != 0',
			)
		);

		return $this;
	}

	/**
	* Returns jobs that are in progress
	* @returns JobQueue
	*/
	public function active()
	{
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => 'server_name_text is not null and end_date is null',
			)
		);

		return $this;
	}

	/**
	* Scope to return process-filtered jobs
	* @returns JobQueue
	*/
	public function processed( $iProcInd = 1 )
	{
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => 'proc_ind = :proc_ind',
				'params' => array( ':proc_ind' => $iProcInd ),
			)
		);

		return $this;
	}

	/**
	* Scope to return queued jobs
	* @returns JobQueue
	*/
	public function queued()
	{
		return $this->processed( 0 );
	}

	/**
	* Scope to get only data for a specific type of job
	* @param integer $eJobTypeCode
	* @returns JobQueue
	*/
	public function jobType( $eJobTypeCode )
	{
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => 'job_type_code = :job_type_code',
				'params' => array( ':job_type_code' => $eJobTypeCode ),
			)
		);

		return $this;
	}

	/**
	* Scope to get only data for a specific named job
	* @param string $sJobName
	* @returns JobQueue
	*/
	public function jobName( $sJobName )
	{
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => 'job_name_text = :job_name_text',
				'params' => array( ':job_name_text' => $sJobName ),
			)
		);

		return $this;
	}

	//********************************************************************************
	//* Statics
	//********************************************************************************

	/**
	* Queues up a job on the job queue
	* Can optionally not queue a job if exact job already exists in queue.
	*
	* @param int $iType The type of job
	* @param string $sName The name of the job
	* @param mixed $oData The optional data for the job
	* @param date $dtTarget The target date
	* @param boolean $bSkipDupes Won't duplicate an entry
	* @return boolean
	* @throws CDbException
	*/
	public static function queue( $iType, $sName, $oData = null, $dtTarget = null, $bSkipDupes = false )
	{
		//	Skipping dupes? Bail!
		if ( $bSkipDupes && JobQueue::model()->queued()->forDate( $dtTarget )->jobType( $iType )->jobName( $sName )->count( 'job_cmd_text = :job_cmd_text', array( ':job_cmd_text' => $oData ? serialize( $oData ) : null ) ) )
			return true;

		try
		{
			$_oJob = new JobQueue();
			$_oJob->job_type_code = $iType;
			$_oJob->job_name_text = $sName;
			$_oJob->target_date = $dtTarget;
			if ( $oData ) $_oJob->job_cmd_text = serialize( $oData );
			$_bResult = $_oJob->save();

			Yii::log( 'Queued job [' . $iType . ' -> ' . $sName . ']', 'trace', __METHOD__ );
		}
		catch ( Exception $_ex )
		{
			Yii::log( 'Error queueing job: ' . $_ex->getMessage(), 'error', 'JobQueue::queue' );
			throw $_ex;
		}

		return $_bResult;
	}

	public static function getRowsToProcess( $sServerId, $iLimit = null )
	{
		$_arJobs = null;

		$_arCrit = array(
			'condition' => 'server_name_text = :server_name_text and proc_ind = :proc_ind',
			'params' => array( ':server_name_text' => $sServerId, ':proc_ind' => 0 ),
		);

		if ( null !== $iLimit ) $_arCrit['limit'] = $iLimit;

		try
		{
			self::tagRows( $sServerId, $iLimit );
			$_arJobs = self::model()->findAll( $_arCrit );
		}
		catch ( Exception $_ex )
		{
			self::untagRows( $sServerId );
			CPSLog::error( 'Error [' . $_ex->getMessage() . '] while getting job queue rows.', __METHOD__ );
		}

		return $_arJobs;
	}

	protected static function tagRows( $sServerId, $iLimit = null )
	{
		CPSLog::trace( 'Tagging job queue rows', __METHOD__ );

		$_arCrit = array(
			'condition' => 'server_name_text is null and proc_ind = :proc_ind',
			'params' => array( ':proc_ind' => 0 ),
		);

		if ( null !== $iLimit ) $_arCrit['limit'] = $iLimit;

		$_iRows = self::model()->updateAll(
			array( 'server_name_text' => $sServerId ),
			$_arCrit
		);

		CPSLog::trace( 'Tagged ' . $_iRows . ' in job queue with serverId ' . $sServerId, __METHOD__ );

		return $_iRows;
	}

	protected static function untagRows( $sServerId )
	{
		CPSLog::trace( 'Untagging job queue rows', __METHOD__ );

		$_arCrit = array(
			'condition' => 'server_name_text = :server_name_text and proc_ind = :proc_ind',
			'params' => array( ':server_name_text' => $sServerId, ':proc_ind' => 0 ),
		);

		$_iRows = self::model()->updateAll(
			array( 'server_name_text' => null ),
			$_arCrit
		);

		CPSLog::trace( 'Untagged ' . $_iRows . ' in job queue with serverId ' . $sServerId, __METHOD__ );

		return $_iRows;
	}

}