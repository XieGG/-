<?php
namespace BaseBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

class MacroExtension extends \Twig_Extension
{

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('macro_no_content', [
                $this,
                'noContent'
            ],[
                'is_safe' => [
                    'html'
                ]
            ])
        );
    }

    public function noContent($num)
    {
        return <<<EOF
        <div colspan="$num" align="center">
            <img src="/public/img/no_content.gif"/>
        </div>
EOF;
    }

}