<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('visit', DateType::class,array(
            'widget' => 'choice','label' => 'Jour de visite :' ,'format' => 'dd-MM-yyyy','years' => range(date('Y'),date('Y')+1,1)
        ))
                ->add('duration', ChoiceType::class, array(
                'choices'=>array(
                    'journée'=>1,
                    'demi-journée'=>0),'label' => 'Durée de la visite :' ))
                ->add('lastname', TextType::class, array('label' => 'Nom :' ))
                ->add('firstname', TextType::class , array('label' => 'Prénom :' ))
                ->add('birthday', BirthdayType::class, array(
            'widget' => 'choice', 'format' => 'dd-MM-yyyy', 'label' => 'Date de naissance :'))
                ->add('country', CountryType::class,[
                'preferred_choices' => ['FR','GB','ES','DE','IT'],
                'placeholder' => '-------------------',
                'label' => 'Pays de provenance :'])
                ->add('offer', CheckBoxType::class, array('required' => false, 'label' => 'Tarif Réduit :'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ticket';
    }


}
