<?php

namespace ckuran;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use DoctrineExtensions\Query\Mysql\Date;

class DoctrineWrapper
{
    protected static $dbal = [];
    protected static $orm = [];

    /**
     * @param string $prefix
     *
     * @return Connection
     * @throws DBALException
     */
    public static function getConnection($prefix = 'default')
    {
        $credentials = self::getCredentials($prefix);

        if (!in_array($prefix, self::$dbal)) {
            $config = new Configuration();
            self::$dbal[$prefix] = DriverManager::getConnection($credentials, $config);
        }

        return self::$dbal[$prefix];
    }

    /**
     * @param string $prefix
     *
     * @return EntityManager
     * @throws ORMException
     */
    public static function getEntityManager($prefix = 'default')
    {
        $credentials = self::getCredentials($prefix);

        if (!in_array($prefix, self::$orm)) {
            $isDevMode = 'true' === getenv('DEV_MODE');
            $setup = Setup::createAnnotationMetadataConfiguration([$credentials['entities']], $isDevMode, ROOT . getenv('PROXY_DIR'), null, false);
            $setup->setNamingStrategy(new UnderscoreNamingStrategy());
            $setup->addCustomDatetimeFunction('DATE', Date::class);

            self::$orm[$prefix] = EntityManager::create($credentials, $setup);
        }

        return self::$orm[$prefix];
    }

    /**
     * @param $prefix
     *
     * @return array
     */
    private static function getCredentials($prefix)
    {
        $config = [
            'driver'   => getenv($prefix . '_DB_DRIVER'),
            'host'     => getenv($prefix . '_DB_HOST'),
            'user'     => getenv($prefix . '_DB_USER'),
            'password' => getenv($prefix . '_DB_PASSWORD'),
            'dbname'   => getenv($prefix . '_DB_NAME'),
            'charset'  => getenv($prefix . '_DB_CHARSET'),
            'entities' => getenv($prefix . '_ENTITY_DIR')
        ];

        return $config;
    }
}
