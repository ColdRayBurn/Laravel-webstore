<?php

use Barryvdh\Debugbar\Facades\Debugbar;
use Beike\Hook\Facades\Hook;
use Beike\Models\AdminUser;
use Beike\Models\Currency;
use Beike\Models\Customer;
use Beike\Models\Language;
use Beike\Plugin\Plugin;
use Beike\Repositories\CurrencyRepo;
use Beike\Repositories\LanguageRepo;
use Beike\Services\CurrencyService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use TorMorten\Eventy\Facades\Eventy;

/**
 *  settings
 *
 * @param      $key
 * @param null $default
 * @return mixed
 */
function setting($key, $default = null)
{
    return config("bk.{$key}", $default);
}

/**
 *  settings
 *
 * @param      $key
 * @param null $default
 * @return mixed
 */
function system_setting($key, $default = null)
{
    return setting("system.{$key}", $default);
}

/**
 *  settings
 *
 * @param      $key
 * @param null $default
 * @return mixed
 */
function plugin_setting($key, $default = null)
{
    return setting("plugin.{$key}", $default);
}

/**
 *
 *
 * @param $code     ,
 * @param $filePath ,  static
 */
function plugin_asset($code, $filePath): string
{
    return shop_route('plugin.asset', ['code' => $code, 'path' => $filePath]);
}

/**
 * ,  admin
 */
function admin_name(): string
{
    if ($envAdminName = config('beike.admin_name')) {
        return Str::snake($envAdminName);
    } elseif ($settingAdminName = system_setting('base.admin_name')) {
        return Str::snake($settingAdminName);
    }

    return 'admin';
}

/**
 *
 */
function load_settings()
{
    if (is_installer() || ! file_exists(__DIR__ . '/../storage/installed')) {
        return;
    }
    $result = \Beike\Repositories\SettingRepo::getGroupedSettings();
    config(['bk' => $result]);
}

/**
 *
 *
 * @param       $route
 * @param mixed $params
 * @return string
 */
function admin_route($route, $params = []): string
{
    $adminName = admin_name();

    return route("{$adminName}.{$route}", $params);
}

/**
 *
 *
 * @param       $route
 * @param mixed $params
 * @return string
 */
function shop_route($route, $params = []): string
{
    return route('shop.' . $route, $params);
}

/**
 *  category, product, brand, page, static, custom
 *
 * @param $type
 * @param $value
 * @return string
 * @throws Exception
 */
function type_route($type, $value): string
{
    return \Beike\Libraries\Url::getInstance()->link($type, $value);
}

/**
 *  category, product, brand, page, static, custom
 *
 * @param       $type
 * @param       $value
 * @param array $texts
 * @return string
 */
function type_label($type, $value, array $texts = []): string
{
    return \Beike\Libraries\Url::getInstance()->label($type, $value, $texts);
}

/**
 *
 *
 * @param $link
 * @return array
 * @throws Exception
 */
function handle_link($link): array
{
    $type  = $link['type']  ?? '';
    $value = $link['value'] ?? '';
    $texts = $link['text']  ?? [];

    $link['link'] = type_route($type, $value);
    $link['text'] = type_label($type, $value, $texts);

    return $link;
}

/**
 *
 * @return bool
 */
function is_admin(): bool
{
    $adminName = admin_name();
    $uri       = request()->getRequestUri();
    if (Str::startsWith($uri, "/{$adminName}")) {
        return true;
    }

    return false;
}

/**
 *
 * @return bool
 */
function is_installer(): bool
{
    $uri = request()->getRequestUri();

    return Str::startsWith($uri, '/installer');
}

/**
 *
 *
 * @return string
 */
function current_route(): string
{
    return Route::getCurrentRoute()->getName();
}

/**
 *
 *
 * @param $routeName
 * @return bool
 */
function equal_route($routeName): bool
{
    if (is_array($routeName)) {
        return in_array(Route::getCurrentRoute()->getName(), $routeName);
    }

    return $routeName == Route::getCurrentRoute()->getName();
}

