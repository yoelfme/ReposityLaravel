<?php

namespace Yoelfme\PatternRepository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Application;

/**
 * This is a class for implements a pattern repository in models Eloquent in Laravel
 * @package Yoelfme\PatternRepository
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * Instance of Illuminate\Foundation
     */
    protected $app = null;

    /**
     * Instance of Eloquent Model
     * @var Model
     */
    protected $model = null;

    /**
     * Variable with the list of relations of model
     * @var array
     */
    protected $relations = array();

    function __construct(Application $app) {
        $this->app = $app;
        $this->makeModel();
        $this->relations = $this->model->_relations;
    }

    /**
     * Function to return class with the namespace of Eloquent Model
     * @return string
     */
    abstract function model();

    /**
     * Function to create the instance of Eloquent Model
     * @return Model
     * @throws Exception
     */
    public function makeModel()
    {
        $name_model = $this->model();
        $model = $this->app->make($name_model);

        if(!$model instanceof Model) {
            throw new Exception("Class { $name_model } must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Return all rows of model, select all columns default
     * @param array $columns
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    /**
     * Return the number of rows given
     * @param $limit
     */
    public function take($limit)
    {
        return $this->model->get()->take($limit);
    }

    /**
     * Return the number of rows given but filtered the field by value given
     * @param $limit
     * @param $field
     * @param $value
     * @return mixed
     */
    public function takeBy($limit, $field, $value)
    {
        return $this->model->where($field, $value)->get()->take($limit);
    }

    /**
     * Return the number of rows given but filtered the field by value given with relations
     * @param $limit
     * @param $field
     * @param $value
     * @return mixed
     */
    public function takeByWithRelations($limit, $field, $value)
    {
        return $this->model->with($this->relations)->where($field, $value)->get()->take($limit);
    }

    /**
     * Return the number of random rows given but filtered the field by value given with relations only for MySQL Database
     * @param $limit
     * @param $field
     * @param $value
     * @return mixed
     */
    public function takeRandomByWithRelations($limit, $field, $value)
    {
        return $this->model->with($this->relations)->where($field, $value)
    	     ->orderBy(DB::raw('RAND()'))->get()->take($limit);
    }

    /**
     * Return all rows with relations
     * @param array $columns
     * @param array $where
     */
    public function allWhitRelations($columns = array('*'), $where = array())
    {
        return $this->model->with($this->relations)->get($columns);
    }

    /**
     * Return all rows paginate by value of $perPage
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 10, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Create a record of model
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a model pass the new data and id of record or entity
     * @param array $data
     * @param $entity
     * @return mixed
     */
    public function update(array $data, $entity)
    {
        if(is_numeric($entity))
        {
            $entity = $this->findOrFail($entity);
        }

        $entity->fill($data);
        $entity->save();

        return $entity;
    }

    /**
     * Delete a record by id of record or entity
     * @param $entity
     * @return null
     */
    public function delete($entity)
    {
        try
        {
            if(is_numeric($entity))
            {
              $this->model->destroy($entity);
            }
            else {
              $entity = $this->findOrFail($entity);
              $entity->delete();
            }
            return true;
        }
        catch(\Exception $e)
        {
            return false;
        }
    }

    /**
     * @param string $field
     * @param string $value
     * @param array $columns
     * @return mixed
     */
    public function where($field, $value, $columns = array('*'))
    {
        return $this->model->where($field, $value)->get($columns);
    }

    /**
     * @param string $field
     * @param string $value
     * @param array $columns
     * @return mixed
     */
    public function whereWithRelations($field, $value, $columns = array('*'))
    {
        return $this->model->with($this->relations)->where($field, $value)->get($columns);
    }


    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findWithRelations($id, $columns = array('*'))
    {
        return $this->model->with($this->relations)->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($field, $value, $columns = array('*'))
    {
        return $this->model->where($field, $value)->first($columns);
    }

    /**
     * @param string $field
     * @param string $value
     * @param array $columns
     * @return mixed
     */
    public function findByWithRelations($field, $value, $columns = array('*'))
    {
        return $this->model->with($this->relations)->where($field, $value)->first($columns);
    }

    /**
     * @param string $display
     */
    public function listsIdAnd($display)
    {
        return $this->model->lists($display, 'id');
    }

    /**
     * @param string $value
     */
    public function listsField($value)
    {
        return $this->model->lists($value);
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function listsFields($key, $value)
    {
        return $this->model->lists($value, $key);
    }


    /**
     * @param string $field
     * @param array $whereIn
     * @return mixed
     */
    public function whereIn($field, $whereIn = array())
    {
        return $this->model->whereIn($field, $whereIn)->get();
    }

    /**
     * @param string $field
     * @param array $whereIn
     * @return mixed
     */
    public function whereInWithRelations($field, $whereIn = array())
    {
        return $this->model->with($this->relations)->whereIn($field, $whereIn)->get();
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function random($columns = array('*'))
    {
        return $this->model->get()->random();
    }

    /**
     * Return data ordered by field
     * @param string $field
     * @param string $order
     */
    public function orderBy($field = 'created_at', $order = 'ASC')
    {
        return $this->model->with($this->relations)->orderBy($field, $order)->get();
    }
}
