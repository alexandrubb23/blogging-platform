<?php

/**
 * Get order direction.
 *
 * @return string
 */
function orderDirection(): string
{
    $order = request()->get('order');

    $orderDirection = match ($order) {
        'asc' => 'asc',
        'desc' => 'desc',
        default => 'desc',
    };

    return $orderDirection;
}
