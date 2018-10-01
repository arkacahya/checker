<html>
<head>
	<title>SBux Account Checker</title>
    <meta name="description" content="SBux Account Checker">
    <meta name="author" content="Alfarady R">
	<link href="cssd/bootstrap.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/check.js"></script>
	<script type="text/javascript">
		function selectText(containerid) {
		if (document.selection) {
			var range = document.body.createTextRange();
			range.moveToElementText(document.getElementById(containerid));
			range.select();
			} else if (window.getSelection()) {
				var range = document.createRange();
				range.selectNode(document.getElementById(containerid));
				window.getSelection().removeAllRanges();
				window.getSelection().addRange(range);
			}
		}
	</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-8" style="margin: 0px auto;float:none;">
				<center>
					<h2>- SBux -</h2>
				</center>
				<hr>
				<div class="panel panel-default">
					<div class="panel-heading">
					   SBux Account Checker | tc0de
					</div>
					<div class="panel-body">
							<textarea name="mailpass" id="mailpass" placeholder="frenzy@tc0de.com|123123" class="form-control" rows="7"></textarea><br>
							<a href="../get_socks.php"><b>Get Socks5</b></a><br>
							<textarea name="socks" id="socks" class="form-control" rows="7" placeholder="127.0.0.1:8080"></textarea><br>
							<p align="center">
                            	Delim: <input name="delim" id="delim" style="text-align: center;display:inline;width: 40px;margin-right: 8px;padding: 4px;" value="|" type="text" class="form-control">
								<button type="button" class="btn btn-success" id="submit">CHECK</button>
								<button type="button" class="btn btn-danger" id="stop">PAUSE</button>&nbsp;
								<img id="loading"><br>
							</p>
                        	<p align="right">
                            	<span id="checkStatus" style="color:limegreen"></span>
                        	</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="result" style="display: none;">
			<div class="col-lg-8" style="margin: 0px auto;float:none;">
				<div class="panel panel-default">
					<div class="panel-heading">
						LIVE&nbsp;<span class="label label-success" id="acc_live_count" style="color:white">0</span>
						<span onclick="selectText('acc_live')" class="pull-right"><a href="javascript:;" style="color:green">Copy all</a><span>
					</div>	
					<div class="panel-body">
						<div id="acc_live"></div>
					</div>
				</div>
			</div>
            <div class="col-lg-8" style="margin: 0px auto;float:none;">
				<div class="panel panel-default">
					<div class="panel-heading">
						DIE&nbsp;<span class="label label-danger" id="acc_die_count" style="color:white">0</span>
					</div>	
					<div class="panel-body">
						<div id="acc_die"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-8" style="margin: 0px auto;float:none;">
				<div class="panel panel-default">
					<div class="panel-heading">
						WRONG&nbsp;<span class="label label-warning" id="wrong_count" style="color:white">0</span>
					</div>	
					<div class="panel-body">
						<div id="wrong"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-8" style="margin: 0px auto;float:none;">
				<div class="panel panel-default">
					<div class="panel-heading">
						SOCK DIE&nbsp;<span class="label label-warning" id="bad_count" style="color:white">0</span>
					</div>	
					<div class="panel-body">
						<div id="acc_bad"></div>
					</div>
				</div>
			</div>
		</div>
	</div><center>Powered By ./teacher-c0de</center>
</body>
</html>