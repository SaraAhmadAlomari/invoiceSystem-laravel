
<?php
session_start();
include 'init.php'; ?>
  
<div class="container">
    
    <div class="row">
        <?php 
            
            if(isset($_GET['name'])){
                $tag=$_GET['name'];
                echo '<h1 class="text-center">'.$tag.'</h1>';
                $alltag=GetAllFrom("*","items","WHERE tags like '%$tag%' " ,"AND approve=1","item_ID");
                foreach($alltag as $item){
                    echo '<div class="col-sm-6 col-md-3">';
                        echo '<div class="img-thumbnail item-box">';
                            echo '<span class="price-tag">'.$item['price'].'</span>';
                            echo"<img src='admin/uplodes/items/".$item['image']."'alt=''>";
                            echo '<div class="caption">';
                                echo '<h3><a href="item.php?itemid='.$item['item_ID'].'">'.$item['name'].'</a></h3>';
                                echo '<p>'.$item['description'].'</p>';
                                echo '<p class="date">'.$item['add_data'].'</p>';

                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            
        }
        ?>
    </div>
</div>

<?php include 'includes/templete/footer.php';?>