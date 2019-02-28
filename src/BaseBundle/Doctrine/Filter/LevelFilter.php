<?php
namespace BaseBundle\Doctrine\Filter;

use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\ORM\Mapping\ClassMetadata;

class LevelFilter extends SQLFilter
{
    
    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($this->checkInterface($targetEntity)) {
            return sprintf('%s.%s = %s', $targetTableAlias, trim($this->getParameter('filedName'), "'"), $this->getParameter('filedValue'));
        } else {
            return '';
        }
    }
    
    private function checkEntity(ClassMetadata $targetEntity)
    {
        $entities = [
            'ArchiveBundle\Entity\CorrectPersonnel',
        ];
        
        return in_array($targetEntity->getReflectionClass()->name, $entities);
    }
    
    private function checkInterface(ClassMetadata $targetEntity)
    {
        return in_array('BaseBundle\Entity\LevelInterface', $targetEntity->getReflectionClass()->getInterfaceNames());
    }
}