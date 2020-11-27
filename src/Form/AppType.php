<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;

class AppType extends AbstractType
{
    /**
     * Function that ease the configuration of a value in a form
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    protected function getConfiguration($label, $placeholder, $options = [])
    {
        return array_merge([
            'label'=> $label,
            'attr'=> [
                'placeholder'=> $placeholder,
            ]
        ], $options);
    
    }

    protected function getConfigNumber($label, $placeholder, $min, $max, $step = 1, $options = [])
    {
        return array_merge([
            'label'=> $label,
            'attr'=> [
                'placeholder'=> $placeholder,
                'min' => $min,
                'max' => $max,
                'step' => $step
            ]
        ], $options);
    }
}