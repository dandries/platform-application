<?php

namespace Oro\Bundle\IssuesBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class IssuePriority implements Migration
{

    public function up(Schema $schema, QueryBag $queries)
    {
        $this->createOroIssuePriorityTable($schema);        
    }

    /**
     * Create oro_issue_priority table
     *
     * @param Schema $schema
     */
    protected function createOroIssuePriorityTable(Schema $schema)
    {
        $table = $schema->createTable('oro_issue_priority');
        $table->addColumn('name', 'string', ['length' => 32]);
        $table->addColumn('label', 'string', ['length' => 255]);
        $table->addColumn('order', 'integer', []);
        $table->setPrimaryKey(['name']);
        $table->addUniqueIndex(['label'], 'UNIQ_CF28BF98EA750E8');
    }    
}