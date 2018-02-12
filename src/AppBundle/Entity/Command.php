<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Command
 *
 * @ORM\Table(name="command")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandRepository")
 */
class Command
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
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(name="holder", type="string", length=255)
     */
    private $holder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecommand", type="datetimetz")
     */
    private $datecommand;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true, unique=true)
     */
    private $reference;

    /**
     * @var decimal
     *
     * @ORM\Column(name="totalOrder", type="decimal")
     */
    private $totalOrder;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var bool
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;

    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="command", cascade={"persist"}))
     * @Assert\Valid()
     * 
     */
    private $tickets;



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
     * Set holder
     *
     * @param string $holder
     *
     * @return Command
     */
    public function setHolder($holder)
    {
        $this->holder = $holder;

        return $this;
    }

    /**
     * Get holder
     *
     * @return string
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * Set datecommand
     *
     * @param \DateTime $datecommand
     *
     * @return Command
     */
    public function setDatecommand($datecommand)
    {
        $this->datecommand = $datecommand;

        return $this;
    }

    /**
     * Get datecommand
     *
     * @return \DateTime
     */
    public function getDatecommand()
    {
        return $this->datecommand;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Command
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Command
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->datecommand = new \DateTime();
        $this->paid = 0;

    }

    /**
     * Add ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Command
     */
    public function addTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $ticket->setCommand($this);
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set totalOrder
     *
     * @param string $totalOrder
     *
     * @return Command
     */
    public function setTotalOrder($totalOrder)
    {
        $this->totalOrder = $totalOrder;

        return $this;
    }

    /**
     * Get totalOrder
     *
     * @return string
     */
    public function getTotalOrder()
    {
        return $this->totalOrder;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     *
     * @return Command
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }
}
