<?php

namespace App\Services;

use App\Domain\Repositories\CustomDomainRepository;
use App\Models\CustomDomain;
use App\Models\Vitrin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CustomDomainService
{
    protected $repository;

    public function __construct(CustomDomainRepository $repository)
    {
        $this->repository = $repository;
    }

    public function verifyDomainOwnership(Vitrin $vitrin, string $domain): bool
    {
        try {
            // Generate verification token
            $token = Str::random(32);
            
            // Store verification token in Redis
            Cache::put("domain_verification:{$domain}", $token, 3600);

            // Create DNS record suggestion
            $dnsRecord = [
                'type' => 'TXT',
                'name' => '_hekimport-verification',
                'value' => $token,
                'ttl' => 3600
            ];

            // Store DNS record suggestion in Redis
            Cache::put("dns_record:{$domain}", $dnsRecord, 3600);

            // Check DNS record
            return $this->checkDnsRecord($domain, $token);
        } catch (\Exception $e) {
            Log::error('Domain verification failed', [
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function checkDnsRecord(string $domain, string $token): bool
    {
        try {
            $response = Http::get("https://dns.google/resolve", [
                'name' => "_hekimport-verification.{$domain}",
                'type' => 'TXT'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Answer'][0]['data'])) {
                    $record = trim($data['Answer'][0]['data'], '"');
                    return $record === $token;
                }
            }
        } catch (\Exception $e) {
            Log::error('DNS record check failed', [
                'domain' => $domain,
                'error' => $e->getMessage()
            ]);
        }

        return false;
    }

    public function addCustomDomain(Vitrin $vitrin, string $domain): CustomDomain
    {
        // Verify domain ownership
        if (!$this->verifyDomainOwnership($vitrin, $domain)) {
            throw new \Exception('Domain ownership verification failed');
        }

        // Create custom domain record using repository
        return $this->repository->create([
            'vitrin_id' => $vitrin->id,
            'domain' => $domain,
            'status' => 'active',
            'verified_at' => now(),
        ]);
    }

    public function getDnsRecordSuggestion(string $domain): ?array
    {
        return Cache::get("dns_record:{$domain}");
    }

    public function removeCustomDomain(CustomDomain $customDomain): bool
    {
        return $this->repository->delete($customDomain);
    }
} 