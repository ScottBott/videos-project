<?php

namespace App\Http\Controllers;

use App\Util\ValidationErrorHandler;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * @param mixed $value
     * @param string $rule
     * @param string $message
     *
     * @return void
     */
    public function validateValue($value, $rule, $message = null)
    {
        $data = ['value' => $value];
        $rules = ['value' => $rule];
        $messages = $message ? [$message] : [];
        return $this->validateArray($data, $rules, $messages);
    }

    /**
     * Validate the given data with the given rules.
     *
     * @param  array $data
     * @param  array $rules
     * @param  array $messages
     * @param  array $customAttributes
     *
     * @return void
     */
    public function validateArray(&$data, array $rules, array $messages = [], array $customAttributes = [])
    {
        if (is_null($data)) {
            $data = [];
        }

        $validator = Validator::make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return false;
        }

        return true;
    }
}
