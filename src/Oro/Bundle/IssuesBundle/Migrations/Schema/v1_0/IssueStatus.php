<?php
/**
 * Created by PhpStorm.
 * User: dandries
 * Date: 07.04.2016
 * Time: 10:55
 */

namespace Oro\Bundle\IssuesBundle\Migrations\Schema\v1_0;


class IssueStatus implements Migration
{

    public function up(Schema $schema, QueryBag $queries)
    {
        $this->createOroIssueStatusTable($schema);
    }

    /**
     * Create oro_issue_status table
     *
     * @param Schema $schema
     */
    protected function createOroIssueStatusTable(Schema $schema)
    {
        $table = $schema->createTable('oro_issue_status');
        $table->addColumn('name', 'string', ['length' => 32]);
        $table->addColumn('label', 'string', ['length' => 255]);
        $table->setPrimaryKey(['name']);
        $table->addUniqueIndex(['label'], 'UNIQ_F35C3A1AEA750E8');
    }
}