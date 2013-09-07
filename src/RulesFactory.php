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
		
		$configuration	= $services->get('Config');
		
		if(isset($configuration['CaSecurity']) && is_array($configuration['CaSecurity'])) {
			
			$ruleProvider = $services->get('CaSecurity/RuleProvider');
			
			foreach($configuration['CaSecurity'] as $rule => $rule_options)
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
		
		return $rules;
	}
}