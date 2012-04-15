<?php

class cidadesTest extends WebTestCase
{
	public $fixtures=array(
		'cidades'=>'cidades',
	);

	public function testShow()
	{
		$this->open('?r=cidades/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=cidades/create');
	}

	public function testUpdate()
	{
		$this->open('?r=cidades/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=cidades/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=cidades/index');
	}

	public function testAdmin()
	{
		$this->open('?r=cidades/admin');
	}
}
