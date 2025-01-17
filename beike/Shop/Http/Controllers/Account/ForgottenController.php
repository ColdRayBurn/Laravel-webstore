<?php
/**
 * ForgottenController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     TL <mengwb@guangda.work>
 * @created    2022-07-06 15:39:08
 * @modified   2022-07-06 15:39:08
 */

namespace Beike\Shop\Http\Controllers\Account;

use Beike\Shop\Http\Requests\ForgottenRequest;
use Beike\Shop\Http\Requests\VerifyCodeRequest;
use Beike\Shop\Services\AccountService;
use Illuminate\Http\JsonResponse;

class ForgottenController
{
    /**
     *
     * @return mixed
     */
    public function index()
    {
        return view('account/forgotten');
    }

    /**
     * email，
     * @param VerifyCodeRequest $request
     * @return JsonResponse
     */
    public function sendVerifyCode(VerifyCodeRequest $request): JsonResponse
    {
        AccountService::sendVerifyCodeForForgotten($request->get('email'), 'email');

        return json_success(trans('shop/forgotten.verification_code_sent'));
    }

    /**
     * 、，、，
     * @param ForgottenRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function changePassword(ForgottenRequest $request): JsonResponse
    {
        AccountService::verifyAndChangePassword($request->get('code'), $request->get('email'), $request->get('password'));

        return json_success(trans('shop/forgotten.password_updated'));
    }
}
