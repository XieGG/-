<?php
namespace BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Form;

class BaseController extends Controller
{

    /**
     *
     * @param Request $request
     * @param string $entity \XxxxBundle\Entity\Yyyy
     * @param string $tableName
     * @param unknown $entityObject Yyyy
     */
    protected function handleRequest(Request $request, $entity, $tableName, $entityObject = null)
    {
        if(is_null($entityObject)){
            $entityObject = new $entity();
        }
        $post = $request->request->get($tableName);
        foreach ($post as $key => $val) {
            $method = 'set' . ucwords($key, '_');
            if(method_exists($entity, $method)){
                $entityObject->$method($val);

            }
        }

        return $entityObject;
    }

    /**
     * 手动进行验证后，增加额外的错误信息
     *
     * @param ConstraintViolationListInterface $errors
     * @param array $msgs
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    protected function addErrors(ConstraintViolationListInterface $errors, $msgs)
    {
        foreach ($msgs as $val) {
            $errors->add(new ConstraintViolation( $val, null, [], null, null, null));
        }
        return $errors;
    }
    /**
     * 主动抛出表单错误信息
     *
     * @param array $msgs
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    protected function generateErrors($msgs)
    {
        $errors = new ConstraintViolationList();
        return $this->addErrors($errors, $msgs);
    }

    /**
     * msg response
     *
     * @param int $type
     *            消息类型(0为绿色,1为蓝色, 2为红色)
     * @param string $title
     *            提示
     * @param string $msg
     *            消息
     * @param routeName $routeName
     *            路由名称
     * @param params $params
     *            路由参数
     * @param string $timeout
     *            消息提示的时间
     * @return Response
     */
    protected function msgResponse($type = 0, $title = '提示', $msg = '操作成功！', $routeName = 'admin_homepage',$params=[], $timeout = 3)
    {
        $classes = [
            'main', // 绿色
            'sub', // 蓝色
            'dot' // 红色
        ];
        $uri = $this->generateUrl($routeName, $params);
        return $this->render('pintuer_msg.html.twig', [
            'type' => $type,
            'timeout' => $timeout,
            'title' => $title,
            'msg' => $msg,
            'uri' => $uri,
            'class' => isset($classes[$type]) ? $classes[$type] : $classes[0]
        ]);
    }
    /**
     * 接口服务调页面
     */
    protected function msgSharingResponse($type = 0, $title = '提示', $msg = '操作成功！', $routeName = 'admin_homepage',$params=[], $timeout = 3)
    {
        $classes = [
            'main', // 绿色
            'sub', // 蓝色
            'dot' // 红色
        ];
        $uri = $this->generateUrl($routeName, $params);
        return $this->render('sharing_msg.html.twig', [
            'type' => $type,
            'timeout' => $timeout,
            'title' => $title,
            'msg' => $msg,
            'uri' => $uri,
            'class' => isset($classes[$type]) ? $classes[$type] : $classes[0]
        ]);
    }

    /**
     * 格式化form表单的错误
     *
     * @param Form $form
     * @return array
     */
    protected function serializeFormErrors(Form $form)
    {
        $errors = [];
        /**
         * @var  $key
         * @var Form $child
         */
        foreach ($form->all() as $key => $child) {
            if (!$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$key] = $error->getMessage();
                }
            }
        }

        return $errors;
    }

    /**
     * ajax upload file
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function uploadAction(Request $request)
    {
        /**
         * @var $image \Symfony\Component\HttpFoundation\File\UploadedFile
         */
        $image = $request->files->get('file'); // 图片的name
        $cut = $request->query->get('cut');
        if($image instanceof UploadedFile){
            $error = $image->getError();
            switch($error)
            {
                case 1:
                    $message="上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值";
                    return $this->json([
                        'data' => $message
                    ]);
                    break;
                case 2:
                    $message="上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值";
                    return $this->json([
                        'data' => $message
                    ]);
                    break;
                case 3:
                    $message="文件只有部分被上传";
                    return $this->json([
                        'data' => $message
                    ]);
                    break;
                case 4:
                    $message="没有文件被上传";
                    return $this->json([
                        'data' => $message
                    ]);
                    break;
                case 6:
                    $message="找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进";
                    return $this->json([
                        'data' => $message
                    ]);
                    break;
                case 7:
                    $message="文件写入失败。PHP 5.1.0 引进";
                    return $this->json([
                        'data' => $message
                    ]);
                    break;
                default:
                    $name = $image->getClientOriginalName();
                    $size = $image->getSize();
                    $type = $image->guessClientExtension();
                    if(empty($cut)){
                        $result = $this->get('base.upload_file_service')->upload($image, 'image/' . date('Y/m'));
                    }else{
                        $mimeTypes = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png'];
                        $result = $this->get('base.upload_file_service')->run($image, $mimeTypes,'', '', $cut);
                    }

                    if($result['code'] == 1){
                        return $this->json([
                            "originalName" => $name,
                            "name" => $name,
                            "url" => '/'.$result['data'],
                            "size" => $size,
                            "type" => "." . $type,
                            "state" => "SUCCESS"
                        ]);
                    }else{
                        return $this->json([
                            'state' => 'FAILD'
                        ]);
                    }
            }
        }else{
            return $this->json([
                "originalName" => '',
                "name" => '',
                "url" => '',
                "size" => '',
                "type" => '',
                "state" => "图片不能为空"
            ]);
        }
    }
}
