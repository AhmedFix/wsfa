<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Recipe;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RecipeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Recipe';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Recipe());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('imgUrl', __('ImgUrl'));
        $grid->column('ingredients', __('Ingredients'));
        $grid->column('steps', __('Steps'));
        
        // $grid->column('category_id', __('Category id'));
        $grid->category_id(__('category Type'))->display(function ($category_id) {
            return ($category_id ? Category::find($category_id)->name : null);
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        
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
        $show = new Show(Recipe::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('imgUrl', __('ImgUrl'));
        $show->field('ingredients', __('Ingredients'));
        $show->field('steps', __('Steps'));

        // $show->field('category_id', __('Category id'));
        $categories = Category::all()->toArray();
        $categoriesArray = [];
        foreach ($categories as $item) {
            $categoriesArray[$item['id']] = $item['name'];
        }
        $show->category_id(__('Select Type of Category'))->using($categoriesArray);
        
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Recipe());

        $form->text('name', __('Name'));
        $form->text('imgUrl', __('ImgUrl'));
        $form->textarea('ingredients', __('Ingredients'));
        $form->textarea('steps', __('Steps'));
        // $form->number('category_id', __('Category id'));

        $form->select('category_id', __('Select Category Type'))->options(Category::all()->pluck('name', 'id')); 
        return $form;
    }
}
