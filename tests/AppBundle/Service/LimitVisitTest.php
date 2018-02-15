<?php 
namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\LimitVisit;

class LimitVisitTest extends TestCase
{
	public function testAgeVisitorfFalse()
	{
		$LimitVisit = new LimitVisit;
		$result = $LimitVisit->nbVisit(1000);
		
		 $this->assertEquals(false,$result);
	}

	public function testAgeVisitorfTrue()
	{
		$LimitVisit = new LimitVisit;
		$result = $LimitVisit->nbVisit(1001);
		
		 $this->assertEquals(true,$result);
	}


}