<?php

namespace App\Models;


class VRPages extends CoreModel
{
    protected $table = 'vr_pages';

    protected $fillable = ['id', 'name', 'pages_categories_id', 'cover_image_id'];





    public function category (  )
    {
        return $this->hasOne(VRPagesCategories::class, 'id', 'pages_categories_id')
            ->with(['parent']);
    }

    public function cover_image (  )
    {
        return $this->hasOne(VRResources::class, 'id', 'cover_image_id');
    }

    public function resourcesConnections (  )
    {
        return $this->hasMany(VRPagesResourcesConnections::class, 'pages_id', 'id')
            ->with(['resource']);
    }

    public function translation()
    {
        return $this->hasOne(VRPagesTranslations::class, 'pages_id', 'id')->where('languages_id', app()->getLocale());
    }

}
    //TODO reik pakeisti languages_id is 'lt' i locale, kad imtu kalba kurios reikia useriui

