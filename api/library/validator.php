<?php

class Validator {
    public static function validate($input) {
        $accept = true;
        $message = "";
        
        foreach ($input as $row) {
            if (!isset($row['product_id']) || !isset($row['qty'])) {
                $accept = false;
                $message = "product_id atau qty wajib di set!";
            }
    
            if (!is_string($row['product_id']) && !is_numeric($row['product_id'])) {
                $accept = false;
                $message = "product_id hanya dapat diisi string atau angka!";
            }
    
            if (!is_numeric($row['qty']) || $row['qty'] < 1) {
                $accept = false;
                $message = "qty hanya dapat diisi angka dan tidak boleh dibawah 1!";
            }
        }
    
        return [$accept, $message];
    }
}