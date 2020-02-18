<?php

namespace ASPager;

class DirPager extends Pager
{
    protected $dirname;

    public function __construct(
        View $view,
        $dir_name = '.',
        $items_per_page = 10,
        $links_count = 3,
        $get_params = null,
        $counter_param = 'page'
    ) {
        $this->dirname = rtrim($dir_name, '/');
        parent::__construct(
            $view,
            $items_per_page,
            $links_count,
            $get_params,
            $counter_param
        );
    }

    public function getItemsCount()
    {
        $countline = 0;

        if (($dir = opendir($this->dirname)) !== false) {
            while (($file = readdir($dir)) !== false) {
                if (is_file($this->dirname . '/' . $file)) {
                    $countline++;
                }
            }
            closedir($dir);
        }
        return $countline;
    }

    public function getItems()
    {
        $current_page = $this->getCurrentPage();
        $total_pages = $this->getPagesCount();

        if ($current_page <= 0 || $current_page > $total_pages) {
            return 0;
        }

        $arr = [];
        $first = ($current_page - 1)  * $this->getItemsPerPage();

        if (($dir = opendir($this->dirname)) === false) {
            return 0;
        }

        $i = -1;
        while (($file = readdir($dir)) !== false) {
            if(is_file($this->dirname . '/' . $file)) {
                $i++;
                
                if ($i < $first) continue;
                if ($i > $first + $this->getItemsPerPage() - 1) break;
                $arr[] = $this->dirname . '/' . $file;
            }
        }
        closedir($dir);

        return $arr;
    }
}
