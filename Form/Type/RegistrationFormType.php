<?php
namespace PMS\Bundle\UserBundle\Form\Type;

class RegistrationFormType extends \FOS\UserBundle\Form\Type\RegistrationFormType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('type');
    }

    public function getName()
    {
        return 'pms_user_registration';
    }
}
