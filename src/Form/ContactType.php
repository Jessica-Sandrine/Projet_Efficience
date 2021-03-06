<?php


namespace App\Form;

use App\Entity\Departement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Contact;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('message')
            ->add('id_departement', EntityType::class, ['class'=> Departement::class,
                'choice_label' => function(Departement $departement) {
                    return sprintf('(%d) %s', $departement->getNomDepartement());
                               }
            ])
            ->add('save', SubmitType::class)

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver); // TODO: Change the autogenerated stub
        $resolver->setDefaults(array(
            'data_class' => Contact::class,
            'csrf_protection' => false
            ));
    }

}