<?php


if (! function_exists('isAuthorized')) {    
    /**
     * isAuthorized - determina se um usuário tem permissão pra fazer uma request dado seu tipo
     *
     * @param  mixed $authorizedTypes
     * @return void
     */
    function isAuthorized($authorizedTypes) {
        
        //vem do DB
        $typesOfuser = [
            'admin'  => 1, 
            'sindico'  => 2, 
            'porteiro'  => 3, 
            'morador'  => 4 
        ];

        if ($authorizedTypes == 'all') return true;

        $userType = auth()->user()->type;
        
        if(is_array($authorizedTypes)){
            $isAuthorized = false;
            foreach ($authorizedTypes as $type) {
                if($userType == $typesOfuser[$type]) $isAuthorized = true;
            }
            return $isAuthorized;
        }

        return($userType == $typesOfuser[$authorizedTypes]);
    }
}


if (! function_exists('clearCpf')) {
    function clearCpf($string) {
        $string = filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        return preg_replace('/[^0-9]/', '', $string);
    }
}