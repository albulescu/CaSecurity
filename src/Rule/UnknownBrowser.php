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

use CaSecurity\Event;

class UnknownBrowser extends AbstractRule
{
	protected $defaultPatterns = array(
		'chrome',
		'firefox',
		'msie',
		'safari',
		'opera',
		'netscape',
		'seamonkey',
		'konqueror',
		'gecko',
		'navigator',
		'mosaic',
		'lynx',
		'amaya',
		'omniweb'
	);
	
	protected $patterns = array();
	

	/**
	 * @return the $userPatterns
	 */
	public function getPatterns() {
		return $this->userPatterns;
	}

	/**
	 * @param multitype: $userPatterns
	 */
	public function setPatterns($patterns) {
		$this->patterns = $patterns;
	}

	/* (non-PHPdoc)
	 * @see \CaSecurity\Rule\AbstractRule::verify()
	 */
	public function verify(\Zend\Http\PhpEnvironment\Request $request) {
		
	    $userAgent = 'Unknown';
		$userAgentHeader = $request->getHeader('useragent', false);
		
		if( $userAgentHeader ) {
		  $userAgent = $userAgentHeader->getFieldValue();
		}
		
		$patterns = array_merge($this->defaultPatterns, $this->patterns);

		foreach($patterns as $pattern) {
			if(strpos(strtolower($userAgent), $pattern) !== false) {
				return;
			}
		}
		
		$event = new Event();
		$event->setName(Event::EVENT_REPORT);
		$event->setTarget($this);
		$event->setParam('message', "Invalid user agent '".$userAgent."'");
		$event->setParam('request', $request);
		$this->getEventManager()->trigger($event);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \CaSecurity\Rule\AbstractRule::getName()
	 */
	public function getName() {
		return strtolower(get_class($this));
	}
}