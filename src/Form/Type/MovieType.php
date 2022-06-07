<?php
/**
 * Movie type.
 */

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Movie;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TaskType.
 */
class MovieType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param array<string, mixed> $options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label.title',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'year',
            \Symfony\Component\Form\Extension\Core\Type\IntegerType::class,
            [
                'label' => 'label.year',
                'required' => true,
                'attr' => ['min' => 1900, 'max' => 2022],
            ]
        );
        $builder->add(
            'duration',
            \Symfony\Component\Form\Extension\Core\Type\IntegerType::class,
            [
                'label' => 'label.duration',
                'required' => true,
                'attr' => ['min' => 60, 'max' => 180],
            ]
        );
        $builder->add(
            'director',
            TextType::class,
            [
                'label' => 'label.director',
                'required' => true,
                'attr' => ['max_length' => 45],
            ]
        );
        $builder->add(
            'description',
            TextareaType::class,
            [
                'label' => 'label.description',
                'required' => true,
                'attr' => ['max_length' => 2000],
            ]
        );
        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category): string {
                    return $category->getTitle();
                },
                'label' => 'label.category',
                'placeholder' => 'label.none',
                'required' => true,
                'expanded' => true,
                'multiple' => true,
            ]
        );
    }

    /**
     * Configures the options for this type.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Movie::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'movie';
    }
}
