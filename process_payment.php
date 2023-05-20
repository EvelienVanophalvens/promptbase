<!DOCTYPE html>
<html>
<head>
	<title>Betaalpagina</title>
	<style>
		.form {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin-top: 50px;
		}
		.input-group {
			margin-top: 20px;
			display: flex;
			flex-direction: column;
		}
		.input-group label {
			margin-bottom: 5px;
			font-weight: bold;
		}
		.input-group input {
			padding: 10px;
			font-size: 16px;
			border-radius: 5px;
			border: none;
			box-shadow: 0px 2px 5px rgba(0,0,0,0.3);
			margin-bottom: 10px;
		}
		.button-group {
			margin-top: 20px;
			display: flex;
			flex-direction: row;
			justify-content: center;
		}
		.button-group button {
			padding: 10px 20px;
			font-size: 16px;
			border-radius: 5px;
			border: none;
			background-color: #008CBA;
			color: #fff;
			cursor: pointer;
			margin-right: 10px;
		}
		.button-group button:last-child {
			margin-right: 0;
		}
	</style>
</head>
<body>
	<div class="form">
		<h1>Betaalpagina</h1>
		<form action="" method="POST">
			<div class="input-group">
				<label for="bedrag">Bedrag:</label>
				<input type="number" name="bedrag" id="bedrag" min="0" step="0.01" required>
			</div>
			<div class="input-group">
				<label for="naam">Naam:</label>
				<input type="text" name="naam" id="naam" required>
			</div>
			<div class="input-group">
				<label for="email">E-mail:</label>
				<input type="email" name="email" id="email" required>
			</div>
			<div class="button-group">
				<button type="submit">Betaal</button>
				<button type="reset">Reset</button>
			</div>
		</form>
	</div>
</body>
</html>
