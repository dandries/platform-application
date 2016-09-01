<?php

namespace Oro\Bundle\IssuesBundle\Form\Type;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\IssuesBundle\Entity\IssueType as Type;
use Oro\Bundle\UserBundle\Entity\User;

class IssueType extends AbstractType
{
    const NAME = 'issue_type';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary', 'text', array(
                'required' => true
            ))
            ->add('code', 'text', array(
                'required' => true
            ))
            ->add('description', 'text', array(
                'required' => true
            ))
            ->add('type', 'entity', array(
                'class' => 'Oro\Bundle\IssuesBundle\Entity\IssueType',
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('itype');
                    return $qb->where($qb->expr()->neq('itype.name', $qb->expr()->literal(Type::SUBTASK)));
                }
            ))
            ->add('status', 'entity', array(
                'class' => 'Oro\Bundle\IssuesBundle\Entity\IssueStatus',
                'choice_label' => 'label',
            ))
            ->add('priority', 'entity', array(
                'class' => 'Oro\Bundle\IssuesBundle\Entity\IssuePriority',
                'choice_label' => 'label',
            ))
            ->add('assignee', 'entity', array(
                'class' => 'Oro\Bundle\UserBundle\Entity\User',
                'choice_label' => function (User $user) {
                    return $user->getFullName();
                },
                'empty_value' => '...',
            ))
            ->add('tags', 'oro_tag_select', array('label' => 'oro.tag.entity_plural_label'));
    }

    /**
     * @param OptionsResolver $resolver
     */
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
        return self::NAME;
    }
}
