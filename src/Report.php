<?php
/**
 * Albulescu Cosmin ( http://www.albulescu.ro/ )
 *
 * @link      http://www.albulescu.ro/
 * @copyright Copyright (c) 2012 Albulescu Cosmin. (http://www.albulescu.com)
 * @license   http://www.albulescu.ro/new-bsd New BSD License
 * @autor Albulescu Cosmin <cosmin@albulescu.ro>
 */

namespace CaSecurity;

use Zend\Http\PhpEnvironment\Request;

class Report
{
	protected $message;
	
	protected $request;
	
	public function __construct( $message, Request $request = null)
	{
		if(!$request) {
			$request = new Request();
		}
		
		$this->message = $message;
		$this->request = $request;
	}
}