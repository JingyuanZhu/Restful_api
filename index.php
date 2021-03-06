<?php 


$loader = new \Phalcon\Loader();
$loader->registerDirs(array(
  __DIR__.'/models/'
))->register();
//connect database
$di = new \Phalcon\DI\FactoryDefault();
$di->set('db',function(){
  return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
    'host'  => 'localhost',
    'username'=> 'root',
    'password'=> 'root',
    'dbname' => 'DatabaseProject'
  ));
});

$app = new \Phalcon\Mvc\Micro($di);

//GET User
$app->get('/api/user',function() use($app){
  $phql = "SELECT * FROM User";
  $users = $app->modelsManager->executeQuery($phql);
  $data = array();
  foreach($users as $user){
    $data[] = array(
    'UserId' => $user->UserId,
    'Age' => $user->Age,
    'Image' => $user->Image,
    'Zipcode' => $user->Zipcode,
    'Email' => $user->Email,
    'Password' => $user->Password,
    'Starttime' => $user->Starttime
    );
  }
  echo json_encode($data);
});



//GET User by Primary Key
$app->get('/api/user/{UserId}',function($UserId) use ($app){

  $phql = "SELECT * FROM User WHERE UserId LIKE :UserId: ORDER BY UserId";
  $users = $app->modelsManager->executeQuery($phql,array(
    'UserId' => '%'. $UserId .'%'
  ));

  $data = array();
  foreach($users as $user){
    $data[] = array(
    'UserId' => $user->UserId,
    'Age' => $user->Age,
    'Image' => $user->Image,
    'Zipcode' => $user->Zipcode,
    'Email' => $user->Email,
    'Password' => $user->Password,
    'Starttime' => $user->Starttime
   );
  }
  echo json_encode($data);

});
//POST User
$app->post('/api/user',function() use ($app){
  $user = $app->request->getJsonRawBody();

  $phql = "INSERT INTO User (UserId, Age, Image, Zipcode, Email, Password, Starttime) VALUES (:UserId:, :Age:, :Image:, :Zipcode:, :Email:, :Password:, :Starttime:)";
  $status = $app->modelsManager->executeQuery($phql,array(
    'UserId' => $user->UserId,
    'Age' => $user->Age,
    'Image' => $user->Image,
    'Zipcode' => $user->Zipcode,
    'Email' => $user->Email,
    'Password' => $user->Password,
    'Starttime' => $user->Starttime
  ));

  $response = new Phalcon\Http\Response();
  if($status->success() == true){
    $response->setStatusCode(201,'Create New User');
    $user->UserId = $status->getModel()->UserId;

    $response->setJsonContent(array('status'=>'ok','data'=>$user));
  }else{
    $response->setStatusCode(409,'Conflict');

    $errors = array();
    foreach($status->getMessages() as $message){
      $errors[] = $message->getMessage();
    }
    $response->setJsonContent(array('status'=>'ERROR','data'=>$errors));
  }
  return $response;

});
//echo json_encode('load');
//Update User
$app->put('/api/user/{UserId}',function($UserId) use ($app){
//echo json_encode('success');
  $user = $app->request->getJsonRawBody();
  //echo json_encode($user);
  $phql = "UPDATE User SET Age = :Age:, Image = :Image:, Zipcode = :Zipcode:, Email = :Email:, Password = :Password:, Starttime = :Starttime: WHERE UserId = :UserId:";
  $status = $app->modelsManager->executeQuery($phql,array(
    'UserId' => $UserId,
    'Age' => $user->Age,
    'Image' => $user->Image,
    'Zipcode' => $user->Zipcode,
    'Email' => $user->Email,
    'Password' => $user->Password,
    'Starttime' => $user->Starttime
  ));
  //echo json_encode($status->success());
// Create a response
    $response = new \Phalcon\Http\Response();

    // Check if the insertion was successful
    if ($status->success() == true) {
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data' => $user
            )
        );
    } else {

        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    return $response;

});

//DELETE
$app->delete('/api/users/{UserId}',function($UserId) use ($app){

  $phql = "DELETE FROM User WHERE UserId = :UserId: ";
  $status = $app->modelsManager->executeQuery($phql,array(
      'UserId' => $UserId
    ));
  $response = new \Phalcon\Http\Response();
  if($status->success() == true){
    $response = array('status'=>'OK');
  }else{
    $this->response->setStatusCode(500,'Internal Error')->setHeaders();

    $errors = array();
    foreach($status->getMessages() as $message){
      $errors[] = $message->getMessage();
    }
    $response = array('status'=>'Error','data'=>$errors);
  }
    return $response;
});

