<?php

namespace App\Company\Cms\Controllers\Item\file;

use App\Company\Cms\Requests\CmsTableItemFileRequest;
use Domain\Cms\Columns\Attributes\FileColumn;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Utils\Storage;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CmsTableItemFileUploader
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

            $path = Storage::create()->preUpload($file);

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
