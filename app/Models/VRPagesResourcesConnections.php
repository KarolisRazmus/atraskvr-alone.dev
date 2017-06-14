<?php

namespace App\Models;


class VRPagesResourcesConnections extends CoreModel
{
    protected $table = 'vr_pages_resources_connections';

    protected $fillable = ['id', 'pages_id', 'resources_id'];

    public function resource (  )
    {
        return $this->hasOne(VRResources::class, 'id', 'resources_id');
    }
}
