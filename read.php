<?PHP
 $dsn = 'mysql:dbname=php_db_app;host=localhost;charset=utf8mb4';
 $user = 'root';
 $password = 'root';
 
 try {
     $pdo = new PDO($dsn, $user, $password);
    // orderパラメータの値が存在すれば（並び替えボタンを押したとき）、その値を変数$orderに代入する
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = NULL;
        }

    // keywordパラメータの値が存在すれば（商品名を検索したとき）、その値を変数$keywordに代入する    
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
        } else {
            $keyword = NULL;
        }
    // orderパラメータの値によってSQL文を変更する
         if ($order === 'desc') {
            $sql_select = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY updated_at DESC';
        } else {
            $sql_select = 'SELECT * FROM products WHERE product_name LIKE :keyword ORDER BY updated_at ASC';
        }    
          // SQL文を用意する
          $stmt_select = $pdo->prepare($sql_select);
          // SQLのLIKE句で使うため、変数$keyword（検索ワード）の前後を%で囲む（部分一致）
          // 補足：partial match＝部分一致
          $partial_match = "%{$keyword}%";
          // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
          $stmt_select->bindValue(':keyword', $partial_match, PDO::PARAM_STR);
          // SQL文を実行する
          $stmt_select->execute();
     
     // SQL文の実行結果を配列で取得する
     $products = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
 } catch (PDOException $e) {
     exit($e->getMessage());
 }
 ?>
 
 <!DOCTYPE html>
 <html lang="ja">
 
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>ProductList</title>
     <link rel="stylesheet" href="css/style.css">
     <!-- Google Fonts-->
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
 </head>
 
 <body>
     <header>
         <nav>
             <a href="index.php">INVENTORY</a>
         </nav>
     </header>
     <main>
         <article class="products">
             <h1>Product List</h1>
             <?php 
             if(isset($_GET['message'])) {
                echo "<p class='success'>{$_GET['message']}</p>";
             }
             ?>
             <div class="products-ui">
                 <div>
                     <!-- ここに並び替えボタンと検索ボックスを作成する -->
                     <a href="read.php?order=desc&keyword=<?= $keyword ?>">
                         <img src="images/desc.png" alt="降順に並び替え" class="sort-img">
                     </a>
                     <a href="read.php?order=asc&keyword=<?= $keyword ?>">
                         <img src="images/asc.png" alt="昇順に並び替え" class="sort-img">
                     </a>
                     <form action="read.php" method="get" class="search-form">
                        <input type="hidden" name="order" value="<?= $order ?>">
                        <input type="text" class="search-box" placeholder="search by product name" name="keyword" value="<?= $keyword ?>">
                     </form>

                 </div>
                 <a href="create.php" class="btn">Registration</a>
             </div>
             <table class="products-table">
                 <tr>
                     <th>Code</th>
                     <th>Name</th>
                     <th>Price</th>
                     <th>Stock</th>
                     <th>Vendor Code</th>
                     <th>Modify</th>
                 </tr>
                 <?php
                 // 配列の中身を順番に取り出し、表形式で出力する
                 foreach ($products as $product) {
                     $table_row = "
                         <tr>
                         <td>{$product['product_code']}</td>
                         <td>{$product['product_name']}</td>
                         <td>{$product['price']}</td>
                         <td>{$product['stock_quantity']}</td>
                         <td>{$product['vendor_code']}</td>
                         <td><a href='update.php?id={$product['id']}'>
                         <img src='images/edit.png' alt='modify' class='edit-icon'></a></td>                        
                         </tr>                    
                     ";
                     echo $table_row;
                 }
                 ?>
             </table>
         </article>
     </main>
     <footer>
         <p class="copyright">&copy; InventoryApp All rights reserved.</p>
     </footer>
 </body>
 
 </html>