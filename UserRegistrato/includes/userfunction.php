<?php 
$errors = [];

//BLOG---------------------------------------------------
function getBlogs() {
    // use global $conn object in function
    global $conn;
    $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    // fetch all posts as an associative array called $blogss
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $blogs;
} 
function getMyBlog($userID) {
    // use global $conn object in function
    global $conn;
    $sql = "SELECT * FROM blogs WHERE user_id = $userID ORDER BY created_at DESC ";
    $result = mysqli_query($conn, $sql);
    // fetch all posts as an associative array called $blogss
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $blogs;
} 
function getMyBlogPlusMeCoaut($userID) {
    // use global $conn object in function
    global $conn;
    $sql = "SELECT * FROM blogs as b where user_id =  $userID UNION SELECT * FROM blogs as b2 where b2.id IN (select blog_id from coautore where user_id = $userID) ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    // fetch all posts as an associative array called $blogss
    $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $blogs;
} 
function getUsernameByBlogUserID($userID){
	global $conn;

	$sql = "SELECT username FROM users WHERE id = $userID";
	$result = mysqli_query($conn, $sql);
	$username = mysqli_fetch_row($result);
	foreach ($username as $value)
      { echo $value;}
	
}
function getBlogTopic($blogID){
	//SELECT nome FROM topics WHERE id IN (select tema_id from temi_blog as t, blogs as b where t.blog_id = b.id AND b.id = 1)
	global $conn;
	$sql = "SELECT nome 
			FROM topics 
			WHERE id IN (select tema_id from temi_blog as t, blogs as b where t.blog_id = b.id AND b.id = $blogID)";
	$result = mysqli_query($conn, $sql);
	if($result->num_rows > 0) {
		// conteggio dei record restituiti dalla query
		while($row = $result->fetch_array(MYSQLI_ASSOC))
		{
			 echo $row['nome'] . "         ";
        }}

}


function getBlogTitle($blogID){
	//SELECT nome FROM topics WHERE id IN (select tema_id from temi_blog as t, blogs as b where t.blog_id = b.id AND b.id = 1)
	global $conn;
	$sql = "SELECT title 
			FROM blogs 
			WHERE id = $blogID";
	$result = mysqli_query($conn, $sql);
	$title = mysqli_fetch_row($result);
	return $title;

}
function getBlogowner($blogID){
	//SELECT nome FROM topics WHERE id IN (select tema_id from temi_blog as t, blogs as b where t.blog_id = b.id AND b.id = 1)
	global $conn;
	$sql = "SELECT username 
			FROM users 
			WHERE id = (select user_id from blogs where id = $blogID)";
	$result = mysqli_query($conn, $sql);
	$username = mysqli_fetch_row($result);
	return $username;

}
function getTopicsArray($blogID){
	
	global $conn;
	$sql = "SELECT nome 
			FROM topics 
			WHERE id IN (select tema_id from temi_blog as t, blogs as b where t.blog_id = b.id AND b.id = $blogID)";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_row($result);
	return $topics;
}
function getitleBlog($blogID) {
	global $conn;

	$sql = "SELECT title FROM blogs WHERE id = $blogID";
	$result = mysqli_query($conn, $sql);
	$title = mysqli_fetch_row($result);
	foreach ($title as $value)
      { echo $value;}
} 
function getitleBlogs() {
	global $conn;

	$sql = "SELECT title FROM blogs ORDER BY created_at DESC";
	$result = mysqli_query($conn, $sql);
	$blogs = mysqli_fetch_all($result,MYSQLI_ASSOC);
	
	return $blogs;
} 

//POST--------------------------------------------------
function getPost($postID){
	global $conn;

	$sql = "SELECT * FROM posts WHERE id ='$postID' ";

	$result = mysqli_query($conn, $sql);

	// fetch query results as associative array.
	$post = mysqli_fetch_assoc($result);
	return $post;
}
function getblogIDbyPost($postID){
	global $conn;

	$sql = "SELECT blog_id FROM posts WHERE id= $postID";

	$result = mysqli_query($conn, $sql);
	$id = mysqli_fetch_row($result);
	return $id;
}
function getitlepost($postID) {
	global $conn;

	$sql = "SELECT title FROM posts WHERE id = $postID";
	$result = mysqli_query($conn, $sql);
	$title = mysqli_fetch_row($result);
	foreach ($title as $value)
      { echo $value;}
} 
function getbodypost($postID) {
	global $conn;

	$sql = "SELECT body FROM posts WHERE id = $postID";
	$result = mysqli_query($conn, $sql);
	$body = mysqli_fetch_row($result);
	foreach ($body as $value)
      { echo $value;}
} 
function getBlogPosts($blogID) {
	global $conn;

	$sql = "SELECT * FROM posts WHERE blog_id = $blogID ORDER BY created_at DESC";

	$result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $posts;
}
function getAllPosts(){
	global $conn;

	$sql = "SELECT * FROM posts ORDER BY created_at DESC";

	$result = mysqli_query($conn, $sql);

	// fetch query results as associative array.
	$posts = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $posts;

}
function getUsernameByPostUserID($userID){
	global $conn;

	$sql = "SELECT username FROM users WHERE id = $userID";
	$result = mysqli_query($conn, $sql);
	$username = mysqli_fetch_row($result);
	foreach ($username as $value)
      { echo $value;}
	
}
function countPosts($blogID) {
	global $conn;
	$sql = "SELECT count(id) FROM posts WHERE blog_id = (SELECT id from blogs where id =  $blogID) ";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_fetch_row($result);
	return $num;
}

