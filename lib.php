<?php
  function load_products():array{
    $data=file_get_contents(__DIR__."/Data/products.json");
    return json_decode($data,true)?:[];
  }  
?>