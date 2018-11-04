<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 29.10.18
 * Time: 09:35.
 */

namespace Foundation\Abstracts\Transformers;

use Foundation\Contracts\Transformable;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Transformer extends JsonResource implements Transformable
{
    public function include()
    {
        return $this;
    }

    public static function resource($model): self
    {
        return new static($model);
    }

    public static function collection($resource)
    {
        return new AnonymousTransformerCollection($resource, static::class, []);
    }

    public function serialize()
    {
        return json_decode(json_encode($this->jsonSerialize()), true);
    }
}
