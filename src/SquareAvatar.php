<?php

namespace Kemp\SquareAvatar;

use Laravel\Nova\Fields\Avatar;
use Intervention\Image\ImageManagerStatic as Image;

class SquareAvatar extends Avatar
{
    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->wrapStorageCallback();
    }

    public function store(callable $storageCallback)
    {
        parent::store($storageCallback);

        $this->wrapStorageCallback();

        return $this;
    }

    private function wrapStorageCallback()
    {
        $originalCallback = $this->storageCallback;

        $this->storageCallback = function($request, $model, $attribute, $requestAttribute, $disk, $storagePath) use ($originalCallback) {
            $file = $request->file($requestAttribute);

            $img = Image::make($file);
            $img->fit($this->maxWidth);
            $img->save();

            return call_user_func(
                $originalCallback,
                $request,
                $model,
                $attribute,
                $requestAttribute,
                $disk,
                $storagePath
            );
        };
    }
}
