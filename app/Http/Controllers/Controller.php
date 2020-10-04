<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get transformed data of a particular Model
     * @param  mixed $object
     * @param  callback[mixed] $callback
     * @return array
     */
    public function getTransformedData($object, $callback, $parseIncludesArr = [])
    {

      $parseIncludesArr = array_unique(array_merge($parseIncludesArr, explode(',', request()->get('includes'))));

    	return fractal($object, $callback)
                  ->parseIncludes($parseIncludesArr)
                  ->toArray();
    }

    /**
     * Get transformed data for collection.
     * @param  Collection $collection
     * @param  callback $callback
     * @return array
     */
    public function getTransformedCollectionData($collection, $callback, $metaArr = [], $parseIncludesArr = [])
    {
        $parseIncludesArr = array_unique(array_merge($parseIncludesArr, explode(',', request()->get('includes'))));

        return fractal()
                  ->collection($collection, $callback)
                  ->parseIncludes($parseIncludesArr)
                  ->toArray();
    }

    /**
     * Get transformed data with pagination of a particular Model
     * @param  mixed $paginatedObject
     * @param  callback[mixed] $callback
     * @return array
     */
    public function getTransformedDataWithPagination($paginatedObject, $callback, $metaArr = [], $parseIncludesArr = [])
    {

      $parseIncludesArr = array_unique(array_merge($parseIncludesArr, explode(',', request()->get('includes'))));

      $paginatedObject->appends(request()->except('_token', '_method'));

      $collection = $paginatedObject->getCollection();

      return fractal()
                ->collection($collection, $callback)
                ->parseIncludes($parseIncludesArr)
                ->paginateWith(new \League\Fractal\Pagination\IlluminatePaginatorAdapter($paginatedObject))
                ->addMeta($metaArr)
                ->toArray();
    }

    /**
     * Get transformed data of a particular Model with meta data
     *
     * @param  mixed      $object
     * @param  callback   $callback
     * @param  array      $metaArr
     * @return array
     */
    public function getTransformedDataWithMeta($object, $callback, $metaArr = [], $parseIncludesArr = [])
    {

      $parseIncludesArr = array_unique(array_merge($parseIncludesArr, explode(',', request()->get('includes'))));

      return fractal($object, $callback)
                  ->parseIncludes($parseIncludesArr)
                  ->addMeta($metaArr)
                  ->toArray();
    }
}
