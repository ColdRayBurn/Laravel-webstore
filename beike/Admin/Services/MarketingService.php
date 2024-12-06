<?php
/**
 * MarketingService.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-09-26 11:50:34
 * @modified   2022-09-26 11:50:34
 */

namespace Beike\Admin\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ZanySoft\Zip\Zip;

class MarketingService
{
    private PendingRequest $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'developer-token' => system_setting('base.developer_token'),
        ]);
    }

    public static function getInstance()
    {
        return new self;
    }

    /**
     *
     *
     * @param array $filters
     * @return mixed
     */
    public function getList(array $filters = []): mixed
    {
        $url = config('beike.api_url') . '/api/plugins?locale=' . (admin_locale() == 'zh_cn' ? 'zh_cn' : 'en');
        if (! empty($filters)) {
            $url .= '&' . http_build_query($filters);
        }

        return $this->httpClient->get($url)->json();
    }

    /**
     *
     *
     * @param $pluginCode
     * @return mixed
     */
    public function getPlugin($pluginCode): mixed
    {
        $url    = config('beike.api_url') . "/api/plugins/{$pluginCode}?version=" . config('beike.version') . '&locale=' . (admin_locale() == 'zh_cn' ? 'zh_cn' : 'en');
        $plugin = $this->httpClient->get($url)->json();

        if (empty($plugin)) {
            throw new NotFoundHttpException('该插件不存在或已下架');
        }

        return $plugin;
    }

    /**
     * Check plugin license
     *
     * @param $pluginCode
     * @param $domain
     * @return array|mixed
     */
    public function checkLicense($pluginCode, $domain): mixed
    {
        $url = config('beike.api_url') . "/api/plugins/{$pluginCode}/license?domain={$domain}";

        return $this->httpClient->get($url)->json();
    }

    /**
     *
     *
     * @throws \Exception
     */
    public function buy($pluginCode, $postData)
    {
        $url = config('beike.api_url') . "/api/plugins/{$pluginCode}/buy?".'locale=' . (admin_locale() == 'zh_cn' ? 'zh_cn' : 'en');

        $content = $this->httpClient->withBody($postData, 'application/json')
            ->post($url)
            ->json();

        $status = $content['status'] ?? '';
        if ($status == 'success') {
            return $content['data'];
        }

        throw new \Exception($content['message'] ?? '');
    }

    /**
     *
     *
     * @throws \Exception
     */
    public function buyService($pluginServiceId, $postData)
    {
        $url = config('beike.api_url') . "/api/plugin_services/{$pluginServiceId}/buy";

        $content = $this->httpClient->withBody($postData, 'application/json')
            ->post($url)
            ->json();

        $status = $content['status'] ?? '';
        if ($status == 'success') {
            return $content['data'];
        }

        throw new \Exception($content['message'] ?? '');
    }

    /**
     *
     *
     * @param $pluginServiceOrderId
     * @return mixed
     */
    public function getPluginServiceOrder($pluginServiceOrderId): mixed
    {
        $url    = config('beike.api_url') . "/api/plugin_services/{$pluginServiceOrderId}?version=" . config('beike.version');
        $plugin = $this->httpClient->get($url)->json();

        if (empty($plugin)) {
            throw new NotFoundHttpException('该插件服务订单不存在或已下架');
        }

        return $plugin;
    }

    /**
     *
     *
     * @param             $pluginCode
     * @throws \Exception
     */
    public function download($pluginCode)
    {
        $datetime = date('Y-m-d');
        $url      = config('beike.api_url') . "/api/plugins/{$pluginCode}/download";

        $content = $this->httpClient->get($url, [
            'timeout' => null,
        ])->body();

        $pluginPath = "plugins/{$pluginCode}-{$datetime}.zip";
        Storage::disk('local')->put($pluginPath, $content);

        $pluginZip = storage_path('app/' . $pluginPath);
        $zipFile   = (new Zip)->open($pluginZip);
        $zipFile->extract(base_path('plugins'));
    }

    // getDomain
    public function getDomain($token)
    {
        $url = config('beike.api_url') . '/api/website/get_domain?token=' . $token;

        return $this->httpClient->get($url)->json();
    }

    // getToken
    public function getToken($domain)
    {
        $url = config('beike.api_url') . '/api/website/get_token?domain=' . $domain;

        return $this->httpClient->get($url)->json();
    }
}
