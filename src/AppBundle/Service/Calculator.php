<?php
namespace AppBundle\Service;

class Calculator
{
	public function ageVisitor($uneDate)
	{
		
		// Vérifie la présence d'une chaîne type dans la date (vérifie le format de la date)
		$test1 = preg_match("/(^[0-9]{2})[-\/]([0-9]{2})[-\/]([0-9]{4}$)/", $uneDate);
		$test2 = preg_match("/(^[0-9]{4})[-\/]([0-9]{2})[-\/]([0-9]{2}$)/", $uneDate);

		if ($test1 or $test2) {
			// Calcule l'âge
			$age = date('Y') - date('Y', strtotime($uneDate));
			
			if (date('md') < date('md', strtotime($uneDate))) {
				
				$age = $age - 1;
			}
		} else {
			return("<b>Format de date invalide : ".$uneDate."</b>");
		}

		// Renvoit l'age.
		return($age);

	}

	public function typeVisitor($age)
	{
		
		switch (true) {
			case ($age<4):
				return 'Gratuit';
				break;
			case ($age>3 && $age<12):
				return 'Enfant';
				break;
			case ($age>12 && $age<60):
				return 'Normal';
				break;
			case ($age>59):
				return 'Senior';
				break;
		}
	}
}