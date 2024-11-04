<!DOCTYPE html>
<html lang="en-us">

<head>

<title>2024 Solutions | Missing Solutions</title>

<link rel="icon" type="image/x-icon" href="images/command.png">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style.css">

</head>

<body>

<?php include 'partials/naviguation.php'; ?>

<header class="p">
<h1>The Missing Solutions of your Missing Semester class</h1>

<br><br><br>
<h2>Exercise solutions<br></h2>
<h4>Edition 2020<h4>
</header>

<main>

<div class="center">
<div class='menu'>
	<ul>
		<li><a href='lectsol/lecture1.htm' target="iframe" id="lect1">Lecture 1</a></li>
		<li><a href='lectsol/lecture2.htm' target="iframe" id="lect2">Lecture 2</a></li>
		<li><a href='lectsol/lecture3.htm' target="iframe" id="lect3">Lecture 3</a></li>
		<li><a href='lectsol/lecture4.htm' target="iframe" id="lect4">Lecture 4</a></li>
		<li><a href='lectsol/lecture5.htm' target="iframe" id="lect5">Lecture 5</a></li>
		<li><a href='lectsol/lecture6.htm' target="iframe" id="lect6">Lecture 6</a></li>
		<li><a href='lectsol/lecture7.htm' target="iframe" id="lect7">Lecture 7</a></li>
		<li><a href='lectsol/lecture8.htm' target="iframe" id="lect8">Lecture 8</a></li>
		<li><a href='lectsol/lecture9.htm' target="iframe" id="lect9">Lecture 9</a></li>
		<li><a href='lectsol/lecture10.htm' target="iframe" id="lect10">Lecture 10</a></li>
	</ul>


<iframe name="iframe" id="exo" class="iframe" title="Exercise Solutions" src="lectsol/default.html"></iframe> 

</div>
</div>

<div class=player-container>

	<div class=track-name-cont><p id=trackName>Here are some beats to help you relax while you do the exercises</p></div>

	<div class=audio-player>

		<div class=button-container id='audioPrevBtn'><img src="images/backward.png" alt="Prev" class='audioBtn'></div>

		<audio id=audioPlayer controls>
			<source src="fire/Bliss.mp3" type="audio/mpeg">
			Your browser does not support audio element
		</audio>

		<div class=button-container id='audioNextBtn'><img src="images/skip.png" alt="Next" class='audioBtn'></div>
	</div>


</div>



</main>

<?php include 'partials/footer.php'; ?>

<script src='js/activeNav.js'></script>

<script src='js/visitedLectureCookie.js'></script>

<script src='js/audioPlayer.js'></script>

<script src='js/lectureNavParentPage.js'></script>

<script src='js/activeSideMenu.js'></script>

<script src='js/lectureReceive.js'></script>

</body>
</html>
