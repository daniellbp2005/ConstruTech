const emailInput = document.getElementById("email");
const senhaInput = document.getElementById("senha");
const nomeInput = document.getElementById("nome");
const btnLogin = document.getElementById("btnLogin");
const btnCadastro = document.getElementById("btnCadastro");
const texto = document.querySelector(".inserir");
const btnSolicitar = document.getElementById("idSolicitar");

let dados = JSON.parse(localStorage.getItem("salvamento")) || [
    {
        id: 1,
        nome: "daniel",
        senha: "123",
        email: "daniel.l.pires@aluno.senai.br",
    },
    {
        id: 2,
        nome: "daniel",
        senha: "123",
        email: "daniellbp2005@gmail.com",
    },
    {
        id: 3,
        nome: "admin",
        senha: "123",
        email: "admin",
    },
];

if (btnLogin) {
    btnLogin.addEventListener("click", (event) => {
        event.preventDefault();

        let email = emailInput.value;
        let senha = senhaInput.value;

        if (dados.find(aux => aux.senha === senha && aux.email === email)) {
            texto.style.color = "green";
            texto.innerText = "Acesso Liberado";
            // document.cookie = "status_acesso=liberado; path=/; max-age=3600";
            // console.log(document.cookie);

            window.location.href = 'inventario.php';
        } else if (email === "" || senha === "") {
            texto.style.color = "red";
            texto.innerText = "Preencha o Formulárioo";
        } else {
            texto.style.color = "red";
            texto.innerText = "Acesso Negado";
        }
    })
}

if(btnSolicitar){
    btnSolicitar.addEventListener("click", ()=>{
    texto.style.color = "green";
    texto.innerText = "Solicitação Feita, aguarde";
})
}
if (btnCadastro) {
    btnCadastro.addEventListener("click", (event) => {
        event.preventDefault();

        let email = emailInput.value;
        let senha = senhaInput.value;
        let nome = nomeInput.value;

        if (email === "" || nome === "" || senha === "") {
            texto.innerText = "Preencha o Formulário";
            texto.style.color = "red"
            return
        }
        let novoUser = {
            id: dados.length + 1,
            nome: nome,
            email: email,
            senha: senha,
        }
        console.log(novoUser);
        if (dados.find(aux => aux.email === email)) {
            texto.style.color = "red";
            texto.innerText = "Esse conta já existe";
            return
        }
        dados.push(novoUser);
        const userJSON = JSON.stringify(dados); // converte p string
        localStorage.setItem("salvamento", userJSON);// guardando a string
        console.log(userJSON);


        texto.style.color = "green";
        texto.innerText = "Cadastro Realizado com Sucesso..."
    })
}