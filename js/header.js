/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
//const node_env = "dev";
const href = window.location;
const url = new URL(href);
const pathname = url.pathname;
const catalogue = document.querySelector(".navi .catalogue a");
const contact = document.querySelector(".navi .send-message a");
const profil = document.querySelector("nav .sign-in .proFil");
const backoffice = document.querySelector(".navi .backoffice a");
const login = document.querySelector("nav .sign-in .logIn");
console.log("pathname",url);
if(node_env === 'dev'){
    const seg = pathname.split("/")[2];
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
    console.log("seg",seg,"pathname","pathname")
    if(pathname === '/' || pathname === '/booking/' || pathname === '/view-room/'){
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
    }else if(pathname === '/sign-in/' || pathname === '/sign-up/'){
        catalogue.classList.remove('active');
        contact.classList.remove('active');
        if(backoffice){
            backoffice.classList.remove('active');
        }
        login.classList.add('active');
    }else if(pathname === '/contact/'){
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
    }else if(pathname === '/profil/'){
        profil.classList.add('active');
        catalogue.classList.remove('active');
        contact.classList.remove('active');
        if(backoffice){
            backoffice.classList.remove('active');
        }
    }else if(pathname === '/admin/'){
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
}


