<?php
/*
Copyright 2017 Metro (https://github.com/metropolian)

Permission is hereby granted, free of charge, 
to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE. 
*/

    function FormatHtml($Text)
    {
        $Text = str_replace(array("\r\n", "\r", "\n"), "<br/>", $Text);
        //$Text = htmlentities($Text, ENT_QUOTES, 'UTF-8' );
        return $Text;
    }


    function FormatDate($D) 
    {
        if (is_string($D)) {
            $D = strtotime($D);
        }        
        if (is_numeric($D))
            return date('d/m/', $D) . FormatYear($D);
        return '-';
    }

    function FormatDateTime($D, $ShowTime = true) 
    {
        if (is_string($D)) {
            $D = strtotime($D);
        }        
        if (is_numeric($D))
            return date('d M ', $D) . FormatYear($D) . (($ShowTime) ? date(' H:i', $D) : '');
            //return utf8_encode(strftime('%d %A %Y %H:%M', $D));
        return $D;
    }

    function FormatDateFull($D) 
    {
        if (is_string($D)) {
            $D = strtotime($D);
        }        
        if (is_numeric($D))
            return date('d M ', $D) . FormatYear($D);
            //return utf8_encode(strftime('%d %A %Y %H:%M', $D));
        return $D;
    }

    function FormatTime($D) 
    {
        if (is_string($D)) {
            $D = strtotime($D);
        }        
        if (is_numeric($D))
            return date('H:i', $D);
        return $D;
    }

    function FormatYear($D)
    {
        return (date('Y', $D));
    }

    function FormatYearThai($D)
    {
        return (date('Y', $D) + 543);
    }


    function FormatMoney($M)
    {
        return number_format( floatval( $M ), 2);
    }


?>