<?php

namespace Ico\Bundle\ParserBundle\Services;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class DatabaseFormater {
    
    protected $em;
    protected $encoders;
    protected $normalizers;
    protected $format;
    
    // Paramètres possibles pour le format de conversion
    const XML = 'xml';
    const JSON = 'json';
    
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
	   $this->encoders = array(new XmlEncoder(), new JsonEncoder());
	   $this->normalizers = array(new GetSetMethodNormalizer());
    }
    
    public function format($entries) {
	   $serializer = new Serializer($this->encoders, $this->normalizers);
	   $entries_converted = array();
	   foreach($entries as $entry) {
		  $entries_converted[] = $serializer->serialize($entry, $this->format);
	   }
    }
    
    public function setFormat($format) {
	   $formats_accepted = $this->getFormatsAccepted();
	   if (!in_array($format, $formats_accepted)) {
		  throw new InvalidArgumentException($format.' : Format inconnu. Formats acceptés : '.inplode(', ', $formats_accepted));
	   }
	   $this->format = $format;
    }
    
    protected function getFormatsAccepted() {
	   $reflection = new ReflectionClass(__CLASS__);
	   return $reflection->getConstants();
    }
}
