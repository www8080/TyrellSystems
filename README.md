# README
=====================================================================
### A) Programming Test
	Source Code at playingCard.php

### B) SQL Improvement Logic Test
	- Please refer to uestion2-SQL_Logic_Test.txt

======================================================================

## Programming Test - PHP playing cards distribute script

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
	This file will contains PHP, HTML, CSS, Javascript and JQuery code

## Usage
1.	User will key-in the total of people in the input box[Number of people].
2. 	Click on the Submit button to generate the result.
3.	The page contains of a table with 2 colume, 
			- left colume 'debugging' containing information of the Original cards in order.
			- Right colume containing the input box[Number of people] and the submit button, and the cards distribution result shows below. Last row will show 'Total card left'.
			