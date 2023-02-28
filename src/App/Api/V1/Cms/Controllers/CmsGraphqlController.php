<?php

namespace App\Api\V1\Cms\Controllers;

use Domain\Api\Models\ApiAccessToken;
use Domain\Cms\Graphql\CmsMutations;
use Domain\Cms\Graphql\CmsQueries;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\CmsTable;
use GraphQL\Error\DebugFlag;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Support\Services\Cms;

class CmsGraphqlController
{
    public function index(Request $request): JsonResponse
    {
        dd($request->server);
        dd($request->headers->get('referer') ?: $request->headers->get('origin'));

        $token = ApiAccessToken::findToken($request->bearerToken());

        Cms::createConnection($token->tokenable);

        $tables = CmsTable::with(CmsTableTableMap::RELATION_COLUMNS)
            ->orWhere(CmsTableTableMap::COL_MUTABLE, true)
            ->orWhere(CmsTableTableMap::COL_QUERYABLE, true)
            ->orWhere(CmsTableTableMap::COL_DELETABLE, true)
            ->get();

        $config = SchemaConfig::create()
            ->setQuery(CmsQueries::create($tables))
            ->setMutation(CmsMutations::create($tables));

        return Response::json(
            GraphQL::executeQuery(new Schema($config), $request->get('query'))
                ->toArray(DebugFlag::INCLUDE_DEBUG_MESSAGE)
        );
    }
}
