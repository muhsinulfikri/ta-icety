<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Model
{
    static function S3($fileData, $folder, $subName)
    {
        $file = $fileData;
        $fileName = $file->getClientOriginalName();
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $s3 = Storage::disk('s3')->getClient();
        $bucket = config('filesystems.disks.s3.bucket');

        $movedName = $subName . '-' . strtotime(date('Y-m-d H:i:s')) . '.' . $extension;

        $path = $folder . '/' . $movedName;
        $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $path,
            'SourceFile' => $file->path(),
            'ACL' => 'public-read',
            'ContentType' => $file->getMimeType(),
            'ContentDisposition' => 'inline; filename="' . $fileName . '"',
        ]);

        return Storage::disk('s3')->url($path);
    }

    static function S3_PDF($localFilePath, $folder, $subName)
    {
        $s3 = Storage::disk('s3')->getClient();
        $file = $localFilePath;
        $bucket = config('filesystems.disks.s3.bucket');

        $movedName = $subName . '-' . strtotime(date('Y-m-d H:i:s')) . '.' . pathinfo($localFilePath, PATHINFO_EXTENSION);

        $path = $folder . '/' . $movedName;

        $s3->putObject([
            'Bucket' => $bucket,
            'Key' => $path,
            'SourceFile' => $localFilePath,
            'ACL' => 'public-read',
            'ContentType' => $file->getMimeType(),
            'ContentDisposition' => 'inline; filename="' . basename($localFilePath) . '"',
        ]);

        return Storage::disk('s3')->url($path);
    }

    public static function UploadFileBlob($files_name, $file_tmp, $folder)
    {
        if (isset($files_name) && isset($file_tmp)) {
            $new_name = time() . '_' . $files_name;

            $s3 = Storage::disk('s3')->getClient();
            try {
                $s3->putObject([
                    'Bucket' => 'tbh-v2',
                    'Key' => $folder . '/' . $new_name,
                    'Body' => $file_tmp,
                    'ContentType' => 'application/pdf',
                    'ACL' => 'public-read',
                ]);

                return "https://is3.cloudhost.id/tbh-v2/{$folder}/{$new_name}";
            } catch (Exception $e) {
                return "Error uploading file: " . $e->getMessage();
            }
        }
    }
}