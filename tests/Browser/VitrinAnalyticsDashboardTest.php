<?php

namespace Tests\Browser;

use App\Models\ProfileVisit;
use App\Models\User;
use App\Models\Vitrin;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VitrinAnalyticsDashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test that the VitrinAnalyticsDashboard component works in the browser.
     * This verifies our fix for the 'visitor_id' column issue.
     */
    public function testVitrinAnalyticsDashboardLoadsCorrectly(): void
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create a vitrin
        $vitrin = Vitrin::factory()->create(['user_id' => $user->id]);
        
        // Create profile visits with same and different IPs
        ProfileVisit::create([
            'vitrin_id' => $vitrin->id,
            'ip_address' => '192.168.1.100',
            'created_at' => Carbon::now(),
        ]);
        
        ProfileVisit::create([
            'vitrin_id' => $vitrin->id,
            'ip_address' => '192.168.1.100', // Same IP
            'created_at' => Carbon::now()->subHour(),
        ]);
        
        ProfileVisit::create([
            'vitrin_id' => $vitrin->id,
            'ip_address' => '192.168.1.101', // Different IP
            'created_at' => Carbon::now()->subHours(2),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            // Use loginAs instead of form login to avoid issues
            $browser->loginAs($user)
                    ->visit('/masam/vitrinim')
                    // Just make a simple assertion that the page loads without errors
                    ->assertDontSee('Whoops, something went wrong')
                    ->screenshot('vitrin-analytics-dashboard');
        });
    }
}
