<?php

namespace App\Repository;

use App\Interfaces\IChildrenRepository;
use App\Models\Children;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

class ChildrenRepository implements IChildrenRepository
{
    /**
     * @param array $data
     * @return Model|Builder
     * @throws Exception
     */
    public function create(array $data): Model|Builder
    {
        return Children::query()->create($data);
    }

    public function update(int $id, array $data): bool|int
    {
        return Children::query()->find($id)->update($data);
    }

    public function delete(int $id)
    {
        return Children::query()->findOrFail($id)->delete();
    }

    public function checkCode(string $code)
    {
        return Children::ofCode($code)->first();
    }

    public function login(string $code, int $password)
    {
        return Children::ofLogin($code, $password)->first();
    }

    public function find(int $id)
    {
        return Children::query()->find($id);
    }
}
