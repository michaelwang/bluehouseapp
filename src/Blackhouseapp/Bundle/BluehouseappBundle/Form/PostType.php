<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text',array(
                'label'=>'讨论标题(必填)',
                'required'=>true,
                'attr'=>array(
                    'class'=>'input-block-level',
                    'placeholder'=>'讨论标题'

                )
            ))
            ->add('content','textarea',array(
                'label'=>'讨论内容(必填)',
                'required'=>true,
                'attr'=>array(
                    'class'=>'input-block-level',
                    'rows'=>10,
                    'placeholder'=>'讨论内容.',

                )
            ))
            ->add('创建讨论','submit',array(
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
            'data_class' => 'Blackhouseapp\Bundle\BluehouseappBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blackhouseapp_bundle_bluehouseappbundle_post';
    }
}
