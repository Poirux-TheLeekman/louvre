<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as TicketAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @var \DateTime
     * @Assert\Range(
     *      min = "today",
     *      max = "first day of January next year UTC",
     *      minMessage ="La date de visite doit être au moins le {{ limit }}",
     *      maxMessage ="La date de visite ne doit pas être plus longue que {{ limit }}"
     * )
     * @TicketAssert\ConstraintDayOff
     * @ORM\Column(name="visit", type="datetime")
     */
    private $visit;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var \DateTime
     * @Assert\LessThan("today")
     *
     * @ORM\Column(name="birthday", type="datetime")
     */
    private $birthday;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var decimal
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     * @var bool
     * @Assert\Choice(callback="getHourDuration", message="Après 14h00, la demi-journée est uniqement disponible.")
     * @ORM\Column(name="duration", type="boolean")
     */
    private $duration;

    /**
     * @var bool
     *
     * @ORM\Column(name="offer", type="boolean")
     */
    private $offer;

    /**
     * @Assert\Valid()
     * @Assert\Type(type="AppBundle\Entity\Command")
     * @ORM\ManyToOne(targetEntity="Command", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set visit
     *
     * @param string $visit
     *
     * @return Ticket
     */
    public function setVisit($visit)
    {
        $this->visit = $visit;

        return $this;
    }

    /**
     * Get visit
     *
     * @return string
     */
    public function getVisit()
    {
        return $this->visit;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Ticket
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Ticket
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Ticket
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Ticket
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set duration
     *
     * @param boolean $duration
     *
     * @return Ticket
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return bool
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set offer
     *
     * @param boolean $offer
     *
     * @return Ticket
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return bool
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set command
     *
     * @param \AppBundle\Entity\Command $command
     *
     * @return Ticket
     */
    public function setCommand(\AppBundle\Entity\Command $command )
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Get command
     *
     * @return \AppBundle\Entity\Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function getHourDuration()
    {
        $visit = $this->getVisit()->format('m/d/Y');
        $duration = $this->getDuration(); 
        
        if($visit === date('m/d/Y') && date('H')>14 && $duration == 1) {    
            return array(0,0);        
        }
        else {  
            return array(0,1);
        }   
    }


    /**
     * Set country
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
