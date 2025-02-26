<?php

namespace App\Repositories;

use App\Repositories\Traits\SimpleCRUD;
use App\Models\Shop;

class ShopRepository
{
    use SimpleCRUD;

    private string $model = Shop::class;

    public function getByEmail(string $email) {
        return $this->model::where('email', $email)->first();
    }

    public function getByName(string $name) {
        return $this->model::where('name', 'LIKE' ,"%$name%")->paginate(6);
    }

    public function filter(array $array) {
        $query = $this->model::query();

        if (isset($array['name'])) {
            $query->where('name', 'LIKE', "%$array[name]%");
        }

        if (isset($array['status'])) {
            if ($array['status'] == 'confirm') {
                $query->whereNotNull('email_verified_at')->whereNull('deleted_at');
            }
            if ($array['status'] == 'ban') {
                $query->whereNotNull('email_verified_at')->whereNotNull('deleted_at');
            }
            if ($array['status'] == 'pending') {
                $query->whereNull('email_verified_at');
            }
        }

        return $query->paginate(6);

    }
}
