<?php

namespace AppBundle\Domain\Stock\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="AppBundle\Domain\Stock\Repository\StockRepository")
 */
class Stock
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
     *
     * @ORM\Column(name="strProductName", type="string", length=50)
     */
    private $strProductName;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductDesc", type="string", length=255)
     */
    private $strProductDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductCode", type="string", unique=true, length=10)
     */
    private $strProductCode;

    /**
     * @var string
     *
     * @ORM\Column(name="intStockValue", type="integer")
     */
    private $intStockValue;

    /**
     * @var string
     *
     * @ORM\Column(name="fltCost", type="float")
     */
    private $fltCost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmAdded", type="datetime")
     */
    private $dtmAdded;

    /**
     * @var bool
     *
     * @ORM\Column(name="boolDiscontinued", type="boolean")
     */
    private $boolDiscontinued = false;

    /**
     * @var int
     *
     * @ORM\Column(name="stmTimestamp", type="integer")
     */
    private $stmTimestamp;

    /**
     * Stock constructor.
     *
     * @param string $strProductName
     * @param string $strProductDesc
     * @param string $strProductCode
     * @param string $intStockValue
     * @param string $fltCost
     * @param bool $boolDiscontinued
     */
    public function __construct(
        $strProductName,
        $strProductDesc,
        $strProductCode,
        $intStockValue,
        $fltCost,
        $boolDiscontinued
    )
    {
        $time = new DateTime();

        $this->strProductName = $strProductName;
        $this->strProductDesc = $strProductDesc;
        $this->strProductCode = $strProductCode;
        $this->intStockValue = '' === $intStockValue ? 0 : intval($intStockValue);
        $this->fltCost = ltrim($fltCost, '$');
        $this->dtmAdded = $time;
        $this->boolDiscontinued = 'yes' === $boolDiscontinued ? true : false;
        $this->stmTimestamp = $time->getTimestamp();
    }


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
     * Set strProductName
     *
     * @param string $strProductName
     *
     * @return Stock
     */
    public function setStrProductName($strProductName)
    {
        $this->strProductName = $strProductName;

        return $this;
    }

    /**
     * Get strProductName
     *
     * @return string
     */
    public function getStrProductName()
    {
        return $this->strProductName;
    }

    /**
     * Set strProductDesc
     *
     * @param string $strProductDesc
     *
     * @return Stock
     */
    public function setStrProductDesc($strProductDesc)
    {
        $this->strProductDesc = $strProductDesc;

        return $this;
    }

    /**
     * Get strProductDesc
     *
     * @return string
     */
    public function getStrProductDesc()
    {
        return $this->strProductDesc;
    }

    /**
     * Set strProductCode
     *
     * @param string $strProductCode
     *
     * @return Stock
     */
    public function setStrProductCode($strProductCode)
    {
        $this->strProductCode = $strProductCode;

        return $this;
    }

    /**
     * Get strProductCode
     *
     * @return string
     */
    public function getStrProductCode()
    {
        return $this->strProductCode;
    }

    /**
     * Set dtmAdded
     *
     * @param \DateTime $dtmAdded
     *
     * @return Stock
     */
    public function setDtmAdded($dtmAdded)
    {
        $this->dtmAdded = $dtmAdded;

        return $this;
    }

    /**
     * Get dtmAdded
     *
     * @return \DateTime
     */
    public function getDtmAdded()
    {
        return $this->dtmAdded;
    }

    /**
     * Set boolDiscontinued
     *
     * @param boolean $boolDiscontinued
     *
     * @return Stock
     */
    public function setDtmDiscontinued($boolDiscontinued)
    {
        $this->boolDiscontinued = $boolDiscontinued;

        return $this;
    }

    /**
     * Get boolDiscontinued
     *
     * @return boolean
     */
    public function getBoolDiscontinued()
    {
        return $this->boolDiscontinued;
    }

    /**
     * Set stmTimestamp
     *
     * @param int $stmTimestamp
     *
     * @return Stock
     */
    public function setStmTimestamp($stmTimestamp)
    {
        $this->stmTimestamp = $stmTimestamp;

        return $this;
    }

    /**
     * Get stmTimestamp
     *
     * @return int
     */
    public function getStmTimestamp()
    {
        return $this->stmTimestamp;
    }

    /**
     * @return string
     */
    public function getIntStockValue()
    {
        return $this->intStockValue;
    }

    /**
     * @param string $intStockValue
     * @return Stock
     */
    public function setIntStockValue($intStockValue)
    {
        $this->intStockValue = $intStockValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getFltCost()
    {
        return $this->fltCost;
    }

    /**
     * @param string $fltCost
     * @return Stock
     */
    public function setFltCost($fltCost)
    {
        $this->fltCost = $fltCost;
        return $this;
    }
}

