<?php

namespace App\Models;


class VRPages extends CoreModel
{
    protected $table = 'vr_pages';

    protected $fillable = ['id', 'name', 'pages_categories_id', 'cover_image_id'];

    public function category (  )
    {
        return $this->hasOne(VRPagesCategories::class, 'id', 'pages_categories_id');
    }

    public function cover_image_id (  )
    {
        return $this->hasOne(VRResources::class, 'id', 'cover_image_id');
    }

    public function resourcesConnections (  )
    {
        return $this->hasMany(VRPagesResourcesConnections::class, 'pages_id', 'id')
            ->with(['resource']);
    }










    public function translations()
    {
        return $this->hasMany(VRPagesTranslations::class, 'pages_id', 'id')->where('languages_id', 'lt');
    }

}
