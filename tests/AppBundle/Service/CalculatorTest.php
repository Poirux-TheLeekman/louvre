<?php 
namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Service\Calculator;

class CalculatorTest extends TestCase
{
	public function testAgeVisitor()
	{
		$calculator = new Calculator;
		$result = $calculator->ageVisitor('04/08/1985');
		
		$this->assertEquals(32,$result);
	}

	public function testTypeVisitorNormal()
	{
		$calculator = new Calculator;
		$result = $calculator->typeVisitor('04/08/1985');
		
		$this->assertEquals('Normal',$result);
	}

	public function testTypeVisitorGratuit()
	{
		$calculator = new Calculator;
		$result = $calculator->typeVisitor('04/08/2016');
		
		$this->assertEquals('Gratuit',$result);
	}

	public function testTypeVisitorEnfant()
	{
		$calculator = new Calculator;
		$result = $calculator->typeVisitor('01/01/2007');
		
		$this->assertEquals('Enfant',$result);
	}

	public function testTypeVisitorSenior()
	{
		$calculator = new Calculator;
		$result = $calculator->typeVisitor('1950/12/01');
		
		$this->assertEquals('Senior',$result);
	}

}