<?php

namespace Ico\Bundle\ParserBundle\Services;

use ReflectionClass;
//use Symfony\Component\Serializer\Encoder\JsonEncoder;
//use Symfony\Component\Serializer\Encoder\XmlEncoder;
//use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
//use Ico\Bundle\ParserBundle\Helpers\IcoNormalizer;

class DatabaseFormater {
    
    protected $format;
    protected $serializer;
    
    // Paramètres possibles pour le format de conversion
    const FORMAT_XML = 'xml';
    const FORMAT_JSON = 'json';
    const FORMAT_YAML = 'yaml';
    const FORMAT_DEFAULT = self::FORMAT_XML;
    
    public function __construct(Serializer $serializer) {
	   $this->setFormat(self::FORMAT_DEFAULT);
	   $this->serializer = $serializer;
    }
    
    /**
     * 
     * @param object $entry
     */
    public function convert($entry) {
	   return $this->serializer->serialize($entry, $this->format, SerializationContext::create()->setGroups(array('Default', 'token')));
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
