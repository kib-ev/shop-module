<?php

namespace Modules\Shop\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseShopRepository {

    /** @var Model */
    protected $model;

    abstract protected function getModel();

}
