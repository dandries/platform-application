<?php

namespace Oro\Bundle\IssuesBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\OrderedMigrationInterface;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class IssueType implements Migration, OrderedMigrationInterface
{

    public function up(Schema $schema, QueryBag $queries)
    {
        $this->createOroIssueTypeTable($schema);
    }

    /**
     * Create oro_issue_type table
     *
     * @param Schema $schema
     */
    protected function createOroIssueTypeTable(Schema $schema)
    {
        $table = $schema->createTable('oro_issue_type');
        $table->addColumn('name', 'string', ['length' => 32]);
        $table->addColumn('label', 'string', ['length' => 255]);
        $table->setPrimaryKey(['name']);
        $table->addUniqueIndex(['label'], 'UNIQ_5769A6DFEA750E8');
    }

    /**
     * Get the order of this migration
     *
     * @return integer
     */
    public function getOrder()
    {
        return 90;
    }
}