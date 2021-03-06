<?php
declare(strict_types = 1);

namespace Agares\MicroORM;

final class QueryAdapter
{
    /**
     * @var DatabaseAdapterInterface
     */
    private $dbAdapter;

    /**
     * @var EntityMapperInterface
     */
    private $entityMapper;

    public function __construct(DatabaseAdapterInterface $dbAdapter, EntityMapperInterface $entityMapper)
    {
        $this->dbAdapter = $dbAdapter;
        $this->entityMapper = $entityMapper;
    }

    public function executeCommand($command, array $parameters = array())
    {
        $this->dbAdapter->executeCommand($command, $parameters);
    }

    public function executeQuery(string $query, EntityDefinition $entityDefinition, array $parameters = array())
    {
        $queryResult = $this->dbAdapter->executeQuery($query, $parameters);
        $entities = [];
        foreach($queryResult as $resultItem) {
            $entities[] = $this->entityMapper->map($resultItem, $entityDefinition);
        }

        return $entities;
    }
}