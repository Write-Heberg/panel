<?php

namespace Pterodactyl\Http\Controllers\Api\Client;

use Pterodactyl\Models\Server;
use Pterodactyl\Models\Permission;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Pterodactyl\Models\Filters\MultiFieldServerFilter;
use Pterodactyl\Transformers\Api\Client\ServerTransformer;
use Pterodactyl\Http\Requests\Api\Client\GetServersRequest;

class ClientController extends ClientApiController
{
    /**
     * ClientController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return all the servers available to the client making the API
     * request, including servers the user has access to as a subuser.
     */
    public function index(GetServersRequest $request): array
    {
        $user = $request->user();
        $transformer = $this->getTransformer(ServerTransformer::class);

        // Start the query builder and ensure we eager load any requested relationships from the request.
        $builder = QueryBuilder::for(
            Server::query()->with($this->getIncludesForTransformer($transformer, ['node']))
        )->allowedFilters([
            'uuid',
            'name',
            'description',
            'external_id',
            AllowedFilter::custom('*', new MultiFieldServerFilter()),
        ]);

        $type = $request->input('type');
        // Either return all the servers the user has access to because they are an admin `?type=admin` or
        // just return all the servers the user has access to because they are the owner or a subuser of the
        // server. If ?type=admin-all is passed all servers on the system will be returned to the user, rather
        // than only servers they can see because they are an admin.
        if (in_array($type, ['admin', 'admin-all'])) {
            // If they aren't an admin but want all the admin servers don't fail the request, just
            // make it a query that will never return any results back.
            $builder = $type === 'admin-all'
            ? ($user->role ? $builder : $builder->whereRaw('1 = 2'))
            : $builder->whereIn('servers.id', $user->subuserServers()->pluck('id')->all());
        } else {
            $builder = $builder->where('servers.owner_id', $user->id);
        }
    

        $servers = $builder->paginate(min($request->query('per_page', 50), 100))->appends($request->query());

        return $this->fractal->transformWith($transformer)->collection($servers)->toArray();
    }

    /**
     * Returns all the subuser permissions available on the system.
     */
    public function permissions(): array
    {
        return [
            'object' => 'system_permissions',
            'attributes' => [
                'permissions' => Permission::permissions(),
            ],
        ];
    }
}
