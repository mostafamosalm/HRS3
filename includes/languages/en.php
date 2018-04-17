<?php
    function lang( $phrase )
    {
        static $lang = array
        (
            'Mesaage' => 'welcome'
        );
        
        return $lang[$phrase];
        
    }