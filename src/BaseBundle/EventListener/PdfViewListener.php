<?php
namespace BaseBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class PdfViewListener
{
    private $templating;
    public function __construct($templating)
    {
        $this->templating = $templating;
    }
    public function preRender(GetResponseForControllerResultEvent $event)
    {
        //result returned by the controller
        $data = $event->getControllerResult();
        
        /* @var $request  \Symfony\Component\HttpFoundation\Request */
        $request =  $event->getRequest();
        $template = $request->get('_template');
        $route = $request->get('_route');
        $format = $request->get('format');
//         dump($format);
//         dump($request);
        if('pdf' == $format){
            $template = '@Base/Default/base.pdf.twig';
            $data['parameters']['base_view'] = $data['view'];
        }else{
            $template = $data['view'];
        }
        $response = $this->templating->renderResponse($template, $data['parameters']);
        $event->setResponse($response);
    }
}