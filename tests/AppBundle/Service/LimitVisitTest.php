<?php 
namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\LimitVisit;

class LimitVisitTest extends TestCase
{

	public function testNbVisitfTrue()
	{
		$LimitVisit = new LimitVisit;
		$result = $LimitVisit->nbVisit(1000, 2);
		
		 $this->assertEquals(true,$result);
	}
	


}