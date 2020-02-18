<?php

namespace ASPager;

class ItemsRange extends View
{

    public function range($first, $second)
    {
        return "[{$first}-{$second}]";
    }

    public function render(Pager $pager)
    {
        $this->pager = $pager;
        $return_page = '';
        $current_page = $this->pager->getCurrentPage();
        $total_pages = $this->pager->getPagesCount();

        if ($current_page - $this->pager->getVisibleLinkCount() >= 1) {
            $range = $this->range(1, $this->pager->getItemsPerPage());
            $return_page .= $this->link($range, 1) . ' ... ';

            $init = $current_page - $this->pager->getVisibleLinkCount();

            for ($i = $init; $i < $current_page; $i++) {
                $range = $this->range(
                    (($i - 1) * $this->pager->getItemsPerPage() + 1),
                    $i * $this->pager->getItemsPerPage()
                );
                $return_page .= ' ' . $this->link($range, $i) . ' ';
            }
        } else {
            for ($i = 1; $i < $current_page; $i++) {
                $range = $this->range(
                    (($i - 1) * $this->pager->getItemsPerPage() + 1),
                    $i * $this->pager->getItemsPerPage()
                );

                $return_page .= ' ' . $this->link($range, $i) . ' ';
            }
        }

        if ($current_page + $this->pager->getVisibleLinkCount() < $total_pages) {
            $cond = $this->current_page + $this->pager->getVisibleLinkCount();

            for ($i = $current_page; $i <= $cond; $i++) {
                if ($current_page == 1) {
                    $return_page .= ' ' . $this->range(
                        (($i - 1) * $this->pager->getItemsPerPage() + 1),
                        $i * $this->pager->getItemsPerPage()
                    ) . ' ';
                } else {
                    $range = $this->range(
                        (($i - 1) * $this->pager->getItemsPerPage() + 1),
                        $i * $this->pager->getItemsPerPage()
                    );

                    $return_page .= ' ' . $this->link($range, $i) . ' ';
                }
            }
            $range = $this->range(
                (($total_pages - 1) * $this->pager->getItemsPerPage() + 1),
                $this->pager->getItemsCount()
            );
            $return_page .= ' ... ' . $this->link($range, $total_pages) . ' ';
        } else {
            for ($i = $current_page; $i <= $total_pages; $i++) {
                if ($total_pages == $i) {
                    if ($current_page == $i) {
                        $return_page .= ' ' . $this->range(
                            (($i - 1) * $this->pager->getItemsPerPage() + 1),
                            $this->pager->getItemsCount()
                        ) . ' ';
                    } else {
                        $range = $this->range(
                            (($i - 1) * $this->pager->getItemsPerPage() + 1),
                            $this->pager->getItemsCount()
                        );
                        $return_page .= ' ' . $this->link($range, $i) . ' ';
                    }
                } else {
                    if ($current_page == $i) {
                        $return_page .= ' ' . $this->range(
                            (($i - 1) * $this->pager->getItemsPerPage() + 1),
                            $i * $this->pager->getItemsPerPage()
                        ) . ' ';
                    } else {
                        $range = $this->range(
                            (($i - 1) * $this->pager->getItemsPerPage() + 1),
                            ($i * $this->pager->getItemsPerPage())
                        ) . ' ';
                    }
                }
            }
        }
        return $return_page;
    }
}
