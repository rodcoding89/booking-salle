/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
//const node_env = "dev";
const href = window.location;
const url = new URL(href);
const pathname = url.pathname;
console.log("pathname",url);
if(node_env === 'dev'){
    const seg = pathname.split("/")[3];
    const links = $(".backoffice .nav li");
    console.log("seg",seg);
    links.each(function(index){
        if(seg === '' && index == 0){
            links.find('a').removeClass("opacity-50 text-dark")
            $(this).find('a').removeClass("opacity-50 text-dark")
            $(this).siblings().find('a').addClass('opacity-50 text-dark');
            $(this).find('a').addClass('opacity-100 text-primary');
        }else if(seg === 'rooms' && index === 1){
            links.find('a').removeClass("opacity-50 text-dark")
            $(this).find('a').removeClass("opacity-50 text-dark")
            $(this).siblings().find('a').addClass('opacity-50 text-dark');
            $(this).find('a').addClass('opacity-100 text-primary');
        }else if(seg === 'orders' && index === 2){
            links.find('a').removeClass("opacity-50 text-dark")
            $(this).find('a').removeClass("opacity-50 text-dark")
            $(this).siblings().find('a').addClass('opacity-50 text-dark');
            $(this).find('a').addClass('opacity-100 text-primary');
        }else if(seg === 'statistic' && index === 3){
            links.find('a').removeClass("opacity-50 text-dark")
            $(this).find('a').removeClass("opacity-50 text-dark")
            $(this).siblings().find('a').addClass('opacity-50 text-dark');
            $(this).find('a').addClass('opacity-100 text-primary');
        }
    })
}else{
    
}