/**
 *
 *
 * @return mixed
 */
function current_user(): ?AdminUser
{
    $user = auth()->guard(AdminUser::AUTH_GUARD)->user();
    if (empty($user)) {
        $user = registry('admin_user');
    }

    return $user;
}

/**
 *
 *
 * @return mixed
 */
function current_customer(): mixed
{
    $customer = auth()->guard(Customer::AUTH_GUARD)->user();
    if (empty($customer) && config('jwt.secret')) {
        return auth('api_customer')->user();
    }

    return $customer;
}

/**
 *  session id
 */
function get_session_id(): string
{
    $headerSessionId = request()->header('Bksessionid');
    if ($headerSessionId) {
        return $headerSessionId;
    }

    return session()->getId();
}

/**
 *
 *
 * @return array
 */
function locales(): array
{
    $locales = LanguageRepo::enabled()->toArray();

    return array_map(function ($item) {
        return [
            'name' => $item['name'],
            'code' => $item['code'],
        ];
    }, $locales);
}

/**
 *
 *
 * @return string
 */
function locale(): string
{
    if (is_admin()) {
        $locales    = collect(locales())->pluck('code');
        $userLocale = current_user()->locale;

        return ($locales->contains($userLocale)) ? $userLocale : 'en';
    }

    $registerLocale = registry('locale');
    if ($registerLocale) {
        return $registerLocale;
    }

    return Session::get('locale') ?? system_setting('base.locale');
}

/**
 *
 *
 * @return string
 */
function admin_locale(): string
{
    if (is_admin()) {
        return current_user()->locale;
    }

    return locale();
}

/**
 *
 *
 * @param        $price
 * @param string $currency
 * @param string $value
 * @param bool   $format
 * @return string
 */
function currency_format($price, string $currency = '', string $value = '', bool $format = true): string
{
    if (! $currency) {
        $currency = is_admin() ? system_setting('base.currency') : current_currency_code();
    }

    return CurrencyService::getInstance()->format($price, $currency, $value, $format);
}

/**
 *
 *
 * @return string
 */
function current_currency_rate(): float
{
    $currency = current_currency_code();

    return Currency::query()->where('code', $currency)->value('value') ?? 1;
}

/**
 *
 *
 * @param null $datetime
 * @return false|string
 */
function time_format($datetime = null)
{
    $format = 'Y-m-d H:i:s';
    if ($datetime instanceof Illuminate\Support\Carbon) {
        return $datetime->format($format);
    } elseif (is_int($datetime)) {
        return date($format, $datetime);
    }

    return date($format);
}

/**
 *
 *
 * @param string $path
 * @return string
 */
function plugin_path(string $path = ''): string
{
    return base_path('plugins') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $path);
}

/**
 * @param $code
 * @return Plugin|null
 */
function plugin($code): ?Plugin
{
    return app('plugin')->getPlugin($code);
}

/**
 *
 *
 * @param     $pluginCode
 * @param     $image
 * @param int $width
 * @param int $height
 * @return mixed|void
 * @throws Exception
 */
function plugin_resize($pluginCode, $image, int $width = 100, int $height = 100)
{
    if (Str::startsWith($image, 'http')) {
        return $image;
    }

    $plugin        = plugin($pluginCode);
    $pluginDirName = $plugin->getDirname();

    return (new \Beike\Services\ImageService($image))->setPluginDirName($pluginDirName)->resize($width, $height);
}

/**
 * Get origin image from plugin
 *
 * @param $pluginCode
 * @param $image
 * @return mixed|void
 * @throws Exception
 */
function plugin_origin($pluginCode, $image)
{
    if (Str::startsWith($image, 'http')) {
        return $image;
    }

    $plugin        = plugin($pluginCode);
    $pluginDirName = $plugin->getDirname();

    return (new \Beike\Services\ImageService($image))->setPluginDirName($pluginDirName)->originUrl();
}

