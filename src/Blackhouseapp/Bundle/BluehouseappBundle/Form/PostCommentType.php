<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostCommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content','textarea',array(
                'label'=>'评论内容(必填)',
                'required'=>true,
                'attr'=>array(
                    'class'=>'input-block-level',
                    'rows'=>6
                )
            ))
            ->add('创建评论','submit',array(
                'attr'=>array(
                    'style'=>'margin-top:20px'
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
            'data_class' => 'Blackhouseapp\Bundle\BluehouseappBundle\Entity\PostComment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blackhouseapp_bundle_bluehouseappbundle_postcomment';
    }
}
