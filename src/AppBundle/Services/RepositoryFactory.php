<?php

namespace AppBundle\Services;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RepositoryFactory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $persistentObjectName
     * @param null $persistentManagerName
     *
     * @return ObjectRepository
     */
    public function getRepository($persistentObjectName, $persistentManagerName = null)
    {
        return $this->getManagerRegistry()->getRepository($persistentObjectName, $persistentManagerName);
    }

    private function getManagerRegistry()
    {
        return $this->container->get('doctrine');
    }
}
