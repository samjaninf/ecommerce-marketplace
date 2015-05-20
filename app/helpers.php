<?php

if ( ! function_exists('current_user')) {
    /**
     * @return \Koolbeans\User|null
     */
    function current_user()
    {
        return app('auth.driver')->user();
    }
}
