/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
const node_env = "dev";
const href = window.location;
const url = new URL(href);
const pathname = url.pathname;
if(node_env === 'dev'){
    const seg = pathname.split("/")[2];
    const catalogue = document.querySelector(".navi .catalogue a");
    const contact = document.querySelector(".navi .send-message a");
    const login = document.querySelector("nav .sign-in a");
    if(seg === ''){
        catalogue.classList.add('active');
        contact.classList.remove('active');
        login.classList.remove('active');
    }else if(seg === 'sign-in' || seg === 'sign-up'){
        catalogue.classList.remove('active');
        contact.classList.remove('active');
        login.classList.add('active');
    }else if(seg === 'contact'){
        catalogue.classList.remove('active');
        contact.classList.add('active');
        login.classList.remove('active');
    }
}else{
    
}

//console.log(seg);
