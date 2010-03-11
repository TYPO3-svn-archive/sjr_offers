<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * A repository for Offers
 */
class Tx_SjrOffers_Domain_Repository_OfferRepository extends Tx_Extbase_Persistence_Repository {
	
	/**
	 * Finds all offers that meets the specified demand.
	 *
	 * @param Tx_SjrOffers_Domain_Model_Demand $demand 
	 * @param array $propertiesToSearch A array of properties to be searched for occurrances of the search word
	 * @return array Matched offers
	 */
	public function findOffersMeetingTheDemand(Tx_SjrOffers_Domain_Model_Demand $demand, array $propertiesToSearch = array()) {
		$query = $this->createQuery();
		$constraints = array();
		if ($demand->getRegion() !== NULL) {
			$constraints[] = $query->contains('regions', $demand->getRegion());
		}
		if ($demand->getCategory() !== NULL) {
			$constraints[] = $query->contains('categories', $demand->getCategory());
		}
		if ($demand->getOrganization() !== NULL) {
			$constraints[] = $query->equals('organization', $demand->getOrganization());
		}
		if (is_string($demand->getSearchWord()) && strlen($demand->getSearchWord()) > 0) {
			$searchWordConstraints = array();
			foreach ($propertiesToSearch as $propertyName) {
				$searchWordConstraints[] = $query->like($propertyName, '%' . $demand->getSearchWord() . '%');
			}
			$constraints[] = $query->implodeOr($searchWordConstraints);
		}
		if ($demand->getAge() !== NULL) {
			$constraints[] = $query->logicalAnd(
				$query->logicalOr($query->equals('ageRange.minimumValue', NULL), $query->lessThanOrEqual('ageRange.minimumValue', $demand->getAge())),
				$query->logicalOr($query->equals('ageRange.maximumValue', NULL), $query->greaterThanOrEqual('ageRange.maximumValue', $demand->getAge()))
				);
		}
		$query->matching($query->implodeAnd($constraints));
		$query->setOrderings(array('organization' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));		
		return $query->execute();
	}
			
}
?>