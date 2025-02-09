<?php

namespace Core;

class MysqlDsnGenerator implements DsnGenerator
{
    public function __construct(protected string $host,protected string $dbName)
    {
    }

    public function getDsn(): string {
        return "mysql:host=$this->host;dbname=$this->dbName";
    }
}