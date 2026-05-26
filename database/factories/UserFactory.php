<?php

/**
 * User factory
 * Note: w/sql trigger is also user_contacts factory
 *
 * 2025-08-31 id became uuid
 * 2025-11-04 changed name() w/firstName() + lastName() to avoid title as Mr. Dr. Col. etc
 * 2026-02-11 added variable name as permitted by php 8.5
 *
 */

namespace Database\Factories;

use App\Models\Organization;
use App\Models\Team;
use App\Models\User;
use App\Models\UserRole;
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
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $first = fake()->firstName();
        $last = fake()->lastName();
        $name = $last . ', ' . $first;
        $email = $first . '.' . $last . '@example.com';
        return [
            'name' => $name,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('Password@12345'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
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
     * Reserved for pest tests
     */
    public function admin(): static
    {
        return $this->afterCreating(function (\App\Models\User $user) {
            $adminOrganization = Organization::firstOrCreate(['name' => '.admin']);
            $adminRole = UserRole::firstOrCreate([
                'user_id' => $user->id,
                'role' => 'admin',
                'organization_id' => $adminOrganization->id,
                'contest_id' => null,
                'federation_id' => null,
            ]);
        });
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
}
