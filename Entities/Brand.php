<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Shop\Repositories\BrandRepository;

class Brand extends Model {

    use SoftDeletes;

    protected $guarded = ['id'];
    protected $appends = ['_parent_name'];

    public function parent() {
        return $this->hasOne($this->getMorphClass(), 'id', 'parent_id');
    }

    public function children() {
        return $this->hasMany($this->getMorphClass(), 'parent_id', 'id');
    }

    public function products() {
        return $this->hasMany(Product::class); // mb todo ProductRepository
    }

    public function setParentNameAttribute($value) {
        $brand = (new BrandRepository())->getModel()
            ->where('name', $value)
            ->first();
        $this->attributes['parent_id'] = @$brand->id;
    }

    public function getParentNameAttribute() {
        $brand = (new BrandRepository())->getModel()
            ->where('id', $this->parent_id)
            ->first();
        return $brand ? $brand->name : null;
    }

    public function setSlugAttribute($value) {
        if ($value == '' || $value == null) {
            $slug = Str::slug($this->name);
        } else {
            $slug = Str::slug($value);
        }

        $slugExists = (new BrandRepository())->getModel()
            ->where('slug', $slug)
            ->where('id', '!=', $this->id)
            ->first();
        if($slugExists) {
            dd(__METHOD__, "Slug: $slug already exists"); // todo unique
        }

        $this->attributes['slug'] = $slug;
    }

}
