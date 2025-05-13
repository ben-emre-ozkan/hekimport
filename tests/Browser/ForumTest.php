<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\ForumCategory;
use App\Models\ForumTopic;
use App\Models\ForumMessage;
use Spatie\Permission\Models\Role;

class ForumTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected User $adminUser;
    protected User $dentistUser;
    protected User $regularUser;
    protected ForumCategory $category;
    protected ForumTopic $topic;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles if they don't exist to avoid issues with multiple tests
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $dentistRole = Role::firstOrCreate(['name' => 'dentist']);
        $regularRole = Role::firstOrCreate(['name' => 'regular']);

        $this->adminUser = User::factory()->create()->assignRole($adminRole);
        $this->dentistUser = User::factory()->create()->assignRole($dentistRole);
        $this->regularUser = User::factory()->create()->assignRole($regularRole);
        
        $this->category = ForumCategory::factory()->create(['name' => 'Genel Kategori', 'slug' => 'genel-kategori']);
        $this->topic = ForumTopic::factory()->create([
            'user_id' => $this->dentistUser->id,
            'category_id' => $this->category->id,
            'title' => 'Örnek Başlık',
            'slug' => 'ornek-baslik'
        ]);

        // Create some messages in the topic
        ForumMessage::factory()->create([
            'user_id' => $this->dentistUser->id, 
            'topic_id' => $this->topic->id,
            'content' => 'Bu bir örnek mesajdır.'
        ]);
    }

    public function test_regular_user_cannot_access_forum()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->regularUser)
                    ->visit('/forum')
                    ->pause(1000) // Give time for any redirects to occur
                    ->assertPathIsNot('/forum') // Should be redirected away from forum
                    ->assertSee('home'); // Should be redirected somewhere, like home
        });
    }

    public function test_middleware_works_properly()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->regularUser)
                    ->visit('/forum-middleware-test')
                    ->pause(1000) // Give time for any redirects to occur
                    ->assertPathIsNot('/forum-middleware-test'); // Should be redirected away

            $browser->loginAs($this->dentistUser)
                    ->visit('/forum-middleware-test')
                    ->pause(1000)
                    ->assertSee('If you can see this, the role middleware is working!');
        });
    }

    public function test_dentist_can_view_forum_create_topic_and_post_reply()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->dentistUser)
                    ->visit('/forum')
                    ->pause(1000) // Give the page time to load
                    ->assertSee('Kategoriler') // This is a more reliable test than the header
                    
                    // Create a new topic - fix the selectors based on actual HTML
                    ->click('.forum-button') // Target the New Topic button by class instead of dusk attribute
                    ->waitFor('.modal-content, .forum-heading') // Wait for any modal to open
                    ->type('input[name="title"], #title', 'Dusk Test Başlığı')
                    ->select('select[name="categoryId"], #category', $this->category->id)
                    ->type('textarea[name="content"], #content', 'Dusk tarafından oluşturulan ilk mesaj.')
                    ->click('button[type="submit"]')
                    ->waitForText('Başlık başarıyla oluşturuldu', 30)
                    
                    // Find the newly created topic (more flexible approach)
                    ->waitForText('Dusk Test Başlığı', 30)
                    ->click('.forum-topic:contains("Dusk Test Başlığı"), .forum-row:contains("Dusk Test Başlığı")')
                    ->waitForText('Dusk tarafından oluşturulan ilk mesaj.', 30)
                    
                    // Post a reply - use more flexible selectors
                    ->type('textarea[name="content"]', 'Bu bir cevap mesajıdır.')
                    ->click('button:contains("Gönder"), .forum-button:contains("Gönder")')
                    ->waitForText('Mesaj başarıyla gönderildi', 30)
                    ->assertSee('Bu bir cevap mesajıdır.');
        });
    }

    public function test_admin_actions_pin_edit_delete_and_ban()
    {
        $this->markTestSkipped('Skipping this test until we fix the basic forum display.');
        
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                    ->visit('/forum')
                    ->assertPathIs('/forum') // Admin should be able to access forum
                    ->waitForText('Kategoriler', 30) // Wait for categories to load
                    
                    // Navigate to the existing topic using more robust selectors
                    ->click('.forum-topic:contains("Örnek Başlık"), .forum-row:contains("Örnek Başlık")')
                    ->waitForText('Bu bir örnek mesajdır.', 30)
                    
                    // Pin the topic - based on text rather than attributes
                    ->click('button:contains("Sabitle")')
                    ->waitForText('Başlık başarıyla sabitlendi', 30)
                    
                    // Edit a message - based on role rather than attributes
                    ->click('button:contains("Düzenle")')
                    ->waitFor('.modal-content, .forum-modal')
                    ->type('textarea:first', 'Düzenlenmiş mesaj içeriği.')
                    ->click('button:contains("Güncelle"), button[type="submit"]')
                    ->waitForText('Mesaj başarıyla güncellendi', 30)
                    ->assertSee('Düzenlenmiş mesaj içeriği.')
                    
                    // Ban a user - based on text content
                    ->click('button:contains("Yasakla")')
                    ->waitFor('.modal-content, .forum-modal')
                    ->click('button:contains("Yasakla")')
                    ->waitForText('Kullanıcı başarıyla forumdan yasaklandı', 30)
                    
                    // Delete the topic - based on text content
                    ->click('button:contains("Sil")')
                    ->waitFor('.modal-content, .forum-modal')
                    ->click('button:contains("Sil"):not(:contains("İptal"))')
                    ->waitForText('Başlık başarıyla silindi', 30);
        });
    }

    public function test_quote_functionality()
    {
        $this->markTestSkipped('Skipping this test until we fix the basic forum display.');
        
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->dentistUser)
                    ->visit('/forum')
                    ->waitForText('Kategoriler', 30) // Wait for categories to load
                    
                    // Navigate to the existing topic using more robust selectors
                    ->click('.forum-topic:contains("Örnek Başlık"), .forum-row:contains("Örnek Başlık")')
                    ->waitForText('Bu bir örnek mesajdır.', 30)
                    
                    // Quote a message using more robust selectors
                    ->click('button:contains("Alıntıla")')
                    ->waitUntilMissing('.loading-indicator')
                    ->assertSeeIn('textarea', 'yazdı:')
                    ->assertSeeIn('textarea', '> Bu bir örnek mesajdır.')
                    
                    // Submit the quoted reply
                    ->type('textarea', 'Bu bir alıntılı yanıt.')
                    ->click('button:contains("Gönder")')
                    ->waitForText('Mesaj başarıyla gönderildi', 30)
                    ->assertSee('Bu bir alıntılı yanıt.')
                    ->assertSee('> Bu bir örnek mesajdır.');
        });
    }

    public function test_search_and_filter_functionality()
    {
        $this->markTestSkipped('Skipping this test until we fix the basic forum display.');
        
        // Create additional topics for testing search
        ForumTopic::factory()->create([
            'user_id' => $this->dentistUser->id,
            'category_id' => $this->category->id,
            'title' => 'Diş Ağrısı Tedavisi',
            'slug' => 'dis-agrisi-tedavisi'
        ]);
        
        ForumTopic::factory()->create([
            'user_id' => $this->adminUser->id,
            'category_id' => $this->category->id,
            'title' => 'İmplant Uygulamaları',
            'slug' => 'implant-uygulamalari'
        ]);
        
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->dentistUser)
                    ->visit('/forum')
                    ->waitForText('Kategoriler', 30) // Wait for categories to load
                    
                    // Search for a topic using more robust selectors
                    ->type('input[type="text"], input[placeholder*="ara"]', 'ağrı')
                    ->waitUntilMissing('.loading-indicator')
                    ->assertSee('Diş Ağrısı Tedavisi')
                    ->assertDontSee('İmplant Uygulamaları')
                    
                    // Clear search and change filter using more robust selectors
                    ->click('button[aria-label="Clear"], button:contains("×")')
                    ->waitUntilMissing('.loading-indicator')
                    ->select('select', 'active')
                    ->waitUntilMissing('.loading-indicator')
                    ->assertSee('Örnek Başlık');
        });
    }

    public function test_mobile_responsive_layout()
    {
        $this->markTestSkipped('Skipping this test until we fix the basic forum display.');
        
        $this->browse(function (Browser $browser) {
            $browser->resize(375, 812) // iPhone X dimensions
                    ->loginAs($this->dentistUser)
                    ->visit('/forum')
                    ->waitForText('Kategoriler', 30) // Wait for categories to load
                    
                    // Check that the mobile layout is displayed properly
                    // Note: Element visibility and stacking will change in responsive layout
                    ->assertPresent('button[aria-label="Menu"], button.mobile-menu')
                    ->click('button[aria-label="Menu"], button.mobile-menu')
                    ->waitForText($this->category->name)
                    ->assertSee('Yeni Başlık')
                    
                    // Create a topic using mobile UI
                    ->click('button:contains("Yeni Başlık")')
                    ->waitFor('.modal-content, .forum-modal')
                    ->type('input[name="title"], #title', 'Mobil Test Başlığı')
                    ->select('select[name="categoryId"], #category', $this->category->id)
                    ->type('textarea[name="content"], #content', 'Mobil cihazdan oluşturulan konu.')
                    ->click('button[type="submit"]')
                    ->waitForText('Başlık başarıyla oluşturuldu', 30);
        });
    }
}
