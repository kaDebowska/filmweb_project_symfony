<?php
/**
 * Comment type.
 */

namespace App\Form\Type;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CommentType.
 */
class CommentType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'content',
            TextType::class,
            [
                'label' => 'label.content',
                'required' => true,
                'attr' => ['min_length' => 2, 'max_length' => 2000],
            ]
        );
        $builder->add(
            'authorEmail',
            EmailType::class,
            [
                'label' => 'label.author_email',
                'required' => true,
            ]
        );
        $builder->add(
            'authorNick',
            TextType::class,
            [
                'label' => 'label.author_nick',
                'required' => true,
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Comment::class]);
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
        return 'comment';
    }
}
