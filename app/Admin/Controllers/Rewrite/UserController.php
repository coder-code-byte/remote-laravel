<?php
/**
 * Created by remote-laravel
 * Author Smiths
 * Created at 2019/6/30 12:19
 */

namespace App\Admin\Controllers\Rewrite;
use Encore\Admin\Controllers\UserController as EncoreUserController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid;

class UserController extends EncoreUserController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $userModel = config('admin.database.users_model');

        $grid = new Grid(new $userModel());

        $grid->column('id', 'ID')->sortable();
        $grid->column('username', trans('admin.username'));
        $grid->column('name', trans('admin.name'));
        $grid->column('roles', trans('admin.roles'))->pluck('name')->label();
        $grid->column('created_at', trans('admin.created_at'));
        $grid->column('updated_at', trans('admin.updated_at'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            if ($actions->getKey() == 1) {
                $actions->disableDelete();
                if (Admin::user()->getAuthIdentifier() != 1){
                    $actions->disableEdit();
                }
            }
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->batch(function (Grid\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        return $grid;
    }
}