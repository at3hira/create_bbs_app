<?php

namespace App\Admin\Controllers;

use App\Thread;
use App\Admin\Models\Thread as AdminThread;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ThreadController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Thread';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Thread());
        $grid->model()->orderBy('id', 'desc');
        $grid->id('ID')->setAttributes(['style' => 'min-width:48px;'])->sortable();
        //$grid->column('category_id', __('Category id'));
        $grid->title('タイトル')->setAttributes(['style' => 'min-width:75px;']);
        //$grid->column('title', __('Title'));
        $grid->body('本文')->setAttributes(['style' => 'min-width:100px;']);
        //$grid->column('tweet_tags', __('Tweet tags'));
        $grid->column('img_url', __('スレッド画像'))->image('http://localhost/storage');
        //$grid->status('ステータス')->setAttributes(['style' => 'min-width:100px;']);
        $grid->column('status')->display(function ($status) {
            if ($status === 1) {
                $color = "#00FF00";
                $status = "表示";
            } else {
                $color = "#FF0000";
                $status = "削除";
            }
            return "<span style=background-color:$color>$status</span>";
        });
        $grid->column('created_at', __('作成日'))->date('Y/m/d H:i:s');
        $grid->column('updated_at', __('更新日'))->date('Y/m/d H:i:s');

        //$grid->column('sub_title', __('Sub title'));
        $grid->paginate(10);

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Thread::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('category_id', __('Category id'));
        $show->field('title', __('Title'));
        $show->field('body', __('Body'));
        $show->field('tweet_tags', __('Tweet tags'));
        $show->field('img_url', __('Img url'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('sub_title', __('Sub title'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     * 編集ページ
     */
    protected function form()
    {
        $form = new Form(new AdminThread());

        $form->number('category_id', __('Category id'));
        $form->text('title', __('Title'));
        $form->text('body', __('Body'));
        //$form->textarea('tweet_tags', __('Tweet tags'));
        $form->html('tweet_tags', 'Tweet tags');
        $form->image('img_url', 'img_url')->move('thread_img');
        $form->number('status', __('Status'))->default(1);
        $form->text('sub_title', __('Sub title'));

        return $form;
    }
}
