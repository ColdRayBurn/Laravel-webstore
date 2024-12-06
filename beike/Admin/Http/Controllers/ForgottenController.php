<?php
/**
 * ForgottenController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     TL <mengwb@guangda.work>
 * @created    2022-07-14 11:39:08
 * @modified   2022-07-14 11:39:08
 */

namespace Beike\Admin\Http\Controllers;

use Beike\Admin\Http\Requests\ForgottenRequest;
use Beike\Admin\Http\Requests\VerifyCodeRequest;
use Beike\Admin\Services\UserService;
use Illuminate\Http\Request;

class ForgottenController
{
    /**
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin::pages.user.forgotten');
    }

    /**
     * email，
     * @param Request $request
     * @return array
     */
    public function sendVerifyCode(VerifyCodeRequest $request)
    {
        UserService::sendVerifyCodeForForgotten($request->get('email'));

        return json_success(trans('admin/forgotten.verify_code_sent'));
    }

    /**
     * 、，、，
     * @param Request $request
     * @return array
     */
    public function changePassword(ForgottenRequest $request)
    {
        UserService::verifyAndChangePassword($request->get('code'), $request->get('email'), $request->get('password'));

        return json_success(trans('common.updated_success'));
    }
}
