<?php
JHTML::stylesheet("style.css","components/com_tourdulich/css/");
jimport('functionclass');
?>
<div id="tdl-wrap">
    <div class="map"><a href="index.php?option=com_tourdulich&view=tourdulich" >Home</a> >> <a href="index.php?option=com_tourdulich&task=loaitour&loaitour_id=<?php echo $this->loaitour->id ?>"><?php echo $this->loaitour->tenloaitour ?></a> >> <?php echo $this->tourlistname; ?> </div>
    <div class='tourlist' >
        <?php
        foreach($this->data as $item)
        {
        ?>
        <div class="tour-item">
            <div class="hinh">
                <a href="index.php?option=com_tourdulich&task=tourdetail&id=<?php echo $item['id'] ?>" title="<?php echo $item['tentour'] ?>"><img class="tourimg" alt="<?php echo $item['tentour'] ?>" width="102px" src="<?php echo $item['anhdaidien'] ?>"></a>
                <a href="index.php?option=com_datcho&view=datcho" title="Order"><img class="imgchitiet" alt="datcho" src="images/bt_datcho-en.png" /></a>
            </div>
            <span>
                <a href="index.php?option=com_tourdulich&task=tourdetail&id=<?php echo $item['id'] ?>" title="<?php echo $item['tentour'] ?>"><?php echo $item['tentour'] ?></a>
            </span>
            <span>
                <b>Price :</b> <?php echo FunctionClass::FormatMoney($item['giatien']) ?> USD
            </span>
            <span>
                <b>Depart Date :</b> <?php echo $item['ngaykhoihanh'] ?>
            </span>
            <span>
                <b>Means :</b> <?php echo $item['phuongtien'] ?> 
            </span>
        </div>
        <?php
        }
        ?>
    </div>   
</div>