/**
 *
 *
 * @param     $image
 * @param int $width
 * @param int $height
 * @return mixed|void
 * @throws Exception
 */
function image_resize($image, int $width = 100, int $height = 100)
{
    if (Str::startsWith($image, 'http')) {
        return $image;
    }

    return (new \Beike\Services\ImageService($image))->resize($width, $height);
}

/**
 *
 * @throws Exception
 */
function image_origin($image)
{
    if (Str::startsWith($image, 'http')) {
        return $image;
    }

    return (new \Beike\Services\ImageService($image))->originUrl();
}

/**
 *
 *
 * @return Collection
 */
function languages(): Collection
{
    return LanguageRepo::enabled()->pluck('code');
}

/**
 *
 *
 * @return string
 */
function current_language()
{
    $code = locale();

    return Language::query()->where('code', $code)->first();
}

/**
 *
 *
 * @return array
 */
function admin_languages(): array
{
    $packages       = language_packages();
    $adminLanguages = collect($packages)->filter(function ($package) {
        return file_exists(resource_path("lang/{$package}/admin"));
    })->toArray();

    return array_values($adminLanguages);
}

/**
 *
 * @return array
 */
function language_packages(): array
{
    $languageDir = resource_path('lang');

    return array_values(array_diff(scandir($languageDir), ['..', '.', '.DS_Store']));
}

/**
 * @return Builder[]|\Illuminate\Database\Eloquent\Collection
 */
function currencies()
{
    return CurrencyRepo::listEnabled();
}

/**
 *
 *
 * @return string
 */
function current_currency_code(): string
{
    $registerLocale = registry('currency');
    if ($registerLocale) {
        return $registerLocale;
    }

    return Session::get('currency') ?? system_setting('base.currency');
}

/**
 *
 *
 * @return string
 */
function current_currency_id(): string
{
    $currencyCode = current_currency_code();
    $currency     = \Beike\Models\Currency::query()->where('code', $currencyCode)->first();

    return $currency->id ?? 0;
}

/**
 * , 、
 *
 * @param $quantity
 * @return mixed|string
 */
function quantity_format($quantity)
{
    if ($quantity > 1000000000000) {
        return round($quantity / 1000000000000, 1) . 'T';
    } elseif ($quantity > 1000000000) {
        return round($quantity / 1000000000, 1) . 'B';
    } elseif ($quantity > 1000000) {
        return round($quantity / 1000000, 1) . 'M';
    } elseif ($quantity > 1000) {
        return round($quantity / 1000, 1) . 'K';
    }

    return $quantity;

}

/**
 * json
 */
function json_success($message, $data = []): JsonResponse
{
    $data = [
        'status'  => 'success',
        'message' => $message,
        'data'    => $data,
    ];

    return response()->json($data);
}

/**
 * json
 */
function json_fail($message, $data = [], $status = 422): JsonResponse
{
    $data = [
        'status'  => 'fail',
        'message' => $message,
        'data'    => $data,
    ];

    return response()->json($data, $status);
}

if (! function_exists('sub_string')) {
    /**
     * @param        $string
     * @param int    $length
     * @param string $dot
     * @return string
     */
    function sub_string($string, int $length = 16, string $dot = '...'): string
    {
        $strLength = mb_strlen($string);
        if ($length <= 0) {
            return $string;
        } elseif ($strLength <= $length) {
            return $string;
        }

        return mb_substr($string, 0, $length) . $dot;
    }
}

/**
 *  $builder SQL
 * @param mixed $builder
 * @return string|string[]|null
 */
function to_sql($builder): array|string|null
{
    $sql = $builder->toSql();
    foreach ($builder->getBindings() as $binding) {
        $value = is_numeric($binding) ? $binding : "'" . $binding . "'";
        $sql   = preg_replace('/\?/', $value, $sql, 1);
    }

    return $sql;
}

/**
 *
 * @param $directoryPath
 */
