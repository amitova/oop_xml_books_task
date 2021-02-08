<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            table, th, td {
                border: 1px solid black;
              }
        </style>
    </head>
    <body>
        <?php
        include_once 'Books.php';
        $book = new Books();
        $book->readXML();
        if(isset($_GET['inputSearch'])){
            $dataBooks = $book->searchBook($_GET['inputSearch']);
        }
        ?>
        <form action="" method="get" name="formSearch">
            <label for="inputSearch">Find book:</label>
            <input type="text" name="inputSearch" id="inputSearch" value=""/>
            <button type="submit">Search</button>
        </form>
        <?php
        if(!empty($dataBooks) && isset($_GET['inputSearch'])){
        ?>
        <hr>
        <table style="width:100%;">
              <tr >
                <th>Catalogue number</th>
                <th>Book author</th>
                <th>Book name</th>
                <th>Book add date</th>
              </tr>
            <?php foreach ($dataBooks as $dataBook) {
            ?>
            <tr>
              <th><?=$dataBook['book_catnum']?></th>
              <th><?=$dataBook['book_author']?></th>
              <th><?=$dataBook['book_name']?></th>
              <th><?=date("Y-m-d H:i:s", strtotime($dataBook['book_add_date']))?></th>
            </tr>
        <?php
            }
            ?>
        </table>
        <?php
        }elseif(empty($dataBooks) && isset($_GET['inputSearch'])){
            echo "<br > <h3>No Results found!</h3>";
        }else{
            echo "<br > <h3>Enter search :)</h3>";
        }
        ?>
     

    </body>
</html>
