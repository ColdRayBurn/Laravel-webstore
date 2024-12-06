<?php
/**
 * CartService.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-01-05 10:12:57
 * @modified   2022-01-05 10:12:57
 */

namespace Beike\Shop\Services;

use Beike\Models\Customer;
use Beike\Repositories\CustomerRepo;
use Beike\Repositories\VerifyCodeRepo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AccountService
{
    /**
     *
     *
     * @param array $data // ['email', 'password']
     * @return mixed
     */
    public static function register(array $data)
    {
        $customerApproved            = system_setting('base.customer_approved', 0);

        $data['customer_group_id'] = system_setting('base.default_customer_group_id', 0);
        $data['from']              = $data['from'] ?? 'pc';
        $data['locale']            = locale();

        if ($data['email'] ?? '') {
            $data['name'] = substr($data['email'], 0, strrpos($data['email'], '@'));
        }
        $data['avatar'] = $data['avatar'] ?? '';
        $data['active'] = 1;

        if ($customerApproved) {
            $data['status'] = 'pending';
        } else {
            $data['status'] = 'approved';
        }

        hook_action('service.account.register.before', $data);

        $customer = CustomerRepo::create($data);
        $customer->notifyRegistration();

        hook_action('service.account.register.after', $customer);

        return $customer;
    }

    /**
     * $type，typeemailtelephone
     * @param $email
     * @param $type
     * @return void
     */
    public static function sendVerifyCodeForForgotten($email, $type)
    {
        $code = str_pad(mt_rand(10, 999999), 6, '0', STR_PAD_LEFT);

        VerifyCodeRepo::deleteByAccount($email);
        VerifyCodeRepo::create([
            'account' => $email,
            'code'    => $code,
        ]);

        Log::info("找回密码验证码：{$code}");

        Customer::query()->where('email', $email)->firstOrFail()->notifyVerifyCodeForForgotten($code);
    }

    /**
     * ，
     * @param        $code
     * @param        $account
     * @param        $password
     * @param string $type     $account，email$account，telephone$account
     * @return void
     * @throws \Exception
     */
    public static function verifyAndChangePassword($code, $account, $password, string $type = 'email')
    {
        $verifyCode = VerifyCodeRepo::findByAccount($account);
        if ($verifyCode->created_at->addMinutes(10) < Carbon::now()) {
            $verifyCode->delete();

            throw new \Exception(trans('shop/account.verify_code_expired'));
        }

        if ($verifyCode->code != $code) {
            throw new \Exception(trans('shop/account.verify_code_error'));
        }

        if ($type == 'email') {
            $customer = CustomerRepo::findByEmail($account);
            if (! $customer) {
                throw new \Exception(trans('shop/account.account_not_exist'));
            }
        } elseif ($type == 'telephone') {
            throw new \Exception('暂不支持手机号码找回密码');
        } else {
            throw new \Exception('找回密码类型错误');
        }
        CustomerRepo::update($customer, ['password' => $password]);
        $verifyCode->delete();
    }
}
