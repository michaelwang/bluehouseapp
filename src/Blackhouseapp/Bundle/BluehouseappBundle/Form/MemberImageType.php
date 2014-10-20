<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 14-10-20
 * Time: 下午10:09
 */

namespace Blackhouseapp\Bundle\BluehouseappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class MemberImageType  extends AbstractType{

    private $isEdit;
    public function __construct($isEdit=false)
    {
        $this->isEdit = $isEdit;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('userImage','file',array(
            'label'=>' ',
            'required'=>!$this->isEdit,
            'attr'=>array(

            )
        ));
        $builder ->add('上传头像','submit',array(
        'attr'=>array(
            'style'=>'display:block;margin-top:20px'
        )
    ))
    ;

    }



    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blackhouseapp\Bundle\BluehouseappBundle\Entity\Member'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blackhouseapp_bundle_bluehouseappbundle_memberimage';
    }
} 