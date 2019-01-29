<?php namespace Premmerce\Filter\Ajax\Strategy;

interface ThemeStrategyInterface
{
    /**
     * @param array $response
     *
     * @return array $response
     */
    public function updateResponse(array $response);
}
