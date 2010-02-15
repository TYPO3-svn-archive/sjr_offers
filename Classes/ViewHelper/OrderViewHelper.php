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
 * View helper for ordering subjects.
 */
class Tx_SjrOffers_ViewHelper_OrderViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Render the supplied range as formatted string
	 *
	 * @param array $subjects An array with subjects to be sorted
	 * @param string $property The property (path) to sort by
	 * @return 
	 */
	public function render($subjects, $propertyPath) {
		if ($subjects instanceof Tx_Extbase_Persistence_ObjectStorage) {
			$subjects = $subjects->toArray();
		}
		$this->propertyPath = $propertyPath;
		uasort($subjects, array($this, 'sortSubjects'));
		return $subjects;
	}
	
	/**
	 * A callback method to sort subjects
	 *
	 * @param string $subject1 The first subject to be compared with the second subject
	 * @param string $subject2 The second subject to be compared with the first subject
	 * @return void
	 */
	protected function sortSubjects($subject1, $subject2) {
		$propertyValue1 = Tx_Extbase_Reflection_ObjectAccess::getPropertyPath($subject1, $this->propertyPath);
		if ($propertyValue1 instanceof DateTime) {
			$propertyValue1 = $propertyValue1->format('U');
		} else {
			$propertyValue1 = 0;
		}
		$propertyValue2 = Tx_Extbase_Reflection_ObjectAccess::getPropertyPath($subject2, $this->propertyPath);
		if ($propertyValue2 instanceof DateTime) {
			$propertyValue2 = $propertyValue2->format('U');
		} else {
			$propertyValue2 = 0;
		}
		if ($propertyValue1 === $propertyValue2) return 0;
		return $propertyValue1 < $propertyValue2 ? -1 : 1;
	}
}
?>