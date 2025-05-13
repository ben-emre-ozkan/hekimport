<?php

namespace App\Domain\Repositories;

use App\Models\CustomDomain;
use App\Models\Vitrin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CustomDomainRepository
{
    public function findByDomain(string $domain): ?CustomDomain
    {
        return CustomDomain::where('domain', $domain)->first();
    }

    public function findByVitrin(Vitrin $vitrin)
    {
        return CustomDomain::where('vitrin_id', $vitrin->id)->get();
    }

    public function create(array $data): CustomDomain
    {
        $domain = CustomDomain::create($data);
        
        // Clear Redis cache
        Redis::del("vitrin:{$domain->vitrin->subdomain}");
        
        return $domain;
    }

    public function delete(CustomDomain $domain): bool
    {
        $result = $domain->delete();
        
        if ($result) {
            // Clear Redis cache
            Redis::del("vitrin:{$domain->vitrin->subdomain}");
        }
        
        return $result;
    }

    public function updateStatus(CustomDomain $domain, string $status): bool
    {
        $result = $domain->update(['status' => $status]);
        
        if ($result) {
            // Clear Redis cache
            Redis::del("vitrin:{$domain->vitrin->subdomain}");
        }
        
        return $result;
    }
} 