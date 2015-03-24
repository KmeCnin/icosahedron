<?php

namespace Ico\Bundle\ParserBundle\Services;

use ReflectionClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Ico\Bundle\ParserBundle\Helpers\IcoNormalizer;

class DatabaseFormater {
    
    protected $encoders;
    protected $normalizers;
    protected $format;
    
    // Paramètres possibles pour le format de conversion
    const XML = 'xml';
    const JSON = 'json';
    
    public function __construct() {
	   $this->setFormat(self::XML);
	   $this->encoders = array(new XmlEncoder(), new JsonEncoder());
	   $normalizer = new IcoNormalizer();
//	   $normalizer->setIgnoredAttributes(array('children', 'parents', 'featPrerequisites', 'featTypes', 'links'));
//	   $normalizer->setCircularReferenceHandler(function($object) {return 'CACA';});
	   $this->normalizers = array($normalizer);
    }
    
    /**
     * 
     * @param object $entry
     */
    public function convert($entry) {
	   $serializer = new Serializer($this->normalizers, $this->encoders);
	   return $serializer->serialize($entry, $this->format);
    }
    
    /**
     * 
     * @param string $format
     * @throws InvalidArgumentException
     */
    public function setFormat($format) {
	   $formats_accepted = self::getFormatsAccepted();
	   if (!in_array($format, $formats_accepted)) {
		  throw new InvalidArgumentException($format.' : Format inconnu. Formats acceptés : '.inplode(', ', $formats_accepted));
	   }
	   $this->format = $format;
    }
    
    /**
     * 
     * @param string $format
     * @return boolean
     */
    static public function isFormatAccepted($format) {
	   return in_array($format, self::getFormatsAccepted());
    }
    
    /**
     * 
     * @return array
     */
    static public function getFormatsAccepted() {
	   $reflection = new ReflectionClass(__CLASS__);
	   return $reflection->getConstants();
    }
}
