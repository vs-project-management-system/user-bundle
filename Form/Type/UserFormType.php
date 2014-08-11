<?php
namespace PMS\Bundle\UserBundle\Form\Type;

class UserFormType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email');
        $builder
            ->add(
                'plainPassword',
                'repeated',
                array(
                    'first_name'    =>  'password',
                    'second_name'   =>  'confirm',
                    'type'          =>  'password'
                )
            );
    }

    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'    =>  'PMS\Bundle\UserBundle\Entity\User'
            )
        );
    }

    public function getName()
    {
        return 'user';
    }
}
