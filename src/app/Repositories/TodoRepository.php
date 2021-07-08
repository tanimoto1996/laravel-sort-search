<?php

namespace App\Repositories;

use App\Models\Todo;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class TodoRepository
 * @package App\Repositories
 * @version July 8, 2021, 11:45 am JST
 */

class TodoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'title',
        'status'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Todo::class;
    }

    public function search($queryText, $status, $sort)
    {
        $query = Todo::where('user_id', Auth::id());
        // 検索機能に検索文字があれば絞り込む
        if ($queryText !== null) $query->where('title', 'LIKE', "%$queryText%");
        // 状態があれば、指定した状態だけを絞り込む
        if ($status !== null) $query->where('status', $status);
        // テーブルヘッダーのソートを変更する
        if ($sort === 'titleAsc') $query->orderBy('title', 'asc');
        if ($sort === 'titleDesc') $query->orderBy('title', 'desc');
        if ($sort === 'statusAsc') $query->orderBy('status', 'asc');
        if ($sort === 'statusDesc') $query->orderBy('status', 'desc');
        $todos = $query->get();
        return $todos;
    }
}