function create_directories($directoryPath)
{
    $path        = '';
    $directories = explode('/', $directoryPath);
    foreach ($directories as $directory) {
        $path = $path . '/' . $directory;
        if (! is_dir(public_path($path))) {
            @mkdir(public_path($path), 0755);
        }
    }
}

/**
 *  debugbar
 *
 * @return bool
 */
function has_debugbar(): bool
{
    return class_exists(\Barryvdh\Debugbar\Facades\Debugbar::class);
}

/**
 * PHP  hook filter
 *
 * @param $hookKey
 * @param $hookValue
 * @return mixed
 */
function hook_filter($hookKey, $hookValue): mixed
{
    if (config('app.debug') && has_debugbar()) {
        Debugbar::log('HOOK === hook_filter: ' . $hookKey);
    }

    return Eventy::filter($hookKey, $hookValue);
}

/**
 * PHP  hook action
 *
 * @param $hookKey
 * @param $hookValue
 */
function hook_action($hookKey, $hookValue)
{
    if (config('app.debug') && has_debugbar()) {
        Debugbar::log('HOOK === hook_action: ' . $hookKey);
    }
    Eventy::action($hookKey, $hookValue);
}

/**
 *  Filter,  PHP
 *
 * @param     $hookKey
 * @param     $callback
 * @param int $priority
 * @param int $arguments
 * @return mixed
 */
function add_hook_filter($hookKey, $callback, int $priority = 20, int $arguments = 1): mixed
{
    return Eventy::addFilter($hookKey, $callback, $priority, $arguments);
}

/**
 *  Action,  PHP
 *
 * @param     $hookKey
 * @param     $callback
 * @param int $priority
 * @param int $arguments
 */
function add_hook_action($hookKey, $callback, int $priority = 20, int $arguments = 1)
{
    Eventy::addAction($hookKey, $callback, $priority, $arguments);
}

/**
 *  Hook  Blade
 *
 * @param     $hookKey
 * @param     $callback
 * @param int $priority
 */
function add_hook_blade($hookKey, $callback, int $priority = 0)
{
    Hook::listen($hookKey, $callback, $priority);
}

/**
 *
 *
 * @return bool
 */
function installed(): bool
{
    return file_exists(storage_path('installed'));
}

/**
 *
 *
 * @return bool
 */
function is_mobile(): bool
{
    return (new \Jenssegers\Agent\Agent())->isMobile();
}

/**
 *  https
 *
 * @return bool
 */
function is_secure(): bool
{
    if (! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
        return true;
    } elseif (! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    } elseif (isset($_SERVER['SERVER_PORT']) && intval($_SERVER['SERVER_PORT']) === 443) {
        return true;
    } elseif (isset($_SERVER['REQUEST_SCHEME']) && strtolower($_SERVER['REQUEST_SCHEME']) === 'https') {
        return true;
    }

    return false;
}

/**
 *
 *
 * @return int
 */
function perPage(): int
{
    return (int) system_setting('base.product_per_page', 20);
}

/**
 * @param      $key
 * @param      $value
 * @param bool $force
 */
function register($key, $value, bool $force = false)
{
    \Beike\Libraries\Registry::set($key, $value, $force);
}

/**
 * @param      $key
 * @param null $default
 * @return mixed
 */
function registry($key, $default = null): mixed
{
    return \Beike\Libraries\Registry::get($key, $default);
}

/**
 * ,
 *
 * @param $domain
 * @return string
 */
function clean_domain($domain): string
{
    $domain = trim($domain);
    if (empty($domain)) {
        return '';
    }

    return trim(str_replace(['http://', 'https://'], '', $domain));
}

/**
 * Check domain ha license.
 * ,  https://beikeshop.com/vip/subscription
 *
 * @return bool
 * @throws Exception
 */
