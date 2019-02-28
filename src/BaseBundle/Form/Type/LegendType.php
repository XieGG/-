<?php
namespace BaseBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;

class LegendType extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}