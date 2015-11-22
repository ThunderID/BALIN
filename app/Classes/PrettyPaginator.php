<?php namespace App\Classes;

use URL;

class PrettyPaginator {
    var $total_item;
    var $item_per_page;
    var $cur_page;
    var $link_count;
    var $page_param;
    var $from_page;
    var $to_page;
    /**
     * __construct
     *
     * @return void
     * @author 
     **/
    public function __construct($total_item, $cur_page = 1, $item_per_page, $current_count=1, $link_count=5, $page_param = 'page')
    {
        $this->total_item = intval($total_item);
        $this->item_per_page = max(1, $item_per_page);
        $this->cur_page = max(1, $cur_page);
        $this->link_count = min(max(1, $link_count), 13);
        $this->page_param = $page_param;
        $this->current_count = $current_count;
        $this->from_page = $this->fromPage();
        $this->to_page = $this->toPage();
    }

    public function links($route, $param = array())
    {
        if (!$this->total_item)
        {
            return;
        }

        if (!is_array($param))
        {
            $param = [];
        }

        $total_page = ceil($this->total_item / $this->item_per_page);

        $result = '<ul class="pagination pagination-hollow">';

        //prev
        if ($this->cur_page == 1)
        {
            $result .= '<li>
                                <a href="javascript:;" class="disabled">
                                    <i class="fa fa-angle-left black"></i>
                                </a>
                        </li>';
        }
        else
        {
            $result .= '<li>
                                <a href="'.URL::route($route, array_merge($param, array($this->page_param => $this->cur_page-1))).'">
                                    <i class="fa fa-angle-left black"></i>
                                </a>
                        </li>'; 
        }

        // 1&2
        $start = max(1, $this->cur_page - $this->link_count);
        $end = min($total_page, $this->cur_page + $this->link_count);

        if ($start > 2)
        {
            for ($i = 1; $i <= 2; $i++)
            {
                $result .= '<li ' .($i == $this->cur_page ? 'class="hollow-active"' : ''). '>
                                <a href="'.URL::route($route, array_merge($param, array($this->page_param => ($i == 1 ? '' : $i)))).'">
                                    '.$i.'
                                </a>
                            </li>'; 
            }

            if ($start > 3)
            {
                $result .= '<li class="disabled">
                                <a>...</a>
                            </li>';     
            }
        }

        //center
        for ($i = $start; $i <= $end; $i++)
        {
            $result .= '<li ' .($i == $this->cur_page ? 'class="hollow-active"' : ''). '>
                            <a href="'.URL::route($route, array_merge($param, array($this->page_param => ($i == 1 ? '' : $i)))).'">
                                '.$i.'
                            </a>
                        </li>'; 
        }

        // n-1, n-2
        if ($end < $total_page - 2)
        {
            if ($end < $total_page - 2)
            {
                $result .= '<li class="disabled">
                                <a>...</a>
                            </li>';     
            }

            for ($i = $total_page-1; $i <= $total_page; $i++)
            {
                $result .= '<li ' .($i == $this->cur_page ? 'class="hollow-active"' : ''). '>
                                <a href="'.URL::route($route, array_merge($param, array($this->page_param => ($i == 1 ? '' : $i)))).'">
                                    '.$i.'
                                </a>
                            </li>'; 
            }
        }

        //next
        if ($this->cur_page >= $total_page)
        {
            $result .= '<li >
                                <a href="javascript:;">
                                    <i class="fa fa-angle-right black"></i>
                                </a>
                        </li>';
        }
        else
        {
            $result .= '<li>
                                <a href="'.URL::route($route, array_merge($param, array($this->page_param => $this->cur_page+1))).'">
                                    <i class="fa fa-angle-right black"></i>
                                </a>
                        </li>'; 
        }

        $result .= '</ul>';

        return $result;

    }

    function currentPage()
    {
        return $this->cur_page;
    }

    function maxPage()
    {
        return ceil($this->total_item / $this->item_per_page);
    }

    function fromPage()
    {
        if($this->cur_page==1)
        {
            return 1;
        }
        return ceil(($this->cur_page-1) * $this->item_per_page);
    }

    function toPage()
    {
        if($this->cur_page==1)
        {
            return $this->current_count;
        }
        return ceil($this->from_page + $this->current_count);
    }

}