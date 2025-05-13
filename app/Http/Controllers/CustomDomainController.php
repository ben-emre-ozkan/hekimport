<?php

namespace App\Http\Controllers;

use App\Models\CustomDomain;
use App\Services\CustomDomainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomDomainController extends Controller
{
    protected $customDomainService;

    public function __construct(CustomDomainService $customDomainService)
    {
        $this->customDomainService = $customDomainService;
    }

    public function index()
    {
        $vitrin = Auth::user()->vitrin;
        $customDomains = $vitrin->customDomains;
        $dnsRecord = null;

        if ($customDomains->isNotEmpty()) {
            $dnsRecord = $this->customDomainService->getDnsRecordSuggestion($customDomains->first()->domain);
        }

        return view('custom-domains.index', [
            'customDomains' => $customDomains,
            'dnsRecord' => $dnsRecord,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|string|max:255|unique:custom_domains,domain',
        ]);

        try {
            $vitrin = Auth::user()->vitrin;
            $customDomain = $this->customDomainService->addCustomDomain($vitrin, $request->domain);

            return redirect()->route('custom-domains.index')
                ->with('success', 'Domain başarıyla eklendi. Lütfen DNS kaydını doğrulayın.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Domain eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function destroy(CustomDomain $domain)
    {
        try {
            $this->customDomainService->removeCustomDomain($domain);

            return redirect()->route('custom-domains.index')
                ->with('success', 'Domain başarıyla kaldırıldı.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Domain kaldırılırken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function verify(CustomDomain $domain)
    {
        try {
            $verified = $this->customDomainService->verifyDomainOwnership($domain->vitrin, $domain->domain);

            if ($verified) {
                $domain->update([
                    'status' => 'active',
                    'verified_at' => now(),
                ]);

                return redirect()->route('custom-domains.index')
                    ->with('success', 'Domain doğrulaması başarılı.');
            }

            return redirect()->route('custom-domains.index')
                ->with('error', 'Domain doğrulaması başarısız. Lütfen DNS kaydını kontrol edin.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Domain doğrulanırken bir hata oluştu: ' . $e->getMessage());
        }
    }
} 