//GET Post
$app->get('/api/news',function() use($app){

  $phql = "SELECT * FROM News";
  $news = $app->modelsManager->executeQuery($phql);
  $data = array();
  foreach($news as $new){
    $data[] = array(
    'PostId' => $new->PostId,
    'UserId' => $new->UserId,
    'Image' => $new->Image,
    'Video' => $new->Video,
    'Entry' => $new->Entry,
    'Posttime' => $new->Posttime,
    'LocationId' => $new->LocationId,
    'Setting' => $new->Setting,
    'Ilikeit' => $new->Ilikeit
    );
  }
  echo json_encode($data);
});
//search User's Post
$app->get('/api/news/{UserId}',function($UserId) use ($app){

  $phql = "SELECT * FROM News WHERE UserId LIKE :UserId: ORDER BY UserId";
  $news = $app->modelsManager->executeQuery($phql,array(
    'UserId' => '%'. $UserId .'%'
  ));

  $data = array();
  foreach($news as $new){
    $data[] = array(
    'PostId' => $new->PostId,
    'UserId' => $new->UserId,
    'Image' => $new->Image,
    'Video' => $new->Video,
    'Entry' => $new->Entry,
    'Posttime' => $new->Posttime,
    'LocationId' => $new->LocationId,
    'Setting' => $new->Setting,
    'Ilikeit' => $new->Ilikeit
   );
  }
  echo json_encode($data);
});
//GET post by setting
$app->get('/api/public/news',function($UserId) use ($app){

//   $phql = "SELECT * FROM News WHERE UserId IN (
// SELECT Friend From Relationship WHERE UserId = :UserId:)";
 $phql = "SELECT * FROM News WHERE Setting = 'Public'";
  $news = $app->modelsManager->executeQuery($phql,array(
    'UserId' => $UserId 
  ));

  $data = array();
  foreach($news as $new){
    $data[] = array(
    'PostId' => $new->PostId,
    'UserId' => $new->UserId,
    'Image' => $new->Image,
    'Video' => $new->Video,
    'Entry' => $new->Entry,
    'Posttime' => $new->Posttime,
    'LocationId' => $new->LocationId,
    'Setting' => $new->Setting,
    'Ilikeit' => $new->Ilikeit
   );
  }
  echo json_encode($data);
});
//GET post by postID
$app->get('/api/news/{PostId}',function($PostId) use ($app){

  $phql = "SELECT * FROM News WHERE PostId = :PostId: ORDER BY PostId";
  $news = $app->modelsManager->executeQuery($phql,array(
    'PostId' => $PostId
  ));

  $data = array();
  foreach($news as $new){
    $data[] = array(
    'PostId' => $new->PostId,
    'UserId' => $new->UserId,
    'Image' => $new->Image,
    'Video' => $new->Video,
    'Entry' => $new->Entry,
    'Posttime' => $new->Posttime,
    'LocationId' => $new->LocationId,
    'Setting' => $new->Setting,
    'Ilikeit' => $new->Ilikeit
   );
  }
  echo json_encode($data);
});
//echo json_encode('load');



//Update Post
$app->put('/api/news/{PostId}',function($PostId) use ($app){
//echo json_encode('success');
  $news = $app->request->getJsonRawBody();
  //echo json_encode($user);
  $phql = "UPDATE News SET UserId = :UserId:, Image = :Image:, Video = :Video:, Entry = :Entry:, Posttime = :Posttime:, LocationId = :LocationId:, Setting = :Setting:, Ilikeit = :Ilikeit: WHERE PostId = :PostId:";
  $status = $app->modelsManager->executeQuery($phql, array(
    'PostId' => $PostId,
    'UserId' => $news->UserId,
    'Image' => $news->Image,
    'Video' => $news->Video,
    'Entry' => $news->Entry,
    'Posttime' => $news->Posttime,
    'LocationId' => $news->LocationId,
    'Setting' => $news->Setting,
    'Ilikeit' => $news->Ilikeit
  ));  
  //echo json_encode($status->success());
// Create a response
    $response = new \Phalcon\Http\Response();

    // Check if the insertion was successful
    if ($status->success() == true) {
        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data' => $news
            )
        );
    } else {

        // Change the HTTP status
        $response->setStatusCode(409, "Conflict");

        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    return $response;

});






