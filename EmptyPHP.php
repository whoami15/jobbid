<?php
$i=5;
while($i<count($lstSanpham)) {
    $sp=$lstSanpham[$i];
    $i++;
    $tinhtrang="CÒN HÀNG";
    if($sp['SanPham']['tinhtrang']==0)
        $tinhtrang="HẾT HÀNG";
?>