<?php

class ManagedServerTest extends WebTestCase
{
	public $fixtures=array(
		'managedServers'=>'ManagedServer',
	);

	public function testShow()
	{
		$this->open('?r=servers/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=servers/create');
	}

	public function testUpdate()
	{
		$this->open('?r=servers/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=servers/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=servers/index');
	}

	public function testAdmin()
	{
		$this->open('?r=servers/admin');
	}
}
