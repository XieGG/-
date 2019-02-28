<?php
namespace BaseBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;

class UpdateSubmitStateService
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * 更新数据提交状态
     *
     * @param string  $tablename
     * @param array $ids
     * @return number
     */
    public function updateSubmitState($tablename,$ids,$result, $code)
    {
        $time = time();
        if($code == 1){
            $sql = 'UPDATE '.$tablename.' SET SUBMITSTATE = 1,SUBMITTIME = '.$time.',SUBMITRESULT = :result WHERE ID IN (:ids)';
        }else{
            $sql = 'UPDATE '.$tablename.' SET SUBMITTIME = '.$time.',SUBMITRESULT = :result WHERE ID IN (:ids)';
        }
        $res = $this->doctrine->getConnection()->executeUpdate(
            $sql,
            array(
                'ids'=>$ids,
                'result'=>$result
            ),
            array(
                'ids'=>\Doctrine\DBAL\Connection::PARAM_INT_ARRAY
            )
        );
        dump($res);
        return $res;
    }
}