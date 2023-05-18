<?php


namespace app\models\admin;


use app\models\AppModel;
use RedBeanPHP\R;

class Category extends AppModel
{

    public function category_validate(): bool
    {
        $errors = '';
        foreach ($_POST['category_description'] as $v) {
            $v['title'] = trim($v['title']);
            if (empty($v['title'])) {
                $errors .= "Не заполнено Наименование <br>";
            }
        }
        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            return false;
        }
        return true;
    }

    public function save_category(): bool
    {
        R::begin();
        try {
            $category = R::dispense('category');
            $category->parent_id = post('parent_id', 'i');
            $category_id = R::store($category);
            $category->slug = AppModel::create_slug('category', 'slug', $_POST['category_description'][1]['title'], $category_id);
            R::store($category);

            foreach ($_POST['category_description'] as $item) {
                R::exec("INSERT INTO category_description (category_id, language_id, title, description, keywords, content) VALUES (?,?,?,?,?,?)", [
                    $category_id,
                    1,
                    $item['title'],
                    $item['description'],
                    $item['keywords'],
                    $item['content'],
                ]);
            }
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }
    }

    public function update_category($id): bool
    {
        R::begin();
        try {
            $category = R::load('category', $id);
            if (!$category) {
                return false;
            }
            $category->parent_id = post('parent_id', 'i');
            R::store($category);

            foreach ($_POST['category_description'] as $item) {
                R::exec("UPDATE category_description SET title = ?, description = ?, keywords = ?, content = ? WHERE category_id = ? AND language_id = ?", [
                    $item['title'],
                    $item['description'],
                    $item['keywords'],
                    $item['content'],
                    $id,
                    1,
                ]);
            }
            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }
    }

    public function get_category($id): array
    {
        return R::getAssoc("SELECT cd.language_id, cd.*, c.* FROM category_description cd JOIN category c on c.id = cd.category_id WHERE cd.category_id = ?", [$id]);
    }

}