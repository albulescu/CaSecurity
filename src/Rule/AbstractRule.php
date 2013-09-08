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

use Zend\Stdlib\AbstractOptions;
use Zend\Http\PhpEnvironment\Request;
use CaSecurity\Report;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManager;

abstract class AbstractRule extends AbstractOptions 
							implements EventManagerAwareInterface
{
	
	protected $eventManager;
	
	/**
	 * Verify the rule
	 * @param Request $request
	 */
	abstract public function verify( Request $request );
	
	/**
	 * Get rule name
	 */
	abstract public function getName();
	
	/* (non-PHPdoc)
	 * @see \Zend\EventManager\EventManagerAwareInterface::setEventManager()
	 */
	public function setEventManager(\Zend\EventManager\EventManagerInterface $eventManager) {
		$this->eventManager = $eventManager;	
	}

	/* (non-PHPdoc)
	 * @see \Zend\EventManager\EventsCapableInterface::getEventManager()
	 */
	public function getEventManager() {
		
		if(!$this->eventManager) {
			$this->eventManager = new EventManager();
		}
		
		return $this->eventManager;
	}

}