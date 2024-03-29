<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Jochen Rau <jochen.rau@typoplanet.de>
*  All rights reserved
*
*  This class is a backport of the corresponding class of FLOW3. 
*  All credits go to the v5 team.
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
 * Validator for Range Constraints.
 *
 * @package sjr_offers
 * @scope prototype
 */
class Tx_SjrOffers_Domain_Validator_RangeConstraintValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {

	/**
	 * Checks if  the minimum value is not greater than the maximum value.
	 *
	 * @param object $value The range object to be validated
	 * @return boolean TRUE if the property value is valid, FALSE if an error occured
	 */
	public function isValid($value) {
		$this->errors = array();
		if ($value instanceof Tx_SjrOffers_Domain_Model_RangeConstraint) {
			$minimumValue = $value->getMinimumValue();
			$maximumValue = $value->getMaximumValue();
			if ($maximumValue !== NULL && $minimumValue !== NULL) {
				if ($minimumValue > $maximumValue) {
					$this->addError('Das Minimum darf nicht größer sein als das Maximum.', 1265622568);
					return FALSE;
				}
			}
		}
		return TRUE;
	}	

}

?>