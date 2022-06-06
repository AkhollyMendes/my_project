<?php
	include('./seg.php');


				if ($_SESSION['id'] == 1)
				{
					echo ('<p class="loginTitle">id de cadastro</p>');

					echo ('<div class="campos" onclick="copyDivToClipboard()">');
						echo ('<p class="labels">Id gerada</p>');

						$idvery = md5(date('mYd'));

						echo ('<span class="id" id="chave">'.$idvery.'<span>');

					echo ('</div>');


				}
			

?>

    <script>
        function copyDivToClipboard() {
             var range = document.createRange();
             range.selectNode(document.getElementById("chave"));
             window.getSelection().removeAllRanges();
             window.getSelection().addRange(range);
             document.execCommand("copy")
             window.getSelection().removeAllRanges();
        }
    </script>

<script type="text/javascript" src="./js/sessao.js"></script>