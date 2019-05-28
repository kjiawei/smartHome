<?php

echo "hello";
require 'rb.php';

//R::debug( TRUE, 1 ); //select mode 1 to suppress screen output
//R::debug( TRUE );
//$openid = 'shit php';
function insertopenid($openid)
{
    R::setup('mysql:host=localhost;dbname=lizi','root','123456'); //for both mysql or mariaDB
    $book = R::dispense( 'user' );
    $book->name = 'lizi';
    $book->password = '123';
    $book->openid = $openid;
    $id = R::store( $book );
    echo 'id is '.$id;
    R::close();
   
}

insertopenid('fuck you ');

/*
$books = R::findAll('user');
    foreach($books as $book) {
        echo $book->name;
        echo $book->password;
        echo '<p>';

    }
*/
    //$numOfBooks = R::count( 'user' );
    //echo 'tatal number is : '.$numOfBooks ;

    
    //$books = R::findAll( 'user' , ' ORDER BY title DESC LIMIT 10 ' );
    
    /*
    $books = R::findAll( 'user' , ' password = :password ', [':password' => '1235'] );
    foreach($books as $book) {
        echo $book->name;
        echo $book->password;
        echo '<p>';

    }

    $fields = R::inspect( 'user' );
    var_dump ($fields); 
    */

    


/*
Find or create (4.2+)

    $book = R::findOrCreate( 'book', [
        'title' => 'my book', 
        'price' => 50] );
*/



?>
