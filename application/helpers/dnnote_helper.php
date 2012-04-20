<?php
/*
 * Created on 2012/04/19
 * @author
 * Yuya Tanaka
 */


function rand_data()
{
    // make uniqe ID
    return md5(uniqid("", 1));
}



function streaching($pass, $salt)
{
    for ( $i = 0; $i < 1000; $i++ ) {
        $pass = md5($pass . $salt . $pass);
    }
    return $pass;
}



