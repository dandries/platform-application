<?php

namespace Oro\Bundle\IssuesBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class IssueResolution implements Migration
{

    public function up(Schema $schema, QueryBag $queries)
    {
        $this->createOroIssueResolutionTable($schema);
    }

    /**
     * Create oro_issue_resolution table
     *
     * @param Schema $schema
     */
    protected function createOroIssueResolutionTable(Schema $schema)
    {
        $table = $schema->createTable('oro_issue_resolution');
        $table->addColumn('name', 'string', ['length' => 32]);
        $table->addColumn('label', 'string', ['length' => 255]);
        $table->setPrimaryKey(['name']);
        $table->addUniqueIndex(['label'], 'UNIQ_4A352091EA750E8');
    }
}