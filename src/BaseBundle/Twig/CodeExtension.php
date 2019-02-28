<?php
namespace BaseBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;
use SystemBundle\Entity\Administration;

class CodeExtension extends \Twig_Extension
{

    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('code_name', array(
                $this,
                'codeName'
            )),
            new \Twig_SimpleFunction('code_type_name', array(
                $this,
                'codeTypeName'
            )),
            new \Twig_SimpleFunction('code_all_name', array(
                $this,
                'codeAllName'
            )),
            new \Twig_SimpleFunction('select_all_name', array(
                $this,
                'selectAllName'
            )),
            new \Twig_SimpleFunction('xz_jgmc', array(
                $this,
                'getXZJGMC'
            )),
            new \Twig_SimpleFunction('xzqhmc', array(
                $this,
                'getXZQHMC'
            ))
        );
    }

    public function codeName($codenum, $codetypeid)
    {
        if ($codenum == null){
            return $codename = ' 无 ';
        }
        /**
         *
         * @var \SystemBundle\Repository\CodeRepository $codeRepo
         */
        $codeRepo = $this->doctrine->getRepository('SystemBundle:Code');
        $codename = $codeRepo->getcodeName($codenum, $codetypeid);
        return empty($codename) ? ' 无 ' : $codename;

    }

    public function codeTypeName($codetypeId)
    {
        /**
         *
         * @var \SystemBundle\Repository\CodeTypeRepository $codeTypeReop
         */
        $codeTypeReop = $this->doctrine->getRepository('SystemBundle:CodeType');
        $codeType = $codeTypeReop->find($codetypeId);

        return empty($codeType) ? ' 无 ' : $codeType->getName();
    }

    /**
     * codename
     * 
     * @param unknown $codetypeid
     * @return Ambigous <string, unknown>
     */
    public function codeAllName($codetypeid)
    {
        /**
         *
         * @var \SystemBundle\Repository\CodeRepository $codeReop
         */
        $codeReop = $this->doctrine->getRepository('SystemBundle:Code');
        $codeAllName = $codeReop->getcodeAllName($codetypeid);
        return empty($codeAllName) ? ' 无 ' : $codeAllName;
    }

    /**
     * 下拉菜单
     * 
     * @param string $codetypeid
     * @param string $id
     * @return string
     */
    public function selectAllName($codetypeid, $id = '')
    {
        /**
         *
         * @var \SystemBundle\Repository\CodeRepository $codeReop
         */
        $codeReop = $this->doctrine->getRepository('SystemBundle:Code');
        $codeAllName = $codeReop->getcodeAllName($codetypeid);
        $option = '';
        if (! empty($id) && strpos($id, ',') !== false) {
            $id = explode(',', $id);
        }
        if (! empty($codeAllName)) {
            foreach ($codeAllName as $codename) {
                if (! empty($id) && is_array($id)) {
                    for ($i = 0; $i < count($id); $i ++) {
                        if ($id[$i] == $codename['codenum']) {
                            $option .= '<option value=' . $codename['codenum'] . ' selected >' . $codename['codename'] . '</option>';
                        } else {
                            $option .= '<option value=' . $codename['codenum'] . '>' . $codename['codename'] . '</option>';
                        }
                    }
                } else if (! empty($id) && $id == $codename['codenum']) {
                    $option .= '<option value=' . $codename['codenum'] . ' selected >' . $codename['codename'] . '</option>';
                } else {
                    $option .= '<option value=' . $codename['codenum'] . '>' . $codename['codename'] . '</option>';
                }
            }
        } else {
            $option = '';
        }
        return $option;
    }

    /**
     * 获取行政区划名称
     * 
     * @param string $xzdm
     * @return NULL|string
     */
    public function getXZQHMC($xzdm)
    {
        /**
         *
         * @var \SystemBundle\Entity\Administration $administration
         */
        $repo = $this->doctrine->getRepository('SystemBundle:Administration');
        if (empty($xzdm)) {
            return null;
        }
        $administration = $repo->findOneBy([
            'areaID' => $xzdm
        ]);
        if (empty($administration)) {
            return null;
        }
        return $administration->getAreaName();
    }
    
    /**
     * 获取机构名称
     * 
     * @param string $jgdm
     * @return NULL|string
     */
    public function getXZJGMC($jgdm)
    {
        $repo = $this->doctrine->getRepository('ArchiveBundle:Information');
        if (empty($jgdm)) {
            return null;
        }
        $information = $repo->findOneBy([
            'jGBM' => $jgdm
        ]);
        if (empty($information)) {
            return null;
        }
        return $information->getJGMC();
    }
}