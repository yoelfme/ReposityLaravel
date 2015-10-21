<?php
namespace Yoelfme\Repository;

interface RepositoryInterface
{
    public function all($columns = array('*'));

    public function take($limit);

    public function takeBy($limit, $field, $value);

    public function takeByWithRelations($limit, $field, $value);

    public function takeRandomByWithRelations($limit, $field, $value);

    public function allWithRelations($columns = array('*'));

    public function paginate($perPage = 10, $columns = array('*'));

    public function paginateWithAllRelations($perPage = 10, $columns = array('*'));

    public function paginateByFiltersWithAllRelations($filters = array(), $perPage = 10, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $entity);

    public function delete($entity);

    public function where($field, $value, $columns = array('*'));

    public function whereWithRelations($field, $value, $columns = array('*'));

    public function find($id, $columns = array('*'));

    public function findWithRelations($id, $columns = array('*'));

    public function findOrFail($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function findByWithRelations($field, $value, $columns = array('*'));

    public function listsIdAnd($display);

    public function listsField($field);

    public function listsFields($key, $value);

    public function whereIn($field, $whereIn = array());

    public function whereInWithRelations($field, $whereIn = array());

    public function random($columns = array('*'));

    public function orderBy($field = 'created_at', $order = 'ASC');
}
