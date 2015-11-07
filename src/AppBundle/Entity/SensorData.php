<?php

namespace AppBundle\Entity;

/**
 * SensorData
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SensorData
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="text")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text")
     */
    private $data;

    public function __construct($data)
    {
        $this->created = date( 'Y-m-d H:i:s');
        $this->data = json_encode($data,10);
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return SensorData
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return SensorData
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
}

