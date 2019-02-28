<?php
namespace BaseBundle\Service;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class UuidService
{
    /**
     * $version 1 3 4 5
     * @param number $version
     * @return number[]|string[]|number[]|mixed[]|number[]|NULL[]
     */
    public function generate($version = 5)
    {
        try {
            $baseName = microtime(true) . mt_rand(0, 9);
            switch ($version) {
                case 1:
                    // Generate a version 1 (time-based) UUID object
                    $uuid = Uuid::uuid1();
                    break;
                case 3:
                    // Generate a version 3 (name-based and hashed with MD5) UUID object
                    $uuid = Uuid::uuid3(Uuid::NAMESPACE_DNS, $baseName);
                    break;
                case 4:
                    // Generate a version 4 (random) UUID object
                    $uuid = Uuid::uuid4();
                    break;
                case 5:
                    // Generate a version 5 (name-based and hashed with SHA1) UUID object
                    $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $baseName);
                    break;
                default:
                    return [
                        'code' => 2,
                        'data' => 'version error'
                    ];
                    break;
            }
            return [
                'code' => 1,
                'data' => str_replace('-', '', $uuid->toString())
            ];
        } catch (UnsatisfiedDependencyException $e) {
            // Some dependency was not met. Either the method cannot be called on a
            // 32-bit system, or it can, but it relies on Moontoast\Math to be present.
            return [
                'code' => 0,
                'data' => $e->getMessage()
            ];
        }
    }
}
