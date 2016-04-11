<?php

namespace Oro\Bundle\IssuesBundle\Entity;

use BeSimple\SoapBundle\ServiceDefinition\Annotation as Soap;

use Oro\Bundle\SoapBundle\Entity\SoapEntityInterface;


/**
 * @Soap\Alias("Oro.Bundle.IssuesBundle.Entity.Issue")
 */
class IssueSoap extends Issue implements SoapEntityInterface
{

    /**
     * @Soap\ComplexType("int", nillable=true)
     */
    protected $id;

    /**
     * @Soap\ComplexType("string", nillable=false)
     */
    protected $summary;

    /**
     * @Soap\ComplexType("string", nillable=false)
     */
    protected $code;

    /**
     * @Soap\ComplexType("string", nillable=false)
     */
    protected $description;

    /**
     * @Soap\ComplexType("string", nillable=false)
     */
    protected $type;

    /**
     * @Soap\ComplexType("string", nillable=false)
     */
    protected $priority;

    /**
     * @Soap\ComplexType("string", nillable=true)
     */
    protected $resolution;

    /**
     * @Soap\ComplexType("string", nillable=false)
     */
    protected $status;

    /**
     * Init soap entity with original entity
     *
     * @param Issue $issue
     */
    public function soapInit($issue)
    {
        $this->id = $issue->getId();
        $this->summary = $issue->getSummary();
        $this->code = $issue->getCode();
        $this->description = $issue->getDescription();
        $this->type = $issue->getType()->getName();
        $this->status = $issue->getStatus()->getName();
        $this->priority = $issue->getPriority()->getName();
        $this->resolution = $issue->getResolution()->getName();
    }
}