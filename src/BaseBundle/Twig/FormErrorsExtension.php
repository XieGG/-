<?php
namespace BaseBundle\Twig;


class FormErrorsExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('form_errors_tips', array($this,'formErrorsTips')),
        );
    }

    public function formErrorsTips($errors)
    {
        if(!empty($errors)){
            $html = '<div class="alert alert-yellow">';
            foreach ($errors as $error) {
                $html .= '<p style="margin:0;"><span class="close rotate-hover"></span><strong>提示：</strong>' . $error->getMessage().'</p>';
            }
            $html .= '</div>';
        }else{
            $html = '';
        }
        return $html;
    }
}