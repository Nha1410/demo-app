<?php
// app/Repositories/BaseRepository.php

namespace App\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

abstract class Repository
{
    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function model()
    {
        return app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->model()->all();
    }


    public function __call($name, $arguments)
    {
        return $this->model()->{$name}(...$arguments);
    }


    /**
     * Safely execute database interactions using transaction.
     *
     * @param  \Closure  $callback
     * @param  string  $titleError
     * @return mixed
     */
    protected function handleSafely(\Closure $callback, $titleError = 'Process')
    {
        DB::beginTransaction();

        try {
            $result = call_user_func($callback);
            DB::commit();

            return $result;
        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error("{$titleError}: {$e->getMessage()}");

            return null;
        }
    }

    protected function getList($query, $filters, array $columns = ['*'])
    {
        $page = Arr::get($filters, 'page', 1);
        $perPage = Arr::get($filters, 'per_page', 10);

        return $query->orderByDesc('created_at')
            ->paginate($perPage, $columns, 'page', $page)
            ->items();
    }
}
