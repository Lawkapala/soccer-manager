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
    {echo "<pre>FORM OPTIONS :: ";print_r($options);echo "</pre>";
        $builder->add(
            'player', 'choice',
            array(
                'label' => 'Jugadores',
                'choices' => $options['data'][0]
            )
        )
        ->add(
            'event', 'choice',
            array(
                'label' => 'Eventos',
                'choices' => $options['data'][1],
            )
        )
        ->add(
            'acount', 'text',
            array(
                'label' => 'Cantidad',
                'data'  => 1
            )
        );
    }

    public function getName()
    {
        return 'TestFormType';
    }
}