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
 * @ORM\Table(name="oro_issue_priority")
 *
 * @Config()
 */
class IssuePriority
{

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

    /**
     * @var string
     *
     * @ORM\Column(name="`order`", type="integer")
     */
    protected $order;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get priority name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set issue priority label
     *
     * @param string $label
     * @return IssuePriority
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get issue priority label
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

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order
     *
     * @param string $order
     * @return IssuePriority
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function __toString()
    {
        return (string) $this->label;
    }
}
