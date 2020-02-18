<?php

namespace ASPager;

class PdoPager extends Pager
{
    protected $pdo;
    protected $tablename;
    protected $where;
    protected $params;
    protected $order;

    public function __construct(
        View $view,
        $pdo,
        $tablename,
        $where = '',
        $params = [],
        $order = '',
        $items_per_page = 10,
        $links_count = 3,
        $get_params = null,
        $counter_param = 'page'
    ) {
        $this->pdo = $pdo;
        $this->tablename = $tablename;
        $this->where = $where;
        $this->params = $params;
        $this->order = $order;

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
        $query = "SELECT COUNT(*) AS total FROM {$this->tablename} {$this->where}";
        $tot = $this->pdo->prepare($query);
        $tot->execute($this->params);
        return $tot->fetch()['total'];
    }

    public function getItems()
    {
        $current_page = $this->getCurrentPage();
        $total_pages = $this->getPagesCount();

        if ($current_page <= 0 || $current_page > $total_pages) {
            return 0;
        }
        $arr = [];
        $first = ($current_page - 1) * $this->getItemsPerPage();

        $query = "SELECT * FROM {$this->tablename}
        {$this->where} 
        {$this->order} 
        LIMIT $first, {$this->getItemsPerPage()}";

        $tbl = $this->pdo->prepare($query);
        $tbl->execute($this->params);

        return $results = $tbl->fetchAll();
    }
}
