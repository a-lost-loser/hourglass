<?php namespace Hourglass\Core\Database\Connections;

use Illuminate\Database\Connection as ConnectionBase;
use Hourglass\Core\Database\Schema\Builder as SchemaBuilder;

class Connection extends ConnectionBase
{
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new SchemaBuilder($this);
    }
}