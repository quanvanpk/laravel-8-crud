<?php


namespace App\Services;


class BaseService
{
    /**
     * @param $errorMessage
     * @param array $data
     * @return array
     */
    public function responseServiceError($errorMessage, $data = []): array //In the future can custom to throw exception directly
    {
        return ['error' => $errorMessage, $data];
    }

}