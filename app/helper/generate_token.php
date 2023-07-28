<?php
    function generate_token(){

        $str=random_bytes(20);
        return bin2hex($str);
    }

