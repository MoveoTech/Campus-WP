<?php

namespace Campus;

abstract class Campus_Card_Base
{

    /**
     * @var $language
     */
    protected $language;

    /**
     * @var $data
     */
    protected $data;

    /**
     * @var string $pod_data_type
     */
    protected string $pod_data_type;

    /**
     * @var $card_type
     */
    protected $card_type;

    /**
     * @var $stripe_id
     */
    protected $stripe_id;

    /**
     * Campus_Program constructor.
     */
    public function __construct($object_id, $stripe_id = null)
    {
        $this->language = apply_filters('wpml_current_language', null);
        $this->pod_data_type = $this->getPodDataType();
        $this->data = pods($this->pod_data_type, $object_id, true);
        $this->card_type = $this->getCardType($stripe_id);
        $this->stripe_id = $stripe_id;
    }
    /**
     * base functions
     */
    public function getCardType($stripe_id)
    {

        if (isset($stripe_id)) {
            return "stripe_card";
        } else if ($stripe_id == null) {
            return "catalog_card";
        } else {
          //todo - if no stripe id ? (there is already validation on stripe id)
        }
    }

    public function getImageUrl()
    {
        return $this->data->display('image');
    }

    public function getMarketingTags()
    {
        $marketing_tags_data = sortTagsByOrder($this->data->field('marketing_tags'));
        if (isset($marketing_tags_data)) {
            $marketing_tags_titles = [];
            if ($this->language == 'en') {
                $name = 'english_name';
            } elseif ($this->language == 'ar') {
                $name = 'arabic_name';
            } else {
                $name = 'name';
            }
            for ($x = 0; $x <= 1; $x++) {
                //TODO - rethink on how to arrange tags instead of in html template
                if (isset($marketing_tags_data[$x][$name])) {
                    array_push($marketing_tags_titles, $marketing_tags_data[$x][$name]);
                }
            }
            return $marketing_tags_titles;
        }
    }

    public function getPodType()
    {
        return $this->data->display('pod_type');
    }

    public function getCard()
    {
        $card_type = $this->card_type;
        $pod_type = $this->getPodType();
        $title = $this->getName();
        $image_url = $this->getImageUrl();
        $institutions = $this->getAcademicInstitution();
        $marketing_tags = $this->getMarketingTags();
        $permalink = $this->getpermalink();

//        get_template_part(
//            'template',
//            'parts/Classes/card-base-class',
//            array(
//                'args' => array(
//                    'card_type' => $card_type,
//                    'title' => $title,
//                    'image_url' => $image_url,
//                    'institutions' => $institutions,
//                    'marketing_tags' => $marketing_tags,
//                    'permalink' => $permalink,
//                    'pod_type' => $pod_type,
//                )
//            )
//        );

        ?>
        <div>
            <p> <?= $card_type ?></p>
            <p> <?= $pod_type ?></p>
            <p> <?= $title ?></p>
            <p> <?= $image_url ?></p>
            <p> <?= $institutions[0] ?></p>
            <p> <?= $marketing_tags ?></p>
            <p> <?= $marketing_tags[0] ?></p>
            <p> <?= $permalink ?></p>
        </div>
        <?php
    }

    /**
     * child functions
     */
    abstract public function getPodDataType();

    abstract public function getName();

    abstract public function getAcademicInstitution();

    abstract public function getPermalink();
}
