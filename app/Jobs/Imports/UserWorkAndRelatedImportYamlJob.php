<?php

/**
 * UserWork, UserWorkMore, UserContact and User import
 *   from yaml file editable and edited by humans
 *   following the included instructions.
 * @see /storage/app/public/samples/user_work_skeleton_en.yaml
 *
 */

namespace App\Jobs\Imports;

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserWork;
use App\Models\UserWorkMore;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Throwable;

class UserWorkAndRelatedImportYamlJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    // email address mapped to uuid new or readd
    protected array $userEmailToUuidMap = [];
    // input work id to uuid - old or assigned
    protected array $workIdToUuidMap = [];
    // timeout seconds
    public int $timeout = 600; // 600 secs 10 mins

    /**
     * Create a new job instance.
     *
     * @param User $requesterUser utente abilitato dalle Policy ad eseguire il job
     * @param string $yamlPath Percorso del file YAML
     */
    public function __construct(
        public User $requesterUser, // external policy checked
        public string $yamlPath
    ) {
        $jobName = class_basename($this);
        Log::info('Job: ' . $jobName . ' called for: ' . $yamlPath);
        // $this->requesterUser = $requesterUser;
        // $this->yamlPath      = $yamlPath;
    }

    /**
     * Validation rules for import
     *
     */
    private function getValidationRules(string $model): array
    {
        return match ($model) {
            'users' => [
                'email'      => 'required|email|max:250',
                'id'         => 'nullable|string|max:250',
                'name'       => 'nullable|string|max:250',
                'created_at' => 'nullable|date_format:Y-m-d H:i:s',
                'updated_at' => 'nullable|date_format:Y-m-d H:i:s',
                'deleted_at' => 'nullable|string',
            ],
            'user_contacts' => [
                'email'          => 'required|email|max:250',
                'first_name'     => 'required|string|max:250',
                'last_name'      => 'required|string|max:250',
                'nick_name'      => 'nullable|string|max:250',
                'id'             => 'nullable|string|max:250',
                'passport_photo' => 'nullable|url|max:255',
                'url_path'       => 'nullable|url|max:250',
                'country_id'     => 'required|string|size:3',
                'timezone_id'    => 'required|string|max:40',
                'address'        => 'nullable|string|max:250',
                'address_line2'  => 'nullable|string|max:250',
                'city'           => 'nullable|string|max:250',
                'region'         => 'nullable|string|max:250',
                'postal_code'    => 'nullable|string|max:10',
                'website'        => 'nullable|url|max:250',
                'facebook'       => 'nullable|url|max:250',
                'x_twitter'      => 'nullable|url|max:250',
                'instagram'      => 'nullable|url|max:250',
                'whatsapp'       => 'nullable|url|max:36',
                'linkedin'       => 'nullable|url|max:250',
            ],
            'user_works' => [
                'id'               => 'required|string|max:250',
                'user_id'          => 'required|string|min:36|max:250',
                'title_en'         => 'required|string|max:250',
                'title_local'      => 'nullable|string|max:250',
                'file_path'        => 'nullable|string|max:250',
                'url_path'         => 'nullable|url|max:250',
                'file_format'      => 'nullable|string|max:250',
                'file_size'        => 'nullable|integer|between:100000,6000000',
                'width'            => 'nullable|integer|between:1080,4000',
                'height'           => 'nullable|integer|between:1080,4000',
                'long_size'        => 'nullable|integer|between:1080,4000',
                'short_size'       => 'nullable|integer|between:1080,4000',
                'is_landscape'     => 'nullable|boolean',
                'is_monochromatic' => 'nullable|boolean',
                'has_raw_file'     => 'nullable|boolean',
            ],
            'user_work_mores' => [
                'id'            => 'nullable|int|min:1',
                'user_work_id'  => 'required|string|max:250',
                'federation_id' => 'required|string|max:10',
                'field_name'    => 'required|string|max:20',
                'field_value'   => 'required|string|max:255',
            ],
            default => [],
        };
    }

    /**
     * Write a report in same folder of input file
     *
     */
    protected function writeReportLog(array $messages): void
    {
        $directory = pathinfo(path:$this->yamlPath, flags: PATHINFO_DIRNAME);
        $fileName = pathinfo(path:$this->yamlPath, flags: PATHINFO_FILENAME);
        $fileName = ($directory !== '.' ? $directory . '/' : '') . "{$fileName}_report.txt";

        $content = "==================================================\n";
        $content .= __("IMPORT REPORT") . "\n";
        $content .= __("Requester") . ": {$this->requesterUser->name} (ID: {$this->requesterUser->id})\n";
        $content .= __("Import Date") . ": " . now()->toDateTimeString() . "\n";
        $content .= "==================================================\n\n";
        $content .= implode("\n", $messages) . "\n";

        Storage::disk('public')->put($fileName, $content);
    }

    /**
     * Execute the job
     *
     */
    public function handle(): void
    {
        $jobName = class_basename($this);
        Log::info('Job: ' . $jobName . ' / 1. started ');

        $errors = [];
        if (!Storage::disk('public')->exists($this->yamlPath)) {
            Log::error('Job: ' . $jobName . ' / 1. yaml file not found: ' . $this->yamlPath);
            $this->writeReportLog(["File YAML not found: {$this->yamlPath}"]);
            return;
        }
        $fullPath = Storage::disk('public')->path($this->yamlPath);

        Log::info('Job: ' . $jobName . ' / 1. yaml file found');

        try {
            $parsedData = Yaml::parseFile($fullPath);
        } catch (Throwable $e) {
            Log::info('Job: ' . $jobName . ' / 1. yaml parsed errors');
            $errors[] = 'Errors from yaml parser: ' . $e->getMessage();
            $this->writeReportLog($errors);
            return;
        }

        Log::info('Job: ' . $jobName . ' / 1. yaml file parsed ok');
        $data = $parsedData['data'] ?? [];
        Log::info('Job: ' . $jobName . ' / 1. yaml content ready to upsert');

        // ===================================================================
        // Model user - loop
        // ===================================================================
        if (!empty($data['users'])) {
            foreach ($data['users'] as $index => $userData) {
                Log::info('Job: ' . $jobName . ' / 2. users loop / ' . $index);
                try {
                    Validator::make(
                        data: $userData,
                        rules: $this->getValidationRules('users')
                    )->validate();
                } catch (ValidationException $e) {
                    $errors[] = "Validation errors in 2. users loop on index {$index}: "
                        . implode(', ', Arr::flatten($e->errors()));
                    $this->writeReportLog($errors);
                    return;
                }

                $user = User::withTrashed()
                    ->where('email', $userData['email'])
                    ->first();

                if ($user) {
                    $userId = $user->id;
                    try {
                        DB::transaction(function () use ($userData, $user) {
                            if (($userData['deleted_at'] ?? null) === 'restore') {
                                $user->restore();
                            }
                            unset($userData['id'], $userData['deleted_at']);

                            // Aggiorna tramite Query Builder per supportare i modelli soft-deleted
                            $user->newQuery()->withTrashed()->whereKey($user->getKey())->update($userData);
                        });
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 2. users loop / ' . $index . ' for userId:' . $userId);
                        $errors[] = 'Errors from user loop: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                } else {
                    $userId = (($userData['id'] ?? 'new') === 'new')
                        ? (string) Str::uuid7()
                        : $userData['id'];
                    $userData['id'] = $userId;
                    $userData['password'] = (!empty($userData['password']))
                        ? $userData['password']
                        : Hash::make(Str::random(24));
                    unset($userData['deleted_at']);

                    try {
                        $user = User::create($userData);
                        $userId = $user->id;
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 2. users loop / ' . $index . ' for userId:' . $userId);
                        $errors[] = 'Errors from user loop: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                }

                $this->userEmailToUuidMap[$userData['email']] = $userId;
            }
        }

        // ===================================================================
        // Model UserContact - loop
        // ===================================================================
        if (!empty($data['user_contacts'])) {
            foreach ($data['user_contacts'] as $index => $userData) {
                Log::info('Job: ' . $jobName . ' / 3. user_contacts loop / ' . $index);

                $userData['country_id'] = !empty($userData['country_id'])
                    ? strtoupper($userData['country_id'])
                    : 'ITA';
                $userData['timezone_id'] = (!empty($userData['timezone_id']))
                    ? $userData['timezone_id']
                    : 'Europe/Rome';
                $userData['last_name'] = $userData['last_name'] ?? '';
                $userData['first_name'] = $userData['first_name'] ?? '';

                try {
                    Validator::make(
                        data: $userData,
                        rules: $this->getValidationRules('user_contacts')
                    )->validate();
                } catch (ValidationException $e) {
                    $errors[] = "Validation errors in 3. user_contacts loop on index {$index}: "
                        . implode(', ', Arr::flatten($e->errors()));
                    $this->writeReportLog($errors);
                    return;
                }

                $user = User::withTrashed()
                    ->where('email', $userData['email'])
                    ->first();

                if (!$user) {
                    $newUser = [
                        'id'       => (($userData['id'] ?? 'new') === 'new') ? (string) Str::uuid7() : $userData['id'],
                        'email'    => $userData['email'],
                        'name'     => trim($userData['last_name'] . ', ' . $userData['first_name']),
                        'password' => Hash::make(Str::random(24)),
                    ];

                    try {
                        $user = User::create($newUser);
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 3. user_contacts fallback user create / ' . $index);
                        $errors[] = 'Errors creating parent user from contact: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                }
                $userId = $user->id;

                $contact = UserContact::withTrashed()
                    ->where('email', $userData['email'])
                    ->first();

                // Pulisce campi extra non presenti sulla tabella user_contacts prima del salvataggio
                unset($userData['url_path']);

                if ($contact) {
                    try {
                        DB::transaction(function () use ($userData, $contact) {
                            if (($userData['deleted_at'] ?? null) === 'restore') {
                                $contact->restore();
                            }
                            unset($userData['id'], $userData['deleted_at']);

                            $contact->newQuery()->withTrashed()->whereKey($contact->getKey())->update($userData);
                        });
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 3. user_contacts loop / ' . $index . ' for userId:' . $userId);
                        $errors[] = 'Errors from user_contact update: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                } else {
                    $userData['id'] = $userId;
                    unset($userData['deleted_at']);

                    try {
                        $contact = UserContact::create($userData);
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 3. user_contacts loop / ' . $index . ' for userId:' . $userId);
                        $errors[] = 'Errors from user_contact create: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                }

                $this->userEmailToUuidMap[$userData['email']] = $userId;
            }
        }

        // ===================================================================
        // Model UserWork - loop
        // ===================================================================
        if (!empty($data['user_works'])) {
            foreach ($data['user_works'] as $index => $userData) {
                $userData['is_landscape'] = !empty($userData['is_landscape']) ? (bool) $userData['is_landscape'] : false;
                $userData['is_monochromatic'] = !empty($userData['is_monochromatic']) ? (bool) $userData['is_monochromatic'] : false;
                $userData['has_raw_file'] = !empty($userData['has_raw_file']) ? (bool) $userData['has_raw_file'] : false;

                // 1. Risoluzione user_id
                $mapUserId = $userData['user_id'];
                if (isset($this->userEmailToUuidMap[$mapUserId])) {
                    $userIdFound = $this->userEmailToUuidMap[$mapUserId];
                } elseif (in_array($mapUserId, $this->userEmailToUuidMap, true)) {
                    $userIdFound = $mapUserId;
                } else {
                    try {
                        $user = User::withTrashed()
                            ->where('email', $userData['user_id'])
                            ->orWhere('id', $userData['user_id'])
                            ->first();
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 7. user_works loop / ' . $index . ' for userId:' . $userData['user_id']);
                        $errors[] = 'Errors from user find: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }

                    if (!$user) {
                        Log::info('Job: ' . $jobName . ' / 7. user_works loop / ' . $index . ' for userId:' . $userData['user_id']);
                        $errors[] = 'Errors user not found for: ' . $userData['user_id'];
                        $this->writeReportLog($errors);
                        return;
                    }

                    $userIdFound = $user->id;
                    $this->userEmailToUuidMap[$user->email] = $user->id;
                }
                $userData['user_id'] = $userIdFound;

                // 2. Risoluzione dell'ID per il lavoro
                $originalWorkId = $userData['id'];
                $isUuid = (bool) (preg_match('/^[0-9a-f]{8}(?:\-[0-9a-f]{4}){3}-[0-9a-f]{12}$/i', $userData['id']));
                if ($isUuid) {
                    $workIdFound = $userData['id'];
                } else {
                    $workIdFound = (string) Str::uuid7();
                }
                $userData['id'] = $workIdFound;

                // 3. Scaricamento immagine da url_path e salvataggio tramite photoBox()
                if (!empty($userData['url_path'])) {
                    try {
                        $userContact = UserContact::where('id', $userIdFound)->first();
                        $photoBoxDir = $userContact ? $userContact->photoBox() : 'photos/default';

                        $response = Http::timeout(30)->get($userData['url_path']);
                        if (!$response->successful()) {
                            Log::error(
                                'Job: ' . $jobName . ' / 7. user_works file not dloaded: '
                                . $userData['url_path']
                            );
                            $this->writeReportLog(["File not found: {$userData['url_path']}"]);
                            return;
                        }

                        $fileContent = $response->body();

                        $extension = strtolower(pathinfo(parse_url($userData['url_path'], PHP_URL_PATH), PATHINFO_EXTENSION)) ?: 'jpg';
                        $filename = $workIdFound . '.' . $extension;

                        $relativeFilePath = $photoBoxDir . '/' . $filename;

                        Storage::disk('public')->put('photos/' . $relativeFilePath, $fileContent);

                        $tempPath = Storage::disk('public')->path('photos/' . $relativeFilePath);
                        $imgInfo = @getimagesize($tempPath);

                        if ($imgInfo) {
                            $userData['width'] = $imgInfo[0];
                            $userData['height'] = $imgInfo[1];
                            $userData['file_size'] = filesize($tempPath);
                            $userData['file_format'] = $extension;
                            $userData['long_size'] = max($imgInfo[0], $imgInfo[1]);
                            $userData['short_size'] = min($imgInfo[0], $imgInfo[1]);
                            $userData['is_landscape'] = $imgInfo[0] >= $imgInfo[1];

                            $imgManager = new ImageManager(new Driver());
                            $miniature = $imgManager->read($tempPath);
                            $miniature->scaleDown(width: 300, height: 300);
                            $jpegMiniature = $miniature->encode(new JpegEncoder(quality: 80));

                            $miniatureStorePath = 'photos/' . $photoBoxDir . '/300_' . $filename;
                            Storage::disk('public')->put($miniatureStorePath, (string)$jpegMiniature);
                        }

                        $userData['file_path'] = str_replace('photos/', '', $relativeFilePath);
                    } catch (\Throwable $e) {
                        Log::error('Job: ' . $jobName . ' / Download error / ' . $e->getMessage());
                        $errors[] = "Error downloading image for work index {$index}: " . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                }

                // 4. Validazione dei dati elaborati
                try {
                    Validator::make(
                        data: $userData,
                        rules: $this->getValidationRules('user_works')
                    )->validate();
                } catch (ValidationException $e) {
                    $errors[] = "Validation errors in 7. user_works loop on index {$index}: "
                        . implode(', ', Arr::flatten($e->errors()));
                    $this->writeReportLog($errors);
                    return;
                }

                // 5. Cerca se l'opera esiste già su DB
                $userWork = UserWork::withTrashed()
                    ->where('id', $workIdFound)
                    ->first();

                // Unset delle chiavi non appartenenti alla colonna del DB
                unset($userData['url_path']);

                // 6. Persistence su Database
                if ($userWork) {
                    $userWorkId = $userWork->id;
                    try {
                        DB::transaction(function () use ($userData, $userWork) {
                            if (($userData['deleted_at'] ?? null) === 'restore') {
                                $userWork->restore();
                            }
                            unset($userData['id'], $userData['deleted_at']);

                            $userWork->newQuery()->withTrashed()->whereKey($userWork->getKey())->update($userData);
                        });
                    } catch (\Throwable $e) {
                        Log::info(
                            'Job: ' . $jobName . ' / 7. user_work loop / '
                            . $index . ' for userId:' . $userIdFound
                        );
                        $errors[] = 'Errors from user_work update: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                } else {
                    unset($userData['deleted_at']);

                    try {
                        $userWork = UserWork::create($userData);
                        $userWorkId = $userWork->id;
                    } catch (\Throwable $e) {
                        Log::info(
                            'Job: ' . $jobName . ' / 7. user_work loop / '
                            . $index . ' for userId:' . $userIdFound
                        );
                        $errors[] = 'Errors from user_work create: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                }

                $this->workIdToUuidMap[$originalWorkId] = $userWorkId;
            }
        }

        // ===================================================================
        // Model userWorkMores - loop
        // ===================================================================
        if (!empty($data['user_work_mores'])) {
            foreach ($data['user_work_mores'] as $index => $userData) {
                $userWorkIdFound = false;
                $mapUserWorkId = $userData['user_work_id'];
                if (isset($this->workIdToUuidMap[$mapUserWorkId])) {
                    $userWorkIdFound = $this->workIdToUuidMap[$mapUserWorkId];
                } elseif (in_array($mapUserWorkId, $this->workIdToUuidMap, true)) {
                    $userWorkIdFound = $mapUserWorkId;
                } else {
                    try {
                        $userWork = UserWork::withTrashed()
                            ->where('id', $mapUserWorkId)
                            ->first();
                        $userWorkIdFound = $userWork?->id ?? false;
                    } catch (\Throwable $e) {
                        Log::info(
                            'Job: ' . $jobName . ' / 8. user_work_mores loop / '
                            . $index . ' for userId:' . $mapUserWorkId
                        );
                        $errors[] = 'Errors from user find: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                }

                if ($userWorkIdFound) {
                    $userData['user_work_id'] = $userWorkIdFound;
                } else {
                    Log::info(
                        'Job: ' . $jobName . ' / 8. user_work_mores loop / '
                        . $index . ' for userId:' . $userData['user_work_id']
                    );
                    $errors[] = 'Errors user_work not found for: ' . $userData['user_work_id'];
                    $this->writeReportLog($errors);
                    return;
                }

                $federation = Federation::where('id', $userData['federation_id'])
                    ->first();
                if (!$federation) {
                    Log::info(
                        'Job: ' . $jobName . ' / 8. user_work_mores loop / '
                        . $index . ' for federationId:' . $userData['federation_id']
                    );
                    $errors[] = 'Errors federation not found for: ' . $userData['federation_id'];
                    $this->writeReportLog($errors);
                    return;
                }
                $userData['federation_id'] = $federation->id;

                $federationMore = FederationMore::where('federation_id', $userData['federation_id'])
                    ->where('referenced', UserWork::TABLENAME)
                    ->where('field_name', $userData['field_name'])
                    ->first();
                if (!$federationMore) {
                    Log::info(
                        'Job: ' . $jobName . ' / 8. user_work_mores loop / ' . $index
                        . ' for federationId:' . $userData['federation_id']
                        . ' value: ' . $userData['field_name']
                    );
                    $errors[] = 'Errors user_work_more not found for: '
                        . ' for federationId:' . $userData['federation_id']
                        . ' value: ' . $userData['field_name'];
                    $this->writeReportLog($errors);
                    return;
                }

                try {
                    Validator::make(
                        data: $userData,
                        rules: $this->getValidationRules('user_work_mores')
                    )->validate();
                } catch (ValidationException $e) {
                    $errors[] = "Validation errors in 8. user_work_mores loop on index {$index}: "
                        . implode(', ', Arr::flatten($e->errors()));
                    $this->writeReportLog($errors);
                    return;
                }

                $validationRules = [
                    'field_value' => $federationMore->field_validation_rules,
                ];
                try {
                    Validator::make(
                        data: $userData,
                        rules: $validationRules
                    )->validate();
                } catch (ValidationException $e) {
                    $errors[] = "Validation errors in 8. user_work_mores loop on index {$index}: "
                        . implode(', ', Arr::flatten($e->errors()));
                    $this->writeReportLog($errors);
                    return;
                }

                $userWorkMore = UserWorkMore::withTrashed()
                    ->where('user_work_id', $userData['user_work_id'])
                    ->where('federation_id', $userData['federation_id'])
                    ->where('field_name', $userData['field_name'])
                    ->first();

                if ($userWorkMore) {
                    $userWorkMoreId = $userWorkMore->id;
                    try {
                        DB::transaction(function () use ($userData, $userWorkMore) {
                            if (($userData['deleted_at'] ?? null) === 'restore') {
                                $userWorkMore->restore();
                            }
                            unset($userData['deleted_at'], $userData['id']);

                            $userWorkMore->newQuery()->withTrashed()->whereKey($userWorkMore->getKey())->update($userData);
                        });
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 8. user_work_more loop / ' . $index . ' for userWorkMoreId: ' . $userWorkMoreId);
                        $errors[] = 'Errors from user_work_more update: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                } else {
                    unset($userData['id'], $userData['deleted_at']);
                    try {
                        $userWorkMore = UserWorkMore::create($userData);
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 8. user_work_more loop / ' . $index . ' for userWorkMore.');
                        $errors[] = 'Errors from user_work_more create: ' . $e->getMessage();
                        $this->writeReportLog($errors);
                        return;
                    }
                }
            }
        }

        // Report all done ok
        Log::info('Job: ' . $jobName . ' / ended.');
        $allDoneOk = [];
        $allDoneOk[] = "YAML parsed and imported without errors. (maybe an empty file)";
        $allDoneOk[] = "Anyway, a data check on database is mandatory.";
        $this->writeReportLog($allDoneOk);
        //
    }
}
