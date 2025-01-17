<?php


namespace app\models\admin;


use app\models\AppModel;
use RedBeanPHP\R;

class Page extends AppModel
{

    public function get_pages($start, $perpage): array
    {
        return R::getAll("SELECT p.*, pd.title FROM page p JOIN page_description pd on p.id = pd.page_id WHERE pd.language_id = 1 LIMIT $start, $perpage");
    }

    public function deletePage($id): bool
    {
        R::begin();
        try {
            $page = R::load('page', $id);
            if (!$page) {
                return false;
            }
            R::trash($page);
            R::exec("DELETE FROM page_description WHERE page_id = ?", [$id]);

            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }
    }

}