<?php

use App\Models\Sistema\UserType;

if (!function_exists('isAuthorized')) {
    /**
     * isAuthorized - determina se um usuário tem permissão pra fazer uma request dado seu tipo
     *
     * @param  mixed $authorizedTypes
     * @return void
     */
    function isAuthorized($authorizedTypes)
    {

        $typesOfuser = UserType::all();
        if ($authorizedTypes == 'all') return true;

        $userType = auth()->user()->type;

        if (is_array($authorizedTypes)) {
            $isAuthorized = false;

            foreach ($authorizedTypes as $type) {
                if ($userType == $typesOfuser->firstWhere('nome', $type)->id) $isAuthorized = true;
            }
            return $isAuthorized;
        }

        return ($userType == $typesOfuser->firstWhere('nome', $authorizedTypes)->id);
    }
}


if (!function_exists('clearCpf')) {
    function clearCpf($string)
    {
        $string = filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        return preg_replace('/[^0-9]/', '', $string);
    }
}


if (!function_exists('exceptionApi')) {    
    /**
     * exceptionApi
     *
     * @param  mixed $exception
     * @param  mixed $httpStatusCode
     * @return Exception
     */
    function exceptionApi(Throwable $exception, $httpStatusCode = 400)
    {
        $debug = env('APP_DEBUG', true);

        if ($exception instanceof Throwable) {
            
            if ($debug) {
                return ['error' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ], 'code' => $httpStatusCode];
            }

            return ['error' => $exception->getMessage(), 'code' => $httpStatusCode];
        }
    }
}
