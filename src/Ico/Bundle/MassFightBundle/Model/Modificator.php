<?php

namespace Ico\Bundle\MassFightBundle\Model;

use Ico\Bundle\KingmakerBundle\Entity\Campaign;

abstract class Modificator
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var int
     */
    protected $fp;
    
    /**
     * @var int
     */
    protected $ma;
    
    /**
     * @var int
     */
    protected $damages;
    
    /**
     * @var int
     */
    protected $vd;
    
    /**
     * @var int
     */
    protected $moral;
    
    /**
     * @var int
     */
    protected $speed;
    
    /**
     * @var int
     */
    protected $conso;
    
    /**
     * @var string
     */
    protected $description;
    
    protected function __construct()
    {
        $this->fp = 0;
        $this->ma = 0;
        $this->damages = 0;
        $this->vd = 0;
        $this->moral = 0;
        $this->speed = 0;
        $this->conso = 0;
    }
    
    public function __toString()
    {
        $mods = $this->modsAsArray();
        return count($mods)
            ? $this->name.' ('.implode(', ', $mods).')'
            : $this->name;
    }

    public function modsAsArray()
    {
        $modsComputed = [];
        $mods = [
            'fp' => 'FP',
            'ma' => 'MA',
            'damages' => 'Dégâts',
            'vd' => 'VDéf',
            'moral' => 'Moral',
            'speed' => 'Vitesse',
            'conso' => 'Conso',
        ];

        foreach ($mods as $var => $label) {
            $val = $this->{$var};
            if ($val !== 0) {
                $val = $val < 0 ? $val : '+'.$val;
                $modsComputed[] = $val.' '.$label;
            }
        }

        return $modsComputed;
    }

    public function modsAsString()
    {
        return implode(', ', $this->modsAsArray());
    }
    
    public function getMappedMods()
    {
        return [
            'fp' => $this->fp,
            'ma' => $this->ma,
            'damages' => $this->damages,
            'vd' => $this->vd,
            'moral' => $this->moral,
            'speed' => $this->speed,
            'conso' => $this->conso,
        ];
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Campaign
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function getFp() {
        return $this->fp;
    }

    public function getMa() {
        return $this->ma;
    }

    public function getDamages() {
        return $this->damages;
    }

    public function getVd() {
        return $this->vd;
    }

    public function getMoral() {
        return $this->moral;
    }

    public function getSpeed() {
        return $this->speed;
    }

    public function getConso() {
        return $this->conso;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setFp($fp) {
        $this->fp = $fp;
        return $this;
    }

    public function setMa($ma) {
        $this->ma = $ma;
        return $this;
    }

    public function setDamages($damages) {
        $this->damages = $damages;
        return $this;
    }

    public function setVd($vd) {
        $this->vd = $vd;
        return $this;
    }

    public function setMoral($moral) {
        $this->moral = $moral;
        return $this;
    }

    public function setSpeed($speed) {
        $this->speed = $speed;
        return $this;
    }

    public function setConso($conso) {
        $this->conso = $conso;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
}
