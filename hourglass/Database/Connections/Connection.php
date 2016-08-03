<?php namespace Hourglass\Database\Connections;

use Illuminate\Database\Connection as ConnectionBase;
use Hourglass\Database\Schema\Builder as SchemaBuilder;

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