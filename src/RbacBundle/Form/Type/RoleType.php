<?php
namespace RbacBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rolename', null, [
            'label' => '角色名称'
        ])
            ->add('note', null, [
            'label' => '备注'
        ])
            ->add('level', ChoiceType::class, [
            'label' => '角色等级',
            'choices' => [
                '系统超级管理员' => 0,
                '省级' => 1,
                '省级（按地市划分）' => 2,
                '市级' => 3,
                '县区级' => 4
            ]
        ])
            ->add('sort', ChoiceType::class, [
                'label' => '市级角色状态',
                'choices' => [
                    '市一审' => 1,
                    '市二审' => 2,
                ],
                'data' => 1,
                'expanded' => true,
                'attr' => [
                    'class' => 'checkbox_sort'
                ],
            ])
            ->add('area', ChoiceType::class, [
            'choices' => [
                '太原市' => 140100,
                '大同市' => 140200,
                '阳泉市' => 140300,
                '长治市' => 140400,
                '晋城市' => 140500,
                '朔州市' => 140600,
                '晋中市' => 140700,
                '运城市' => 140800,
                '忻州市' => 140900,
                '临汾市' => 141000,
                '吕梁市' => 141100
            ],
            'attr' => [
                'class' => 'checkbox_area'
            ],
            'choice_attr' => function ($val, $key, $index) {
                // adds a class like attending_yes, attending_no, etc
                return [
                    'class' => 'checkbox_float'
                ];
            },
            'expanded' => true,
            'multiple' => true,
            'label' => '负责地市'
            // 'data' => [1], //此处需要注意，由于值为多个，所以默认选中需要传数组
        ]);
        if ($options['is_new'] == 1) {
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
        } else {
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
        $builder->add('submit', SubmitType::class, [
            'label' => '提交'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'RbacBundle\Entity\Role',
            'is_new' => 1
        ]);
    }
}