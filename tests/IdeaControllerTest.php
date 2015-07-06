<?php

class IdeaControllerTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->ideaController = new App\IdeaController;
	}

	public function testIdeaControllerCanBeInstantiated() {
		$this->assertInstanceOf('App\IdeaController', $this->ideaController);
	}

}
