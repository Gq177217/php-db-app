
<?php 
 $dsn= 'mysql:dbname=php_db_app;host=localhost;charset=utf8mb4';
 $user ='root';
 $password ='root';

 try {
    $pdo = new PDO($dsn, $user, $password);
    $sql_select = 'SELECT vendor_code FROM vendors';
    $stmt_select = $pdo->query($sql_select);
    $vendor_codes = $stmt_select->fetchAll(PDO::FETCH_COLUMN); 
 } catch (PDOException $e){
    exit($e->getMessage());
 }
 ?>
 
 <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <a href="index.php"> INVENTORY</a>
        </nav>
    </header>
    <main>
        <article class="registration">
            <h1>Registration</h1>
            <div class="back">
                <a href="read.php" class="btn">&lt; 戻る</a>
            </div>
            <form action="create.php" method="post" class="registration-form">
                <div>
                    <label for="product_code">Product code</label>
                    <input type="number" name="product_code" min="0" max="100000000" required>
                    <label for="product_name"> Product name</label>
                    <input type="text" name="product_name" maxlength="50" required>
                    <label for="price">Price</label>
                    <input type="number" name="price" min="0" max="100000000" required>
                    <label for="stock_quantity">Stock</label>
                    <input type="number" name="stock_quantity" min="0" max="100000000" required>
                    <label for="vendor_code">Vendor code</label>
                    <select name="vendor_code" required>
                        <option disabled selected value>Please Select</option>
                        <?php 
                        foreach ($vendor_codes as $vendor_code) {
                            echo "<option value='{$vendor_code}'>{$vendor_code}</option>";
                          
                        } 
                        ?>
                    </select>
                </div>
                <button type="submit" class="submit-btn" name="submit" value="create">submit</button>
            </form>
        </article>
    </main>
    <footer>
        <p class="copyright">&copy; INVENTORYAPP All rights reserved.</p>
    </footer>
</body>
</html>