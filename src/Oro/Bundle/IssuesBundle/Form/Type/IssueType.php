<?php

namespace Oro\Bundle\IssuesBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Oro\Bundle\IssuesBundle\Entity\Issue;
use Oro\Bundle\IssuesBundle\Entity\IssueType as Type;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueType extends AbstractType
{

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

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /* @var $issue Issue */
            $issue = $event->getData();
            $form = $event->getForm();

            if ($issue && $issue->getType() && $issue->getType()->getName() == Type::SUBTASK) {
                $form->add('parent', 'entity', array(
                    'class' => 'Oro\Bundle\IssuesBundle\Entity\Issue',
                    'required' => true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('i')
                            ->where('i.type = :type')
                            ->setParameter('type', Type::STORY);
                    },
                    'choice_label' => function (Issue $issue) {
                        return $issue->getCode() . ' \\ ' . $issue->getSummary();
                    },
                    'data' => $issue->getParent()
                ));
            }
        });
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
