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
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Testcase for the Offer Repository class
 */
class Tx_SjrOffers_Domain_Repository_OfferRepositoryTest extends Tx_Extbase_BaseTestCase {
	
	/**
	 * @test
	 */
	public function allOffersMeetingTheDemandCanBeFound() {
		$mockDemand = $this->getMock('Tx_SjrOffers_Domain_Model_Demand');
		$mockOffer = $this->getMock('Tx_SjrOffers_Domain_Model_Offer');

		$mockQuery = $this->getMock('Tx_Extbase_PersistenceQuery', array('execute', 'setOrderings'), array(), '', FALSE);
		$mockQuery
			->expects($this->once())
			->method('execute')
			->will($this->returnValue(array($mockOffer)));

		$mockOfferRepository = $this->getMock('Tx_SjrOffers_Domain_Repository_OfferRepository', array('createQuery', 'offerMeetsDemand'), array(), '', FALSE);
		$mockOfferRepository
			->expects($this->once())
			->method('createQuery')
			->will($this->returnValue($mockQuery));
		$mockOfferRepository
			->expects($this->once())->method('offerMeetsDemand')
			->with($this->isInstanceOf(get_class($mockOffer)), $this->isInstanceOf(get_class($mockDemand)))
			->will($this->returnValue(TRUE));
		$result = $mockOfferRepository->findOffersMeetingTheDemand($mockDemand);
		$this->assertEquals(array($mockOffer), $result);
	}

	/**
	 * @test
	 */
	public function offersNotMeetingTheDemandAreExcludedFromTheResult() {
		$mockDemand = $this->getMock('Tx_SjrOffers_Domain_Model_Demand');
		$mockOffer = $this->getMock('Tx_SjrOffers_Domain_Model_Offer');

		$mockQuery = $this->getMock('Tx_Extbase_PersistenceQuery', array('execute', 'setOrderings'), array(), '', FALSE);
		$mockQuery
			->expects($this->once())
			->method('execute')
			->will($this->returnValue(array($mockOffer)));

		$mockOfferRepository = $this->getMock('Tx_SjrOffers_Domain_Repository_OfferRepository', array('createQuery', 'offerMeetsDemand'), array(), '', FALSE);
		$mockOfferRepository
			->expects($this->once())
			->method('createQuery')
			->will($this->returnValue($mockQuery));
		$mockOfferRepository
			->expects($this->once())->method('offerMeetsDemand')
			->with($this->isInstanceOf(get_class($mockOffer)), $this->isInstanceOf(get_class($mockDemand)))
			->will($this->returnValue(FALSE));
		$result = $mockOfferRepository->findOffersMeetingTheDemand($mockDemand);
		$this->assertFalse(in_array($mockOffer, $result));
	}
	
	/**
	 * This is the data provider for constraint test results
	 *
	 * @return array An array of test results
	 */
	public function provideConstraintTestResults() {
		return array(
			array(TRUE, TRUE,  TRUE, TRUE, TRUE),
			array(TRUE, FALSE, TRUE, TRUE, FALSE),
			array(TRUE, FALSE, FALSE, TRUE, FALSE),
			array(TRUE, FALSE, TRUE, FALSE, FALSE),
			array(TRUE, TRUE, FALSE, TRUE, FALSE),
			array(TRUE, TRUE, FALSE, FALSE, FALSE),
			array(TRUE, TRUE, TRUE, FALSE, FALSE),
			array(TRUE, FALSE, FALSE, FALSE, FALSE),
			array(FALSE, TRUE,	TRUE, TRUE, FALSE),
			array(FALSE, FALSE, TRUE, TRUE, FALSE),
			array(FALSE, FALSE, FALSE, TRUE, FALSE),
			array(FALSE, FALSE, TRUE, FALSE, FALSE),
			array(FALSE, TRUE, FALSE, TRUE, FALSE),
			array(FALSE, TRUE, FALSE, FALSE, FALSE),
			array(FALSE, TRUE, TRUE, FALSE, FALSE),
			array(FALSE, FALSE, FALSE, FALSE, FALSE),
			);
	}
	
