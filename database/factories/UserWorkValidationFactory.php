<?php

namespace Database\Factories;

use App\Models\ContestSection;
use App\Models\FederationSection;
use App\Models\UserContact;
use App\Models\UserWork;
use App\Models\UserWorkValidation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserWorkValidation>
 */
class UserWorkValidationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserWorkValidation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_work_id'          => UserWork::factory(),
            'section_id'            => ContestSection::factory(),
            'federation_section_id' => null, // di default assume una sezione indipendente
            'validator_user_id'     => UserContact::factory(),
        ];
    }

    /**
     * Stato per indicare che la validazione è legata a una sezione federale.
     */
    public function forFederationSection(?int $federationSectionId = null): static
    {
        return $this->state(fn (array $attributes) => [
            'federation_section_id' => $federationSectionId ?? FederationSection::factory(),
        ]);
    }

    /**
     * Stato per una sezione completamente indipendente (senza federazione).
     */
    public function independentSection(): static
    {
        return $this->state(fn (array $attributes) => [
            'federation_section_id' => null,
        ]);
    }
}
