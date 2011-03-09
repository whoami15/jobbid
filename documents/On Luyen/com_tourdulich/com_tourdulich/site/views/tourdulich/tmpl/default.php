<?php
JHTML::stylesheet("style.css","components/com_tourdulich/css/");
jimport('functionclass');
?>
<div id="tdl-wrap">    
    <?php
    foreach($this->data as $items)
    {
        ?>
        <div class='tourlist' >
            <a  class="tourcat" href="index.php?option=com_tourdulich&task=loaitour&loaitour_id=<?php echo $items['loaitour_id']; ?>" ><span style="font-size: 12pt;color: red"><?php echo $items['tenloaitour']; ?></span></a>
        <?php
        foreach($items['listtour'] as $item)
        {
        ?>
        <div class="tour-item">
            <div class="hinh">
                <a href="index.php?option=com_tourdulich&task=tourdetail&id=<?php echo $item->id ?>" title="<?php echo $item->tentour ?>"><img class="tourimg" alt="<?php echo $item->tentour ?>" width="102px" src="<?php echo $item->anhdaidien ?>"></a>
                <a href="index.php?option=com_datcho&view=datcho" title="Đặt chỗ"><img class="imgchitiet" alt="datcho" src="images/bt_datcho.jpg" /></a>
            </div>
            <span>
                <a href="index.php?option=com_tourdulich&task=tourdetail&id=<?php echo $item->id ?>" title="<?php echo $item->tentour ?>"><?php echo $item->tentour ?></a>
            </span>
            <span>
                <b>Giá :</b> <?php echo FunctionClass::FormatMoney($item->giatien) ?> VNĐ
            </span>
            <span>
                <b>Ngày đi :</b> <?php echo $item->ngaykhoihanh ?>
            </span>
            <span>
                <b>Phương tiện :</b> <?php echo $item->phuongtien ?>
            </span>
        </div>
        <?php
        }
        ?>
            <div class="foot"><a href="index.php?option=com_tourdulich&task=loaitour&loaitour_id=<?php echo $items['loaitour_id']; ?>" title="Xem thêm">Xem thêm...</a></div>
        </div>
        <?php
    }
    ?>    
</div>
