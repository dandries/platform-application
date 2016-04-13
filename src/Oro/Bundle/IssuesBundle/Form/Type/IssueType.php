<?php

namespace Oro\Bundle\IssuesBundle\Form\Type;


use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', 'text', array(
                'required' => true
            ))
            ->add('code')
            ->add('description')
            ->add('type', 'entity', array(
                'class' => 'Oro\Bundle\IssuesBundle\Entity\IssueType',
                'choice_label' => 'label',
                'empty_value' => '...',
            ))
            ->add('status', 'entity', array(
                'class' => 'Oro\Bundle\IssuesBundle\Entity\IssueStatus',
                'choice_label' => 'label',
                'empty_value' => '...',
            ))
            ->add('priority', 'entity', array(
                'class' => 'Oro\Bundle\IssuesBundle\Entity\IssuePriority',
                'choice_label' => 'label',
                'empty_value' => '...',
            ))
            ->add('resolution', 'entity', array(
                'class' => 'Oro\Bundle\IssuesBundle\Entity\IssueResolution',
                'choice_label' => 'label',
                'empty_value' => '...',
            ))
            ->add('assignee', 'entity', array(
                'class' => 'Oro\Bundle\UserBundle\Entity\User',
                'choice_label' => function(User $user){
                    return $user->getFirstName() . ' ' . $user->getMiddleName() . ' ' . $user->getLastName();
                },
                'empty_value' => '...',
            ))
            ->add('tags', 'oro_tag_select', array(
                    'label' => 'oro.tag.entity_plural_label',
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Oro\Bundle\IssuesBundle\Entity\Issue',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'issue_type';
    }
}