<?php

namespace App\Admin\Controllers;

use App\Movies;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\User;

class MoviesController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Movies);

        $grid->id('Id');
        $grid->title('Title');
        $grid->director('Director');
        $grid->rate('Rate');
        $grid->released('Released');
        $grid->release_at('Release at');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Movies::findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->director('監督');
        $show->rate('レート');
        $show->released('発売日');
        $show->release_at('Release at');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Movies);

        $form->text('title', 'Title');
        $form->number('director', 'Director');
        $form->number('rate', 'Rate');
        $form->date('released', 'Released')->default(date('Y-m-d'));
        $form->datetime('release_at', 'Release at')->default(date('Y-m-d H:i:s'));
        $form->select('user_id')->options(function ($id) {
            $user = User::find($id);

            if ($user) {
                return [$user->id => $user->name];
            }
        })->ajax('/admin/api/users');

        return $form;
    }
}
