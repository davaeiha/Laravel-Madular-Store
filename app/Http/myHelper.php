<?php

use Illuminate\Support\Facades\Route;

if(!function_exists("isActive")){
    function isActive(array $routeNames,string $bootstrapOption="active"){
        return in_array(Route::currentRouteName(),$routeNames)  ? $bootstrapOption : '';
    }
}

if(!function_exists("dateAgo")){
    function dateAgo($date){
        if($year = jdate()->getYear() - jdate($date)->getYear()>=1){
            return jdate("now - $year years")->ago();
        }

        if($month = jdate()->getMonth() - jdate($date)->getMonth()>=1){
            return jdate("now - $month months")->ago();
        }

        if($day = jdate()->getDay() - jdate($date)->getDay()>=1){
            return jdate("now - $day days")->ago();
        }

        if($hour = jdate()->getMonth() - jdate($date)->getMonth()>=1){
            return jdate("now - $hour hours")->ago();
        }

        if($minute = jdate()->getMinute() - jdate($date)->getMinute()>=1){
            return jdate("now - $minute minutes")->ago();
        }

        if($second = jdate()->getSecond() - jdate($date)->getSecond()>=1){
            return jdate("now - $second seconds")->ago();
        }
    }
}

if(!function_exists("isUrl")){
    function isUrl(string $route,string $bootstrapOption="active"){
        return request()->fullUrl() == $route ? $bootstrapOption : "";
    }
}


