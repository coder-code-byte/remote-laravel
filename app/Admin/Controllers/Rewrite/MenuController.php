<?php
/**
 * Created by remote-laravel
 * Author Smiths
 * Created at 2019/6/30 11:57
 */

namespace App\Admin\Controllers\Rewrite;
use Encore\Admin\Controllers\MenuController as EncoreMenuController;
use Encore\Admin\Tree;

class MenuController extends EncoreMenuController
{
    /**
     * @return \Encore\Admin\Tree
     */
    protected function treeView()
    {
        $menuModel = config('admin.database.menu_model');

        return $menuModel::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $titleTranslation = 'admin.menu_titles.' . trim(str_replace(' ', '_', strtolower($branch['title'])));
                $title = trans($titleTranslation);
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$title}</strong>";

                if (!isset($branch['children'])) {
                    if (url()->isValidUrl($branch['uri'])) {
                        $uri = $branch['uri'];
                    } else {
                        $uri = admin_base_path($branch['uri']);
                    }

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
                }

                return $payload;
            });
        });
    }
}