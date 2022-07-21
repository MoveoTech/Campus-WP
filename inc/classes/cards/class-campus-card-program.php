<?php

namespace Campus;

class Campus_Card_Program extends Campus_Card_Base
{
    /**
     * getting all data for program card
     */

    public function getName()
    {
        $name = $this->language !== 'he' ? $this->data->display($this->language.'_name') : $this->data->display('name');
        $name = $name === '' ? $this->data->display('name') : $name;
        return $name;
    }

    public function getPodDataType()
    {
        return "programs";
    }

    public function getAcademicInstitution()
    {
        if ($this->language == 'en') {
            return $this->data->field('institutions.english_name');
        } elseif ($this->language == 'ar') {
            return $this->data->field('institutions.arabic_name');
        } else {
            return $this->data->field('institutions.name');
        }
    }

    public function getPermalink()
    {
        return $this->data->display('permalink');
    }

}
