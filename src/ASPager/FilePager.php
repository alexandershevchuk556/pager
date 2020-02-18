<?php

namespace ASPager;

class FilePager extends Pager
{
    protected $filename;

    public function __construct(
        View $view,
        $filename = '.',
        $items_per_page = 10,
        $links_count = 3,
        $get_params = null,
        $counter_param = 'page'
    ) {
        $this->filename = $filename;
        
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
        $fd = fopen($this->filename, 'r');
        
        if ($fd) {
            while (! feof($fd)) {
                fgets($fd, filesize($this->filename));
                $countline++;
            }
            fclose($fd);
        }
        return $countline;
    }

    public function getItems()
    {
        $current_page = $this->getCurrentPage();
        $total = $this->getItemsCount();
        $total_pages = $this->getPagesCount();

        if ($current_page <= 0 || $current_page > $total_pages) {
            return 0;
        }

        $arr = [];
        $fd = fopen($this->filename, 'r');
        if (! $fd) return 0;
        $first = ($current_page - 1) * $this->getItemsPerPage();

        for ($i = 0; $i <= $total; $i++) {
            $str = fgets($fd, filesize($this->filename));

            if ($i < $first) continue;

            if ($i > $first + $this->getItemsPerPage() - 1) break;

            $arr[] = $str;
        }
        fclose($fd);

        return $arr;
    }
}