<?php
namespace App\Form;

use App\Entity\Subscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('packId', ChoiceType::class, [
                'choices' => [
                    'Junior Pack' => 1,
                    'Student Pack' => 2,
                    'Premium Pack' => 3,
                ],
            ])
            ->add('startDate', DateType::class, ['widget' => 'single_text'])
            ->add('endDate', DateType::class, ['widget' => 'single_text'])
            ->add('paymentMethod', ChoiceType::class, [
                'choices' => [
                    'Cash' => 'cash',
                    'Credit Card' => 'credit_card',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subscription::class,
        ]);
    }
}
