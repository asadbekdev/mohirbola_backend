<?php

namespace App\Repository;

use App\Interfaces\IParentsRepository;
use App\Models\Parents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ParentsRepository implements IParentsRepository
{
    public function getParentByPhone(string $phone)
    {
        return Parents::ofPhone($phone)->first();
    }

    public function create(array $data): Model|Builder
    {
        return Parents::query()->create($data);
    }

    public function update(int $id, array $data): bool|int
    {
        return Parents::query()->find($id)->update($data);
    }

    public function setIsFree(int $id, bool $isFree)
    {
        /** @var Parents $parent */
        $parent = Parents::query()->find($id);
        $parent->setIsFree($isFree);
        $parent->save();
    }
}
