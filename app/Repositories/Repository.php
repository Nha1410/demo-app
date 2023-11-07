<?php
// app/Repositories/BaseRepository.php

namespace App\Repositories;

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

}
