<?php

namespace Support\Services;

use Config;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\Cms as CmsDatabase;
use Domain\Cms\Models\CmsTable;
use Illuminate\Support\Facades\DB;

class Cms
{
    /**
     * @var CmsTable|null
     */
    private static ?CmsTable $table = null;

    /**
     * @var CmsDatabase|null
     */
    private static ?CmsDatabase $database = null;

    /**
     * @param int $id
     *
     * @return void
     */
    public static function findAndCreateConnection(int $id): void
    {
        $cms = CmsDatabase::find($id);

        if ($cms instanceof CmsDatabase) {
            self::createConnection($cms);
        }
    }

    /**
     * @param CmsDatabase $cms
     *
     * @return void
     */
    public static function createConnection(CmsDatabase $cms): void
    {
        if ($cms->isNot(self::$database)) {
            $default = Config::get('database.connections.cms', []);

            Config::set('database.connections.cms', [
                ...$default,
                'database' => $cms->database,
                'username' => $cms->username->decrypt,
                'password' => $cms->password->decrypt,
            ]);

            DB::connection('cms')->reconnect();

            self::$database = $cms;
        }
    }

    /**
     * @param int|string $id
     * @param string     $key
     *
     * @return void
     */
    public static function findAndSetTable(int|string $id, string $key): void
    {
        $table = CmsTable::where($key, $id)->with(CmsTableTableMap::RELATION_COLUMNS)->first();

        if ($table instanceof CmsTable) {
            self::setTable($table);
        }
    }

    /**
     * @return CmsTable|null
     */
    public static function getTable(): ?CmsTable
    {
        return self::$table;
    }

    /**
     * @param CmsTable $table
     *
     * @return void
     */
    public static function setTable(CmsTable $table): void
    {
        self::$table = $table;
    }
}
