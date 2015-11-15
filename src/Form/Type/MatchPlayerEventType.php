<?php
/**
 * Created by PhpStorm.
 * User: mginov
 * Date: 13/11/15
 * Time: 23:41
 */

namespace Fut7\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchPlayerEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name'
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array());
    }

    public function getName()
    {
        return 'MatchPlayerEvent';
    }
}