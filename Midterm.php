
<?php
require_once('config.php');

function outputActivities() {
		try{
			$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = "select * from activities ORDER BY ID";
		$id = isset($_GET['id']) ? $_GET['id'] : '';
	$statement = $pdo->prepare($sql);
	$statement->bindValue(':id', $id);
	$statement->execute();
         $result = $pdo->query($sql);
         while ($row = $statement->fetch()) {
            echo '<a href="' . $_SERVER["SCRIPT_NAME"] . '?id=' . $row['ID'] . '" class="';
            if (isset($_GET['id']) && $_GET['id'] == $row['ID']) echo 'active ';
            echo 'item">';
            echo '<li class="name">' . $row['Name'] . '</li></a>';
	    outputSingleLocation($row);
         }

         $pdo = null;

	}
		catch(PDOException $e){
			die ($e->getMessage("Activity was not found") );
	}
}



function outputSingleLocation($row) {
   echo '<div class="location"';
   echo '<p class="Name">';
   echo $row['Street'] . ', ' . $row['City'] . ' ' . $row['State'] . ' ' . $row['County'] . ' ' . 'County';
   echo '</p>';
   echo '</div>';  
   
}


function outputDetails() {
   try {
      if (isset($_GET['id']) && $_GET['id'] > 0) {   
         $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
         $sql = 'select * from ActivitiesType where Id=' . $_GET['id'];
         $result = $pdo->query($sql);
         while ($row = $result->fetch()) {
            outputSingleDetail($row);         
         }
         $pdo = null;
      }
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}
function outputSingleDetail($row) {
   echo '<div class="item">';
   echo '<div class="image">';
   echo '<img  src="images/' . $row['Images'] .'.jpg">';
   echo '</div>';
   echo '<p class="location"';
   echo '<div class="content">';
   echo '<h4 class="header">';
   echo $row['activityTypes']; 
   echo '</h4>';
   echo '<p class="description">';
   echo  $row['Description'];
   echo '</p>';
   echo '</div>';  
   echo '</div>'; 
}



function echoCssError($submit)
{
if($_SERVER['REQUEST_METHOD'] == "GET")
return;
}



?>

<?php
class ValidationResult{
private $value;
private $cssClassName;
private $errorMessage;
private $isValid = true;

public function _construct($cssClassName, $value, $errorMessage, $isValid) {
	$this->cssClassName = $cssClassName;
	$this->value = $value;
	$this->errorMessage = $errorMessage;
	$this->isValid = $isValid;

	}

	public function getCssClassName() {return $this->cssClassName;}
	public function getValue() {return $this->value;}
	public function getErrorMessage() {return $this->errorMessage;}
	public function isValid() {return $this->isValid;}

	static public function checkParameter($queryName, $pattern, $errMsg) {
		$error = "";
		$errClass = "";
		$value = "";
		$isValid = true;

	if (empty($_POST[$queryName])) {
		$error = $errMsg;
		$errClass = "error";
		$isValid = false;
		}
	else{
		$value = $_POST[$queryName];
		if(!preg_match($pattern, $value)){
			$error = $errMsg;
			$errClass = "error";
			$isValid = false;
			}
		}
	return new ValidationResult($errClass, $value, $error, $isValid);	
	}
}

?>

<?php
session_start();

	if(!isset($_SESSION['textMessage'])) {
	if(!isset($_POST['text'])){
		
	}
	else{
		$_SESSION['textMessage'] = $_POST['text'];
	}
}
else{
	if($_POST["Reset Form"] == "POST"){
		unset($_SESSION['textMessage']);
		header("Location:" . $_SERVER['REQUEST_URI']);
	}
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors','1');


$textValid = new ValidationResult("text", "[a-zA-Z]", "", true);

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$textValid = ValidationResult::checkParameter("text", '[a-zA-Z]', 'Enter a valid location [PHP]');
	
	if($textValid->isValid()) {
		header('Location: Midterm.php');
	}
}

?>

<?php
function findAll()
{
	$sql = $this->getSelectStatement();
	$results = $this->dbAdapter->fetchAsArray($sql);
	return $results;
}
function findById($id)
{
	$sql = $this->getSelectStatement();
	$sql .= 'WHERE' . $this->getPrimaryKeyName() . '=:id'


$gate = new ArtistTableGateway($dbAdapter);
$results = $gate->findAll();
foreach($results as $activity){
echo $activity['name'] . '-' . $activity['name'];

class Activities {
	private $name;
	private $rollNo;

	Activities($name, $rollNo){
	this.name = name;
	this.rollNo = rollNo;
	}
	public function getName() {
		return $this->name;
	}
	public void setName(string name){
		$this->name = $name;
	}
	public int getRollNo(){
		return $this->rollNo;
	}
	public void setRollNo(int rollNo){
		$this->rollNo = $rollNo;
	}
}



}

?>
<html>

<head>
	<meta charset="utd-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Concord Activities</title>
	<link href="markup.css" rel="stylesheet">
</head>
<body>
  <div class="search-container" <?php echo $textValid->getCssClassName(); ?> id="searchActivities">
	<label class="search-label" for="text"><strong>Activity Search</strong></label> 
	<form name='mainForm' id='mainForm' method='post'>
	<div class="form-group">
      <input id="text" value="<?php echo $textValid->getValue(); ?>" placeholder="Search for an activity" name="activities" class="input-xlarge" required>
<span class="help-inline" id="errorText"></span>
	<?php echo $textValid->getErrorMessage(); ?>
	</div>
</div>
      <button value="Submit Form" class="form-control">Submit</button>
	<button value="Reset Form" class="form-control">Reset</button>
    </form>
</div>
<main class="main">
      <div class="header">
         <h1><span>Activities in Concord</span></h1>
      </div>
		<div class="activities"
   			<li>
                 <span><?php outputActivities(); ?></span>
			</li>
           </div>
           <div class="outputDetails">
              <body            
			<?php outputDetails() ?> 
              </body>
           </main>
	</div>

</body>

</html>  