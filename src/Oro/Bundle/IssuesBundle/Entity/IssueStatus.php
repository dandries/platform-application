<?php
/**
 * Created by PhpStorm.
 * User: dandries
 * Date: 06.04.2016
 * Time: 17:20
 */

namespace Oro\Bundle\IssuesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * @ORM\Entity()
 * @ORM\Table(name="oro_issue_status")
 *
 * @Config()
 */
class IssueStatus
{

    const OPEN = 'new';
    const IN_PROGRESS = 'in_progress';
    const RESOLVED = 'resolved';
    const CLOSED = 'closed';
    const REOPENED = 'reopened';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=32)
     * @ORM\Id
     *
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "identity"=true
     *          }
     *      }
     * )
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, unique=true)
     */
    protected $label;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get status name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set issue status label
     *
     * @param string $label
     * @return IssueStatus
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get issue status label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->label;
    }
}