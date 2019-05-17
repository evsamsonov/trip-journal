<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="trips")
 * @ORM\Entity
 */
class Trip
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     * @Assert\NotBlank()
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var Region
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="trips")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var Region
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Courier", inversedBy="trips")
     * @ORM\JoinColumn(name="courier_id", referencedColumnName="id")
     */
    private $courier;

    /**
     * @var int
     * @ORM\Column(name="courier_id", type="integer", nullable=false)
     */
    private $courierId;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return self
     */
    public function setStartDate(\DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return Region
     */
    public function getRegion(): ?Region
    {
        return $this->region;
    }

    /**
     * @param Region $region
     * @return self
     */
    public function setRegion(Region $region): self
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return Region
     */
    public function getCourier(): ?Courier
    {
        return $this->courier;
    }

    /**
     * @param Courier $courier
     * @return self
     */
    public function setCourier(Courier $courier): self
    {
        $this->courier = $courier;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return self
     */
    public function setEndDate(\DateTime $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getCourierId(): ?int
    {
        return $this->courierId;
    }

    /**
     * @param int $courierId
     * @return self
     */
    public function setCourierId($courierId): self
    {
        $this->courierId = $courierId;
        return $this;
    }
}