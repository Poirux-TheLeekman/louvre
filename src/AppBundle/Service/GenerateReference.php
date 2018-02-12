<?php
namespace AppBundle\Service;

class GenerateReference
{
	public function createReference($a, $b)
	{
		$c = $a.$b;
		$c = preg_replace("#[^a-zA-Z-0123456789]#", "", $c);
		return str_shuffle($c);
	}
}