function check_license(): bool
{
    $configLicenceCode = system_setting('base.license_code');
    $appDomain         = clean_domain(request()->getHost());

    try {
        $domain         = new \Utopia\Domains\Domain($appDomain);
        $registerDomain = $domain->getRegisterable();
    } catch (\Exception $e) {
        $registerDomain = '';
    }

    if (filter_var($appDomain, FILTER_VALIDATE_IP)) {
        $registerDomain = $appDomain;
    }

    if (empty($registerDomain)) {
        return true;
    }

    return $configLicenceCode == md5(mb_substr(md5($registerDomain), 2, 8));
}

/**
 * @param $sourceFolder
 * @param $zipPath
 * @return ZipArchive
 */
function zip_folder($sourceFolder, $zipPath): ZipArchive
{
    $zip = new ZipArchive;
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
        $dirIterator = new RecursiveDirectoryIterator($sourceFolder);
        $iterator    = new RecursiveIteratorIterator($dirIterator);
        foreach ($iterator as $file) {
            if (! $dirIterator->isDot()) {
                $filePath     = $file->getPathname();
                $relativePath = substr($filePath, strlen($sourceFolder));
                if ($file->isDir()) {
                    $zip->addEmptyDir($relativePath);
                } else {
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }
        $zip->close();
    }

    return $zip;
}

/**
 *
 *
 * @param $sourcePath
 * @param $destinationPath
 */
function move_dir($sourcePath, $destinationPath)
{
    $baseSourceName = basename($sourcePath);
    $files          = File::allFiles($sourcePath);
    if (empty($files)) {
        File::ensureDirectoryExists("{$destinationPath}{$baseSourceName}");
    } else {
        foreach ($files as $file) {
            $relativePath = $file->getRelativePath();
            $newBasePath  = "{$destinationPath}{$baseSourceName}/{$relativePath}/";
            $newFilePath  = $newBasePath . $file->getFilename();
            File::ensureDirectoryExists($newBasePath);
            File::move($file->getPathname(), $newFilePath);
        }
    }
    File::deleteDirectory($sourcePath);
}

/**
 *
 *
 * @return bool
 */
function has_translator(): bool
{
    return \Beike\Repositories\PluginRepo::getTranslators()->count() > 0;
}

/**
 * @return string
 */
function beike_api_url(): string
{
    $apiUrl      = config('beike.api_url');
    $adminLocale = admin_locale();
    if ($adminLocale == 'zh_cn') {
        return str_replace('beikeshop.com', 'beikeshop.cn', $apiUrl);
    }

    return $apiUrl;
}

/**
 *  .env
 *
 * @return bool
 */
function check_same_domain(): bool
{
    $request       = request();
    $envDomain     = clean_domain(env('APP_URL'));

    $host = $request->getHost();
    $port = $request->getPort();

    if (in_array($port, [80, 443])) {
        $requestDomain = clean_domain($host);
    } else {
        $requestDomain = $host . ':' . $port;
    }

    return get_domain($envDomain) == get_domain($requestDomain);
}

/**
 * @return bool
 */
function is_miniapp(): bool
{
    return \request()->header('platform') == 'miniapp';
}

/**
 *
 * @param null $domain
 * @return string
 */
function get_domain($domain = null)
{

    if (!$domain) {

        $domain = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST) ?: $_SERVER['HTTP_HOST'];
    } else {

        $domain = parse_url($domain, PHP_URL_HOST) ?: $domain;
    }


    $domain = preg_replace('/:\d+$/', '', $domain);


    $known_tlds = array('co.uk', 'gov.uk', 'ac.uk', 'org.uk', 'com.au', 'net.au');


    $parts = explode('.', $domain);
    $count = count($parts);

    if ($count > 2) {

        $last_two = implode('.', array_slice($parts, -2));
        $last_three = implode('.', array_slice($parts, -3));

        if (in_array($last_two, $known_tlds)) {
            return implode('.', array_slice($parts, -3));
        } elseif (in_array($last_three, $known_tlds)) {
            return implode('.', array_slice($parts, -4));
        }
    }


    return implode('.', array_slice($parts, -2));
}
