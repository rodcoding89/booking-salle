/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
const node_env = "dev";
const href = window.location;
const url = new URL(href);
const pathname = url.pathname;
console.log("pathname",url);
if(node_env === 'dev'){
    const seg = pathname.split("/")[2];
    const catalogue = document.querySelector(".navi .catalogue a");
    const contact = document.querySelector(".navi .send-message a");
    const profil = document.querySelector("nav .sign-in .proFil");
    const backoffice = document.querySelector(".navi .backoffice a");
    const login = document.querySelector("nav .sign-in .logIn");
    console.log(seg);
    if(seg === '' || seg === 'booking' || seg === 'view-room'){
        catalogue.classList.add('active');
        contact.classList.remove('active');
        if(login){
            login.classList.remove('active');
        }
        if(backoffice){
            backoffice.classList.remove('active');
        }
        if(profil){
            profil.classList.remove('active');
        }
    }else if(seg === 'sign-in' || seg === 'sign-up'){
        catalogue.classList.remove('active');
        contact.classList.remove('active');
        if(backoffice){
            backoffice.classList.remove('active');
        }
        login.classList.add('active');
    }else if(seg === 'contact'){
        catalogue.classList.remove('active');
        contact.classList.add('active');
        if(login){
            login.classList.remove('active');
        }
        if(backoffice){
            backoffice.classList.remove('active');
        }
        if(profil){
            profil.classList.remove('active');
        }
    }else if(seg === 'profil'){
        profil.classList.add('active');
        catalogue.classList.remove('active');
        contact.classList.remove('active');
        if(backoffice){
            backoffice.classList.remove('active');
        }
    }else if(seg === 'admin'){
        catalogue.classList.remove('active');
        contact.classList.remove('active');
        if(login){
            login.classList.remove('active');
        }
        if(profil){
            profil.classList.remove('active');
        }
        backoffice.classList.add('active');
    }
}else{
    
}