//Post Post
$app->post('/api/news',function() use ($app){
  $news = $app->request->getJsonRawBody();
  $phql = "INSERT INTO News (PostId, UserId, Image, Video, Entry, Posttime, LocationId, Setting, Ilikeit) VALUES (:PostId:, :UserId:, :Image:, :Video:, :Entry:, :Posttime:, :LocationId:, :Setting:, :Ilikeit:)";
  $status = $app->modelsManager->executeQuery($phql,array(
    'PostId' => $news->PostId,
    'UserId' => $news->UserId,
    'Image' => $news->Image,
    'Video' => $news->Video,
    'Entry' => $news->Entry,
    'Posttime' => $news->Posttime,
    'LocationId' => $news->LocationId,
    'Setting' => $news->Setting,
    'Ilikeit' => $new->Ilikeit
  ));

  $response = new Phalcon\Http\Response();
    if ($status->success() == true) {
        $response->setStatusCode(201, "Created");

        $news->PostId = $status->getModel()->PostId;

        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $new
            )
        );

    } else {
        $response->setStatusCode(409, "Conflict");
        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    return $response;

});



//GET Location

$app->get('/api/local',function() use($app){
  $phql = "SELECT * FROM Location";
  $locals = $app->modelsManager->executeQuery($phql);
  $data = array();
  foreach($locals as $local){
    $data[] = array(
    'LocationId'=>$local->LocationId,
    'Longtitude'=>$local->Longtitude,
    'Latitude'=>$local->Latitude
    );
  }
  echo json_encode($data);
});

//Post location
$app->post('/api/local',function() use ($app){
  $local = $app->request->getJsonRawBody();
  $phql = "INSERT INTO Location (LocationId, Longtitude, Latitude) VALUES (:LocationId:, :Longtitude:, :Latitude:)";
  $status = $app->modelsManager->executeQuery($phql,array(
    'LocationId' => $local->LocationId,
    'Longtitude' => $local->Longtitude,
    'Latitude' => $local->Latitude
  ));

  $response = new Phalcon\Http\Response();
    if ($status->success() == true) {
        $response->setStatusCode(201, "Created");

        $news->LocationId = $status->getModel()->LocationId;

        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $local
            )
        );

    } else {
        $response->setStatusCode(409, "Conflict");
        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    return $response;

});





//GET friendship
$app->get('/api/relationship',function() use($app){
  $phql = "SELECT * FROM Relationship";
  $relations = $app->modelsManager->executeQuery($phql);
  $data = array();
  foreach($relations as $relation){
    $data[] = array(
      'UserId' => $relation->UserId,
      'Friend' => $relation->Friend
    );
  }
  echo json_encode($data);
});

//post relationship
$app->post('/api/relationship',function() use ($app){
  $relation = $app->request->getJsonRawBody();
  $phql = "INSERT INTO Relationship (UserId, Friend) VALUES (:UserId:, :Friend:)";
  $status = $app->modelsManager->executeQuery($phql,array(
    'UserId' => $relation->UserId,
    'Friend' => $relation->Friend
  ));

  $response = new Phalcon\Http\Response();
    if ($status->success() == true) {
        $response->setStatusCode(201, "Created");


        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $relation
            )
        );

    } else {
        $response->setStatusCode(409, "Conflict");
        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    return $response;

});
//get friend from user
$app->get('/api/relationship/{UserId}',function($UserId) use ($app){

  $phql = "SELECT * FROM Relationship WHERE UserId LIKE :UserId: ORDER BY UserId";
  $relations = $app->modelsManager->executeQuery($phql,array(
    'UserId' => '%'. $UserId .'%'
  ));

  $data = array();
  foreach($relations as $relation){
    $data[] = array(
    'UserId' => $relation->UserId,
    'Friend' => $relation->Friend
   );
  }
  echo json_encode($data);

});

