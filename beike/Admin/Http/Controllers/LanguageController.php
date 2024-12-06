<?php
/**
 * LanguageController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     TL <mengwb@guangda.work>
 * @created    2022-07-05 16:37:04
 * @created    2022-07-05 16:37:04
 */

namespace Beike\Admin\Http\Controllers;

use Beike\Admin\Services\LanguageService;
use Beike\Repositories\LanguageRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     *
     * @return mixed
     */
    public function index()
    {
        $languages = LanguageService::all();

        $data = [
            'languages' => $languages,
        ];
        $data = hook_filter('admin.language.index.data', $data);

        return view('admin::pages.languages.index', $data);
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $language = LanguageService::create($request->only('name', 'code'));

        return json_success(trans('common.created_success'), $language);
    }

    /**
     * @param Request $request
     * @param int     $id
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $language = LanguageRepo::update($id, $request->except('status'));

        return json_success(trans('common.updated_success'), $language);
    }

    /**
     *
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        LanguageService::delete($id);

        return json_success(trans('common.deleted_success'));
    }
}
