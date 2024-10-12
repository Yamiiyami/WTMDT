<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository 
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all($relations = [])
    {
        return $this->model->with($relations)->get();
    }

    public function find($id,$relations=[])
    {
        return $this->model->with($relations)->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return false;
    }

    public function delete($id)
    {
        $record = $this->model->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    public function findBy(string $column, $value, $relations=[])
    {
        return $this->model->with($relations)->where($column, $value)->first();
    }

    public function findAllBy(string $column, $value,$relations=[],$columns=['*'])
    {
        return $this->model->with($relations)->where($column, $value)->select($columns)->get();
    }

    public function findWithWhere(array $conditions){
        $query = $this->model->newQuery();
        foreach($conditions as $column => $value ){
            $query->where($column,$value);
        }
        return $query->first();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function count()
    {
        return $this->model->count();
    }

    public function countBy(string $column, $value)
    {
        return $this->model->where($column, $value)->count();
    }

    public function pluck(string $column, string $key = null)
    {
        return $this->model->pluck($column, $key);
    }

    public function updateOrCreate(array $attributes, array $values)
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    public function bulkInsert(array $data)
    {
        return $this->model->insert($data);
    }

    public function exists(string $column, $value)
    {
        return $this->model->where($column, $value)->exists();
    }

    public function exitstsWhere(array $conditions){
        $query = $this->model;

        foreach($conditions as $column => $value){
            $query->where($column,$value);
        }
        return $query->exists();
    }

    public function search(array $columns, string $keyword)
    {
        $query = $this->model->query();
        foreach ($columns as $column) {
            $query->orWhere($column, 'like', '%' . $keyword . '%');
        }
        return $query->get();
    }

    public function whereIn(string $column, array $values)
    {
        return $this->model->whereIn($column, $values)->get();
    }

    public function whereNotIn(string $column, array $values)
    {
        return $this->model->whereNotIn($column, $values)->get();
    }

    public function firstOrCreate(array $attributes, array $values = [])
    {
        return $this->model->firstOrCreate($attributes, $values);
    }

}