<?php 
namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\LimitVisit;

class LimitVisitTest extends TestCase
{
	/*public function testNbVisitFalse()
	{
		$LimitVisit = new LimitVisit;
		$result = $LimitVisit->nbVisit(999, 1);
		
		 $this->assertEquals(false,$result);
	}*/

	public function testNbVisitfTrue()
	{
		$LimitVisit = new LimitVisit;
		$result = $LimitVisit->nbVisit(1000, 2);
		
		 $this->assertEquals(true,$result);
	}


}