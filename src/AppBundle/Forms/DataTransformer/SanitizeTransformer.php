<?php

namespace AppBundle\Forms\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class SanitizeTransformer implements DataTransformerInterface
{
    /**
     * @param string $text
     * @return string
     */
    public function transform($text)
    {
        if (is_object($text)) {
            return $text;
        }
        return trim(strip_tags($text));
    }

    /**
     * @param string $text
     * @return string
     */
    public function reverseTransform($text)
    {
        if (is_object($text)) {
            return $text;
        }
        return trim(strip_tags($text));
    }
}
