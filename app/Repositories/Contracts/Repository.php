<?php 

namespace App\Repositories\Contracts;

interface Repository
{
    /**
     * Get all of the models from the data source.
     * 
     * @param array $related
     * @return \Illuminate\Support\Collection
     */
    public function all(array $related = null);

    /**
     * Get the paginated models from the data source.
     * 
     * @param  int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15);

    /**
     * Get a model by its primary key.
     *
     * @param int $id
     * @param array $related
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \App\Exceptions\ModelNotFoundException
     */
    public function get($id, array $related = null);

    /**
     * Get the model data by adding the given where query.
     * 
     * @param  string     $column
     * @param  mixed      $value
     * @param  array|null $related
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * @throws \App\Exceptions\ModelNotFoundException
     */
    public function getWhere($column, $value, array $related = null);

    /**
     * Get the model data by adding the given whereIn query.
     * 
     * @param  string     $column
     * @param  mixed      $value
     * @param  array|null $related
     * @return \Illuminate\Support\Collection
     */
    public function getWhereIn($column, $value, array $related = null);

    /**
     * Create a new instance of the model.
     *
     * @param  array  $attributes
     * @param  bool  $exists
     * @return static
     */
    public function newInstance(array $attributes, $exists);

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Get the first record matching the attributes or instantiate it.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNew(array $attributes);

    /**
     * Get the first record matching the attributes or create it.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate(array $attributes);

    /**
     * Update the model by the given attributes.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param  array  $attributes
     * @return bool|int
     */
    public function update($model, array $attributes);

    /**
     * Fill the model with an array of attributes and save it. Force mass assignment.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param  array  $attributes
     * @return bool
     */
    public function forceUpdate($model, array $attributes);

    /**
     * Chunk the results of the query.
     *
     * @param  int  $count
     * @param  callable  $callback
     * @return bool
     */
    public function chunk($count, callable $callback);

    /**
     * Check if any relation exists.
     *
     * @param int $id
     * @param  array  $relations
     * @return bool
     */
    public function hasRelations($id, array $relations);

    /**
     * Eager load relations on the model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  array|string  $relations
     * @return void
     */
    public function load($model, $relations);

    /**
     * Delete the model from the data source.
     *
     * @return \Illuminate\Database\Eloquent\Model $model
     * @return bool|null
     *
     * @throws \Exception
     */
    public function delete($id);

    /**
     * Begin querying the model.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query();
}
