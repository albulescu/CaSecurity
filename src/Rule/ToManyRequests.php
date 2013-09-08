<?php
/**
 * Albulescu Cosmin ( http://www.albulescu.ro/ )
 *
 * @link      http://www.albulescu.ro/
 * @copyright Copyright (c) 2012 Albulescu Cosmin. (http://www.albulescu.com)
 * @license   http://www.albulescu.ro/new-bsd New BSD License
 * @autor Albulescu Cosmin <cosmin@albulescu.ro>
 */

namespace CaSecurity\Rule;

use CaSecurity\Exception;
use Zend\Http\PhpEnvironment\Request;

class ToManyRequests extends AbstractRule
{
	protected $maxRequests	= 50;
	
	protected $interval		= 60;
	
	protected $pattern		= '.*';
	
	
	/**
	 * @return the $maxRequests
	 */
	public function getMaxRequests() {
		return $this->maxRequests;
	}

	/**
	 * @return the $interval
	 */
	public function getInterval() {
		return $this->interval;
	}

	/**
	 * @return the $pattern
	 */
	public function getPattern() {
		return $this->pattern;
	}

	/**
	 * @param number $maxRequests
	 */
	public function setMaxRequests($maxRequests) {
		
		if(!is_numeric($maxRequests) || $maxRequests < 0) {
			throw new Exception("Invalid max request, only positive numbers accepted.");
		}
		
		$this->maxRequests = $maxRequests;
	}

	/**
	 * @param number $interval
	 */
	public function setInterval($interval) {
		
		if(!is_numeric($interval) || $interval < 0) {
			throw new Exception("Invalid requests interval, only positive numbers accepted.");
		}
		
		$this->interval = $interval;
	}

	/**
	 * @param string $pattern
	 */
	public function setPattern($pattern) {
		$this->pattern = $pattern;
	}

	/* (non-PHPdoc)
	 * @see \CaSecurity\Rule\AbstractRule::verify()
	 */
	public function verify(Request $request) {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \CaSecurity\Rule\AbstractRule::getName()
	 */
	public function getName() {
		return 'to_many_requests';
	}
}