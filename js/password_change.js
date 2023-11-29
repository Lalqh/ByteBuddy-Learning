const registro = document.getElementById('registro');
const inputs=document.querySelectorAll('#registro input');
const n_contraseña=document.getElementById("n-contraseña");
const contraseña=document.getElementById("contraseña");

const expresiones = { //expresiones regulares par validacion.
	password: /^.{4,12}$/, // 4 a 12 digitos.
}

const borrarAlerta=()=>{//Funcion para borrar alerta de inputs
    if( n_contraseña.value !=""|| contraseña.value !=""){
        document.getElementById("nombre_vacio").style.display="none";
        document.getElementById("contraseña_vacio").style.display="none";
    }
}
const validaRegistro = (e)=>{
    switch(e.target.name) {
		case "contraseña":
			validarCampo(expresiones.password,e.target,'password');
		break;
		case "n-contraseña":
			validarCampo(expresiones.password,e.target,'n-contraseña');
		break;
    }//Switch que compara el id del elemento con las clases}
}
const validarCampo=(expresion,input,campo)=>{
    if (expresion.test(input.value)) {
        document.getElementById(`grupo_${campo}`).classList.remove('form-incorrect');
        document.getElementById(`grupo_${campo}`).classList.add('form-correct');
    }else{
        document.getElementById(`grupo_${campo}`).classList.add('form-incorrect');
    }if (input.value=="") {
		document.getElementById(`grupo_${campo}`).classList.remove('form-incorrect');
		document.getElementById(`grupo_${campo}`).classList.remove('form-correct');
	}
}
inputs.forEach((input) => {
    input.addEventListener('keyup', validaRegistro);
    input.addEventListener('blur', validaRegistro);
    input.addEventListener('keydown', borrarAlerta);
});
//funcion para comprobar que esten llenos los inputs
registro.addEventListener('submit', (e) =>{
	if(n_contraseña.value==""){
		document.getElementById("n-contraseña_vacio").style.display="block";
		document.getElementById("n-contraseña_vacio").style.color="red";
      
	}else{
		document.getElementById("n-contraseña_vacio").style.display="none";
	}
	if(contraseña.value==""){
		document.getElementById("contraseña_vacio").style.display="block";
		document.getElementById("contraseña_vacio").style.color="red";
	}else{
		document.getElementById("contraseña_vacio").style.display="none";
	}
	  e.preventDefault();
});

