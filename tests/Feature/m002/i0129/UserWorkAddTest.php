<?php

use App\Models\User;
use App\Models\UserContact;
use App\Models\UserWork;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Rossi, Mario',
        'email_verified_at' => now(),
    ]);

    $this->userContact = UserContact::firstOrCreate(
        ['id' => $this->user->id],
        [
            'email' => $this->user->email,
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'country_id' => 'ITA',
        ]
    );
});

it('allows authenticated users with contact to access user.work.add page', function () {
    $this->actingAs($this->user)
        ->get(route('user.work.add'))
        ->assertSuccessful()
        ->assertSeeLivewire('user.work.add');
});

it('redirects unauthenticated users trying to access user.work.add page', function () {
    $this->get(route('user.work.add'))
        ->assertRedirect(route('login'));
});

it('allows an authenticated user to upload a jpeg image work', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('landscape.jpg', 1920, 1080);

    $this->actingAs($this->user);

    Volt::test('user.work.add')
        ->set('userWorkTitleEn', 'My Mountain Sunset')
        ->set('userWorkTempImage', $file)
        ->set('userWorkIsMonochromatic', false)
        ->set('userWorkRawAvailable', true)
        ->call('addUserWork')
        ->assertHasNoErrors()
        ->assertRedirect(route('user.work.add'));

    $this->assertDatabaseHas('user_works', [
        'user_id' => $this->userContact->id,
        'title_en' => 'My Mountain Sunset',
        'file_format' => 'jpeg',
        'long_size' => 2073600,
        'long_size' => 1920,
        'short_size' => 1080,
        'is_monochromatic' => false,
        'has_raw_file' => true,
    ]);

    $userWork = UserWork::where('user_id', $this->userContact->id)
        ->where('title_en', 'My Mountain Sunset')
        ->first();

    expect($userWork)->not->toBeNull();
    Storage::disk('public')->assertExists('photos/'.$userWork->file_path);
});

it('fails validation when uploading an invalid file format or missing required fields', function () {
    Storage::fake('public');

    $pngFile = UploadedFile::fake()->image('document.png');

    $this->actingAs($this->user);

    Volt::test('user.work.add')
        ->set('userWorkTitleEn', '')
        ->set('userWorkTempImage', $pngFile)
        ->call('addUserWork')
        ->assertHasErrors(['userWorkTitleEn', 'userWorkTempImage']);
});
