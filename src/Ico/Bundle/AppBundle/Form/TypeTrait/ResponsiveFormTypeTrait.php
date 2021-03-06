<?php

namespace Ico\Bundle\AppBundle\Form\TypeTrait;

trait ResponsiveFormTypeTrait
{
    protected static $inputLarge = ' col-xs-12 col-sm-12 col-md-12 col-lg-12 ';
    protected static $inputDefault = ' col-xs-12 col-sm-6 col-md-6 col-lg-6 ';
    protected static $inputSmall = ' col-xs-12 col-sm-6 col-md-4 col-lg-4 ';
    protected static $inputExtraSmall = ' col-xs-12 col-sm-4 col-md-3 col-lg-2 ';
    
    protected static $visibilityLg = ' visible-lg-block ';
    protected static $visibilityMd = ' visible-md-block ';
    protected static $visibilitySm = ' visible-sm-block ';
    protected static $visibilityXs = ' visible-xs-block ';
    protected static $visibilityAll = '';
}
