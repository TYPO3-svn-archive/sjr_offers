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
	 * @param string $propertiesToSearch A comma separated list of properties to be searched for occurrances of the search word
	 * @return array Matched offers
	 */
	public function findOffersMeetingTheDemand(Tx_SjrOffers_Domain_Model_Demand $demand = NULL, $propertiesToSearch) {
		$query = $this->createQuery();
		$query->setOrderings(array('organization' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
		$offers = $query->execute();
		
		if (!is_null($demand)) {
			$filteredOffers = array();
			foreach ($offers as $offer) {
				if ($this->offerMeetsDemand($offer, $demand, $propertiesToSearch)) $filteredOffers[] = $offer;
			}
			$offers = $filteredOffers;
		}

		return $offers;
	}
	
	/**
	 * Tests if a given offer meets the specified demand.
	 *
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer
	 * @param Tx_SjrOffers_Domain_Model_Demand $demand The demand
	 * @param string $propertiesToSearch A comma separated list of properties to be searched for occurrances of the search word
	 * @return bool TRUE if the offer meets the demand, otherwise FALSE 
	 */
	protected function offerMeetsDemand(Tx_SjrOffers_Domain_Model_Offer $offer, Tx_SjrOffers_Domain_Model_Demand $demand, $propertiesToSearch) {
		$result = $this->containsSearchWord($demand->getSearchWord(), $offer, $propertiesToSearch)
			&& $this->ageIsInRange($demand->getAge(), $offer->getAgeRange())
			&& $this->offerIsAssignedToTheDemandedCategory($demand->getCategory(), $offer->getCategories())
			&& $this->offerIsAvailableInTheDemandedRegion($demand->getRegion(), $offer->getRegions())
			&& $this->offerIsAssignedToTheDemandedOrganization($demand->getOrganization(), $offer->getOrganization());
		return $result;
	}
	
	/**
	 * Test, if the given search word is in the age range of the offer
	 *
	 * @param string $searchWord The search word
	 * @param Tx_SjrOffers_Domain_Model_Offer $offer The offer
	 * @param string $propertiesToSearch A comma separated list of properties to be searched for occurrances of the search word
	 * @return bool TRUE, if the search word was found, otherwise FALSE
	 */
	protected function containsSearchWord($searchWord, $offer, $propertiesToSearch) {
		if (empty($searchWord)) return TRUE;
		$result = FALSE;
		foreach (t3lib_div::trimExplode(',', $propertiesToSearch) as $propertyName) {
			$propertyValue = Tx_Extbase_Reflection_ObjectAccess::getProperty($offer, $propertyName);
			if (stripos($propertyValue, $searchWord) !== FALSE) return TRUE;
		}
		return $result;
	}
	
	/**
	 * Test, if the given age is in the age range of the offer
	 *
	 * @param string $age The demanded age
	 * @param string $ageRange The age range of the offer
	 * @return bool TRUE, if the age is in the age range of the offer, otherwise FALSE
	 */
	protected function ageIsInRange($age, $ageRange) {
		$result = TRUE;
		if (!empty($age) && $ageRange instanceof Tx_SjrOffers_Domain_Model_AgeRange) {
			$minimumValue = (int)$ageRange->getMinimumValue();
			$maximumValue = (int)$ageRange->getMaximumValue() !== 0 ? (int)$ageRange->getMaximumValue() : 999;
			$result = ($age >= $minimumValue) && ($age <= $maximumValue);
		}
		return $result;
	}
	
	/**
	 * Test, if the offer is assigned to the demanded category
	 *
	 * @param Tx_SjrOffers_Domain_Model_Category $demandedCategory The demanded category
	 * @param Tx_Extbase_Persistence_ObjectStorage $offeredCategories The categories the offer is assigned to
	 * @return bool TRUE, if the offer is assigned to the demanded category, otherwise FALSE
	 */
	protected function offerIsAssignedToTheDemandedCategory(Tx_SjrOffers_Domain_Model_Category $demandedCategory = NULL, Tx_Extbase_Persistence_ObjectStorage $offeredCategories) {
		return $demandedCategory !== NULL ? $offeredCategories->contains($demandedCategory) : TRUE;
	}
	
	/**
	 * Test, if the offer is available in the demanded region
	 *
	 * @param Tx_SjrOffers_Domain_Model_Region $demandedRegion The demanded region
	 * @param Tx_Extbase_Persistence_ObjectStorage $offeredRegions The offered regions
	 * @return bool TRUE, if the offer is available in the demanded region, otherwise FALSE
	 */
	protected function offerIsAvailableInTheDemandedRegion(Tx_SjrOffers_Domain_Model_Region $demandedRegion = NULL, Tx_Extbase_Persistence_ObjectStorage $offeredRegions) {
		return $demandedRegion !== NULL ? $offeredRegions->contains($demandedRegion) : TRUE;
	}
	
	/**
	 * Test, if the offer is assigned to the demanded organization
	 *
	 * @param Tx_SjrOffers_Domain_Model_Organization $demandedOrganization The demanded organiztation
	 * @param Tx_SjrOffers_Domain_Model_Organization $organization The organization the offer belongs to
	 * @return bool TRUE, if the offer is assigned to teh demanded organization, otherwise FALSE
	 */
	protected function offerIsAssignedToTheDemandedOrganization(Tx_SjrOffers_Domain_Model_Organization $demandedOrganization = NULL, Tx_SjrOffers_Domain_Model_Organization $organization) {
		return $demandedOrganization === NULL ? TRUE : $demandedOrganization === $organization;
	}
		
}
?>