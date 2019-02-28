<?php
namespace BaseBundle\Twig;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;

class InformationListExtension extends \Twig_Extension
{

    private $doctrine;

    private $token;

    private $router;
    
    private $request;

    public function __construct(Registry $doctrine, TokenStorage $token, Router $router,RequestStack $request)
    {
        $this->doctrine = $doctrine;
        $this->token = $token;
        $this->router = $router;
        $this->request = $request;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('info_lists', array(
                $this,
                'infoList'
            ))
        );
    }

    public function infoList()
    {
        $request = $this->request->getCurrentRequest();
        $uri = $request->get('_route');
        $user = $this->getUser();
        $router = $this->router->generate($uri);
        $repo = $this->doctrine->getRepository('ArchiveBundle:Information');
        if ($user->getLEVEL() == '0' || $user->getLEVEL() == '1') { // 厅级
            $sjgInfo = $repo->findBy([
                'jGLSCJ' => '03'
            ]);
            $html = $sHtmlList =  '';
            foreach ($sjgInfo as $v) {
                $xjgInfo = $repo->findBy([
                    'sJSFXZZGJG' => $v->getJGBM()
                ]);
                $xjgList = '';
                foreach ($xjgInfo as $vo) {
                    $xjgList .= '<p>
                                    <span class="icon-minus-square-o"></span>
                                    <a href="' . $router . '?jzjgbm=' . $vo->getJGBM() . '">' . $vo->getJGMC() . '</a>
                                 </p>';
                }
                $xjg = '<div class="tree_li_box">' . $xjgList . '</div>';
                $sHtmlList .= '<div class="tree_head">
                                    <span class="span_fist icon-plus-square-o"></span>
                                    <span>
                                        <a href="' . $router . '?jzjgbm=' . $v->getJGBM() . '">' . $v->getJGMC() . '</a>
                                    </span>
                                </div>' . $xjg;
            }
            $html .= '<div class="tree_li_box" style="display:block;">' . $sHtmlList . '</div>';
            $htmlList = '<div class="tree_list">
                            <div class="tree_head">
                                <span class="span_fist icon-minus-square-o"></span>
                                <span>
                                    <a href="' . $router . '?jzjgbm=140000020101010001">省司法厅</a>
                                </span>
                            </div>
                            ' . $html . '
                        </div>';
        } elseif ($user->getLEVEL() == '2') { // 市级
            $xjgInfo = $repo->findBy([
                'sJSFXZZGJG' => $user->getJZJGSZDSSFJ()
            ]);
            $span = '';
            foreach ($xjgInfo as $v) {
                $span .= '<p>
                            <span class="span_fist icon-minus-square-o"></span>
                              <span>
                                 <a href="' . $router . '?jzjgbm=' . $v->getJGBM() . '">' . $v->getJGMC() . '</a>
                              </span>
                          </p>';
            }
            $htmlList = '<div class="tree_list">
                            <div class="tree_head">
                                <span class="span_fist icon-minus-square-o"></span>
                                <span>
                                    <a href="' . $router . '?jzjgbm='.$user->getJZJGSZDSSFJ().'">'.$user->getJZJGSZDSSFJMC().'</a>
                                </span>
                            </div>
                            <div class="tree_li_box" style="display:block;">
                                <div class="tree_head">' . $span . '</div>
                            </div>
                        </div>';
        } elseif ($user->getLEVEL() == '3') { // 区县级
            $sfsInfo = $repo->findBy([
                'sJSFXZZGJG' => $user->getJZJGSZQXSFJ()
            ]);
            $span = '';
            foreach ($sfsInfo as $v) {
                $span .= '<p>
                            <span class="span_fist icon-minus-square-o"></span>
                            <span>
                                <a href="' . $router . '?jzjgbm=' . $v->getJGBM() . '">' . $v->getJGMC() . '</a>
                            </span>
                          </p>';
            }
            $htmlList = '<div class="tree_list" style="display:block;">
                            <div class="tree_head">
                                <span class="span_fist icon-minus-square-o"></span>
                                <span>
                                    <a href="' . $router . '?jzjgbm='.$user->getJZJGSZQXSFJ().'">'.$user->getJZJGSZQXSFJMC().'</a>
                                </span>
                            </div>
                            <div class="tree_li_box"  style="display:block;">
                                <div class="tree_head">' . $span . '</div>
                            </div>
                        </div>';
        } elseif ($user->getLEVEL() == '4') { // 所级
            $htmlList = '<div class="tree_list">
                            <div class="tree_head">
                                <span class="span_fist icon-minus-square-o"></span>
                                <span>
                                    <a href="' . $router . '?jzjgbm='.$user->getJZJGSZQXSFJ().'">'.$user->getJZJGSZQXSFJMC().'</a>
                                </span>
                            </div>
                            <div class="tree_li_box"  style="display:block;">
                                <div class="tree_head">
                                    <span class="span_fist icon-minus-square-o"></span>
                                    <span>
                                        <a href="' . $router . '?jzjgbm=' . $user->getJZJGSZSFS() . '">' . $user->getJZJGSZSFSMC() . '</a>
                                    </span>
                                </div>
                            </div>
                        </div>';
        } else {
            $htmlList = "";
        }
        return $htmlList;
    }

    private function getUser()
    {
        if (null === $token = $this->token->getToken()) {
            return false;
        }
        
        if (! is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return false;
        }
        
        return $user;
    }
} 