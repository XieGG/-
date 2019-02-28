<?php
namespace BaseBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

class AreaExtension extends \Twig_Extension
{
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFunction('area',array(
                $this,
                'areaname'
            ))
        );
    }

    public function area($code)
    {
        if ($code == null){
            return $area = ' 无 ';
        }

        $repo = $this->doctrine->getRepository('OrganBundle:Area');
        $area = $repo->findOneBy([
            'areacode' => $code
        ]);
        return empty($area) ? ' 无 ' : $area->getAreaname();
    }
}