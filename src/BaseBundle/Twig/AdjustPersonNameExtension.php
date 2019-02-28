<?php
namespace BaseBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

class AdjustPersonNameExtension extends \Twig_Extension
{
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('AdjustPersonName', array($this,'AdjustPersonName')),
            new \Twig_SimpleFunction('correcter_sfzh', array($this,'correcterSfzh')),
            new \Twig_SimpleFunction('correcter_name', array($this,'correcterName')),
            new \Twig_SimpleFunction('correcter', array($this,'correcters')),
            new \Twig_SimpleFunction('jgmc', array($this,'jgmc')),
        );
    }

    public function AdjustPersonName($num)
    {
        $res = strstr($num,'[');
        if($res){
            $num=\GuzzleHttp\json_decode($num);
            $count=count($num);
            for($i=0;$i<$count;$i++){
                $correcter = $this->doctrine->getRepository('ArchiveBundle\Entity\CorrectPersonnel')->findOneBy(['sQJZRYBH' => $num[$i]]);
                if (!empty($correcter))
                {
                    $name[] = $correcter->getxM();
                }
            }
            $name=implode(",",$name);
        }else{
            $correcter = $this->doctrine->getRepository('ArchiveBundle:CorrectPersonnel')->findOneBy(['sQJZRYBH' => $num]);
            if (!empty($correcter))
            {
                $name = $correcter->getxM();
            }else {
                $name = '';
            }
            
        }
        return $name;
    }
    
    public function correcterSfzh($num){
        $correcter = $this->doctrine->getRepository('ArchiveBundle:CorrectPersonnel')->findOneBy(['sQJZRYBH' => $num]);
        if(!empty($correcter)){
            return $correcter->getSFZH();
        }else{
            return null;
        }
    }

    public function correcterName($num)
    {
        $num=\GuzzleHttp\json_decode($num);
        $count=count($num);
        for($i=0;$i<$count;$i++){
            $correcter[]= $this->doctrine->getRepository('ArchiveBundle\Entity\CorrectPersonnel')->findOneBy(['id' => $num[$i]]);
            $name[] = $correcter[$i]->getxM();
        }
        $name=implode(",",$name);
        return $name;
    }

    public function correcters($num){
        $correcter = $this->doctrine->getRepository('ArchiveBundle:CorrectPersonnel')->findOneBy(['sQJZRYBH' => $num]);
        if(!empty($correcter)){
            return $correcter;
        }else{
            return null;
        }
    }
     public function jgmc($num){
         $correcter = $this->doctrine->getRepository('ArchiveBundle:CorrectPersonnel')->findOneBy(['sQJZRYBH' => $num]);
         if(!empty($correcter)){
             $JGBM=$correcter->getJZJGBM();
             if($JGBM!=99){
                 $JZJGBMobj = $this->doctrine->getRepository("ArchiveBundle:Information")->getJzjgmc($JGBM);
                 if(!empty($JZJGBMobj)){
                     $SSJG = $JZJGBMobj[0]->getJGMC();
                 }
             }else{
                 $SSJG='暂无';
             }
             return $SSJG;
         }else{
             return null;
         }

     }
}