<?php

class ServersController extends BaseController
{
	public $_model;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
//			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ManagedServer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ManagedServer']))
		{
			$model->attributes=$_POST['ManagedServer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ManagedServer']))
		{
			$model->attributes=$_POST['ManagedServer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=ManagedServer::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='managed-server-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * blah
	 */
	public function actionIndex( $render = true )
	{
		//	Check for our post backs...
		if ( $this->isAjaxRequest )
		{
			if ( $_id = PS::o( $_POST, 'id' ) )
			{
				//	Do something
			}

			CPSLog::error( __METHOD__, 'Invalid request for id ' . $_id );
			return false;
		}

		$_page = PS::o( $_REQUEST, 'page', 1 );
		$_limit = PS::o( $_REQUEST, 'rows', 10 );
		$_sortColumn = PS::nvl( PS::o( $_REQUEST, 'sidx' ), 'create_date' );
		$_sortOrder = PS::o( $_REQUEST, 'sord', 'desc' );
		$_totalPages = 0;
		$_rows = $_results = $_condition = array();
		$_searchField = PS::o( $_REQUEST, 'searchField' );
		$_searchString = PS::o( $_REQUEST, 'searchString' );

		$_crit = new CDbCriteria(
			array(
				'order' => 't.' . $_sortColumn . ' ' . $_sortOrder,
			)
		);

		$_rows = array();

		if ( $_serverList = ManagedServer::model()->findAll( $_crit ) )
		{
			foreach ( $_serverList as $_server )
			{
				$_rows[] = array(
					'id' => $_server->id,
					'dev_url_text' => $_server->dev_url_text,
					'url_text' => $_server->url_text,
				);
			}
		}

		$_rowCount = count( $_rows );
		$_totalPages = ceil( $_rowCount / $_limit );
		if ( $_page > $_totalPages ) $_page = $_totalPages;
		$_start = $_limit * $_page - $_limit;

		if ( ! $render )
		{
			$this->layout = false;

			$_results = array(
				'page' => $_page,
				'total' => $_totalPages,
				'records' => $_rowCount,
				'rows' => $_rows,
			);

			echo json_encode( $_results );
			return;
		}

		$this->render( 'index',
			array(
				'data' => $_rows,
			)
		);
	}

}
