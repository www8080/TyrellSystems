<?
$numOfPeople	= floor($_POST['numOfPeople']);
$cardTypes		= array('S','H','D','C');
$cards				= array('A',2,3,4,5,6,7,8,9,'X','J','Q','K');

$debugRowSpan	= 2; //$default row span size Debug Row
$debugRowSpan += $numOfPeople;

$deck = array();	
foreach ($cardTypes as $cardType) {
    foreach ($cards as $card) {
        $deck[] = $cardType . "-" . $card;
    }
}
$totalCards	=	count($deck);

function getNumSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }

//****************************DEBUG**********************************************************
/*
//Debugging:
foreach($deck as $key => $value)
{
  echo $value ."<br>";
}
echo "Count Array Size:" . count($deck);

echo "<br>numOfPeople:". $numOfPeople."<br>";
*/
//************************END DEBUG**********************************************************
?>
<html>
	<head>
		<style>
			html {
  			scroll-behavior: smooth;
			}
			table {
			  border-collapse: collapse;
			  width: 90%;
			}
			
			th, td {
			  text-align: center;
			  padding: 8px;
			}
			
			tr:hover {background-color:#f2f2f2;}
			
			th {
			  background-color: #4CAF50;
			  color: white;
			}
		</style>
		<script src= "https://code.jquery.com/jquery-3.5.0.min.js"></script> 		
	</head>
	<body><a id="top"></a><br>
<?	
//****************************DEBUG**********************************************************
//array_chunk($shuffleResult, $numOfPeople);
//for ($i =0; $i<sizeOf($shuffleResult); $i++) {
//	echo "$shuffleResult[$i]";
//}
//************************END DEBUG**********************************************************

//
?>
		<table width="90%" border="1" align="center" id="myHeader">
			<tr>
				<th>Debuging</th>
				<th>Programming Test - Playing cards will be given out to n(number) people</th>
			</tr>
			<tr>
				<td width="32%" rowspan="<?=$debugRowSpan?>" valign="top" align="left">
					<b><u>Total Cards (Original):</u> <font color='#008000'><?=$totalCards?></font></b><br>
					<?
						//print_r($deck);
						print_r(implode(',', $deck));
					?>
					<br><br><b><u>Total Cards (After Shuffle):</u> <font color='#008000'><?=$totalCards?></font></b><br>
					<?
						shuffle($deck);
						//print_r($deck);
						print_r(implode(',', $deck));
					?>
				</td>
				<td width="68%" align="center">
					<form id="target" method="POST" action="playingCard2.php">
							<b>Number of people:</b> 
							<!-- Set the numOfPeople input MaxLenght Size to 2 digit, max 99, IF server heavy load, maxlength="2" -->
							<input type="text" id="numOfPeople" name="numOfPeople" autofocus> 
							<button type="button">Submit</button>
					</form>
					<?
						//<input type="submit" name="Action" value="Submit">
						//Dealing Cards to N people
						echo "<b><u>Total of People:</u> <font color='#008000'> ". $numOfPeople."</font></b><br>";
					?>
				</td>
			</tr>
					<?
						//Get Number of Card for each person (Total of Card / Number of People)
						$numOfCardPerPerson = @floor($totalCards / $numOfPeople);
							//break;
						for ($i=1; $i<=$numOfPeople;$i++) {
					?>
			<tr>
				<td align="center">
					<?
							$numSuffix = getNumSuffix($i);
							//Case IF numOfPeople more than 'total of card'
							if ($numOfPeople > $totalCards && $numOfCardPerPerson == 0) {
									$numOfCardPerPerson = $totalCards/$totalCards;
							}
							echo "<b>".$numSuffix." People</b>, get <b>$numOfCardPerPerson</b> Card(s)<br>";
							if ($i <= $totalCards) {
								$myCards = array_rand($deck, $numOfCardPerPerson);
							} else {
								echo "<font color=Red>Card empty, ALL cards distributed out. No More card for this people.[".$numSuffix."]</font><br>";
							}
								//IF exceeded $totalCards (IE:52)
							//} elseif ($numOfPeople > $totalCards && $numOfCardPerPerson == 0) {
									//echo "error1001 numOfCardPerPerson-->$numOfCardPerPerson<---";
									//$numOfCardPerPerson = $totalCards/$totalCards;
									//$myCards = array_rand($deck, $numOfCardPerPerson);
							//}
								//****************************DEBUG**********************************************************
								//echo "numOfCardPerPerson-->$numOfCardPerPerson<--";
								//echo "myCards-->$myCards<--";
								//print_r ($myCards); 
								//$myHand = array();
								//*************************END DEBUG*********************************************************
								
							if ((is_array($myCards) || is_object($myCards)) && $numOfCardPerPerson > 1) {
								foreach ($myCards as $key) {
								    $myHand[] = $deck[$key];
								    unset($deck[$key]);
								}
							} elseif (count($numOfCardPerPerson) == 1) {
								$key = $myCards;
								$myHand[] = $deck[$key];
								unset($deck[$key]);
							}
							//print_r($myHand);
							$myHandSepByComma = implode(',', $myHand); 
							echo "<font color='#008000'>";
								print_r($myHandSepByComma);
							echo "</font>";
							//if (count($myHand))
							unset($myHand);
						}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?
					//****************************DEBUG**********************************************************
							//echo $shuffleResult."<br>";
							//print_r($myHand);
							//*************************END DEBUG*********************************************************
							
							//Show ALL Card(s) which is left or Not distributed
							echo "<br><b><u>Total cards left/Not distributed:</u> <font color='#008000'>" . count($deck)."</font></b><br><font color='#008000'>";
								print_r(implode(',', $deck));
							echo "</font>";
					?>
				</td>
			</tr>
		</table>
		
		<script type="text/javascript"> 
        $(document).ready(function() {
        	 $("#numOfPeople").focus();
        	/*
        	//Validation - numOfPeople textbox - only INTEGER NUMBER allowed - Disabled for now, using validation with alert message
        	$('#numOfPeople').keypress(function(event) {
						return /\d/.test(String.fromCharCode(event.keyCode));
					});
					*/
 					//Prevent keypress Enter at text box
        	$('#numOfPeople').keypress(function(event){
								    var keycode = (event.keyCode ? event.keyCode : event.which);
								    if(keycode == '13'){
								        alert('Please presse on the Submit Button');
								        event.preventDefault()
								    }
					});
					//Number Validation - numOfPeople textbox 
          $("button").click(function() {
          	var inputVal	= $("#numOfPeople").val(); 
            var numValid	= $.isNumeric(inputVal); 
                if (numValid && inputVal >= 0) {
                    //alert("The Value Entered is Numeric"); 
                    $("#target" ).submit();
                } else {
                    alert("Input value does not exist or value is invalid");
                    $("#numOfPeople").select();
                } 
          }); 
        }); 
        
        window.onscroll = function() {myFunction()};
				var header = document.getElementById("myHeader");
				var sticky = header.offsetTop;
				
				function myFunction() {
				  if (window.pageYOffset > sticky) {
				    header.classList.add("sticky");
				  } else {
				    header.classList.remove("sticky");
				  }
				}
    </script> 
    <?
    	if ($numOfPeople > 15) {
    ?>
    	<br>		
    	<div align="right">
    		<a href="#top">Go to top of page</a>
    	<div>
		<?
    	}
    ?>		
</body>
</html>