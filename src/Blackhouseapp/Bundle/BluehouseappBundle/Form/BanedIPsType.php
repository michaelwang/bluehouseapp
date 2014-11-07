<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BanedIPsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip','text',array(
                'label'=>'IP',
                'required'=>true,
                'attr'=>array(
                    'class'=>'input-block-level',
                    'placeholder'=>'请输入要屏蔽的IP'
                )
            ))
            ->add('fromDate',null,array(
                'label'=>'开始时间',
                'required'=>true,
                'attr'=>array(

                )))
            ->add('toDate',null,array(
                'label'=>'结束时间',
                'required'=>true,
                'attr'=>array(

                )))
            ->add('保存','submit',array(
                'attr'=>array(
                    'style'=>'margin-top:20px;'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blackhouseapp\Bundle\BluehouseappBundle\Entity\BanedIPs'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blackhouseapp_bundle_bluehouseappbundle_banedips';
    }
}
