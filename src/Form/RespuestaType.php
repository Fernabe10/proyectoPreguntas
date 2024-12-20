<?php
namespace App\Form;

use App\Entity\Respuesta;
use App\Entity\Pregunta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RespuestaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $pregunta = $options['pregunta']; 

        
        $respuestas = [
            $pregunta->getRespuesta1(),
            $pregunta->getRespuesta2(),
            $pregunta->getRespuesta3(),
            $pregunta->getRespuesta4(),
        ];

        $builder
            ->add('respuesta', ChoiceType::class, [
                'choices' => array_combine($respuestas, $respuestas),
                'expanded' => true,  
                'multiple' => false, 
                'label' => 'Selecciona tu respuesta',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Debe seleccionar una respuesta.',
                    ]),
    
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Respuesta::class,
            'pregunta' => null,
        ]);
    }
}
