<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 16/11/2015
 * Time: 11:21
 */

namespace MG\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'MatchEvent';
    }
}