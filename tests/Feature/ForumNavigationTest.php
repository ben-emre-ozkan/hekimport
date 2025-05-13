<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ForumCategory;
use App\Models\ForumTopic;
use App\Models\ForumMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Livewire\Livewire; // Use Livewire test helpers if needed later

class ForumNavigationTest extends TestCase
{
    use RefreshDatabase;

    protected User $dentistUser;
    protected User $regularUser;
    protected ForumCategory $category1;
    protected ForumCategory $category2;
    protected ForumTopic $topic1;
    protected ForumTopic $topic2;
    protected ForumTopic $topic3;
    protected ForumMessage $message1_1;
    protected ForumMessage $message1_2;
    protected ForumMessage $message2_1;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users with specific roles (adjust role names if different)
        $this->dentistUser = User::factory()->create();
        $this->dentistUser->assignRole('dentist'); // Assuming Spatie Permissions

        $this->regularUser = User::factory()->create(); 
        // Assign a non-dentist/admin role if applicable, or leave as default

        // Create categories
        $this->category1 = ForumCategory::factory()->create(['name' => 'Genel Konular']);
        $this->category2 = ForumCategory::factory()->create(['name' => 'Klinik Vakalar']);

        // Create topics
        $this->topic1 = ForumTopic::factory()->create([
            'category_id' => $this->category1->id,
            'user_id' => $this->dentistUser->id,
            'title' => 'Genel Konu Başlığı 1'
        ]);
        $this->topic2 = ForumTopic::factory()->create([
            'category_id' => $this->category1->id,
            'user_id' => $this->dentistUser->id,
            'title' => 'Genel Konu Başlığı 2'
        ]);
        $this->topic3 = ForumTopic::factory()->create([
            'category_id' => $this->category2->id,
            'user_id' => $this->dentistUser->id,
            'title' => 'Klinik Vaka Başlığı 1'
        ]);

        // Create messages
        $this->message1_1 = ForumMessage::factory()->create([
            'topic_id' => $this->topic1->id,
            'user_id' => $this->dentistUser->id,
            'content' => 'İlk mesaj içerik - Genel Konu 1'
        ]);
        $this->message1_2 = ForumMessage::factory()->create([
            'topic_id' => $this->topic1->id,
            'user_id' => $this->dentistUser->id,
            'content' => 'İkinci mesaj içerik - Genel Konu 1'
        ]);
        $this->message2_1 = ForumMessage::factory()->create([
            'topic_id' => $this->topic2->id,
            'user_id' => $this->dentistUser->id,
            'content' => 'İlk mesaj içerik - Genel Konu 2'
        ]);
        
        Log::info('ForumNavigationTest setup complete.');
    }

    /** @test */
    public function guest_cannot_access_forum()
    {
        Log::info('Testing guest access restriction.');
        $response = $this->get(route('forum.index'));
        $response->assertRedirect(route('login')); // Or assert view is unauthorized
        Log::info('Guest access test completed.');
    }
    
    /** @test */
    public function unauthorized_user_cannot_access_forum()
    {
        Log::info('Testing unauthorized user access restriction.');
        $response = $this->actingAs($this->regularUser)->get(route('forum.index'));
        $response->assertStatus(200); // Controller should handle auth check
        $response->assertSee(__('Yetkisiz Erişim - Hekimport')); // Check for unauthorized view message
        Log::info('Unauthorized user access test completed.');
    }

    /** @test */
    public function authorized_user_can_access_forum_index()
    {
        Log::info('Testing authorized user access to forum index.');
        $response = $this->actingAs($this->dentistUser)->get(route('forum.index'));
        
        $response->assertStatus(200);
        $response->assertSee('Forum Kategorileri');
        $response->assertSee('Başlık Listesi');
        $response->assertSee($this->category1->name);
        $response->assertSee($this->topic1->title);
        $response->assertSee($this->topic3->title); // From different category
        Log::info('Authorized user access test completed.');
    }
    
    /** @test */
    public function authorized_user_can_view_a_specific_topic()
    {
        $topicUrl = route('forum.topic.show', ['topic' => $this->topic1->id]);
        Log::info("Testing authorized user access to specific topic: {$topicUrl}");
        
        $response = $this->actingAs($this->dentistUser)->get($topicUrl);

        $response->assertStatus(200);
        $response->assertSee('Konu Detayı');
        $response->assertSee($this->topic1->title);
        $response->assertSee('İlk mesaj içerik - Genel Konu 1'); // Check for message1_1 content
        $response->assertSee('İkinci mesaj içerik - Genel Konu 1'); // Check for message1_2 content
        $response->assertDontSee($this->topic2->title); // Shouldn't see other topic titles here
        $response->assertDontSee('İlk mesaj içerik - Genel Konu 2'); // Shouldn't see message from topic2
        Log::info('Specific topic view test completed.');
    }

    /** @test */
    public function navigating_between_topics_updates_content()
    {
        $this->actingAs($this->dentistUser);

        // 1. Load first topic
        $topic1Url = route('forum.topic.show', ['topic' => $this->topic1->id]);
        Log::info("Navigating to first topic: {$topic1Url}");
        $response1 = $this->get($topic1Url);
        $response1->assertStatus(200);
        $response1->assertSee($this->topic1->title);
        $response1->assertSee('İlk mesaj içerik - Genel Konu 1');
        $response1->assertDontSee($this->topic2->title);
        $response1->assertDontSee('İlk mesaj içerik - Genel Konu 2');
        Log::info("Assertion for first topic passed.");

        // 2. Simulate clicking link to second topic (Full page request)
        // We get the URL from the rendered HTML of the first request if possible,
        // or construct it directly if needed. Assuming the list is present.
        $topic2Url = route('forum.topic.show', ['topic' => $this->topic2->id]);
        Log::info("Navigating to second topic: {$topic2Url}");
        
        // Follow the link (Make a new GET request)
        $response2 = $this->get($topic2Url); 
        
        // 3. Assert content for the second topic
        $response2->assertStatus(200);
        Log::info("Response status for second topic OK.");
        
        // Check if the NEW title is present
        $response2->assertSee($this->topic2->title); 
        Log::info("Assertion for second topic title passed.");
        
        // Check if the NEW message content is present
        $response2->assertSee('İlk mesaj içerik - Genel Konu 2'); 
        Log::info("Assertion for second topic message passed.");
        
        // Check if the OLD title is NOT present
        $response2->assertDontSee($this->topic1->title);
        Log::info("Assertion for first topic title (absence) passed.");

        // Check if the OLD message content is NOT present
        $response2->assertDontSee('İlk mesaj içerik - Genel Konu 1');
        Log::info("Assertion for first topic message (absence) passed.");

        Log::info('Navigation between topics test completed.');
    }
    
    // --- TODO: Add tests for ---
    // - Viewing topics by category URL (route('forum.category.show', ...))
    // - Topic/Message Pagination checks
    // - Searching topics
    // - Filtering topics
    // - Creating a topic (using Livewire test helpers potentially)
    // - Posting a message (using Livewire test helpers potentially)
    // - Edit/Delete/Pin/Ban actions (if implemented and testable via HTTP/Livewire)
} 