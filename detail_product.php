<?php
    include 'modules/connectDatabase.php';
    include 'modules/get_product_by_id.php';
    include 'modules/cartFunction.php';

    if(isset($_GET['ProductID'])){
        $product = get_product_by_id($_GET['ProductID']);
        if(isset($product)){
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/CSS/detail_product.css">
    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="shortcut icon" href="assets/Img/logo.png" type="image/x-icon">
    <title><?php echo $product['ProductName'] ?></title>

</head>
<style>
    .material-symbols-outlined {
      font-variation-settings:
      'FILL' 0,
      'wght' 300,
      'GRAD' 0,
      'opsz' 24;
      padding-right: 6px;
    }
</style>
<body>
    <div id="bar-header">
        <?php
        include("components/header.php");
        ?>
    </div>
    <div class="detail_container">
        <div class="detail_product">
<div class="product_img">
  <img 
    src="<?php echo htmlspecialchars($product['ProductImg'], ENT_QUOTES); ?>" 
    alt="<?php echo htmlspecialchars($product['ProductName'], ENT_QUOTES); ?>">
</div>
            <div class="product_name">
                <p class="product_title"><?php echo $product['ProductName'] ?></p>
                <p class="product_price">
                    <?php 
                        if( (int) $product['Discount'] == 0 ){
                    ?>
                            <span class="product_sale"><?php echo number_format($product["PriceToSell"]) ?> đ</span>
                    <?php
                        }
                        else{
                    ?>
                            <span class="product_sale"><?php echo number_format( (int) $product["PriceToSell"] - (int) $product["PriceToSell"]* (int) $product['Discount']/100 ) ?> đ</span>
                            <span class="product_nosale"><?php echo number_format($product["PriceToSell"]) ?> đ</span>
                            <label class="product_price_label"><?php echo $product['Discount'] ?>%</label>
                    <?php
                        }
                    ?>
                </p>
                <p class="product_state">
                    Tình trạng: 
                    <?php
                        $inStock = get_quanty_product_byID($product["ProductID"]);
                        if(isset($inStock)){
                            if( (int) $inStock['Quantity'] >0){
                    ?>
                                <span style="color: green;">còn hàng</span>
                    <?php
                            }else{ 
                    ?>
                                <span style="color: red;">hết hàng</span>
                    <?php
                            }
                        }
                    ?>
                
                </p>
                <p class="product_model">Bộ máy: <?php echo $product['Model'] ?></p>
                <p class="product_gender">Màu máy: <?php echo $product['Color'] ?></p> 
                <div class="product_policy">
                    <div class="product_policy_container">
                        <div class="product_policy_header">
                            <p>Chính sách mua hàng tại Thế giới điện thoại</p>
                        </div>
                        <div class="product_policy_content">
                            <div class="product_policy_group1">
                                <div class="product_policy_shipping">
                                    <span class="material-symbols-outlined">local_shipping</span>
                                    Giao hàng toàn quốc
                                </div>
                                <div class="product_policy_exchange">
                                    <span class="material-symbols-outlined">currency_exchange</span>
                                    Đổi trả hàng trong 7 ngày</div>
                            </div>
                            <div class="product_policy_group2">
                                <div class="product_policy_guarantee">
                                    <span class="material-symbols-outlined">verified_user</span>
                                    Bảo hành 5 năm</div>
                                <div class="product_policy_authentic">
                                    <span class="material-symbols-outlined">thumb_up</span>
                                    Cam kết chính hãng</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add_cart_button">
                    <button type="submit" id="add_cart" name="addToCart" data-id="<?php echo $product["ProductID"] ?>" 
                        <?php if( !isset($inStock) || (int) $inStock['Quantity']== 0) { echo 'class="disabled_button" disabled';} else { echo 'class="enabled_button"';} ?> >
                        Thêm vào giỏ hàng
                    </button>
                </div>
            </div>
        </div>

        <div class="product_description">
        Mô tả:
        <p class="product_description_content">
    <?php echo nl2br(htmlspecialchars($product['Description'])); ?>
</p>
</div>
    </div>
    <div id="my-footer">
        <?php
        include("components/footer.php");
        ?>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>
    <script>
        var productID = document.getElementById("add_cart");
        productID.addEventListener("click",function(event){
            var target = event.target;
            var id = target.getAttribute("data-id");
            var xml = new XMLHttpRequest();
            xml.onreadystatechange = function (){
                if(this.readyState == 4 && this.status == 200){
                    var s = String(this.responseText);
                    if(s == 1){
                        swal("Đã thêm sản phẩm vào giỏ hàng", "", "success");
                    }
                    else if(s == 0){
                        swal("Đã có lỗi xảy ra! vui lòng thử lại sau", "", "error");
                    }
                    else if(s == 2){
                        window.location = "login.php";
                    }
                    else{
                        swal(this.responseText.toString(), "", "warning");
                    }
                }
            }
            xml.open("GET","modules/addToCart.php?ProductID="+id,true);
            xml.send();
        })
    </script>

</body>
</html>

<?php
        }
    }

?>