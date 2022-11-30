<?php

namespace AcMarche\MarcheTail\Lib;

use AcMarche\MarcheTail\Inc\Theme;
use AcMarche\MarcheTail\Lib\Cache;
use Symfony\Contracts\Cache\CacheInterface;

class Menu
{
    const MENU_NAME = 'top-menu';
    const MENU_CACHE_NAME = 'menu_all3';

    private CacheInterface $cache;

    public function __construct()
    {
        $this->cache = Cache::instance();
    }

    public function getItems(int $id_site): array
    {
        switch_to_blog($id_site);
        $menu = wp_get_nav_menu_object(self::MENU_NAME);

        $args = array(
            'order'                  => 'ASC',
            'orderby'                => 'menu_order',
            'post_type'              => 'nav_menu_item',
            'post_status'            => 'publish',
            'output'                 => ARRAY_A,
            'output_key'             => 'menu_order',
            'nopaging'               => true,
            'update_post_term_cache' => false,
        );

        return wp_get_nav_menu_items($menu, $args);
    }

    public function getAllItems(): array
    {
        return $this->cache->get(
            self::MENU_CACHE_NAME,
            function (): array {
                $blog = get_current_blog_id();
                $data = [];
                foreach (Theme::SITES as $idSite => $site) {
                    if (in_array($idSite, [8, 12, 13])) {
                        continue;
                    }
                    $data[$idSite]['name'] = ucfirst($site);
                    if ($idSite == 14) {
                        $data[$idSite]['name'] = 'Enfance-Jeunesse';
                    }
                    $data[$idSite]['blogid']     = $idSite;
                    $data[$idSite]['colorhover'] = 'hover:text-'.$site;
                    $data[$idSite]['color']      = 'text-'.$site;
                    $data[$idSite]['items']      = $this->getItems($idSite);
                }
                switch_to_blog($blog);

                return $data;
            }
        );
    }

    public function getAllItems2(): array
    {
        return $this->cache->get(
            self::MENU_CACHE_NAME.time(),
            function (): array {
                $blog = get_current_blog_id();
                $data = [];
                foreach (Theme::SITES as $idSite => $site) {
                    if (in_array($idSite, [8, 12, 13])) {
                        continue;
                    }
                    $data[$idSite]['name'] = ucfirst($site);
                    if ($idSite == 14) {
                        $data[$idSite]['name'] = 'Enfance-Jeunesse';
                    }
                    $data[$idSite]['blogid']     = $idSite;
                    $data[$idSite]['colorhover'] = 'hover:text-'.$site;
                    $data[$idSite]['color']      = 'text-'.$site;
                    $data[$idSite]['items']      = $this->getItems($idSite);
                }
                switch_to_blog($blog);

                return $this->sortByName($data);
            }
        );
    }

    public function sortByName(array $data): array
    {
        usort(
            $data,
            function ($itemA, $itemB) {
                $nameA = $itemA['name'];
                $nameB = $itemB['name'];

                return $nameA > $nameB ? +1 : -1;
            }
        );

        return $data;
    }
}
