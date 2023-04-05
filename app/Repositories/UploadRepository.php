<?php

namespace App\Repositories;

use App\Interface\Repository\UploadRepositoryInterface;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;

class UploadRepository extends BaseRepository implements UploadRepositoryInterface
{
    protected string $model = Upload::class;
    public function create($data):Upload
    {
        $user = \Auth::user();
        $storage=Storage::disk('public')->putFile(
            'uploads', $data['file']
        );

        return $user->uploads()->create([
            'path' => $storage,
            'title' => $data['title'],
        ]);
    }

    public function update($id,$data): false|string
    {
        $item=$this->get($id);


        if(Storage::disk('public')->delete($item->path)){
            $storage=Storage::disk('public')->putFile(
                'uploads', $data['file']
            );
            return $item->update([
                'path' => $storage,
                'title' => $data['title'],
            ]);
        }
        return false;
    }


    public function delete(Upload $upload): bool
    {
        $item=$this->getWithTrashed($id);
        if(Storage::disk('public')->delete($item->path)){
            $item->forceDelete();
            return true;
        }
        return false;
    }

}
