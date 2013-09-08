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

use CaSecurity\Rule\AbstractRule;
use Zend\EventManager\EventManager;
use CaSecurity\Event;
use Zend\Http\PhpEnvironment\Request;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

class Rules implements EventManagerAwareInterface
{
	protected $request;
	
	protected $rules = array();
	
	protected $eventManager;
	
	/* (non-PHPdoc)
	 * @see \Zend\EventManager\EventManagerAwareInterface::setEventManager()
	 */
	public function setEventManager(EventManagerInterface $eventManager) {
		$this->eventManager = $eventManager;
	}

	/* (non-PHPdoc)
	 * @see \Zend\EventManager\EventsCapableInterface::getEventManager()
	 */
	public function getEventManager() {
		
		if(!$this->eventManager) {
			$this->setEventManager(new EventManager());
		}
		
		return $this->eventManager;
	}

	/**
	 * @return the $request
	 */
	public function getRequest() {
		
		if(!$this->request) {
			$this->request = new Request();
		}
		
		return $this->request;
	}
	
	/**
	 * @param Request $request
	 */
	public function setRequest( Request $request) {
		$this->request = $request;
	}
	
	/**
	 * Add a rule to rules aggregate checker
	 * @param AbstractRule $rule
	 */
	public function addRule(AbstractRule $rule)
	{
		$rule->setEventManager($this->getEventManager());
		$this->rules[] = $rule;
	}
	
	/**
	 * Check all rules
	 */
	public function check()
	{
		foreach($this->rules as $rule)
		{
			$verifySkipped = false;
			
			$event = new Event();
			$event->setName(Event::EVENT_VERIFY);
			$event->setTarget($rule);
			
			$this->getEventManager()->trigger($event, function($data) use (&$verifySkipped){
				$verifySkipped = $data;
			});
			
			if($verifySkipped) {
				$event = new Event();
				$event->setName(Event::EVENT_VERIFY_SKIPPED);
				$event->setTarget($rule);
				$this->getEventManager()->trigger($event);
				continue;
			}
		
			$rule->verify($this->getRequest());
		}
	}
}