<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Interface\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRepository extends Controller implements BaseRepositoryInterface
{
    protected Builder|Model $query;

    public function __construct()
    {
        if (!empty($this->model)) {
            $this->query = (new $this->model);
        }
    }

    public function get(int $id)
    {
        if(!$item = $this->query->find($id)){
            throw new HttpResponseException($this->jsonResponse(status: false, message: __('general.notFound'), statusCode: 404));
        }
        return $item;
    }

    public function getTrashed(int $id)
    {
        if(!$item = $this->query->onlyTrashed()->find($id)){
            throw new HttpResponseException($this->jsonResponse(status: false, message: __('general.notFound'), statusCode: 404));
        }
        return $item;
    }

    public function getWithTrashed(int $id)
    {
        if(!$item = $this->query->withTrashed()->find($id)){
            throw new HttpResponseException($this->jsonResponse(status: false, message: __('general.notFound'), statusCode: 404));
        }
        return $item;
    }

    public function getAll()
    {
        return $this->query->latest()->get();
    }

    public function destroy(int $id): bool
    {
        return $this->query->find($id)->delete();
    }

    public function create(array $data)
    {
        return $this->query->create($data);
    }

    public function update(int $id, array $data)
    {
        $model = $this->query->find($id);
        return tap($model)->update($data);
    }

    public function trash(int $id): bool
    {
        return $this->query->find($id)->delete();
    }

    public function delete(int $id)
    {
        $item=$this->getWithTrashed($id);
        return $item->forceDelete();
    }

    public function restore(int $id): bool
    {
        $item=$this->getTrashed($id);
        return $item->restore();
    }


}
