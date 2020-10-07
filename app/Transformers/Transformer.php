<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{

    /**
    * Transformer constructor
    * @return null
    */
    public function __constructor()
    {
        //
    }

    /**
    * Get array of transformed table timestamps
    * 
    * @param  mixed $object
    * @return array $arr
    */
    protected function getTransformedTimestampsArr($object)
    {
        $arr = [
            'created_at' => (string) $object->created_at,
            'updated_at' => (string) $object->updated_at,
        ];

        if(isset($object->deleted_at))
        {
            $arr['deleted_at'] = (string) $object->deleted_at;
        }

        return $arr;
    }

}
