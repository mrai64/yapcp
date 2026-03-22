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
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
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
        $email = str_ireplace(
            search: ['"', ', ', '  ', ' ', '..'],
            replace: ['', ' ', ' ', '.', '.'],
            subject: strtolower($first . '.' . $last)
        ) . '@athesis77.it'; // real domain to check mail sending
        $password = Hash::make($email);

        return [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
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
        $adminOrganization = Organization::whereName('.admin')->firstOrFail();
        return $this->has(
            UserRole::factory()->state([
                'role' => 'admin',
                'organization_id' => $adminOrganization->id,
                'contest_id' => null,
                'federation_id' => null,
            ]),
            'userRoles'
        );
    }

}