	/**
	 * @test
	 * @dataProvider provideConstraintTestResults
	 */
	public function theTestIfOfferMeetsDemandReturnsExpectedResult($searchWordResult, $ageIsInRangeResult, $offerIsAssignedToTheDemandedCategoryResult, $offerIsAvailableInTheDemandedRegionResult, $expectedFinalResult) {
		$mockObjectStorage = $this->getMock('Tx_Extbase_Persistence_ObjectStorage');
		$mockAgeRange = $this->getMock('Tx_SjrOffers_Domain_Model_AgeRange');
		$mockCategory = $this->getMock('Tx_SjrOffers_Domain_Model_Category');		
		$mockRegion = $this->getMock('Tx_SjrOffers_Domain_Model_Region');
		$mockOrganization = $this->getMock('Tx_SjrOffers_Domain_Model_Organization');

		$mockDemand = $this->getMock('Tx_SjrOffers_Domain_Model_Demand');
		$mockDemand->expects($this->any())->method('getSearchWord')->will($this->returnValue('word'));
		$mockDemand->expects($this->any())->method('getAge')->will($this->returnValue(5));
		$mockDemand->expects($this->any())->method('getCategory')->will($this->returnValue($mockCategory));
		$mockDemand->expects($this->any())->method('getRegion')->will($this->returnValue($mockRegion));

		$mockOffer = $this->getMock('Tx_SjrOffers_Domain_Model_Offer');
		$mockOffer->expects($this->any())->method('getAgeRange')->will($this->returnValue($mockAgeRange));
		$mockOffer->expects($this->any())->method('getCategories')->will($this->returnValue($mockObjectStorage));
		$mockOffer->expects($this->any())->method('getRegions')->will($this->returnValue($mockObjectStorage));
		$mockOffer->expects($this->any())->method('getOrganization')->will($this->returnValue($mockOrganization));
		
		$mockOfferRepository = $this->getMock($this->buildAccessibleProxy('Tx_SjrOffers_Domain_Repository_OfferRepository'), array('containsSearchWord', 'ageIsInRange', 'offerIsAssignedToTheDemandedCategory', 'offerIsAvailableInTheDemandedRegion'), array(), '', FALSE);
		$mockOfferRepository
			->expects($this->any())
			->method('containsSearchWord')
			->will($this->returnValue($searchWordResult));
		$mockOfferRepository
			->expects($this->any())
			->method('ageIsInRange')
			->will($this->returnValue($ageIsInRangeResult));
		$mockOfferRepository
			->expects($this->any())
			->method('offerIsAssignedToTheDemandedCategory')
			->will($this->returnValue($offerIsAssignedToTheDemandedCategoryResult));
		$mockOfferRepository
			->expects($this->any())
			->method('offerIsAvailableInTheDemandedRegion')
			->will($this->returnValue($offerIsAvailableInTheDemandedRegionResult));
		$mockOfferRepository
			->expects($this->any())
			->method('offerIsAssignedToTheDemandedOrganization')
			->will($this->returnValue(TRUE));

		$this->assertSame($expectedFinalResult, $mockOfferRepository->_call('offerMeetsDemand', $mockOffer, $mockDemand));
	}
	
	/**
	 * @test
	 */
	public function theTestIfTheValuesOfTheGivenPropertiesContainsTheSearchWordReturnsAlwaysTrueForEmptySearchWord() {
		$mockOffer = $this->getMock('Tx_SjrOffers_Domain_Model_Offer');
		$mockOffer->expects($this->never())->method('getTitle')->will($this->returnValue('The title with a word.'));
		
		$mockOfferRepository = $this->getMock($this->buildAccessibleProxy('Tx_SjrOffers_Domain_Repository_OfferRepository'), array('dummy'), array(), '', FALSE);

		$this->assertTrue($mockOfferRepository->_call('containsSearchWord', '', $mockOffer, 'title'));
	}

	
	/**
	 * @test
	 */
	public function theTestIfTheValuesOfTheGivenPropertiesContainsTheSearchWordReturnsExpectedResult() {
		$mockOffer = $this->getMock('Tx_SjrOffers_Domain_Model_Offer');
		$mockOffer->expects($this->any())->method('getTitle')->will($this->returnValue('The title with a word.'));
		
		$mockOfferRepository = $this->getMock($this->buildAccessibleProxy('Tx_SjrOffers_Domain_Repository_OfferRepository'), array('dummy'), array(), '', FALSE);

		$this->assertTrue($mockOfferRepository->_call('containsSearchWord', 'word', $mockOffer, 'title'));
		$this->assertTrue($mockOfferRepository->_call('containsSearchWord', 'The', $mockOffer, 'title'));
		$this->assertFalse($mockOfferRepository->_call('containsSearchWord', 'foo', $mockOffer, 'title'));
	}

	/**
	 * This is the data provider for minimum and maximum values with an actual age
	 *
	 * @return array An array of values (minimum value, maximum value, actual age, expected result)
	 */
	public function providerForMinMaxValuesWithAge() {
		return array(
			'4, 6, 5, TRUE' => array(4, 6, 5, TRUE),
			'4, 6, 4, TRUE' => array(4, 6, 4, TRUE),
			'4, 6, 6, TRUE' => array(4, 6, 6, TRUE),
			'4, 6, 3, FALSE' => array(4, 6, 3, FALSE),
			'4, 6, 7, FALSE' => array(4, 6, 7, FALSE),
			'4, 4, 4, TRUE' => array(4, 4, 4, TRUE),
			'4, 4, 3, FALSE' => array(4, 4, 3, FALSE),
			'4, 4, 4, TRUE' => array(4, 4, 4, TRUE),
			'4, 0, 7, TRUE' => array(4, 0, 7, TRUE),
			'4, 0, 3, FALSE' => array(4, 0, 3, FALSE),
			'0, 6, 3, TRUE' => array(0, 6, 3, TRUE),
			'0, 6, 7, TRUE' => array(0, 6, 7, FALSE),
			'0, 0, 7, TRUE' => array(0, 0, 7, TRUE),
			);
	}
		
	/**
	 * @test
	 * @dataProvider providerForMinMaxValuesWithAge
	 */
	public function theTestIfTheAgeIsInRangeReturnsExpectedResult($minimumValue, $maximumValue, $age, $expectedResult) {
		$mockAgeRange = $this->getMock('Tx_SjrOffers_Domain_Model_AgeRange');
		$mockAgeRange->expects($this->any())->method('getMinimumValue')->will($this->returnValue($minimumValue));
		$mockAgeRange->expects($this->any())->method('getMaximumValue')->will($this->returnValue($maximumValue));
		
		$mockOfferRepository = $this->getMock($this->buildAccessibleProxy('Tx_SjrOffers_Domain_Repository_OfferRepository'), array('dummy'), array(), '', FALSE);

		$this->assertSame($expectedResult, $mockOfferRepository->_call('ageIsInRange', $age, $mockAgeRange));
	}
		
}
?>