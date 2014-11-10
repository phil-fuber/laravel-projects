<?php

class DispatchControllerWithDI extends \BaseController {

	protected $dispatch;

	public function __construct(Dispatch $dispatch)
	{
	  $this->dispatch = $dispatch;
	}

	/**
	 * Store an array of dispatches to the database.
	 *
	 * @return Response
	 */
	public function store()
	{

		// verify content type HTTP header field
		if (! Request::isJson())
		{
			App::abort( 400, 'Content type is not JSON.');
		}
		
	    // store all dispatches, marking each with the same date

		$dispatchesIn = Request::json('dispatches');		
		$numDispatches = count($dispatchesIn);
		
		$date = date('Y-m-d');

		foreach($dispatchesIn as $dispatchIn)
		{						
			$this->dispatch->anId = $dispatchIn[0];
			$this->dispatch->message = $dispatchIn[1];
			$this->dispatch->date = $date;				
			$this->dispatch->rating = $dispatchIn[2];
			$this->dispatch->save();
		}
		
		// set response header fields
		$content = "Saved $numDispatches dispatches";
		$statusCode = 201;
		$response = Response::make($content, $statusCode);
		$response->header('Content-Type', ' text/plain; charset=UTF-8');
		
		return $response;
	}

}
