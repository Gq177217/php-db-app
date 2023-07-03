<?PHP
$dsn = 'mysql:dbname=heroku_2338003a1917fd8;host=us-cdbr-east-06.cleardb.net;charset=utf8mb4';
$user = 'bfd69e2febafbf:83fc82e6';
$password = '83fc82e6';


 try {
    $pdo = new PDO($dsn, $user , $password);
    // idカラムの値をプレースホルダ（:id）に置き換えたSQL文をあらかじめ用意する
    $sql_delete ='DELETE FROM products WHERE id = :id';
    $stmt_delete = $pdo->prepare($sql_delete);

    // bindValue()メソッドを使って実際の値をプレースホルダにバインドする（割り当てる）
    $stmt_delete->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    //SQL
    $stmt_delete->execute();
     // 削除した件数を取得する
    $count =$stmt_delete->rowCount();
    $message ="delete prodcuts{$count}item/s";

    header("Location: read.php?message={$message}");
 } catch (PDOException $e){
    exit($e->getMessage());
 }
