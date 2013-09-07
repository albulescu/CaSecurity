<?php
/**
 * Albulescu Cosmin ( http://www.albulescu.com/ )
*
* @link      http://www.albulescu.com/
* @copyright Copyright (c) 2012 Albulescu Cosmin. (http://www.albulescu.com)
* @license   http://www.albulescu.ro/new-bsd New BSD License
* @autor Albulescu Cosmin <cosmin@albulescu.ro>
*/

namespace CaSecurity;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

class RequestListener implements ListenerAggregateInterface
{
	protected $listeners;

	public function onDispatch(MvcEvent $event) {
		$sm = $event->getApplication()->getServiceManager();
		$sm->get('CaSecurity/Rules')->check();
	}
	
	/* (non-PHPdoc)
	 * @see \Zend\EventManager\ListenerAggregateInterface::attach()
	 */
	public function attach(\Zend\EventManager\EventManagerInterface $events) {
		$this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this,'onDispatch'));	
	}

	/* (non-PHPdoc)
	 * @see \Zend\EventManager\ListenerAggregateInterface::detach()
	 */
	public function detach(\Zend\EventManager\EventManagerInterface $events) {
		
		foreach($this->listeners as $listener) {
			$events->detach($listener);
		}
	}
}