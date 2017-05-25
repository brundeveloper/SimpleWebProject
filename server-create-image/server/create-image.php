<?php
	////////////////////////////////////////////////////////////////////
	//Imprime dados
	function pre($arg){
		//Imprime o parametro na tela
		echo "<pre>";
		var_dump($arg);
		echo "</pre>";
	}

	//
	function getTextWidth($textSize, $textFont, $text){
		//Obtem a caixa do texto
		$textBox = imagettfbbox($textSize, 0, $textFont, $text);

		//Retorna tamanho do texto
		return ($textBox[2] - $textBox[0]);
	}

	//Coloca o texto na imagem de forma customizada
	function textImage($image, $textSize, $textColor, $textFont, $text, $textH){
		//Tamanho do texto
		$textWidth = getTextWidth($textSize, $textFont, $text);

		//Tamanho horizontal da imagem
		$imageWidth = imagesx($image);

		//Posição x do texto
		$textX = ($imageWidth / 2) - ($textWidth / 2);

		//Coloca o texto na imagem
		imagettftext($image, $textSize, 0, $textX, $textH, $textColor, $textFont, $text);
	}
	$contador_linhas = 0;
	//Retorna os texto em array
	function getTexts($image, $textSize, $textFont, $text){
		//Array com o texto a ser retornado
		$retorno = array();

		//Tamanho horizontal da imagem
		$imageWidth = imagesx($image);

		//Explode o texto em array
		$wordArray = explode(" ", $text);

		//Frase
		$phrase = "";

		//Passa por cada palavra
		for ($i = 0; $i < count($wordArray); $i++) {
			//Concatena formando a frase
			$phrase .= $wordArray[$i]." ";

			//Verifica se o texto esta maior que o limite
			if (getTextWidth($textSize, $textFont, $phrase) > ($imageWidth - 125)){
				//Adiciona a frase no retorno
				array_push($retorno, trim($phrase));

				//Limpa a variável
				$phrase = "";
//				$contador_linhas+=1;
			}
		}
		//Adiciona a frase no retorno
		array_push($retorno, trim($phrase));

		//Retorna array com os textos
		return $retorno;
	}

	////////////////////////////////////////////////////////////////////
	//Variavel com o recurso de imagem
	$image = @imagecreate(800, 600) or die("Não é possivel inicializar o GD");

	//Cria o background da imagem
	$imageBackground = imagecolorallocate($image, 255, 0, 0);

	//Verifica se passou o parâmetro
	if (array_key_exists("t", $_GET)){
		//Texto
		$text = $_GET['t'];

		//Tamanho do texto
		$textSize = 20;

		//Cor do texto
		$textColor = imagecolorallocate($image, 0, 0, 0);

		//Fonte do texto
		$textFont = "res/font/Verdana.ttf";

		//Obtem o array com o texto
		$textArray = getTexts($image, $textSize, $textFont, $text);

		//vai armazenar a metade da imagem para insersão do texto
		$meio = imagesy($image);
		//$c=0;

		//Passa por cada texto
		for ($i = 0; $i < count($textArray); $i++){
			//Coloca o texto na imagem
			$c =  30 + ($i * ($textSize + 5));
			if($c < (imagesy($image) - 30)){
				textImage($image, $textSize, $textColor, $textFont, $textArray[$i], $c);
			}else{
				textImage($image, $textSize, $textColor, $textFont, $textArray[$i].'...', $c);
				break;
			}
		}
	}

	//Header da pagina
	header("Content-type: image/png");

	//Cria a imagem criada na tela
	imagepng($image);

	//Destroi a imagem
	imagedestroy($image);
?>