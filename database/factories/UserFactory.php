<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    
    /**
     * List of Turkish first names for more localized data
     */
    protected array $turkishFirstNames = [
        'Ahmet', 'Mehmet', 'Ali', 'Mustafa', 'Hüseyin', 'İbrahim', 'Murat', 'Hasan', 'Ömer', 'Yusuf',
        'Osman', 'Halil', 'İsmail', 'Abdullah', 'Süleyman', 'Emre', 'Enes', 'Muhammed', 'Ramazan', 'Burak',
        'Fatma', 'Ayşe', 'Emine', 'Hatice', 'Zeynep', 'Elif', 'Meryem', 'Şerife', 'Havva', 'Hanife',
        'Fadime', 'Sevgi', 'Sultan', 'Zeliha', 'Melek', 'Seher', 'Leyla', 'Sema', 'Hülya', 'Özlem'
    ];
    
    /**
     * List of Turkish last names for more localized data
     */
    protected array $turkishLastNames = [
        'Yılmaz', 'Kaya', 'Demir', 'Şahin', 'Çelik', 'Yıldız', 'Erdoğan', 'Öztürk', 'Aydın', 'Özdemir',
        'Arslan', 'Doğan', 'Kılıç', 'Aslan', 'Çetin', 'Koç', 'Kurt', 'Özkan', 'Şimşek', 'Polat',
        'Yüksel', 'Korkmaz', 'Karataş', 'Gül', 'Sönmez', 'Keskin', 'Yücel', 'Aksoy', 'Acar', 'Kaplan',
        'Tekin', 'Şen', 'Ateş', 'Erbaş', 'Bulut', 'Göktürk', 'Bilgin', 'Türkoğlu', 'Sarı', 'Yalçın'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('tr_TR');
        
        // Turkish dentist titles
        $titles = ['Dr.', 'Dr. Dt.', 'Doç. Dr.', 'Prof. Dr.'];
        $title = $faker->randomElement($titles);
        
        // Generate more Turkish names
        $firstName = $faker->randomElement($this->turkishFirstNames);
        $lastName = $faker->randomElement($this->turkishLastNames);
        $name = $title . ' ' . $firstName . ' ' . $lastName;
        
        // Generate an email based on the name
        $emailPrefix = Str::slug($firstName . '.' . $lastName, '.');
        $emailDomains = ['gmail.com', 'hotmail.com', 'yahoo.com', 'outlook.com', 'live.com'];
        $email = $emailPrefix . '@' . $faker->randomElement($emailDomains);
        
        return [
            'name' => $name,
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
            'is_banned_from_forum' => false,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    /**
     * Indicate that the user should have the dentist role.
     */
    public function asDentist(): static
    {
        return $this->afterCreating(function (User $user) {
            if (!$user->hasRole('dentist')) {
                $user->assignRole('dentist');
            }
        });
    }

    /**
     * Indicate that the user should have the assistant role.
     */
    public function asAssistant(): static
    {
        return $this->afterCreating(function (User $user) {
            if (!$user->hasRole('assistant')) {
                $user->assignRole('assistant');
            }
        });
    }

    /**
     * Indicate that the user should have the admin role.
     */
    public function asAdmin(): static
    {
        return $this->afterCreating(function (User $user) {
            if (!$user->hasRole('admin')) {
                $user->assignRole('admin');
            }
        });
    }
}
