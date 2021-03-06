﻿<!--
# Tyrell Systems Programming Test - PHP playing cards distribute script
======================================================================

## README:

## Overview

- This system capture input [Number of people] and playing cards will be given out to these n(number) of people. 
- Total 52 cards containing 1-13 of each Spade(S), Heart(H), Diamond(D), Club(C) will be given to n people randomly.
-	Card format (Spade = S, Heart = H, Diamond = D, Club = C), (Card 2 to 9 are, as it is, 1=A,10=X,11=J,12=Q,13=K).
- Each people will receive number of cards evenly in a 'First Come First Serve' basis 
	-	For example scenario below,
		-	If 52 cards, 52 people. Each people will receive 1 card each.
		-	If 52 cards, 53 people. Each people will receive 1 card each, except the last people(53th person) will not receive card because the card was empty.

## Folder Structure
	'/path/to/your/www/yourFolder'/playingCard.php

### playingCard.php
	This file will contains PHP, HTML and JQuery code

## Usage
1.	User will key-in the total of people in the input box[Number of people].
2. 	Click on the Submit button to generate the result.
3.	The page contains of a table with 2 colume, 
			- left colume 'debugging' containing information of the Original cards in order.
			- Right colume containing the input box[Number of people] and the submit button, and the cards distribution result shows below. Last row will show 'Total card left'.

//END OF README
-->

<?PHP
if(!empty($_POST['numOfPeople'])){
	$numOfPeople	= floor($_POST['numOfPeople']);
} else {
	$numOfPeople	= 0;
}
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
			
			tr:hover {background-color:#EEFCEE;}
			
			th {
			  background-color: #4CAF50;
			  color: white;
			}
		</style>
		<script src= "https://code.jquery.com/jquery-3.5.0.min.js"></script> 		
	</head>
	<body><a id="top"></a><br>

		<table width="90%" border="1" align="center">
			<tr>
				<th>Debugging</th>
				<th>Programming Test - Playing cards will be given out to n(number) people</th>
			</tr>
			<tr>
				<td width="32%" rowspan="<?PHP echo $debugRowSpan?>" valign="top" align="left">
					<b><u>Total Cards (Original):</u> <font color='#008000'><?PHP echo $totalCards?></font></b><br>
					<?PHP
						//print_r($deck);
						print_r(implode(',', $deck));
					?>
					<br><br><b><u>Total Cards (After Shuffle):</u> <font color='#008000'><?PHP echo $totalCards?></font></b><br>
					<?PHP
						shuffle($deck);
						//print_r($deck);
						print_r(implode(',', $deck));
					?>
				</td>
				<td width="68%" align="center">
					<form id="target" method="POST" action="playingCard.php">
							<b>Number of people:</b> 
							<!-- Set the numOfPeople input MaxLenght Size to 2 digit, max 99, IF server heavy load, maxlength="2" -->
							<input type="text" id="numOfPeople" name="numOfPeople" autofocus> 
							<button type="button">Submit</button>
					</form>
					<?PHP
						//Dealing Cards to N people
						echo "<b><u>Total of People:</u> <font color='#008000'> ". $numOfPeople."</font></b><br>";
					?>
				</td>
			</tr>
					<?PHP
						//Get Number of Card for each person (Total of Card / Number of People)
						$numOfCardPerPerson = @floor($totalCards / $numOfPeople);
							//break;
						for ($i=1; $i<=$numOfPeople;$i++) {
					?>
			<tr>
				<td align="center">
					<?PHP
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
							if ((is_array($myCards) || is_object($myCards)) && $numOfCardPerPerson > 1) {
								foreach ($myCards as $key) {
								    $myHand[] = $deck[$key];
								    unset($deck[$key]);
								}
							} elseif (@count($numOfCardPerPerson) == 1) {
								$key = $myCards;
								$myHand[] = @$deck[$key];
								unset($deck[$key]);
							}
							//print_r($myHand);
							$myHandSepByComma = implode(',', $myHand); 
							echo "<font color='#008000'>";
								print_r($myHandSepByComma);
							echo "</font>";
							unset($myHand);
						}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?PHP
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
        
    </script> 
    
    <?PHP
    	if ($numOfPeople > 15) {
    ?>
    	<br>		
    	<div align="right">
    		<a href="#top">Go to top of page</a>
    	<div>
		<?PHP
    	}
    ?>		
</body>
</html>
