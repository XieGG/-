<?php
namespace BaseBundle\Twig;

class CommonExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('rmerge', array($this, 'rmerge')),
        );
    }
    
    public function rmerge($param, $arr)
    {
        return array_merge($arr, $param);
    }
}