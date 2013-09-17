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

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface
{
	/**
	 * 
	 * @param MvcEvent $event
	 */
	public function onBootstrap(MvcEvent $event) {
		$app = $event->getApplication();
		$em  = $app->getEventManager();
		$sm  = $app->getServiceManager();
		$em->attach($sm->get('CaSecurity/RequestListener'));
	}
	/* (non-PHPdoc)
	 * @see \Zend\ModuleManager\Feature\ConfigProviderInterface::getConfig()
	 */
	public function getConfig() {
		return array(
			'service_manager' => array(
				'invokables'  => array(
					'CaSecurity/RequestListener' => 'CaSecurity\RequestListener',
					'CaSecurity/RuleProvider' => 'CaSecurity\RuleProvider'
				),
				'factories' => array(
					'CaSecurity/Rules' => 'CaSecurity\RulesFactory'
				)
			)
		);
	}

	public function getAutoloaderConfig()
	{
		return array(
				'Ca\Loader\StandardToClassMapLoader' => array(
						'namespaces' => array(
								'CaSecurity' => __DIR__ . '/src',
						),
				),
		);
	}
}