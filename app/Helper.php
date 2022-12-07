<?php
if (!function_exists('checkSuperAdmin')) {
    function checkSuperAdmin()
    {
        return session()->get('level') === 1;
    }
}
