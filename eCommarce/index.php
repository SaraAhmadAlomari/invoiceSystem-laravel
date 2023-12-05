
<?php
session_start();
$pagetitle='Home';
include 'init.php';
?>
<div class="container">
    <div class="row">
        <?php 
            $allitems=GetAllFrom('*','items','WHERE approve=1','','item_ID');
            foreach($allitems as $item){
                echo '<div class="col-sm-6 col-md-3">';
                    echo '<div class="img-thumbnail item-box">';
                        echo '<span class="price-tag">'.$item['price'].'</span>';
                        if(empty($item['image'])){
                            echo"<img src='admin/uplodes/items/default.png'alt=''>";
                        }
                        else{
                        echo"<img src='admin/uplodes/items/".$item['image']."'alt=''>";}
                        echo '<div class="caption">';
                            echo '<h3><a href="item.php?itemid='.$item['item_ID'].'">'.$item['name'].'</a></h3>';
                            echo '<p>'.$item['description'].'</p>';
                            echo '<p class="date">'.$item['add_data'].'</p>';

                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
        ?>
        
    </div>
</div>
<?php include 'includes/templete/footer.php';?>

