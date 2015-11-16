<?php
/**
 * Created by PhpStorm.
 * User: Marc
 * Date: 16/11/2015
 * Time: 15:39
 */

namespace MG\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'player', 'choice',
            array(
                'label'=>'players',
                'choices' => array(1 => 'player1', 2 => 'player2')
            )
        )
        ->add(
            'event', 'choice',
            array(
                'label'=>'events',
                'choices' => array(1 => 'event1', 2 => 'female'),
            )
        );
    }

    public function getName()
    {
        return 'TestFormType';
    }
}