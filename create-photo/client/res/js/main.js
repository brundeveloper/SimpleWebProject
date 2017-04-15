/* JS */

//Carregar o jQuery
$($ => {
	//Altera a imagem
	let changeImage = input => {
		//Verifica se selecionou uma imagem
		if (input.val()){
			//Obtem os arquivos do input
			let foto = input.prop("files");

			//Obtem o arquivo
			foto = foto[0];

			//Verifica se tem suporte ao FileReader
			if (FileReader){
				//Estancia a classe FileReader
				let fr = new FileReader();

				//Le a foto do input
				fr.readAsDataURL(foto);

				//Evento que só acontece apos o FileReader ler o arquivo por completo
				fr.onload = () => {
					//Carrega a imagem no elemento
					$("#id-img-imagem-input").attr("src", fr.result);
				};
			}
		}
		else {
			//Avisa o usuário
			alert("Por favor, selecione uma imagem.");
		}
	};

	//Quando mudar o input file
	$("#id-input-file-photo").on("change", event => {
		//Chama função que muda a imagem
		changeImage($(event.target));
	});

	//Quando clicar no botao
	$("#id-form-save").on("click", event => {
		//Tira o evento do submit
		event.preventDefault();
	});
});