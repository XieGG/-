<?php
namespace BaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class UploadfileType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'label'=>'文件上传',
        ));
    }

    public function getParent()
    {
        return ButtonType::class;
    }
}