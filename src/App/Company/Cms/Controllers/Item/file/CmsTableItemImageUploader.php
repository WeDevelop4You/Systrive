<?php

namespace App\Company\Cms\Controllers\Item\file;

use App\Company\Cms\Requests\CmsTableItemFileRequest;
use Domain\Cms\Columns\Attributes\FileColumn;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CmsTableItemImageUploader
{
    /**
     * @param CmsTableItemFileRequest $request
     * @param Company                 $company
     * @param Cms                     $cms
     * @param CmsTable                $table
     * @param CmsColumn               $column
     *
     * @return JsonResponse
     */
    public function action(CmsTableItemFileRequest $request, Company $company, Cms $cms, CmsTable $table, CmsColumn $column): JsonResponse
    {
        if ($column->type() instanceof FileColumn) {
            $file = $request->file('file');

            $image = Image::make($file)->crop(
                $request->get('width'),
                $request->get('height'),
                $request->get('left'),
                $request->get('top'),
            )->resize(
                $column->property('dimension_width'),
                $column->property('dimension_height')
            )->save();

            $path = Storage::disk('tmp')->putFile('', $image->basePath());

            if (\is_string($path)) {
                return Response::create()->addData([
                    'identifier' => $path,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType(),
                ])->toJson();
            }
        }

        return Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.error.file')),
            ResponseCode::HTTP_BAD_REQUEST
        )->toJson();
    }
}
