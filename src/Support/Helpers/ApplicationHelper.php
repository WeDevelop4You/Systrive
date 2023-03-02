<?php

namespace Support\Helpers;

use App\Account\Settings\Responses\SettingsOverviewResponse;
use BadMethodCallException;
use Domain\Company\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Stringable;
use Str;

/**
 * @method static bool isApiDomain()
 * @method static bool isMainDomain()
 * @method static bool isMiscDomain()
 * @method static bool isAdminDomain()
 * @method static bool isCompanyDomain()
 * @method static bool isAccountDomain()
 * @method static string getApiDomain()
 * @method static string getMiscDomain()
 * @method static string getMainDomain()
 * @method static string getAdminDomain()
 * @method static string getCompanyDomain()
 * @method static string getAccountDomain()
 */
class ApplicationHelper
{
    private static string $domain;

    public static function setDomain(): void
    {
        $domain = request()->headers->get('origin', request()->getHost());

        self::$domain = str_replace(['http://', 'https://'], '', $domain);
    }

    /**
     * @return string
     */
    public static function getAuthRoute(): string
    {
        return route('account.view.auth');
    }

    /**
     * @return string
     */
    public static function getAdminRoute(): string
    {
        return route('admin.view.dashboard');
    }

    /**
     * @return string
     */
    public static function getSwitcherRoute(): string
    {
        return route('company.view.switcher');
    }

    /**
     * @param Company $company
     *
     * @return string
     */
    public static function getCompanyRoute(Company $company): string
    {
        return route('company.view.dashboard', $company->slug);
    }

    /**
     * @return string
     */
    public static function getSettingsRoute(): string
    {
        return route('account.view.settings', SettingsOverviewResponse::DEFAULT_PAGE);
    }

    /**
     * @return string
     */
    public static function getRedirectRoute(): string
    {
        if (!Auth::check()) {
            return self::getAuthRoute();
        }

        return Auth::user()->isSuperAdmin()
            ? self::getAdminRoute()
            : self::getSwitcherRoute();
    }

    /**
     * @param string $application
     *
     * @return bool
     */
    private static function isDomain(string $application): bool
    {
        return self::$domain === self::getDomain($application);
    }

    /**
     * @param string $application
     *
     * @return string
     */
    private static function getDomain(string $application): string
    {
        return Config::get("applications.{$application}.routes.domain");
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return bool|string
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $name = Str::of($name);

        if ($name->endsWith('Domain')) {
            return match (true) {
                $name->startsWith('is') => self::isDomain($name->between('is', 'Domain')->lower()),
                $name->startsWith('get') => self::getDomain($name->between('get', 'Domain')->lower()),
                default => throw new BadMethodCallException()
            };
        }

        throw new BadMethodCallException();
    }
}
