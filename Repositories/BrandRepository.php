<?php

namespace Modules\Shop\Repositories;

use Illuminate\Support\Str;
use Modules\Shop\Entities\Brand as Model;

class BrandRepository extends BaseShopRepository {

    /**
     * Get new filter model instance
     * @return Model
     */
    public function getModel() {
        return new Model();
    }

    public function getWhereId($id) {
        return $this->getModel()
            ->where('id', $id)
            ->first();
    }

    public function getWhereName($name) {
        return $this->getModel()
            ->where('name', $name)
            ->first();
    }

    public function getWhereNameOrCreate($name) {
        $brand = $this->getModel()
            ->where('name', $name)
            ->first();

        if (!$brand) {
            $brand = (new BrandRepository())->getModel();
            $brand->name = $name;
            $brand->slug = Str::slug($name);
            $brand->save();
        }

        return $brand;
    }

    public function getWhereSlug($slug) {
        return $this->getModel()
            ->where('slug', $slug)
            ->first();
    }

}
