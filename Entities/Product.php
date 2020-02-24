<?php

namespace Modules\Shop\Entities;

use App\Helpers\SearchHelper;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Repositories\BrandRepository;

class Product extends Model {

    protected $table = 'filters'; // todo rename products

    protected $guarded = ['id'];
    protected $appends = ['_brand_name'];

    /** @var BrandRepository */
    protected $brandRepository;

    public function __construct(array $attributes = []) {
        $this->brandRepository = app(BrandRepository::class);
        parent::__construct($attributes);
    }

    public function setBrandNameAttribute($value) {
        $brand = $this->brandRepository->getWhereName($value);
        $this->attributes['brand_id'] = $brand->id;
    }

    public function getBrandNameAttribute() {
        $brand = $this->brandRepository->getWhereId($this->brand_id);
        return $brand->name;
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = trim($value);
        $this->attributes['search'] = SearchHelper::field($value);
    }

    public function brand() {
        return $this->belongsTo($this->brandRepository->getModel()->getMorphClass());
    }

}
