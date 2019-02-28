<?php
namespace RbacBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use RbacBundle\Entity\User;
use RbacBundle\Entity\Role;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class CreateUserCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('rbac:create:user')
            ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'admin username')
            ->addOption('password', 'p', InputOption::VALUE_OPTIONAL, 'admin password')
            ->setDescription('generate admin account.')
            ->setHelp("This command generate admin account ...");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getOption('username');
        $password = $input->getOption('password');
        if(empty($username)){
            $username = 'admin';
        }
        if(empty($password)){
            $password = 'mqy2019';
        }
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('generate account username:'.$username.', password:'.$password.'?(enter yes|no)', false);
        
        if (!$helper->ask($input, $output, $question)) {
            return;
        }
        $this->generate($username, $password, $output);
        $output->writeln([
            'generate success'
        ]);
    }

    /**
     *
     * @param unknown $type            
     * @param OutputInterface $output            
     * @param unknown $startDate            
     * @param unknown $endDate            
     * @param unknown $pagesize            
     */
    private function generate($username, $password, OutputInterface $output)
    {
        /**
         * 
         * @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
         */
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();
        try {
            $roleList = $doctrine->getRepository('RbacBundle:Role')->findAll();
//             $information =  $doctrine->getRepository('ArchiveBundle:Information')->findAll();
//             if(empty($information) || !isset($information[0])){
//                 $output->writeln([
//                     'Exception',
//                     'code:2',
//                     'msg:information list empty'
//                 ]);
//                 exit();
//             }
            if(empty($roleList) || !isset($roleList[0])){
                $role = new Role();
                $role->setRolename('超级管理员');
                $role->setIp('127.0.0.1');
                $role->setNote('脚本自动生');
                $role->setStatus(1);
                $role->setLevel(0);
                $role->setNodes('10000,20000,30000,40000,50000,60000,70000,80000,90000,90400,90401,90402,90403');
                $role->setNodenames('首页,实时点名,定位监控,警示管理,工作台账,电子档案,统计查询,信息互动,系统设置');
                $em->persist($role);
                $em->flush($role);
            }else{
                $role = $roleList[0];
            }
            $user = new User();
            $salt = uniqid();
            $user->setSalt($salt);
            /**
             *
             * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder $encoder
             */
            $encoder = $this->getContainer()->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $password);
            $user->setUSERNAME($username);
            $user->setXM('系统管理员');
            $user->setRYBM('14010213');
            $user->setPASSWORD($password);
            $user->setIP('127.0.0.1');
            $user->setLEVEL(0);
            $user->setGROUP($role);
            $user->setROLE('ROLE_ADMIN');
            $user->setSTATUS('1');
            $em->persist($user);
            $em->flush();
        }catch (\Exception $e) {
            $output->writeln([
                'Exception',
                'code:' . $e->getCode(),
                'msg:'. $e->getMessage()
            ]);
            exit();
        }
    }
}