function getPidAutCoaut($userID){
	global $conn;
	$sql= "Select DISTINCT p.id from posts as p WHERE p.user_id = $userID OR p.blog_id = (SELECT blog_id FROM coautore as c WHERE c.user_id = $userID)";
	$result = mysqli_query($conn, $sql);
	
	$p_ids = mysqli_fetch_all($result);
	$p_ids = array_column($p_ids, 0);
	return $p_ids;
}

//LIKES-----------------------------------------------------
function addLike($userID, $postID) {
	global $conn;
    $sql = "INSERT INTO likes (user_id, post_id) VALUES ($userID, $postID)";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die (mysqli_error($conn) . " while executing query: " . $sql);
    }
}
function removeLike($userID, $postID) {
	global $conn;
    $sql = "DELETE FROM likes WHERE user_id = $userID AND post_id = $postID";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die (mysqli_error($conn) . " while executing query: " . $sql);
    }
}
function contaLike($postID){
	global $conn;
    $sql = "SELECT count(id) FROM likes WHERE post_id = $postID";
    $result = mysqli_query($conn, $sql);
	$numLike= mysqli_fetch_assoc($result);
	foreach ($numLike as $value)
	  { echo $value;}
}
//COMMENTI-----------------------------------------------------
function getPostComments($postID){
	global $conn;
	$sql = "SELECT * FROM comments WHERE post_id = $postID";
	$result = mysqli_query($conn, $sql);
	$comments = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $comments;
}


function getUsernameByCommentuserID($postID,$userID){
	global $conn;
	$sql = "SELECT username FROM users as u, comments as c WHERE c.post_id = $postID AND c.user_id = u.id AND u.id = $userID";
	$result = mysqli_query($conn, $sql);
	$username = mysqli_fetch_row($result);
	return $username;
}
//RICERCA----------------------------------------------------------
function getBlogbyTopicTitleName($string){
	 global $conn;
	   $sql = "SELECT * from blogs Where title = '$string' OR id IN (select blog_id from temi_blog as tb, topics as t where tb.tema_id = t.id AND t.nome = '$string') ORDER BY created_at DESC  ";
	   $result = mysqli_query($conn, $sql);
	   $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
	   if (mysqli_num_rows($result) > 0) {
	   return $blogs;
	   }
}
function  getPostbyTitle($string){
	   global $conn;
	   $sql = "SELECT * from posts Where title = '$string' ";
	   $result = mysqli_query($conn, $sql);
	   $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	   if (mysqli_num_rows($result) > 0) {
	   return $posts;
	}
	else{return NULL;} 
}
function getBlogbyUsername($string){
	global $conn;
	  $sql = "SELECT * FROM blogs where user_id = (SELECT id from users WHERE username = '$string') ORDER BY created_at DESC";
	  $result = mysqli_query($conn, $sql);
	  $blogs = mysqli_fetch_all($result, MYSQLI_ASSOC);
	  if (mysqli_num_rows($result) > 0) {
	  return $blogs;
	  }else{return NULL;}
}
function  getPostbyUsername($string){
	global $conn;
	$sql = "SELECT * FROM posts where user_id = (select id from users where username = '$string') ORDER BY created_at DESC";
	$result = mysqli_query($conn, $sql);
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	if (mysqli_num_rows($result) > 0) {
	return $posts;
 }else{return NULL;}
}
//IMMAGINI_______________________________________________________
function getAllImage(){
	global $conn;
	$sql = "SELECT * FROM images ";
	$result = mysqli_query($conn, $sql);
	$images = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $images;
}
function getImageByID($imageID){
	global $conn;
	$sql = "SELECT src FROM images WHERE id = $imageID";
	$result = mysqli_query($conn, $sql);
	$src = mysqli_fetch_row($result);
	foreach ($src as $value)
      { return $value;}
}
function getImageBySRC($src){
	global $conn;
	$sql = "SELECT id FROM images where src = '$src'";
	$result = mysqli_query($conn, $sql);
	$id = mysqli_fetch_row($result);
	return $id;
}
function getImageByblogID($BlogID){
	global $conn;
	$sql = "SELECT src FROM images WHERE id = (SELECT image_id from blogs where id = $BlogID)";
	$result = mysqli_query($conn, $sql);
	$src = mysqli_fetch_row($result);
	return $src;
}
function getImageByPostID($postID){
	global $conn;
	$sql = "SELECT src FROM images WHERE id = (SELECT image_id from posts where id = $postID)";
	$result = mysqli_query($conn, $sql);
	$src = mysqli_fetch_row($result);
	return $src;
}

