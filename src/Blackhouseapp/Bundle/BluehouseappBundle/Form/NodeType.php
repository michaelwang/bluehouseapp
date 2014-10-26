<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeType extends AbstractType
{
    private $isEdit;
    public function __construct($isEdit=false)
    {
        $this->isEdit = $isEdit;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name','text',array(
                'label'=>'名称(必填)',
                'required'=>true,
                'attr'=>array(
                    'class'=>'input-block-level',
                    'placeholder'=>'节点名称'

                )
            ))
            ->add('code','text',array(
                'label'=>'代码(必填:英文字母或数字)',
                'required'=>true,
                'attr'=>array(
                    'class'=>'input-block-level',
                    'placeholder'=>'节点代码'

                )
            ))
            ->add('category',null,array(
                'label'=>'分类(必填)',
                'required'=>true,
                'attr'=>array(
                    'class'=>'input-block-level'

                )
            ))
        ->add('image','file',array(
            'label'=>'节点头像',
            'required'=>!$this->isEdit,
            'attr'=>array(

            )
        ))
            ->add('no',null,array(
                'label'=>'显示序号(必填)',
                'required'=>true,
                'attr'=>array(
                    'class'=>'input-block-level'

                )
            ))
            ->add('description','textarea',array(
                'label'=>'描述',
                'required'=>false,
                'attr'=>array(
                    'class'=>'input-block-level',
                    'rows'=>3,
                    'placeholder'=>'节点简短介绍'
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
            'data_class' => 'Blackhouseapp\Bundle\BluehouseappBundle\Entity\Node'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blackhouseapp_bundle_bluehouseappbundle_node';
    }
}
