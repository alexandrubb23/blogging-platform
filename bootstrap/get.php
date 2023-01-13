<?php

/**
 * Get order direction.
 *
 * @return string
 */
function orderDirection(): string
{
    $order = request()->query('order', 'desc');

    return in_array($order, ['asc', 'desc']) ? $order : 'desc';
}
