<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".//assets/css/product-list.css" type="text/css">
    <title>Phone Store</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link rel="stylesheet" href="components/header.css">
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
   
    <div class="wrapper">
    <div id="bar-header">
        <?php
    include("components/header.php")
    ?>
    </div>
        <?php
        if (isset($_GET['search']) && $_GET['search'] > 0) {
            include(".//mainproduct/paging-search.php");
        } else {
            include(".//mainproduct/searching.php");
            include(".//mainproduct/menu.php");
            if (isset($_GET['idBrand']) && ($_GET['idBrand'] > 0)) {
                include(".//mainproduct/paging-brand.php");
            } else {
                if (isset($_GET['from']) && isset($_GET['to']) > 0) {
                    include(".//mainproduct/paging-price.php");
                } else {
                    if (isset($_GET['color']) && isset($_GET['color']) > 0) {
                        include(".//mainproduct/paging-color.php");
                    } else {
                        if (isset($_GET['gender']) && isset($_GET['gender']) > 0) {
                            include(".//mainproduct/paging-gender.php");
                        } else {
                            if (isset($_GET['model']) && isset($_GET['model']) > 0) {
                                include(".//mainproduct/paging-model.php");
                            } else {
                                if (isset($_GET['nang-cao']) && isset($_GET['nang-cao']) > 0) {
                                    include(".//mainproduct/search-advanced.php");
                                } else {
                                    include("mainproduct/main.php");
                                }
                            }
                        }
                    }
                }
            }

        }




        ?>
    </div>
    
    <div id="my-footer">
        <?php
    include("components/footer.php")
    ?>
    </div>

</body>
  <!--start Hiện thanh line-->
  <script>
    var lineProduct = document.getElementById("navbarProduct");

    lineProduct.style.borderBottom = '2px solid #fff';
    lineProduct.style.paddingBottom = '1.15px';
  </script>
  <!--end Hiện thanh line-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</html>