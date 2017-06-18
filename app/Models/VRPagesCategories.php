<?php

namespace App\Models;


class VRPagesCategories extends CoreModel
{
    protected $table = 'vr_pages_categories';

    protected $fillable = ['id', 'parent_id', 'name'];

    public function parent (  )
    {
        return $this->hasOne(VRPagesCategories::class, 'id', 'parent_id');
    }

    public function pages (  )
    {
        return $this->hasMany(VRPages::class, 'pages_categories_id', 'id')
            ->with(['translation'])->with(['cover_image']);
    }
}
