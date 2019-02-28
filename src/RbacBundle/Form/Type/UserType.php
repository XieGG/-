<?php
namespace RbacBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rYBM', null, [
            'label' => '用户名'
        ]) 
           ->add('pASSWPRD', PasswordType::class, [
            'label' => '密码'
        ])
            ->add('xM',TextType::class,[
            'label' => '真实姓名'
        ])
            ->add('rYBM',null,[
            'label' => '人员编号'
        ])
            ->add('gROUP', EntityType::class, [
            'class' => 'RbacBundle:Role',
            'choice_label' => 'rolename',
            'label' => '职位'
        ])
            ->add('jZJGSZDSSFJ', EntityType::class, [
            'class' => 'RbacBundle:Department',
            'choice_label' => 'name',
            'label' => '机构'
        ])
           ->add('roomNumber',null,[
            'label' => '房间号'
        ])
            ->add('oph',null,[
            'label' => '办公电话'
        ])
            ->add('mobile', null, [
            'label' => '手机号'
        ])
            ->add('trumpet',null,[
            'label' => '小号'
        ]);

        if($options['is_new'] == 1){
            $builder->add('status', ChoiceType::class, [
            'choices' => [
                '启用' => 1,
                '禁用' => 0
            ],
            'expanded' => true,
            'label' => '状态',
            'data' => 1,
            'label_attr' => [
                'class' => 'radio-inline'
            ]
        ]);
        }else{
            $builder->add('status', ChoiceType::class, [
            'choices' => [
                '启用' => 1,
                '禁用' => 0
            ],
            'expanded' => true,
            'label' => '状态',
            'label_attr' => [
                'class' => 'radio-inline'
            ]
        ]);
        }
           
        
            $builder->add('submit', SubmitType::class, ['label' => '提交']);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'RbacBundle\Entity\User',
            'is_new' => 1
        ]);
    }
}