<?php

class grupo_categorias_tiposTest extends WebTestCase
{
	public $fixtures=array(
		'grupo_categorias_tiposes'=>'grupo_categorias_tipos',
	);

	public function testShow()
	{
		$this->open('?r=grupo_categorias_tipos/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=grupo_categorias_tipos/create');
	}

	public function testUpdate()
	{
		$this->open('?r=grupo_categorias_tipos/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=grupo_categorias_tipos/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=grupo_categorias_tipos/index');
	}

	public function testAdmin()
	{
		$this->open('?r=grupo_categorias_tipos/admin');
	}
}