//get friend from user's friend
$app->get('/api/relationship/friend/{UserId}',function($UserId) use ($app){

  $phql = "SELECT DISTINCT Friend FROM Relationship WHERE UserId IN (SELECT Friend FROM Relationship WHERE UserId = :UserId:) and Friend not in (SELECT Friend FROM Relationship WHERE UserId = :UserId:) and Friend != :UserId:";
  $relations = $app->modelsManager->executeQuery($phql,array(
    'UserId' => $UserId 
  ));

  $data = array();
  foreach($relations as $relation){
    $data[] = array(
    'Friend' => $relation->Friend
   );
  }
  echo json_encode($data);

});


//GET request
$app->get('/api/invite',function() use($app){
  $phql = "SELECT * FROM Invitation";
  $invites = $app->modelsManager->executeQuery($phql);
  $data = array();
  foreach($invites as $invite){
    $data[] = array(
      'UserId' => $invite->UserId,
      'Invitor' => $invite->Invitor
    );
  }
  echo json_encode($data);
});

//get request by name
$app->get('/api/invite/{UserId}',function($UserId) use ($app){

  $phql = "SELECT * FROM Invitation Where UserId = :UserId:";
  $invites = $app->modelsManager->executeQuery($phql,array(
    'UserId' => $UserId 
  ));

  $data = array();
  foreach($invites as $invite){
    $data[] = array(
    'Invitor' => $invite->Invitor
   );
  }
  echo json_encode($data);

});

//post request
$app->post('/api/invite',function() use ($app){
  $invite = $app->request->getJsonRawBody();
  $phql = "INSERT INTO Invitation (UserId, Invitor) VALUES (:UserId:, :Invitor:)";
  $status = $app->modelsManager->executeQuery($phql,array(
    'UserId' => $invite->UserId,
    'Invitor' => $invite->Invitor
  ));

  $response = new Phalcon\Http\Response();
    if ($status->success() == true) {
        $response->setStatusCode(201, "Created");


        $response->setJsonContent(
            array(
                'status' => 'OK',
                'data'   => $invite
            )
        );

    } else {
        $response->setStatusCode(409, "Conflict");
        $errors = array();
        foreach ($status->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            array(
                'status'   => 'ERROR',
                'messages' => $errors
            )
        );
    }

    return $response;

});


//GET comments
$app->get('/api/comments',function() use($app){
  $phql = "SELECT * FROM Comments";
  $comments = $app->modelsManager->executeQuery($phql);
  $data = array();
  foreach($comments as $comment){
    $data[] = array(
      'PostId' => $comment->PostId,
      'Author' => $comment->Author,
      'Recipient' => $comment->Recipient,
      'Content' => $comment->Content,
      'Sendtime' => $comment->Sendtime
    );
  }
  echo json_encode($data);
});
//GET Comments by postid
$app->get('/api/comments/{PostId}',function($PostId) use ($app){

  $phql = "SELECT * FROM Comments WHERE PostId = :PostId:";
  $comments = $app->modelsManager->executeQuery($phql,array(
    'PostId' => $PostId 
  ));

  $data = array();
  foreach($comments as $comment){
    $data[] = array(
      'PostId' => $comment->PostId,
      'Author' => $comment->Author,
      'Recipient' => $comment->Recipient,
      'Content' => $comment->Content,
      'Sendtime' => $comment->Sendtime
   );
  }
  echo json_encode($data);

});

//post comments
$app->post('/api/comments',function() use ($app){
  $comment = $app->request->getJsonRawBody();

  $phql = "INSERT INTO Comments (PostId, Author, Recipient, Content, Sendtime) VALUES (:PostId:, :Author:, :Recipient:, :Content:, :Sendtime:)";
  $status = $app->modelsManager->executeQuery($phql,array(
      'PostId' => $comment->PostId,
      'Author' => $comment->Author,
      'Recipient' => $comment->Recipient,
      'Content' => $comment->Content,
      'Sendtime' => $comment->Sendtime
  ));

  $response = new Phalcon\Http\Response();
  if($status->success() == true){
    $response->setStatusCode(201,'Create New Comments');
    $comment->PostId = $status->getModel()->PostId;

    $response->setJsonContent(array('status'=>'ok','data'=>$comment));
  }else{
    $response->setStatusCode(409,'Conflict');

    $errors = array();
    foreach($status->getMessages() as $message){
      $errors[] = $message->getMessage();
    }
    $response->setJsonContent(array('status'=>'ERROR','data'=>$errors));
  }
  return $response;

});


$app->handle();


