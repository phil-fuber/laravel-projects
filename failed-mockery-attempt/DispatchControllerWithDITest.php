<?php

class DispatchControllerWithDITest extends TestCase
{	
	protected $mock;

	
	public function setUp()
	{
		parent::setUp();

		$this->mock = Mockery::mock('Dispatch');

		$this->app->instance('Dispatch', $this->mock);
	}		  
	
	public function tearDown()
	{
		Mockery::close();
	}

	/**
     * Verify controller functionality for valid input.
     *
     * Side effect: inserts values into the database.
	 */
	public function testValidDispatchStore()
	{
		
		$this->mock->shouldReceive('save');
		 
		// default is application/x-www-form-urlencoded
		$contentType = array('CONTENT_TYPE' => 'application/json');

		$postData = array(		   
		   'dispatches' => 
		  array(
		    0 => 
		    array(
		      0 => 'id_1',
		      1 => 'thisisamessage',
		      2 => 60,
		    ),
		    1 => 
		    array(
		      0 => 'id_2',
		      1 => 'thisisanothermessage',
		      2 => 30,
		    ),
		  ),
		);

		
		$response = $this->call(
			'POST', 'dispatch',
			array(), array(), $contentType,
			json_encode($postData)
		);

		$this->assertResponseStatus(201);
	}
}