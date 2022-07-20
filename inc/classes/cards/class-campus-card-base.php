<?php

namespace Campus;

abstract class Campus_Card_Base {

   /**
    * @var $language
    */
   public $language;

   /**
    * Campus_Program constructor.
    */
   public function __construct() {
       $this->language = apply_filters( 'wpml_current_language', NULL );
   }

   public abstract function getPodType();
   public abstract function getName();
   public abstract function getImageUrl();
   public abstract function getAcademicInstitution();
   public abstract function getMarketingTags();
   public abstract function getPermalink();
   public abstract function getCatalogCard($program_id);
   public abstract function getStripeCard($program_id, $stripe_id);


}
