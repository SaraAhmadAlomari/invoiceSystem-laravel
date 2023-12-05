
<?php
session_start();
include 'init.php'; ?>
  
<div class="container">
    <h1 class="text-center">Show Category Items</h1>
    <div class="row">
        <?php 
            $catID=isset($_GET['pageid']) && is_numeric($_GET['pageid'])?intval($_GET['pageid']):0;
            $allitem=GetAllFrom('*','items','WHERE cat_ID='.$catID.'','','item_ID');
            foreach($allitem as $item){
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