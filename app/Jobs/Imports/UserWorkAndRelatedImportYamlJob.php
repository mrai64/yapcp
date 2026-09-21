<?php

/**
 * UserWork, UserWorkMore, UserContact and User import
 *   from yaml file editable and edited by humans
 *   following the included instructions.
 * @see /storage/app/public/samples/user_work_skeleton_en.yaml
 *
 */

namespace App\Jobs\Imports;

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

use function PHPUnit\Framework\isEmpty;

class UserWorkAndRelatedImportYamlJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    // email address mapped to uuid new or readd
    protected array $userEmailToUuidMap = [];
    // file path to work id uuid new or readed
    protected array $workPathToUuidMap = [];

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
                'email'      => 'required|email|max:250', //    email
                'id'         => 'nullable|string|max:250', //   'new', uuid or email
                'name'       => 'nullable|string|max:250',//    Surname, name
                'created_at' => 'nullable|date_format:Y-m-d H:i:s',
                'updated_at' => 'nullable|date_format:Y-m-d H:i:s',
                'deleted_at' => 'nullable|string',
            ],
            'user_contacts' => [
                'email'          => 'required|email|max:250',
                'first_name'     => 'required|string|max:250',
                'last_name'      => 'required|string|max:250',
                'nick_name'      => 'nullable|string|max:250',
                'id'             => 'nullable|string|max:250',// 'new' or uuid or email
                'passport_photo' => 'nullable|url|max:255', //
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
                'id'              => 'required|string',
                'user_id'         => 'required|string|min:36|max:250', //
                'title_en'        => 'required|string|max:250',
                'title_local'     => 'nullable|string|max:250',
                'file_path'       => 'required|string|max:250',
                'url_path'        => 'required|url|max:250', // not in model
                'file_format'     => 'nullable|string|max:250',
                'file_size'       => 'nullable|integer|between:100000,6000000',
                'width'           => 'nullable|integer|between:1080,4000',
                'height'          => 'nullable|integer|between:1080,4000',
                'long_size'       => 'nullable|integer|between:1080,4000',
                'short_size'      => 'nullable|integer|between:1080,4000',
                'is_landscape'    => 'nullable|boolean',
                'is_monochromatic' => 'nullable|boolean',
                'has_raw_file'    => 'nullable|boolean',
            ],
            'user_work_mores' => [
                'id'            => 'nullable',
                'user_work_id'  => 'required|string|max:250',
                'federation_id' => 'required|string|max:10',
                'field_name'    => 'required|string|max:20',
                'field_value'   => 'required|string|max:255',
            ],
            default => [], // don't fill, default values set in o different way
        };
    }

    /**
     * Write a report in same folder of input file
     *
     */
    protected function writeReportLog(array $errors): void
    {
        $directory = pathinfo(path: $this->yamlPath, flags: PATHINFO_DIRNAME);
        $fileName = pathinfo(path: $this->yamlPath, flags: PATHINFO_FILENAME);
        $fileName = ($directory !== '.' ? $directory . '/' : '') . "{$fileName}_report.txt";

        $content = "==================================================\n";
        $content .= __("IMPORT REPORT") . "\n";
        $content .= __("Requester") . ": {$this->requesterUser->name} (ID: {$this->requesterUser->id})\n";
        $content .= __("Import Date") . ": " . now()->toDateTimeString() . "\n";
        $content .= "==================================================\n\n";
        $content .= implode("\n", $errors) . "\n";

        // Salva specificamente nel disk public
        Storage::disk('public')->put($fileName, $content);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobName = class_basename($this);
        Log::info('Job: ' . $jobName . ' / 1. started ');
        //
        $errors = [];
        // 2. find the uploaded file
        if (!Storage::disk('public')->exists($this->yamlPath)) {
            Log::error('Job: ' . $jobName . ' / 2. file not found: ' . $this->yamlPath);
            $this->writeReportLog(["File YAML not found: {$this->yamlPath}"]);
            return;
        }
        $fullPath = Storage::disk('public')->path($this->yamlPath);

        Log::info('Job: ' . $jobName . ' / 2. file found');
        // Yaml parse
        try {
            $parsedData = Yaml::parseFile($fullPath);
        } catch (Throwable $e) {
            Log::info('Job: ' . $jobName . ' / 3. yaml parsed errors');
            $errors[] = 'Errors from yaml parser: ' . $e->getMessage();
            $this->writeReportLog(errors: $errors);
            return;
        }
        Log::info('Job: ' . $jobName . ' / 3. yaml file parsed ok');
        $data = $parsedData['data'] ?? [];
        Log::info('Job: ' . $jobName . ' / 4. yaml content ready to upsert');
        // ===================================================================
        // Model user - loop
        // ===================================================================
        if (!empty($data['users'])) {
            foreach ($data['users'] as $index => $userData) {
                Log::info('Job: ' . $jobName . ' / 5. users loop / ' . $index);
                try {
                    // validate
                    Validator::make(
                        data: $userData,
                        rules: $this->getValidationRules('users')
                    )->validate();
                } catch (ValidationException $e) {
                    $errors[] = "Validation errors in 5. user loop on index {$index}: "
                        . implode(', ', Arr::flatten($e->errors()));
                    $this->writeReportLog($errors);
                    return;
                }
                // find
                $user = User::withTrashed()
                    ->where('email', $userData['email'])
                    ->first();
                if ($user) {
                    // exist
                    $userId = $user->id;
                    try {
                        DB::transaction(function () use ($userData, $userId, $user) {
                            // restore required? restore it
                            if (($userData['deleted_at'] ?? null) === 'restore') {
                                $user->restore();
                            }
                            unset($userData['id']);
                            unset($userData['deleted_at']);
                            // update
                            $user->update(array_merge($userData, ['id' => $userId]));
                        });
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 5. user loop / ' . $index . ' for userId:' . $userId);
                        $errors[] = 'Errors from user loop: ' . $e->getMessage();
                        $this->writeReportLog(errors: $errors);
                        return;
                    }
                } else {
                    // not found, new or physically removed
                    $userId = ($userData['id'] ?? 'new') === 'new' ? (string) Str::uuid7() : $userData['id'];
                    $userData['id'] = $userId;
                    $userData['password'] = (!empty($userData['password'])) ? $userData['password'] : Hash::make(Str::random(24));
                    unset($userData['deleted_at']);

                    try {
                        $user = User::create($userData);
                        $userId = $user->id;
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 5. user loop / ' . $index . ' for userId:' . $userId);
                        $errors[] = 'Errors from user loop: ' . $e->getMessage();
                        $this->writeReportLog(errors: $errors);
                        return;
                    }
                }
                // email - uuid
                $this->userEmailToUuidMap[$userData['email']] = $userId;
            } // foreach - user
        }
        // users
        // ===================================================================
        // Model UserContact - loop
        // ===================================================================
        // TODO import passport_photo in a file __passport_photo under photo_box()
        if (!empty($data['user_contacts'])) {
            foreach ($data['user_contacts'] as $index => $userData) {
                Log::info('Job: ' . $jobName . ' / 6. user_contacts loop / ' . $index);
                // default
                $userData['country_id'] = !empty($userData['country_id']) ? strtoupper($userData['country_id']) : 'ITA';
                $userData['timezone_id'] = (!empty($userData['timezone_id'])) ? $userData['timezone_id'] : 'Europe/Rome';
                $userData['last_name'] = $userData['last_name'] ?? '';
                $userData['first_name'] = $userData['first_name'] ?? '';

                try {
                // validate
                    Validator::make(
                        data: $userData,
                        rules: $this->getValidationRules('user_contacts')
                    )->validate();
                } catch (ValidationException $e) {
                    $errors[] = "Validation errors in 6. user_contacts loop on index {$index}: " . implode(', ', Arr::flatten($e->errors()));
                    $this->writeReportLog($errors);
                    return;
                }
                // find user
                $user = User::withTrashed()
                    ->where('email', $userData['email'])
                    ->first();
                // missing user - maybe
                if (!$user) {
                    $newUser = [];
                    $newUser['id'] = (($userData['id'] ?? 'new') === 'new') ? (string) Str::uuid7() : $userData['id'];
                    $newUser['email'] = $userData['email'];
                    $newUser['name'] = trim($userData['last_name'] . ', ' . $userData['first_name']);
                    $newUser['password'] = Hash::make(Str::random(24));
                    // now exist
                    $user = User::create($newUser);
                } // missing user
                $userId = $user->id;
                // find UserContact
                $contact = UserContact::withTrashed()
                    ->where('email', $userData['email'])
                    ->first();
                if ($contact) {
                    $userEmail = $contact->email;
                    try {
                        DB::transaction(function () use ($userData, $userId, $userEmail, $contact) {
                            // restore required
                            if (($userData['deleted_at'] ?? null) === 'restore') {
                                $contact->restore();
                            }
                            unset($userData['id']);
                            unset($userData['deleted_at']);

                            $contact->update(array_merge($userData, [
                                'id' => $userId,
                            ]));
                        });
                        // DB transaction
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 6. user_contact loop / ' . $index . ' for userId:' . $userId);
                        $errors[] = 'Errors from user_contact update: ' . $e->getMessage();
                        $this->writeReportLog(errors: $errors);
                        return;
                    }
                    // exist
                } else {
                    $userData['id'] = $userId;
                    unset($userData['deleted_at']);

                    try {
                        $contact = UserContact::create($userData);
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 6. user_contact loop / ' . $index . ' for userId:' . $userId);
                        $errors[] = 'Errors from user_contact create: ' . $e->getMessage();
                        $this->writeReportLog(errors: $errors);
                        return;
                    }
                }

                $this->userEmailToUuidMap[$userData['email']] = $userId;
            }
        }
        // user_contacts
// ===================================================================
        // Model UserWork - loop
        // ===================================================================
        if (!empty($data['user_works'])) {
            foreach ($data['user_works'] as $index => $userData) {
                // Default booleans
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
                        $this->writeReportLog(errors: $errors);
                        return;
                    }

                    if (!$user) {
                        Log::info('Job: ' . $jobName . ' / 7. user_works loop / ' . $index . ' for userId:' . $userData['user_id']);
                        $errors[] = 'Errors user not found for: ' . $userData['user_id'];
                        $this->writeReportLog(errors: $errors);
                        return;
                    }

                    $userIdFound = $user->id;
                    $this->userEmailToUuidMap[$user->email] = $user->id;
                }

                $userData['user_id'] = $userIdFound;

                // 2. Risoluzione dell'ID per il lavoro
                $rawWorkId = $userData['id'] ?? 'new';
                $userWorkId = ($rawWorkId === 'new') ? (string) Str::uuid7() : $rawWorkId;

                // 3. Scaricamento immagine da url_path e salvataggio tramite photoBox()
                if (!empty($userData['url_path'])) {
                    try {
                        // Recupera il contatto per ottenere la directory di destinazione
                        $userContact = UserContact::where('id', $userIdFound)->first();
                        $photoBoxDir = $userContact ? $userContact->photoBox() : 'photos/default';

                        // Esegui il download
                        $response = Http::timeout(30)->get($userData['url_path']);
                        if (!$response->successful()) {
                            Log::error('Job: ' . $jobName . ' / 7. file not dloaded: ' . $userData['url_path']);
                            $this->writeReportLog(["File not found: {$userData['url_path']}"]);
                            return;
                        }

                        $fileContent = $response->body();

                        // Determina estensione e nome file
                        $extension = strtolower(pathinfo(parse_url($userData['url_path'], PHP_URL_PATH), PATHINFO_EXTENSION)) ?: 'jpg';
                        $filename = $userWorkId . '.' . $extension;

                        // Percorso relativo interno al disk 'public'
                        $relativeFilePath = $photoBoxDir . '/' . $filename;

                        // Salva l'originale
                        Storage::disk('public')->put('photos/' . $relativeFilePath, $fileContent);

                        // Calcola dimensioni reali dal file scaricato
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

                            // Genera la miniatura a 300px con Intervention Image
                            $imgManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Imagick\Driver());
                            $miniature = $imgManager->read($tempPath);
                            $miniature->scaleDown(width: 300, height: 300);
                            $jpegMiniature = $miniature->encode(new \Intervention\Image\Encoders\JpegEncoder(quality: 80));

                            $miniatureStorePath = 'photos/' . $photoBoxDir . '/300_' . $filename;
                            Storage::disk('public')->put($miniatureStorePath, (string) $jpegMiniature);
                        }

                        // Aggiorna file_path definitivo per il DB
                        $userData['file_path'] = $relativeFilePath;
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
                    $errors[] = "Validation errors in 7. user_works loop on index {$index}: " . implode(', ', Arr::flatten($e->errors()));
                    $this->writeReportLog($errors);
                    return;
                }

                // 5. Cerca se l'opera esiste già su DB
                $userWork = UserWork::withTrashed()
                    ->where(function ($query) use ($rawWorkId, $userData) {
                        if ($rawWorkId !== 'new') {
                            $query->where('id', $rawWorkId);
                        }
                        if (!empty($userData['file_path'])) {
                            $query->orWhere('file_path', $userData['file_path']);
                        }
                    })
                    ->first();

                // Unset delle chiavi che non appartengono alla tabella user_works
                unset($userData['url_path']);

                // 6. Persistence su Database (Create o Update)
                if ($userWork) {
                    $userWorkId = $userWork->id;
                    try {
                        DB::transaction(function () use ($userData, $userWork, $userWorkId) {
                            if (($userData['deleted_at'] ?? null) === 'restore') {
                                $userWork->restore();
                            }
                            unset($userData['deleted_at'], $userData['id']);

                            $userWork->update(array_merge($userData, [
                                'id' => $userWorkId,
                            ]));
                        });
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 7. user_work loop / ' . $index . ' for userId:' . $userIdFound);
                        $errors[] = 'Errors from user_work update: ' . $e->getMessage();
                        $this->writeReportLog(errors: $errors);
                        return;
                    }
                } else {
                    $userData['id'] = $userWorkId;
                    unset($userData['deleted_at']);

                    try {
                        $userWork = UserWork::create($userData);
                    } catch (\Throwable $e) {
                        Log::info('Job: ' . $jobName . ' / 7. user_work loop / ' . $index . ' for userId:' . $userIdFound);
                        $errors[] = 'Errors from user_work create: ' . $e->getMessage();
                        $this->writeReportLog(errors: $errors);
                        return;
                    }
                }

                // Popola la mappa per il ciclo successivo user_work_mores
                $this->workPathToUuidMap[$userData['file_path']] = $userWorkId;
            }
        }
        // user_works
        // ===================================================================
        // Model userWorkMores - loop
        // ===================================================================
        //
    }
    // handle()
}
// class
