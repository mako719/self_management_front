<?php

namespace App\Foundation\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class CacheUserProvider extends EloquentUserProvider
{
    protected $cache;
    protected $cacheKey = "authenticatio:user:%s";
    protected $lifeTime;

    public function __construct(
        HasherContract $hasher,
        string $model,
        CacheRepository $cache,
        int $lifeTime = 120
    ) {
        Parent::__construct($hasher, $model);
        $this->cache = $cache;
        $this->lifeTime = $lifeTime;
    }

    public function retrieveById($identifier)
    {
        $cacheKey = sprintf($this->cacheKey, $identifier);
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $result = parent::retrieveById($identifier);
        if (is_null($result)) {
            return null;
        }
        $this->cache->add($cacheKey, $result, $this->lifeTime);
    }

    public function retrieveByToken($identifier, $token)
    {
        $model = $this->retrieveById($identifier);
        if (!$model) {
            return null;
        }

        $rememberToken = $model->getRememberToken();
        return $rememberToken && hash_equals($rememberToken, $token) ? $model : null;
    }
}
