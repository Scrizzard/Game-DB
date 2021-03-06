<!DOCTYPE html>

<html>

	<header>
		<script type="text/javascript" src="jquery/jquery.min.js"></script>
		<script type="text/javascript" src="jquery/jquery-ui.min.js"></script>
		<script type="text/javascript" src="datatable/jquery.dataTables.min.js"></script>

		<script type="text/javascript" src="JS/view.js"></script>

		<link rel="stylesheet" type="text/css" href="jquery/jquery-ui.min.css">
		<link rel="stylesheet" type="text/css" href="jquery/jquery-ui.structure.min.css">
		<link rel="stylesheet" type="text/css" href="jquery/jquery-ui.theme.min.css">
		<link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css">

		<link href='http://fonts.googleapis.com/css?family=Ubuntu|Asap' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="CSS/view.css">

		<?php include('PHP/header.php') ?>
		<?php include('PHP/insertGame.php') ?>
		<?php include('PHP/insertConsole.php') ?>

	</header>

	<body>
		<table id="outerTable">
			<tr>
				<td>
				<div id="tabs">

					<ul>
						<li>
							<a href="#gameFormWrapper">Insert Game</a>
						</li>
						<li>
							<a href="#consoleFormWrapper">Insert Console</a>
						</li>
					</ul>

					<div id="gameFormWrapper">

						<p class="formTitle">
							Insert a Game
						</p>

						<div class="line"></div>

						<form action="view.php" method="post" enctype="multipart/form-data">

							<div class="scrollbox">

								<div>
									<p class="fieldTitle">
										Game Name
									</p>
									<br/>
									<input type="text" name="title">
								</div>

								<div id="consoleInputWrapper">
									<p class="fieldTitle">
										Console
									</p>
									</br>
									<select name="gameConsole">
										<!--This is probably bad practice, but $field is used in populateFieldDDL.php.-->
										<?php $field = 'console'; include('PHP/populateFieldDDL.php')?>
									</select>
								</div>

								<div>
									<p class="fieldTitle">
										Year
									</p>
									<br/>
									<input type="text" name="releaseYear">
								</div>

								<div id="InputWrapper">
									<p class="fieldTitle">
										Rating
									</p>
									</br>
									<select name="rating">
										<!--This is probably bad practice, but $field is used in populateFieldDDL.php.-->
										<?php $field = 'rating'; include('PHP/populateFieldDDL.php')?>
									</select>
								</div>

								<div id="regionInputWrapper">
									<p class="fieldTitle">
										Region
									</p>
									<br/>
									<input type="text" name="region">
								</div>

								<div id="publisherInputWrapper">
									<p class="fieldTitle">
										Publisher
									</p>
									<p class="addField" type="button" onclick="addField(this, 'publisher')">
										add
									</p>
									<br/>
									<input type="text" name="publisher1">
									<br/>
								</div>

								<div id="developerInputWrapper">
									<p class="fieldTitle">
										Developer
									</p>
									<p class="addField" type="button" onclick="addField(this, 'developer')">
										add
									</p>
									<br/>
									<input type="text" name="developer1">
									<br/>
								</div>

								<div id="genreInputWrapper">
									<p class="fieldTitle">
										Genre
									</p>
									<p class="addField" type="button" onclick="addField(this, 'genre')">
										add
									</p>
									<br/>
									<input type="text" name="genre1">
									<br/>
								</div>
								<div>
									<p class="fieldTitle">
										Image <span class="unbold">(optional)</span>
									</p>
									<br/>
									<input id="imageInput" type="file" name="coverImage">
								</div>

								<div>
									<p class="fieldTitle">
										Pricing URL <span class="unbold">(optional)</span>
									</p>
									<br/>
									<input id="priceInput" type="text" name="price">
								</div>

							</div>

							<div class="line"></div>

							<input type="checkbox" name="submitted" checked class="hidden">
							<input id="submit" type="submit" value="Submit">

						</form>
					</div>

					<div id="consoleFormWrapper">
						<p class="formTitle">
							Insert a Console
						</p>

						<div class="line"></div>

						<form action="view.php?submitted=yup" method="post">
							<p class="fieldTitle">
								Name
							</p>
							<br/>
							<input type="text" name="consoleName">
							<br/>
							<p class="fieldTitle">
								First Party
							</p>
							<br/>
							<input type="text" name="firstParty">
							<br/>
							<p class="fieldTitle">
								Release Year
							</p>
							<br/>
							<input type="text" name="consoleYear">
							<br/>
							<p class="fieldTitle">
								Handheld
							</p>
							<input type="checkbox" name="consoleName">
							<br/>
							<input id="submit" type="submit" value="Submit">
						</form>
					</div>
				</div></td>
				<td id="rightCell">
				<table id="gameTable" class="row-border compact">
					<thead class="noSelect">
						<th>Title</th>
						<th>Console</th>
						<th>Year</th>
						<th>Price</th>
						<th>Rating</th>
						<th>Date Added</th>
						<th>Delete</th>
					</thead>

					<?php include('PHP/fetchTable.php') ?>

				</table></td>
			</tr>
		</table>
	</body>
</html>