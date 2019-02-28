<?php

namespace RbacBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use RbacBundle\Repository\DepartmentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DepartmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',null,[
            'label' => '部门名称',
            'label_attr' => [
                'class' => 'radio-inline'
            ]
        ])
        ->add('pid',EntityType::class,[
            'class' => 'RbacBundle:Department',
            'query_builder' => function (DepartmentRepository $repo) {
                return $repo->createQueryBuilder('d')
                    ->orderBy('d.level', 'ASC');
            },
//             'choices' => $group->getUsers(),
            'choice_label' => 'name',
            'label' => '上一级部门',
            'label_attr' => [
                'class' => 'radio-inline'
            ]
        ])
        ->add('code',null,[
            'label' => '部门编码',
            'label_attr' => [
                'class' => 'radio-inline'
            ]
        ])
        ->add('submit',SubmitType::class,[
            'label' => '提交',
            'attr' => [
                'lay-filter' => '*'
            ]
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RbacBundle\Entity\Department'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'rbacbundle_department';
    }


}
