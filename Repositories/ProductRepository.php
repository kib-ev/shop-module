<?php

namespace Modules\Shop\Repositories;

use Modules\Shop\Entities\Product as Model;

class ProductRepository extends BaseShopRepository {

    /**
     * Get new filter model instance
     * @return Model
     */
    public function getModel() {
        return new Model();
    }

    public function getWhereId($id) {
        return $this->getModel()->where('id', $id)->first();
    }
}
