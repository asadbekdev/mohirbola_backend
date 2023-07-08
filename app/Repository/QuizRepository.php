<?php

namespace App\Repository;

use App\Interfaces\IQuizRepository;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class QuizRepository implements IQuizRepository
{
    public function getActiveQuizzes()
    {
        return Quiz::active()->get();
    }

    public function getById(int $id): Model|null
    {
        return Quiz::query()->with('questions')->findOrFail($id);
    }

    public function search(string $query): Collection|array
    {
        return Quiz::query()->where('name', 'LIKE', "%$query%")->get();
    }
}
