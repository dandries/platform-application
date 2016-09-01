<?php
/**
 * Created by PhpStorm.
 * User: dandries
 * Date: 06.04.2016
 * Time: 17:20
 */

namespace Oro\Bundle\IssuesBundle\Entity;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="oro_issue_resolution")
 *
 * @Config()
 */
class IssueResolution
{
    const FIXED = 'fixed';
    const WONT_FIX = 'wont_fix';
    const DUPLICATE = 'duplicate';
    const INCOMPLETE = 'incomplete';
    const DONE = 'done';
    const WONT_DO = 'wont_do';
    const REJECTED = 'rejected';
    const CANNOT_REPRODUCE = 'cant_reproduce';

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
     * Get resolution name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set issue resolution label
     *
     * @param string $label
     * @return IssueResolution
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get issue resolution label
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
