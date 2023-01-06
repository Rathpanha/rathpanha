<?php

class Pagination 
{
  /**
   * Preparing neccessary data and format to simplified the process
   * of making pagination.

   * @param array $config
   */
  public static function build($config) 
  {
    $server_name = $_SERVER['SERVER_NAME'];
    $path_info = "";
    if (isset($_SERVER['PATH_INFO']) && is_string($_SERVER['PATH_INFO'])) {
      $path_info = $_SERVER['PATH_INFO'];
    } else if (isset($_SERVER['ORIG_PATH_INFO']) && is_string($_SERVER['ORIG_PATH_INFO'])) {
      $path_info = $_SERVER['ORIG_PATH_INFO'];
    }

    if (!isset($config['param'])) {
      $config['param'] = array();
    }

    // If no page is set, by defualt it is page number 1
    $current = isset($_GET['page']) ? intval($_GET['page']) : 1;

    // If page number is incorrect redirect to page 1
    if (isset($_GET['page']) && (!is_numeric($_GET['page']) || $_GET['page'] == 0)) {
      header("Location: " . '//' . $server_name . $path_info);
      exit();
    }


    // Execute the count function
    $count = call_user_func_array($config['count'], $config['param']);

    // Caclulate the number of total page
    $total = intval(ceil($count / $config['length']));

    // Get the start and the end page
    $start = ($current < 4) ? 1 : $current - 1;
    $end = 3 + $start;
    $end = ($total < $end) ? $total : $end;
    $diff = $start - $end + 4;
    $start -= ($start - $diff > 0) ? $diff : 0;

    // 
    $param = $config['param'];
    $param[] = ($current - 1) * $config['length'];
    $param[] = $config['length'];

    $data = call_user_func_array($config['data'], $param);

    // -----------------------------------------
    // Construct original URL without page query
    // -----------------------------------------
    $link = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['PATH_INFO'];
    $link .= '?';

    $query = $_GET;
    unset($query['page']);
    $query = http_build_query($query);

    if ($query != '') {
      $query .= '&';
    }

    $link = $link . $query . 'page=';

    // -----------------------------------------------
    // Construct a HTML display for pagination
    // -----------------------------------------------
    $pagination = "<div class='pagination_parent'>";
    $pagination .= "<div>Showing " . ((( $current - 1 ) * $config['length']) + ( $count > 0 ? 1 : 0)) . " to " . ( $current  * $config['length'] > $count ? $count : $current  * $config['length'] ) . " of " . $count . " entr" . ( $count > 1 ? "ies" : "y" ) . "</div>";
    $pagination .= "<ul class='pagination'>";

    if ($current > 1) {
      $pagination .= "<li><a href='{$link}" . (1) . "'><i class='fa fa-angle-double-left'></i></a></li>";
      $pagination .= "<li><a href='{$link}" . ($current - 1) . "'><i class='fa fa-angle-left'></i></a></li>";
    } else {
      $pagination .= "<li class='disable'><a href='#'><i class='fa fa-angle-double-left'></i></a></li>";
      $pagination .= "<li class='disable'><a href='#'><i class='fa fa-angle-left'></i></a></li>";
    }

    if ($start > 1) {
      $pagination .= "<li><a href='{$link}1'>" . 1 . "</a></li>";
      $pagination .= "<li class='disable'><a href='#'>• • •</a></li>";
    }

    for ($i = $start; $i <= $end; $i++) {
      $pagination .= "<li " . ($i == $current ? "class='active'" : "") . "><a href='{$link}{$i}'>{$i}</a></li>";
    }

    if ($end < $total) {
      $pagination .= "<li class='disable'><a href='#'>• • •</a></li>";
      $pagination .= "<li><a href='{$link}{$total}'>" . $total . "</a></li>";
    }

    if ($current < $total) {
      $pagination .= "<li><a href='{$link}" . ($current + 1) . "'><i class='fa fa-angle-right'></i></a></li>";
      $pagination .= "<li><a href='{$link}" . ($total) . "'><i class='fa fa-angle-double-right'></i></a></li>";
    } else {
      $pagination .= "<li class='disable'><a href='#'><i class='fa fa-angle-right'></i></a></li>";
      $pagination .= "<li class='disable'><a href='#'><i class='fa fa-angle-double-right'></i></a></li>";
    }

    $pagination .= "</ul>";

    // -----------------------------------------------
    // Construct a HTML display for pagination lite
    // -----------------------------------------------
    $pagination .= "<ul class='pagination lite'>";

    if ($current > 1) {
      $start = $current - ($current < $total ? 1 : ($current - 2 == 0) ? 1 : 2);
      $end = $current + ($current < $total ? 1 : 0);
      $pagination .= "<li><a href='{$link}" . (1) . "'><i class='fa fa-angle-double-left'></i></a></li>";
      $pagination .= "<li><a href='{$link}" . ($current - 1) . "'><i class='fa fa-angle-left'></i></a></li>";
    } else {
      $start = $current;
      $end = $current + ($total - $current > 2 ? 2 : $total - $current);
      $pagination .= "<li class='disable'><a href='#'><i class='fa fa-angle-double-left'></i></a></li>";
      $pagination .= "<li class='disable'><a href='#'><i class='fa fa-angle-left'></i></a></li>";
    }

    for ($i = $start; $i <= $end; $i++) {
      $pagination .= "<li " . ($i == $current ? "class='active'" : "") . "><a href='{$link}{$i}'>{$i}</a></li>";
    }

    if ($current < $total) {
      $pagination .= "<li><a href='{$link}" . ($current + 1) . "'><i class='fa fa-angle-right'></i></a></li>";
      $pagination .= "<li><a href='{$link}" . ($total) . "'><i class='fa fa-angle-double-right'></i></a></li>";
    } else {
      $pagination .= "<li class='disable'><a href='#'><i class='fa fa-angle-right'></i></a></li>";
      $pagination .= "<li class='disable'><a href='#'><i class='fa fa-angle-double-right'></i></a></li>";
    }

    $pagination .= "</ul>";
    $pagination .= "</div>";

    return (object) array(
        "data" => $data,
        "start" => $start,
        "end" => $end,
        "count" => $count,
        "current_start" => max(1, ($current - 1) * $config['length']),
        "current_end" => min($current * $config['length'], $count),
        "pagination" => $pagination,
        "pagination_lite" => $pagination_lite
    );
  }
}
