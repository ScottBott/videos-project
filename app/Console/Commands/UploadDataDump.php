<?php

namespace App\Console\Commands;

use App\Country;
use App\Like;
use App\Registration;
use App\Upload;
use App\User;
use App\Video;
use App\Watch;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class UploadDataDump extends Command
{
    const FILE_PATH = 'storage/app/public/data.dump';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data-dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploads data from datadump file';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Model $entity
     * @param int $entityId
     * @param string $name
     *
     * @return Model
     */
    private static function createEntityIfDoesntExist($entity, $entityId = '', $name = '')
    {
        $model = $entity::find($entityId);
        if(!$model) {
            $model = new $entity();

            if($entityId) {
                $model->id = $entityId;
            }

            if($name) {
                $model->name = $name;
            }

            $model->save();
        }

        return $model;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting data dump');

        $handle = fopen(self::FILE_PATH, "r");
        $modelIndex = 1;
        while ($line = fgets($handle)) {
            $data = explode(" ", $line);

            if(isset($data[$modelIndex])) {
                self::createEntityIfDoesntExist(User::class, $data[2]);
                switch ($data[$modelIndex]) {
                    case 'REGISTER':
                        self::handleRegistration($data);
                        break;
                    case 'UPLOAD':
                        self::handleUploads($data);
                        break;
                    case 'WATCH':
                        self::handleWatches($data);
                        break;
                    case 'LIKE':
                        self::handleLikes($data);
                        break;
                    default:
                        break;
                }
            }
        }

        $this->info('Data dump autoload finished');
    }

    /**
     * @param array $data
     */
    private static function handleRegistration($data)
    {
        $country = self::createEntityIfDoesntExist(Country::class, '', $data[3]);
        $registration = new Registration();
        $registration->user_id = $data[2];
        $registration->country_id = $country->id;
        $registration->ip = trim($data[4]);
        $registration->created_at = Carbon::parse($data[0])->toDateTimeString();
        $registration->save();
    }

    /**
     * @param array $data
     */
    private static function handleUploads($data)
    {
        self::createEntityIfDoesntExist(Video::class, $data[3]);
        $upload = new Upload();
        $upload->user_id = $data[2];
        $upload->video_id = trim($data[3]);
        $upload->created_at = Carbon::parse($data[0])->toDateTimeString();
        $upload->save();
    }

    /**
     * @param array $data
     */
    private static function handleLikes($data)
    {
        self::createEntityIfDoesntExist(Video::class, $data[3]);
        $like = new Like();
        $like->user_id = $data[2];
        $like->video_id = trim($data[3]);
        $like->created_at = Carbon::parse($data[0])->toDateTimeString();
        $like->save();
    }

    /**
     * @param array $data
     */
    private static function handleWatches($data)
    {
        self::createEntityIfDoesntExist(Video::class, $data[3]);
        $watch = new Watch();
        $watch->user_id = $data[2];
        $watch->video_id = trim($data[3]);
        $watch->created_at = Carbon::parse($data[0])->toDateTimeString();
        $watch->save();
    }
}
