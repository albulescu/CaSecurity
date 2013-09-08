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

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReportListener implements ListenerAggregateInterface, ServiceLocatorAwareInterface
{
	protected $listener;
	
	protected $services;
	
	/**
	 * Report
	 * @param Event $event
	 */
	public function onReport(Event $event) {
		
		if($event->propagationIsStopped()) {
			return;
		}
		
		var_dump($event->getParam('message'));exit;
	}
	
	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::getServiceLocator()
	 */
	public function getServiceLocator() {
		return $this->services;
	}

	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\ServiceLocatorAwareInterface::setServiceLocator()
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->services = $serviceLocator;
	}

	/* (non-PHPdoc)
	 * @see \Zend\EventManager\ListenerAggregateInterface::attach()
	 */
	public function attach(EventManagerInterface $events) {
		$this->listener = $events->attach(Event::EVENT_REPORT, array($this,'onReport'));
	}

	/* (non-PHPdoc)
	 * @see \Zend\EventManager\ListenerAggregateInterface::detach()
	 */
	public function detach(EventManagerInterface $events) {
		$events->detach($this->listener);
	}
}