function getAllBg(){
	global $conn;
	$sql = "SELECT * FROM backgrounds";
	$result = mysqli_query($conn, $sql);
    $sfondi = mysqli_fetch_all($result,MYSQLI_ASSOC);
		return $sfondi;
	
}
function getBackground($blogID){
	global $conn;
	$sql = "SELECT src FROM backgrounds WHERE id = (SELECT sfondo_id from customization where blog_id = $blogID) ";
	$result = mysqli_query($conn, $sql);
		$src = mysqli_fetch_row($result);
		return $src;
}
function getBGBySRC($src){
	global $conn;
	$sql = "SELECT id FROM backgrounds where src = '$src'";
	$result = mysqli_query($conn, $sql);
	$id = mysqli_fetch_row($result);
	return $id;
}
function getAllHeader(){
			global $conn;
			$sql = "SELECT * FROM header";
			$result = mysqli_query($conn, $sql);
			$header = mysqli_fetch_all($result,MYSQLI_ASSOC);
				return $header;
			
}

function getHeaderBySRC($src){
	global $conn;
	$sql = "SELECT id FROM header where src = '$src'";
	$result = mysqli_query($conn, $sql);
	$id = mysqli_fetch_row($result);
	return $id;
}
function getHeader($blogID){
	global $conn;
	$sql = "SELECT src FROM header WHERE id = (SELECT header_id from customization where blog_id = $blogID) ";
	$result = mysqli_query($conn, $sql);
	$src = mysqli_fetch_row($result);
	if (mysqli_num_rows($result) > 0) {
	foreach ($src as $value){
		return $value;
	}}else{return NULL;}

}
function getBg() {
    // use global $conn object in function
    global $conn;
    $sql = "SELECT sfondo FROM customization";
    $result = mysqli_query($conn, $sql);
    // fetch all posts as an associative array called $blogss
    $sfondi = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $sfondi;
}

//TOPICS___________________________
function getTopicNames() {
    // use global $conn object in function
    global $conn;
    $sql = "SELECT nome FROM topics";
    $result = mysqli_query($conn, $sql);
    // fetch all posts as an associative array called $blogss
    $topics = mysqli_fetch_all($result, MYSQLI_BOTH);
    return $topics;
}
function getBlogTopicArray($blogID){
	//SELECT nome FROM topics WHERE id IN (select tema_id from temi_blog as t, blogs as b where t.blog_id = b.id AND b.id = 1)
	global $conn;
	$sql = "SELECT nome 
			FROM topics 
			WHERE id IN (select tema_id from temi_blog as t, blogs as b where t.blog_id = b.id AND b.id = $blogID)";
	$result = mysqli_query($conn, $sql);
	$nomi = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $nomi;

}
//SICUREZZA STRINGHE
function esc(String $value){
	// bring the global db connect object into function
	global $conn;
	// remove empty space sorrounding string
	$val = trim($value); 
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}
//CREA SLUG
function makeSlug(String $string){
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}
//SELEZIONA USER
function getUserById($id){
    global $conn;
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // returns user in an array format: 
    // ['id'=>1 'username' => 'jk', 'email'=>'a@a.com', 'password'=> 'mypass']
    return $user; 
}
function getUsers($userID){
	global $conn;
    $sql = "SELECT * FROM users where id <> $userID ORDER BY username";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result,MYSQLI_ASSOC);
    return $users; 
}
function getUsersbyusername($string){
	global $conn;
    $sql = "SELECT DISTINCT id,username FROM users  where username = '$string'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_row($result);
    return $user; 
}
function getUsersN(){
	global $conn;
    $sql = "SELECT username FROM users";
    $result = mysqli_query($conn, $sql);
    $usersN = mysqli_fetch_all($result,MYSQLI_ASSOC);
    return $usersN; 
}
//COAUTORE 
function getCoautbyBlogID($BlogID){
	global $conn;
	$sql = "SELECT username FROM users WHERE id = (SELECT user_id from coautore where blog_id = $BlogID)";
	$result = mysqli_query($conn, $sql);
	if(!empty($result)){
		$user = mysqli_fetch_row($result);
	return $user;
	}else{
		return NULL;
	}
	
}

?>