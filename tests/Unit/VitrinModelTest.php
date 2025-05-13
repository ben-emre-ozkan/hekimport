<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\User;
use App\Models\Vitrin;
use App\Models\Student;
use App\Models\VitrinAnalytic;
use App\Models\ProfileVisit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VitrinModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_vitrin_with_appointment_slots(): void
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $appointmentSlots = [
            'Pazartesi' => ['09:00-10:00', '10:00-11:00', '11:00-12:00'],
            'Salı' => ['13:00-14:00', '14:00-15:00'],
            'Çarşamba' => ['09:00-10:00', '10:00-11:00'],
        ];
        
        $vitrin = Vitrin::create([
            'user_id' => $user->id,
            'subdomain' => 'test-subdomain',
            'title' => 'Test Doktor',
            'description' => 'Test açıklama',
            'working_hours' => $appointmentSlots,
            'is_active' => true,
        ]);
        
        // Assert
        $this->assertInstanceOf(Vitrin::class, $vitrin);
        $this->assertEquals($appointmentSlots, $vitrin->working_hours);
        $this->assertEquals($user->id, $vitrin->user_id);
        $this->assertEquals('test-subdomain', $vitrin->subdomain);
        $this->assertTrue($vitrin->is_active);
    }
    
    public function test_vitrin_belongs_to_user_relationship(): void
    {
        // Arrange
        $user = User::factory()->create();
        $vitrin = Vitrin::factory()->create(['user_id' => $user->id]);
        
        // Act & Assert
        $this->assertInstanceOf(User::class, $vitrin->user);
        $this->assertEquals($user->id, $vitrin->user->id);
    }
    
    public function test_vitrin_belongs_to_student_relationship(): void
    {
        // Arrange
        $student = Student::factory()->create();
        $vitrin = Vitrin::factory()->create(['student_id' => $student->id]);
        
        // Act & Assert
        $this->assertInstanceOf(Student::class, $vitrin->student);
        $this->assertEquals($student->id, $vitrin->student->id);
    }
    
    public function test_vitrin_has_many_analytics_relationship(): void
    {
        // Arrange
        $vitrin = Vitrin::factory()->create();
        
        // Create associated analytics
        $analytic1 = VitrinAnalytic::factory()->create(['vitrin_id' => $vitrin->id]);
        $analytic2 = VitrinAnalytic::factory()->create(['vitrin_id' => $vitrin->id]);
        
        // Act & Assert
        $this->assertCount(2, $vitrin->analytics);
        $this->assertInstanceOf(VitrinAnalytic::class, $vitrin->analytics->first());
    }
    
    public function test_vitrin_has_many_visits_relationship(): void
    {
        // Arrange
        $vitrin = Vitrin::factory()->create();
        
        // Create associated visits
        $visit1 = ProfileVisit::factory()->create(['vitrin_id' => $vitrin->id]);
        $visit2 = ProfileVisit::factory()->create(['vitrin_id' => $vitrin->id]);
        
        // Act & Assert
        $this->assertCount(2, $vitrin->visits);
        $this->assertInstanceOf(ProfileVisit::class, $vitrin->visits->first());
    }
    
    public function test_vitrin_active_scope(): void
    {
        // Arrange
        $activeVitrin = Vitrin::factory()->create(['is_active' => true]);
        $inactiveVitrin = Vitrin::factory()->create(['is_active' => false]);
        
        // Act
        $activeVitrins = Vitrin::active()->get();
        
        // Assert
        $this->assertTrue($activeVitrins->contains($activeVitrin));
        $this->assertFalse($activeVitrins->contains($inactiveVitrin));
    }
} 