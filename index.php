<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Cart System</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"crossorigin="annonymous">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


</head>


<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="index.php">Shopping</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link active" href="index.php" >Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php">Categories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="checkout.php">Checkout</a></li>
      <li class="nav-item">  
        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i><span id="cart-item" class="badge badge=danger">
        </span></a>
      </li>  
    </ul>
  </div>
</nav>

<div class="container">
<div id="message"> </div>
    <div class="row mt-2 pb-3">
        <?php 
        session_start();
        
        include 'conn.php';
        $stmt=$conn->prepare("SELECT * FROM product");
        $stmt->execute();
        $result=$stmt->get_result();
        while($row = $result->fetch_assoc()):
          $_SESSION['product_image']=$row['product_image'];
          
        ?>

        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
            <div class="card-deck">
                <div class="card p-2 border-secondary mb-2">
                    <img src="<?php echo $_SESSION['product_image']?>" class="card-img-top height="250">
                    <div class="card-body p-1">
                      <h4 class="card-title text-center text-info">
                        <?php echo $row['product_name'] ?> 
                      </h4>
                      <h5 class="card-text text-center text-danger">RM
                      <?php echo number_format($row['product_price'],2) ?>
                      </h5>
                  </div>
                  <div class="card-footer p-1">
                  <form action="" class="form-submit">
                  <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                  <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                  <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                  <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                  <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                  <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to Cart</button>
                  </form>
                </div>
              </div>
          </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e){
  $(".addItemBtn").click(function(e){
    e.preventDefault();
    var $form = $(this).closest(".form-submit");
    var pid = $form.find(".pid").val();
    var pname = $form.find(".pname").val();
    var pprice = $form.find(".pprice").val();
    var pimage = $form.find(".pimage").val();
    var pcode = $form.find(".pcode").val();

    $.ajax({
      url: 'action.php',
      method: 'post',
      data: {pid:pid,pname:pname,pprice:pprice,pimage:pimage,pcode:pcode},
      success:function(response){
        $("#message").html(response);
        window.scrollTo(0,0);
        load_cart_item_number();

      }
    });
  });

  load_cart_item_number();

  function load_cart_item_number(){
    $.ajax({
      url: 'action.php',
      method: 'get',
      data: {cartItem:"cart_item"},
      success:function(response){
        $("#cart-item").html(response);
      }
    });
  }
});
</script>
    
</body>
</html>