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

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use CaSecurity\Rules;

class RulesFactory implements FactoryInterface
{
	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(ServiceLocatorInterface $services) {
		
		$rules = new Rules();
		
		//create reporter listener
		$reporter = new ReportListener();
		$reporter->setServiceLocator($services);
		
		//attach the reporter listener to the rules em
		$rules->getEventManager()->attach($reporter);
		
		$config	= $services->get('Config');
		
		if(isset($config['CaSecurity'])) {
			
			$config = $config['CaSecurity'];
			
			if(isset($config['rules']) && is_array($config['rules']))
			{
				$ruleProvider = $services->get('CaSecurity/RuleProvider');
				
				foreach($config['rules'] as $rule => $rule_options)
				{
					if(is_numeric($rule)) {
						$rule = $rule_options;
						$rule_options = array();
					}
					
					if(!$ruleProvider->has($rule)) {
						throw new Exception(sprintf(
								"Invalid rule '%s'",
								$rule
						));
					}
					
					$rule = $ruleProvider->get($rule);
					$rule->setFromArray($rule_options);
					
					$rules->addRule($rule);
				}
			}
		}
		
		return $rules;
	}
}