<?php

namespace Oro\Bundle\IssuesBundle\Tests\Unit\Entity;

use Oro\Bundle\NoteBundle\Entity\Note;

class TestNote extends Note
{
    protected $target;

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }
}
