<?php namespace app\Helpers;

/**
 * Loans - Menu Functions Helper
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

class Menu {
    /**
     * sideBar Menu
     * @param output type [json or array]
     * @return [json o array]
     *
     * The array content has to be a least [route, text]
     *
     * Array format > [route, text, badge cont, divider, class, icon]
     *
     * @author Gustavo Ocanto <gustavoocanto@gmail.com>
     */
    public static function sideBar($returnArray = true) {
        $user = \Auth::user();

        $menu = [
            ['route' => route('home'), 'text' => trans('globals.section_title.dashboard'), 'icon' => 'glyphicon glyphicon-dashboard'],
        ];

        if ($user) {
            $menu = array_merge($menu, [
                ['route' => route('customers.index'), 'text' => trans('globals.side_bar.customers'), 'icon' => 'glyphicon glyphicon-briefcase', 'divider' => 1, 'cont' => 1],
                ['route' => route('loans.index'), 'text' => trans('globals.side_bar.loans'), 'icon' => 'fa fa-cube', 'divider' => 1, 'cont' => 1],
                ['route' => route('surcharges.index'), 'text' => trans('globals.side_bar.surcharges'), 'icon' => 'glyphicon glyphicon-leaf', 'divider' => 1, 'cont' => 1],
                ['route' => route('payments.index'), 'text' => trans('globals.side_bar.payments'), 'icon' => 'fa fa-credit-card', 'divider' => 1, 'cont' => 1],
            ]);
            if ($user->role == 'admin') {
                $menu = array_merge($menu, [
                    ['route' => '/', 'text' => trans('globals.side_bar.settings'), 'icon' => 'fa fa-gears', 'divider' => 1, 'cont' => 1],
                ]);
            }
        }

        return $returnArray ? $menu : json_encode($menu);
    }

    public static function subMenu($key) {
        $menu = [];

        //CALENDAR
        /*$menu[trans('globals.side_bar.full_calendar')] = [
            ['route' => route('calendar.holydays.index'), 'text' => trans('globals.side_bar.holydays'), 'icon' => 'glyphicon glyphicon-user', 'divider' => 1, 'cont' => 0],
        ];*/

        //MAINTENANCE
        $menu[trans('globals.side_bar.settings')] = [
            ['route' => route('employees.index'), 'text' => trans('globals.side_bar.employees'), 'icon' => 'glyphicon glyphicon-user', 'divider' => 1, 'cont' => 0],
            ['route' => route('calendar.holydays.index'), 'text' => trans('globals.side_bar.holydays'), 'icon' => 'glyphicon glyphicon-user', 'divider' => 1, 'cont' => 0],
            ['route' => route('banks.index'), 'text' => trans('globals.side_bar.banks'), 'icon' => 'glyphicon glyphicon-user', 'divider' => 1, 'cont' => 0],
            ['route' => route('cities.index'), 'text' => trans('globals.side_bar.cities'), 'icon' => 'glyphicon glyphicon-user', 'divider' => 1, 'cont' => 0],
        ];

        /*['route' => route('paymentsFrequency.index'), 'text' => trans('globals.side_bar.payments_frequency'), 'icon' => 'glyphicon glyphicon-user', 'divider' => 1, 'cont' => 0],*/
        return (array_key_exists($key, $menu)) ? $menu[$key] : [];
    }

}
