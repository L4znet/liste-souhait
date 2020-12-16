<?php

namespace Core;

use PDO;
use Core\QueryBuilder;

abstract class Model
{
    protected $attributes = [];
    public static $table_name = null;

    public static function find($id)
    {
        //$query_builder = QueryBuilder::model(static::class);

        return static::query()->where('id', $id)->first();
    }

    public static function get()
    {
        //$query_builder = QueryBuilder::model(static::class);

        return static::query()->orderByDesc('created_at')->get();
    }

    public static function create($data)
    {
        //$query_builder = QueryBuilder::model(static::class);
        
        $id = static::query()->insert($data);
        return static::find($id);
    }

    public static function update($data, $id)
    {
        //$query_builder = QueryBuilder::model(static::class);

        static::query()->where('id', $id)->update($data);

        return static::find($id);
    }

    public static function destroy($id)
    {
        //$query_builder = QueryBuilder::model(static::class);

        static::query()->where('id', $id)->delete();
    }

    public static function query()
    {
        return QueryBuilder::model(static::class);
    }

    public static function __callStatic($name, $arguments)
    {
        $query_builder = QueryBuilder::model(static::class);
        
        if (method_exists($query_builder, $name)) {
            return call_user_func_array([$query_builder, $name], $arguments);
        }
    }

    public function __get($name)
    {
        // passer du snake_case au PascalCase pour créer le nom du getter
        $getter = 'get' . str_replace('_', '', ucwords($name, '_')) . 'Value';

        $value = $this->attributes[$name] ?? null;

        if (method_exists($this, $getter)) {
            return $this->{$getter}($value);
        } else {
            return $value;
        }
    }

    public function __set($name, $value)
    {
        // passer du snake_case au PascalCase pour créer le nom du getter
        $setter = 'set' . str_replace('_', '', ucwords($name, '_')) . 'Value';
        
        if (method_exists($this, $setter)) {
            $this->attributes[$name] = $this->{$setter}($value);
        } else {
            $this->attributes[$name] = $value;
        }
    }
}
