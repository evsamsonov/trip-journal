<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="trips")
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
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
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="trips")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Courier", inversedBy="trips")
     * @ORM\JoinColumn(name="courier_id", referencedColumnName="id")
     */
    private $courier;

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
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return self
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Region
     */
    public function getRegion(): Region
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
    public function getCourier(): Courier
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
}