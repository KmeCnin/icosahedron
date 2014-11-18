<?php // 

namespace Ico\Bundle\RulesBundle\Entity;

//use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
abstract class Normalized
{

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    
    /**
     * Constructor
     */
    public function __construct() {
	   
    }
    
    // http://www.foulquier.info/tutoriaux/url-rewriting-avec-slugification-du-titre-d-un-article-symfony-2-partie-11
    protected function slugify($text)
    {
	   // replace non letter or digits by -
	   $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

	   // trim
	   $text = trim($text, '-');

	   // transliterate
	   if (function_exists('iconv'))
	   {
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	   }

	   // lowercase
	   $text = strtolower($text);

	   // remove unwanted characters
	   $text = preg_replace('#[^-\w]+#', '', $text);

	   if (empty($text))
	   {
		  return 'n-a';
	   }

	   return $text;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($input) {

	   $this->slug = $this->slugify($input);

	   return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug() {
	   return $this->slug;
    }
}