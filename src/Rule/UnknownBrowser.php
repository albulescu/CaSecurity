<?php
/**
 * Albulescu Cosmin ( http://www.albulescu.com/ )
*
* @link      http://www.albulescu.com/
* @copyright Copyright (c) 2012 Albulescu Cosmin. (http://www.albulescu.com)
* @license   http://www.albulescu.ro/new-bsd New BSD License
* @autor Albulescu Cosmin <cosmin@albulescu.ro>
*/

namespace CaSecurity\Rule;

class UnknownBrowser extends AbstractRule
{
	protected $browserPatterns = array(
		".*Chrome.*",
		".*Firefox.*",
		".*IE.*",
		".*Safari.*",
	);
	
	protected $userPatterns = array();
	

	/**
	 * @return the $userPatterns
	 */
	public function getUserPatterns() {
		return $this->userPatterns;
	}

	/**
	 * @param multitype: $userPatterns
	 */
	public function setUserPatterns($userPatterns) {
		$this->userPatterns = $userPatterns;
	}

	/* (non-PHPdoc)
	 * @see \CaSecurity\Rule\AbstractRule::verify()
	 */
	public function verify(\Zend\Http\PhpEnvironment\Request $request) {
		$userAgent = $request->getHeader('useragent', false)->getFieldValue();
		$patterns = array_merge($this->browserPatterns, $this->userPatterns);

		foreach($patterns as $pattern) {
			if(!preg_match("/".$pattern."/", $userAgent)) {
				$event = new Event();
				$event->setName(Event::EVENT_REPORT);
				$event->setTarget($this);
				$event->setParam('message', "Invalid user agent '".$userAgent."'");
				$this->getEventManager()->trigger($event);
				break;
			}
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \CaSecurity\Rule\AbstractRule::getName()
	 */
	public function getName() {
		return 'unknown_browser';
	}
}