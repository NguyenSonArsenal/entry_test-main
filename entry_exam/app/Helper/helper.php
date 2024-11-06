<?php

function getStt($entities, $index)
{
    return getAdminPagination() * ($entities->currentPage() -1) + 1 + $index;
}

function getAdminPagination($perPage = '')
{
    $perPage = empty($perPage) ? getConfig('pagination.admin', 20) : $perPage;
    return $perPage;
}

function getConfig($key, $default = '')
{
    return config('config.' . $key, $default);
}

function getInputOld($old, $default = '')
{
    return empty($old) ? $default : $old;
}
